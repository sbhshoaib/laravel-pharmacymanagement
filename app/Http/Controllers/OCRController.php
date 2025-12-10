<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class OCRController extends Controller
{
    /**
     * Process OCR on uploaded image using Tesseract
     */
    public function processOCR(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $request->validate([
                'image_data' => 'required|string'
            ]);

            $base64Image = $request->input('image_data');
            
            // Generate unique filename
            $filename = 'captcha_' . time() . '_' . uniqid() . '.png';
            $imagePath = 'public/temp/' . $filename;
            
            // Decode and save base64 image
            $imageData = base64_decode($base64Image);
            if ($imageData === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid base64 image data'
                ], 400);
            }
            
            // Save image to storage
            Storage::put($imagePath, $imageData);
            $fullImagePath = Storage::path($imagePath);
            
            if (!file_exists($fullImagePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save image file'
                ], 500);
            }

            // Check if Tesseract OCR executable exists
            $tesseractPath = "C:\\Program Files\\Tesseract-OCR\\tesseract.exe";
            if (!file_exists($tesseractPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tesseract OCR executable not found',
                    'path_checked' => $tesseractPath
                ], 500);
            }
            
            // Preprocess image for better OCR results (keep only white pixels)
            $processedImagePath = $this->preprocessImageKeepWhiteOnly($fullImagePath);
            
            // Run Tesseract OCR with specific configuration for numbers
            $command = "\"$tesseractPath\" " . escapeshellarg($processedImagePath) . " stdout -l eng --psm 8 -c tessedit_char_whitelist=0123456789";
            
            Log::info("Running OCR command: " . $command);
            
            $extractedText = shell_exec($command);
            
            if (empty($extractedText)) {
                // Try alternative OCR settings
                $command = "\"$tesseractPath\" " . escapeshellarg($processedImagePath) . " stdout -l eng --psm 7 -c tessedit_char_whitelist=0123456789";
                $extractedText = shell_exec($command);
            }
            
            // Clean up temporary files
            Storage::delete($imagePath);
            if ($processedImagePath !== $fullImagePath && file_exists($processedImagePath)) {
                unlink($processedImagePath);
            }
            
            if (empty($extractedText)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to extract text from the image'
                ], 500);
            }

            // Clean and extract only numbers
            $cleanText = trim($extractedText);
            $numbersOnly = preg_replace('/[^0-9]/', '', $cleanText);
            
            Log::info("OCR raw result: '$cleanText', numbers only: '$numbersOnly'");
            
            if (empty($numbersOnly)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No numbers found in OCR result',
                    'raw_text' => $cleanText
                ], 400);
            }

            return response()->json([
                'success' => true,
                'extracted_text' => $cleanText,
                'numbers_only' => $numbersOnly,
                'text' => $numbersOnly, // For compatibility
                'message' => 'OCR completed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('OCR processing error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'OCR processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Preprocess image to keep only white pixels and make everything else black
     * This creates a binary image with only white text/elements visible
     */
    private function preprocessImageKeepWhiteOnly(string $imagePath): string
    {
        try {
            // Check if ImageMagick is available
            if (!extension_loaded('imagick')) {
                Log::warning('ImageMagick not available, trying GD library fallback');
                return $this->preprocessWithGD($imagePath);
            }

            $image = new \Imagick($imagePath);
            
            // Get image dimensions for scaling later
            $originalWidth = $image->getImageWidth();
            $originalHeight = $image->getImageHeight();
            
            // Convert to RGB colorspace first to ensure consistent color handling
            $image->transformImageColorspace(\Imagick::COLORSPACE_RGB);
            
            // Define white color range with some tolerance
            // This allows for slightly off-white pixels to be preserved
            $whiteThreshold = 0.85; // Adjust this value (0.0 to 1.0) - higher means stricter white detection
            
            // Create a mask for white pixels
            $image->colorThresholdImage('white', 'white', $whiteThreshold * \Imagick::getQuantum(), \Imagick::CHANNEL_ALL, false);
            
            // Alternative approach: Use fuzz factor for more flexible white detection
            $image->setImageFuzz(15 * \Imagick::getQuantum() / 100); // 15% fuzz factor
            
            // Make all non-white pixels black and keep white pixels white
            $image->transparentPaintImage('white', 0, 0, false);
            $image->setImageBackgroundColor('black');
            $image->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);
            
            // Convert the remaining pixels to pure white
            $image->levelImage(0, 1.0, \Imagick::getQuantum());
            
            // Convert to grayscale for OCR
            $image->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
            
            // Apply additional enhancement
            $image->contrastImage(true);
            $image->normalizeImage();
            
            // Scale up image for better OCR (3x for better recognition)
            $image->scaleImage($originalWidth * 3, $originalHeight * 3);
            
            // Apply sharpening
            $image->sharpenImage(0, 1);
            
            // Apply morphological operations to clean up the image
            $image->morphologyImage(\Imagick::MORPHOLOGY_CLOSE, 1, [\Imagick::KERNEL_RECTANGLE, '3x3']);
            
            // Save processed image
            $processedPath = str_replace('.png', '_white_only.png', $imagePath);
            $image->writeImage($processedPath);
            $image->destroy();
            
            Log::info('Image preprocessed successfully - white pixels only preserved');
            return $processedPath;
            
        } catch (\Exception $e) {
            Log::warning('ImageMagick preprocessing failed: ' . $e->getMessage() . '. Trying GD fallback.');
            return $this->preprocessWithGD($imagePath);
        }
    }

    /**
     * Fallback preprocessing using GD library when ImageMagick is not available
     */
    private function preprocessWithGD(string $imagePath): string
    {
        try {
            // Load image using GD
            $image = imagecreatefrompng($imagePath);
            if (!$image) {
                // Try JPEG if PNG fails
                $image = imagecreatefromjpeg($imagePath);
            }
            
            if (!$image) {
                Log::warning('GD preprocessing failed - could not load image. Using original.');
                return $imagePath;
            }
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            // Create a new image for processing
            $processedImage = imagecreatetruecolor($width * 2, $height * 2); // Scale 2x
            
            // Set background to black
            $black = imagecolorallocate($processedImage, 0, 0, 0);
            $white = imagecolorallocate($processedImage, 255, 255, 255);
            imagefill($processedImage, 0, 0, $black);
            
            // Define white threshold (how close to white a pixel needs to be)
            $whiteThreshold = 200; // RGB values above this are considered "white-ish"
            
            // Process each pixel
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    $rgb = imagecolorat($image, $x, $y);
                    
                    // Extract RGB values
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    
                    // Check if pixel is close to white
                    if ($r >= $whiteThreshold && $g >= $whiteThreshold && $b >= $whiteThreshold) {
                        // Keep as white, scale up 2x
                        imagesetpixel($processedImage, $x * 2, $y * 2, $white);
                        imagesetpixel($processedImage, $x * 2 + 1, $y * 2, $white);
                        imagesetpixel($processedImage, $x * 2, $y * 2 + 1, $white);
                        imagesetpixel($processedImage, $x * 2 + 1, $y * 2 + 1, $white);
                    }
                    // All other pixels remain black (default background)
                }
            }
            
            // Save processed image
            $processedPath = str_replace('.png', '_gd_white_only.png', $imagePath);
            imagepng($processedImage, $processedPath);
            
            // Clean up memory
            imagedestroy($image);
            imagedestroy($processedImage);
            
            Log::info('Image preprocessed using GD - white pixels only preserved');
            return $processedPath;
            
        } catch (\Exception $e) {
            Log::warning('GD preprocessing failed: ' . $e->getMessage() . '. Using original image.');
            return $imagePath;
        }
    }

    /**
     * Original preprocessing method (kept for reference/fallback)
     */
    private function preprocessImage(string $imagePath): string
    {
        try {
            // Check if ImageMagick is available
            if (!extension_loaded('imagick')) {
                Log::info('ImageMagick not available, using original image');
                return $imagePath;
            }

            $image = new \Imagick($imagePath);
            
            // Convert to grayscale
            $image->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
            
            // Enhance contrast
            $image->contrastImage(true);
            
            // Apply threshold to make text clearer
            $image->thresholdImage(0.5 * \Imagick::getQuantum());
            
            // Scale up image for better OCR (2x)
            $image->scaleImage($image->getImageWidth() * 2, $image->getImageHeight() * 2);
            
            // Apply slight blur reduction
            $image->sharpenImage(0, 1);
            
            // Save processed image
            $processedPath = str_replace('.png', '_processed.png', $imagePath);
            $image->writeImage($processedPath);
            $image->destroy();
            
            Log::info('Image preprocessed successfully');
            return $processedPath;
            
        } catch (\Exception $e) {
            Log::warning('Image preprocessing failed: ' . $e->getMessage() . '. Using original image.');
            return $imagePath;
        }
    }

    /**
     * Test endpoint to check if OCR server is working
     */
    public function test(): JsonResponse
    {
        // Check Tesseract availability
        $tesseractPath = "C:\\Program Files\\Tesseract-OCR\\tesseract.exe";
        $tesseractAvailable = file_exists($tesseractPath);
        
        // Check ImageMagick availability
        $imagickAvailable = extension_loaded('imagick');
        
        // Check GD library availability
        $gdAvailable = extension_loaded('gd');
        
        // Check storage directory
        $storageWritable = Storage::exists('public/temp') || Storage::makeDirectory('public/temp');
        
        return response()->json([
            'success' => true,
            'message' => 'OCR Server is running',
            'tesseract_available' => $tesseractAvailable,
            'tesseract_path' => $tesseractPath,
            'imagemagick_available' => $imagickAvailable,
            'gd_available' => $gdAvailable,
            'storage_writable' => $storageWritable,
            'php_version' => PHP_VERSION,
            'server_time' => now()->toDateTimeString(),
            'preprocessing_method' => $imagickAvailable ? 'ImageMagick (Primary)' : ($gdAvailable ? 'GD Library (Fallback)' : 'None Available')
        ]);
    }

    /**
     * Health check endpoint
     */
    public function health(): JsonResponse
    {
        return response()->json([
            'status' => 'healthy',
            'service' => 'OCR Server',
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}