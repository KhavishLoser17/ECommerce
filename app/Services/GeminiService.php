<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        // Get these from your .env file
        $this->apiKey = env('GEMINI_API_KEY');
        $this->model = env('GEMINI_MODEL', 'gemini-2.0-flash'); // Default to 2.0-flash, but allow override in .env
        $this->baseUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    public function generateResponse(string $prompt)
    {
        try {
            // Check if API key is available
            if (empty($this->apiKey)) {
                Log::error('Gemini API key is missing');
                return 'Error: API key is not configured. Please check your .env file.';
            }

            // Prepare request data
            $requestData = [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => trim($prompt)]
                        ]
                    ]
                ]
            ];

            // Log the request (without sensitive data)
            Log::debug('Sending request to Gemini API', [
                'model' => $this->model,
                'prompt_length' => strlen($prompt)
            ]);

            // Make the request using Laravel's HTTP client
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("{$this->baseUrl}?key={$this->apiKey}", $requestData);

            // Log the response status
            Log::debug('Gemini API response received', [
                'status_code' => $response->status(),
                'successful' => $response->successful()
            ]);

            // Handle non-successful responses
            if (!$response->successful()) {
                Log::error('Gemini API returned error', [
                    'status_code' => $response->status(),
                    'response' => $response->body()
                ]);

                return 'Error from Gemini API (Status: ' . $response->status() . '). Please try again later.';
            }

            // Parse the response
            $responseData = $response->json();

            // Check for expected response structure
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                return trim($responseData['candidates'][0]['content']['parts'][0]['text']);
            } else {
                Log::warning('Unexpected Gemini API response structure', [
                    'response' => $responseData
                ]);

                // Check for specific error messages
                if (isset($responseData['error'])) {
                    return 'Error from Gemini API: ' . ($responseData['error']['message'] ?? 'Unknown error');
                }

                return 'No response generated. Please try again.';
            }
        } catch (Exception $e) {
            Log::error('Gemini API error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return 'Error connecting to AI service: ' . $e->getMessage();
        }
    }
}
