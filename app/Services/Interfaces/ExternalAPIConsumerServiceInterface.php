<?php
    namespace App\Services\Interfaces;

    interface ExternalAPIConsumerServiceInterface
    {
        public function loadCompetitions(): array|string;
        public function loadNextMatches(int $competitionId) : array|string;
        public function loadLatestResults(int $competitionId): array|string;
        public function loadTeamMatches(int $teamId): array|string;
    }
