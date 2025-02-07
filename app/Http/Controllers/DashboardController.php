<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ExternalAPIConsumerServiceInterface;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class DashboardController extends Controller
{
    private readonly ExternalAPIConsumerServiceInterface $consumerService;

    public function __construct(ExternalAPIConsumerServiceInterface $service)
    {
        $this->consumerService = $service;
    }

    public function loadHome(Request $request)
    {
        $competitionsResponse = $this->consumerService->loadCompetitions();
        if (gettype($competitionsResponse) === gettype('')) {
            return view('dashboard.home', [
                'error' => 'Erro de conexão! Tente novamente.',
            ]);
        }

        $competitions = $competitionsResponse['competitions'] ?? [];
        
        if (empty($competitions)) {
            return view('dashboard.home', [
                'error' => 'Não foi possível carregar as ligas. Tente novamente mais tarde.',
            ]);
        }

        $selectedCompetitionId = $request->input('competition');

        $nextMatches = [];
        $latestResults = [];
        if ($selectedCompetitionId) {
            $nextMatches = $this->consumerService->loadNextMatches($selectedCompetitionId);
            if (gettype($nextMatches) === gettype('')) {
                return view('dashboard.home', [
                    'error' => 'Erro de conexão! Tente novamente.',
                ]);
            }

            $latestResults = $this->consumerService->loadLatestResults($selectedCompetitionId);
            if (gettype($latestResults) === gettype('')) {
                return view('dashboard.home', [
                    'error' => 'Erro de conexão! Tente novamente.',
                ]);
            }
        }
        
        return view('dashboard.home', [
            'competitions' => $competitions,
            'selectedCompetitionId' => $selectedCompetitionId,
            'nextMatches' => $nextMatches,
            'latestResults' => $latestResults,
        ]);
    }

    public function showTeam(int $teamId)
    {
        $teamMatches = $this->consumerService->loadTeamMatches($teamId);
        if (empty($teamMatches)) {
            return view('dashboard.team', [
                'error' => 'Não foi possível carregar as partidas do time. Tente novamente mais tarde.',
            ]);
        }
        $teamMatches = $teamMatches['matches'];
        $scheduledMatches = array_filter($teamMatches, function ($match) {
            return $match['status'] === 'SCHEDULED';
        });

        $finishedMatches = array_filter($teamMatches, function ($match) {
            return $match['status'] === 'FINISHED';
        });

        $teamName = $teamMatches[0]['homeTeam']['id'] == $teamId
            ? $teamMatches[0]['homeTeam']['name']
            : $teamMatches[0]['awayTeam']['name'];

        return view('dashboard.team', [
            'teamName' => $teamName,
            'scheduledMatches' => array_values($scheduledMatches),
            'finishedMatches' => array_values($finishedMatches),
        ]);
    }
}