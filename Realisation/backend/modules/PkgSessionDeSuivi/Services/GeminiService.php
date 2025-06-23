<?php

namespace Modules\PkgSessionDeSuivi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;

class GeminiService
{
    private Client $httpClient;
    private string $apiKey;
    private string $baseUrl;
    private string $model;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-1.5-flash');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
        
        if (empty($this->apiKey)) {
            throw new Exception('Gemini API key is not configured');
        }
    }

    public function analyzeStudentResponses(array $studentData): string
    {
        try {
            $prompt = $this->buildAnalysisPrompt($studentData);
            
            $response = $this->httpClient->post($this->baseUrl . $this->model . ':generateContent', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'key' => $this->apiKey
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 1024,
                    ]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            
            if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                return $body['candidates'][0]['content']['parts'][0]['text'];
            } else {
                throw new Exception('Invalid response format from Gemini API: ' . json_encode($body));
            }
            
        } catch (RequestException $e) {
            $errorBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            throw new Exception('Gemini API request failed: ' . $e->getMessage() . ' - Response: ' . $errorBody);
        } catch (Exception $e) {
            throw new Exception('AI analysis failed: ' . $e->getMessage());
        }
    }

    private function buildAnalysisPrompt(array $studentData): string
    {
        $prompt = "Vous êtes un conseiller pédagogique analysant les réponses des étudiants au formulaire de suivi. Fournissez une analyse BRÈVE en 2 lignes maximum.\n\n";
        
        $prompt .= "Informations sur l'étudiant :\n";
        $prompt .= "- ID étudiant : {$studentData['student_id']}\n";
        $prompt .= "- Formulaire de suivi : {$studentData['form_title']}\n";
        $prompt .= "- Date de soumission : {$studentData['submitted_at']}\n\n";
        
        $prompt .= "Questions et réponses de l'étudiant :\n";
        foreach ($studentData['answers'] as $index => $qa) {
            $prompt .= ($index + 1) . ". Question : {$qa['question']}\n";
            $prompt .= "   Réponse : {$qa['answer']}\n";
            $prompt .= "   Type : {$qa['question_type']}\n\n";
        }
        
        $prompt .= "Fournissez un résumé concis en 1 à 2 phrases couvrant :\n";
        $prompt .= "1. Sentiment général et observation clé\n";
        $prompt .= "2. Niveau de risque (Faible/Moyen/Élevé) et recommandation principale\n\n";
        $prompt .= "Format : [Sentiment] - [Observation clé]. Risque : [Niveau] - [Recommandation brève].\n";
        $prompt .= "Exemple : Positif - L'étudiant fait preuve d'une bonne gestion du temps en terminant ses devoirs tôt. Risque : Faible - Continuer à surveiller l'équilibre vie professionnelle/vie personnelle.\n\n";
        $prompt .= "Restez professionnel et ne dépassez pas 2 lignes.";
        
        return $prompt;
    }
    

    public function testConnection(): array
    {
        try {
            $response = $this->httpClient->post($this->baseUrl . $this->model . ':generateContent', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'key' => $this->apiKey
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => 'Hello, please respond with "Connection successful" to test the API.'
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            
            return [
                'success' => true,
                'message' => 'API connection successful',
                'response' => $body['candidates'][0]['content']['parts'][0]['text'] ?? 'No response text',
                'model_used' => $this->model
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'API connection failed: ' . $e->getMessage(),
                'model_attempted' => $this->model
            ];
        }
    }

    public function getAvailableModels(): array
    {
        // Common model names based on current Gemini API
        return [
            'gemini-1.5-flash',
            'gemini-1.5-pro',
            'gemini-1.5-flash-002',
            'gemini-1.5-pro-002',
            'gemini-2.0-flash-exp',
            'gemini-pro' // Legacy, might not work
        ];
    }
}