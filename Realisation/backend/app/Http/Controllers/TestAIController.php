<?php 

// app/Http/Controllers/TestAIController.php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Http; 

class TestAIController extends Controller 
{ 
    public function testGemini() 
    { 
        $prompt = "Summarize this mood check-in: I'm feeling overwhelmed with tasks, but trying to stay positive."; 
        $apiKey = env('GEMINI_API_KEY');

        // Build the URL with the API key as a query parameter
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

        $response = Http::post($url, [ 
            'contents' => [ 
                [ 
                    'parts' => [ 
                        ['text' => $prompt] 
                    ] 
                ] 
            ] 
        ]); 

        if ($response->successful()) { 
            return response()->json([ 
                'status' => 'success', 
                'result' => $response->json('candidates.0.content.parts.0.text'), 
                'raw' => $response->json() 
            ]); 
        } else { 
            return response()->json([ 
                'status' => 'error', 
                'message' => 'API call failed', 
                'response' => $response->body() 
            ], 500); 
        } 
    }  
}