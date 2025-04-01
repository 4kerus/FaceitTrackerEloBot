<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FaceitService
{
    protected string $apiUrl = 'https://open.faceit.com/data/v4';
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.faceit.api_key');
    }

    public function getCurrentElo(string $nickname)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get("{$this->apiUrl}/players?nickname={$nickname}");

            if ($response->failed()) {
                Log::error('getCurrentElo error: ' . $response->body());

                return null;
            }

            $elo = $response->json()['games']['cs2']['faceit_elo'] ?? null;
            $lvl = $response->json()['games']['cs2']['skill_level'] ?? null;

            return ['elo' => $elo, 'lvl' => $lvl,];
        } catch (\Exception $e) {
            Log::error('getCurrentElo error: ' . $e->getMessage());

            return null;
        }
    }
}
