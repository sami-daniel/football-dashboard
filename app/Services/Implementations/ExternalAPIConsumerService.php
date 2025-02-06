<?php

namespace App\Services\Implementations;

use App\Services\Interfaces\ExternalAPIConsumerServiceInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ExternalAPIConsumerService implements ExternalAPIConsumerServiceInterface
{
    private const API_URI = "https://api.football-data.org/v4";
    private const AUTH_HEADER = "X-Auth-Token";
    
    private function loadApiToken(): string {
        $token = getenv("API_TOKEN");
        assert($token != "", "The API_TOKEN should be defined in .env file.");
        return $token;
    }

    public function loadCompetitions(): array|string
    {
        $url = self::API_URI . "/competitions";
        try {
            $response = Http::withHeaders([
                self::AUTH_HEADER => $this->loadApiToken(),
            ])->get($url);
        } catch (ConnectionException $e) {
            return "Erro de conexão. Tente novamente mais tarde.";
        }

        return $response->successful() ? $response->json() : [];
    }

    public function loadNextMatches(int $competitionId): array|string
    {
        $url = self::API_URI . "/competitions/{$competitionId}/matches";
        
        try {
            $response = Http::withHeaders([
                self::AUTH_HEADER => $this->loadApiToken(),
            ])->get($url);
        } catch (ConnectionException $e) {
            return  "Erro de conexão. Tente novamente mais tarde.";
        }

        if ($response->successful()) {
            $data = $response->json();
            $scheduledMatches = array_filter($data['matches'], function ($match) {
                return $match['status'] === 'SCHEDULED';
            });
            return array_values($scheduledMatches);
        }

        return [];
    }

    public function loadLatestResults(int $competitionId): array|string
    {
        $url = self::API_URI . "/competitions/{$competitionId}/matches";
        try {
            $response = Http::withHeaders([
                self::AUTH_HEADER => $this->loadApiToken(),
            ])->get($url);
        } catch (ConnectionException $e) {
            return  "Erro de conexão. Tente novamente mais tarde.";
        }

        if ($response->successful()) {
            $data = $response->json();
            $finishedMatches = array_filter($data['matches'], function ($match) {
                return $match['status'] === 'FINISHED';
            });
            return array_values($finishedMatches);
        }

        return [];
    }

    public function loadTeamMatches(int $teamId): array|string
    {
        $url = self::API_URI . "/teams/{$teamId}/matches";
        try {
            $response = Http::withHeaders([
                self::AUTH_HEADER => $this->loadApiToken(),
            ])->get($url);
        } catch (ConnectionException $e) {
            return "Erro de conexão. Tente novamente mais tarde.";
        }

        return $response->successful() ? $response->json() : [];
    }
}
