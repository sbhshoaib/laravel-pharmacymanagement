<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiSuggestController extends Controller
{
    /**
     * Display the AI Suggest menu page
     */
    public function index()
    {
        return view('ai-suggest.index');
    }

    /**
     * Display the Medicine Information page
     */
    public function medicineInfo()
    {
        $medicines = DB::select("SELECT m.id, m.name, g.name as generic_name 
                                FROM medicines m 
                                LEFT JOIN generics g ON m.generic_id = g.id 
                                ORDER BY m.name");
        
        return view('ai-suggest.medicine-info', compact('medicines'));
    }

    /**
     * Get AI-generated information about a specific medicine
     */
    public function getMedicineInfo(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|integer'
        ]);

        $medicine = DB::selectOne("SELECT m.name, g.name as generic_name 
                                FROM medicines m 
                                LEFT JOIN generics g ON m.generic_id = g.id 
                                WHERE m.id = ?", [$request->medicine_id]);

        if (!$medicine) {
            return response()->json([
                'success' => false,
                'message' => 'Medicine not found'
            ], 404);
        }

        $medicineName = $medicine->name;
        $genericName = $medicine->generic_name;

        try {
            $prompt = "Give me this medicine information, Side effects, Dosage and Amount of dosage, Indications and other necessary information. The medicine is {$medicineName}  generic is {$genericName}";
            

          //  echo $prompt;
           // exit;
            $response = $this->callAiApi($prompt);
            
            return response()->json([
                'success' => true,
                'message' => 'Medicine information generated successfully',
                'medicine_name' => $medicineName,
                'generic_name' => $genericName,
                'information' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating medicine information: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the Medicine Suggestion page
     */
    public function medicineSuggest()
    {
        return view('ai-suggest.medicine-suggest');
    }

    /**
     * Get AI-suggested medicines based on symptoms
     */
    public function getSuggestion(Request $request)
    {
        $request->validate([
            'symptoms' => 'required|string|min:5'
        ]);

        try {
            // Get all medicines from the database
            $medicines = DB::select("SELECT m.name, g.name as generic_name 
                                    FROM medicines m 
                                    LEFT JOIN generics g ON m.generic_id = g.id");
            
            // Format medicine list for the prompt
            $medicineList = "";
            foreach ($medicines as $medicine) {
                $medicineList .= "- {$medicine->name} ({$medicine->generic_name})\n";
            }
            
            $prompt = "I give you symptoms and medicine names from our pharmacy. Find necessary medicine for these symptoms. If none are suitable, suggest generic names for medicines needed for the patient.\n\nSymptoms: {$request->symptoms}\n\nAvailable Medicines:\n{$medicineList}";
            
            $response = $this->callAiApi($prompt);
            
            return response()->json([
                'success' => true,
                'message' => 'Medicine suggestions generated successfully',
                'suggestions' => $response,
                'symptoms' => $request->symptoms
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating medicine suggestions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Call the OpenRouter AI API
     */
    private function callAiApi($prompt)
    {



            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://openrouter.ai/api/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "model": "deepseek/deepseek-r1-0528:free",
            "messages": [
                {
                "role": "user",
                "content": "'.$prompt.'"
                }
            ]
            
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer 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'
            ),
            ));





       
        
        $response = curl_exec($curl);

    
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            throw new \Exception('Error calling OpenRouter API: ' . $err);
        }
        
        $responseData = json_decode($response, true);
        
        if (!isset($responseData['choices'][0]['message']['content'])) {
           return $response;
        }
        
        return $responseData['choices'][0]['message']['content'];
    }
}
