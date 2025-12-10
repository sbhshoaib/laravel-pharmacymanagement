<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PrescriptionVerificationController extends Controller
{
    /**
     * Upload and process a prescription image
     */
    public function upload(Request $request)
    {
        $request->validate([
            'prescription_file' => 'required|image|max:2048',
        ]);

        try {
            // Upload the image to a temporary location
            $image = $request->file('prescription_file');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('temp/prescriptions', $imageName, 'public');
            
            // Get the full path to the image
            $fullPath = Storage::path('public/' . $imagePath);
            
            return response()->json([
                'success' => true,
                'message' => 'Prescription uploaded successfully',
                'image_path' => $imagePath,
                'full_path' => $fullPath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload prescription: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Extract text from the prescription image using Tesseract OCR
     */
    public function extractText(Request $request)
    {
        $request->validate([
            'image_path' => 'required|string'
        ]);

        try {
            $imagePath = Storage::path('public/' . $request->image_path);
            
            // Check if Tesseract OCR executable exists
            $tesseractPath = "C:\\Program Files\\Tesseract-OCR\\tesseract.exe";
            if (!file_exists($tesseractPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tesseract OCR executable not found',
                    'path_checked' => $tesseractPath
                ], 500);
            }
            
            // Run Tesseract OCR
            $command = "\"$tesseractPath\" " . escapeshellarg($imagePath) . " stdout -l eng";
            $extractedText = shell_exec($command);
            
            if (empty($extractedText)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to extract text from the image'
                ], 500);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Text extracted successfully',
                'extracted_text' => $extractedText
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error extracting text: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Extract BMDC registration number using OpenRouter AI API
     */
    public function extractBmdcNumber(Request $request)
    {
        $request->validate([
            'extracted_text' => 'required|string'
        ]);

        try {
            $extractedText = $request->extracted_text;
            
            // Set up cURL request to OpenRouter AI API
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://openrouter.ai/api/v1/chat/completions',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    'model' => 'deepseek/deepseek-r1-0528:free',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => "from the text I gave you now, find out the bmdc registration no and give me response only the bmdc reg no, No need extra text, just one number will be the response, nothing much. and if its A-10808 or something like that, give me only the number like 10808. the text is following: $extractedText"
                        ]
                    ]
                ]),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer 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'
                ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error calling OpenRouter API: ' . $err
                ], 500);
            }
            
            $responseData = json_decode($response, true);
            
            if (!isset($responseData['choices'][0]['message']['content'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid response from OpenRouter API',
                    'response' => $responseData
                ], 500);
            }
            
            $bmdcNumber = trim($responseData['choices'][0]['message']['content']);
            
            return response()->json([
                'success' => true,
                'message' => 'BMDC number extracted successfully',
                'bmdc_number' => $bmdcNumber,
                'full_response' => $responseData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error extracting BMDC number: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify the doctor using the BMDC API
     */
    public function verifyDoctor(Request $request)
    {
        $request->validate([
            'bmdc_number' => 'required|string'
        ]);

        try {
            $bmdcNumber = $request->bmdc_number;
            
            $url = "http://localhost/apitest/bmdc.php?bmdc=" . $bmdcNumber;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            
            $response = curl_exec($curl);
            
            // Get detailed curl information
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $redirect_count = curl_getinfo($curl, CURLINFO_REDIRECT_COUNT);
            $redirect_url = curl_getinfo($curl, CURLINFO_REDIRECT_URL);
            $effective_url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
            
            curl_close($curl);
            
            // Check for "Not Found" response
            if (strpos($response, 'Not Found') !== false || $http_code === 404) {
                return response()->json([
                    'success' => false,
                    'message' => 'Doctor verification failed: No doctor found with this registration number',
                    'bmdc_number' => $bmdcNumber,
                    'http_code' => $http_code,
                    'raw_response' => $response
                ]);
            }
            /*
            if (!$redirect_url) {
                return response()->json([
                    'success' => false,
                    'response' => $response,
                    'bmdcNumber' => $bmdcNumber,
                    'message' => 'Doctor verification failed: No doctor found with this registration number',
                ]);
            }


            
            // Get doctor details from the redirect URL
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $redirect_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: bmdckyc_csrf_cookie=cca97d1e378c94f92f88c575d4228be6; bmdckyc_sessions=b6jibnjjgu3kgtn539t7finest25bjik'
                ),
            ));
            */
            $doctorHtml = $response;
            curl_close($curl);
            
            // Remove unwanted elements from the HTML
            $dom = new \DOMDocument();
            // Suppress warnings for malformed HTML
            libxml_use_internal_errors(true);
            $dom->loadHTML($doctorHtml);
            libxml_clear_errors();
            
            $xpath = new \DOMXPath($dom);
            $elements = $xpath->query('//*[contains(@class, "img-holder")]');
            
            // Remove elements from back to front to avoid index issues
            for ($i = $elements->length - 1; $i >= 0; $i--) {
                $element = $elements->item($i);
                $element->parentNode->removeChild($element);
            }
            
            // Get the modified HTML
            $modifiedHtml = $dom->saveHTML();
            
            // Extract doctor information
            $doctorName = $this->extractTextBetween($doctorHtml, '<h3 class="mb-4 font-weight-bold text-center">', '</h3>');
            $doctorQualification = $this->extractTextBetween($doctorHtml, '<h3>Registered ', ' Doctor</h3>');
            $doctorRegistration = $this->extractTextBetween($doctorHtml, '<h3 class="badge badge-pill badge-success mt-1 mb-3 font-weight-bold d-block text-center text-white">', '</h3>');
            $doctorStatus = $this->extractTextBetween($doctorHtml, '<span class="text-warning font-weight-bold">', '</span>');
            
            // If we couldn't extract the registration number from the HTML, use the provided BMDC number
            if (empty($doctorRegistration)) {
                $doctorRegistration = $bmdcNumber;
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Doctor verified successfully',
                'doctor_info' => [
                    'name' => $doctorName ?: 'Cant Retrive', // Fallback if extraction fails
                    'registration' => $doctorRegistration,
                    'qualification' => $doctorQualification ? $doctorQualification : 'MBBS', // Fallback if extraction fails
                    'status' => $doctorStatus ?: 'ACTIVE' // Fallback if extraction fails
                ],
                'html' => '<div class="form-holder">' . $modifiedHtml . '</div>'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error verifying doctor: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Helper function to extract text between two strings
     */
    private function extractTextBetween($text, $start, $end)
    {
        $startPos = strpos($text, $start);
        if ($startPos === false) {
            return '';
        }
        
        $startPos += strlen($start);
        $endPos = strpos($text, $end, $startPos);
        
        if ($endPos === false) {
            return '';
        }
        
        return trim(strip_tags(substr($text, $startPos, $endPos - $startPos)));
    }
}
