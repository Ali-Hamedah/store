<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;

    protected $baseUrl = 'https://v6.exchangerate-api.com/v6/9235813176c9e06c98bafcb8/latest/USD';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert(string $from, string $to, float $amount = 1): float
    {
       
        $url = "https://v6.exchangerate-api.com/v6/9235813176c9e06c98bafcb8/latest/{$from}";
    
        $response = Http::get($url);
    
        if ($response->successful()) {
            $data = $response->json();
            
            if (isset($data['conversion_rates'][$to])) {
                $rate = $data['conversion_rates'][$to]; 
                return $rate * $amount; 
           
            } else {
                Log::error("Conversion rate for {$to} not found in API response.", ['response' => $data]);
                throw new \Exception("Conversion rate for {$to} not found.");
            }
        } else {
           
            Log::error("Failed to fetch conversion rates from API.", [
                'status_code' => $response->status(),
                'response' => $response->body(),
            ]);
            throw new \Exception("Failed to fetch conversion rates. Status: {$response->status()}");
        }
    }
    
    
}