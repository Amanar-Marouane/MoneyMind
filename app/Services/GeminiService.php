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
                                    'text' => "Based on this data: $inputDataString, generate helpful tips for saving money, better management, and more access to achieve the wishes in the wish list, Answer In 4-5 Lines and From Client Insight (Null Categories In Expenses Means That They Were Wishes That Has Been True), And Call The Category By It's Name"
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
