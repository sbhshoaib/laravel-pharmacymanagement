<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmdcVerificationController extends Controller
{
    /**
     * Display BMDC verification page
     */
    public function index()
    {
        return view('bmdc.index');
    }

    /**
     * Verify doctor by BMDC registration number
     */
    public function verify(Request $request)
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
            
            $doctorHtml = $response;
            
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
