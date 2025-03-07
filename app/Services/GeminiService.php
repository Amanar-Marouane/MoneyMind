<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $client;
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEY');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$this->apiKey}";
    }

    public function generateTips($inputData)
    {
        try {
            $inputDataString = json_encode($inputData);
            $request = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => "Based on this data: $inputDataString, generate helpful tips for saving money, better financial management, and improving access to achieve the wishes in the wish list. Answer in 4-5 lines, using insights from the client's data. (Note: Null categories in expenses indicate wishes that have been fulfilled.) Refer to each category by its name and provide general advice while being specific about the current month. If there is any event in the current month like Ramadan 2025 ect..., mention it in the tips."
                                ]
                            ]
                        ]
                    ]
                ],
            ]);

            $response = json_decode($request->getBody()->getContents(), true);
            $advice = $response['candidates'][0]['content']['parts'][0]['text'] ?? 'No advice generated';
            return $advice;
        } catch (\Exception $e) {
            Log::error("Gemini API error: " . $e->getMessage());
            return "Error generating tips.";
        }
    }
}
