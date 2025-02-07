<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partidas do Time</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-4">
        <a href="/" class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">
            Voltar para as Ligas
        </a>
        @if(!isset($teamName) || $teamName != '')
            <h1 class="text-3xl font-bold text-center mb-8">Partidas do Time: {{ $teamName }}</h1>
            <div class="bg-yellow-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <p>
                    Se não houver dados exibidos, a API pode não ter funcionado corretamente. 
                    Recarregue a página para conferir.
                </p>
            </div>
            @if (isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $error }}
                </div>
            @endif
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Próximos Jogos</h2>
                @if (isset($scheduledMatches) && count($scheduledMatches) > 0)
                    <ul class="space-y-4">
                        @foreach ($scheduledMatches as $match)
                            <li class="border-b border-gray-200 pb-4">
                                <div class="flex justify-between items-center">
                                    <div class="flex-1 text-center">
                                        <a href="/team/{{ $match['homeTeam']['id'] }}" class="text-blue-500 hover:underline">
                                            <span class="font-semibold">{{ $match['homeTeam']['name'] }}</span>
                                        </a>
                                    </div>
                                    <div class="flex-1 text-center">
                                        <span class="text-gray-500">vs</span>
                                    </div>
                                    <div class="flex-1 text-center">
                                        <a href="/team/{{ $match['awayTeam']['id'] }}" class="text-blue-500 hover:underline">
                                            <span class="font-semibold">{{ $match['awayTeam']['name'] }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center text-sm text-gray-600 mt-2">
                                    <span>{{ \Carbon\Carbon::parse($match['utcDate'])->format('d/m/Y H:i') }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center text-gray-600">Nenhum jogo programado no momento.</p>
                @endif
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 mt-8">
                <h2 class="text-2xl font-bold mb-4">Últimos Resultados</h2>
                @if (isset($finishedMatches) && count($finishedMatches) > 0)
                    <ul class="space-y-4">
                        @foreach ($finishedMatches as $match)
                            <li class="border-b border-gray-200 pb-4">
                                <div class="flex justify-between items-center">
                                    <div class="flex-1 text-center">
                                        <a href="/team/{{ $match['homeTeam']['id'] }}" class="text-blue-500 hover:underline">
                                            <span class="font-semibold">{{ $match['homeTeam']['name'] }}</span>
                                        </a>
                                    </div>
                                    <div class="flex-1 text-center">
                                        <span class="text-gray-500">{{ $match['score']['fullTime']['home'] ?? '?' }} -
                                            {{ $match['score']['fullTime']['away'] ?? '?' }}</span>
                                    </div>
                                    <div class="flex-1 text-center">
                                        <a href="/team/{{ $match['awayTeam']['id'] }}" class="text-blue-500 hover:underline">
                                            <span class="font-semibold">{{ $match['awayTeam']['name'] }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center text-sm text-gray-600 mt-2">
                                    <span>{{ \Carbon\Carbon::parse($match['utcDate'])->format('d/m/Y H:i') }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center text-gray-600">Nenhum resultado recente disponível.</p>
                @endif
            </div>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $error ?? 'A API de futebol está indisponível no momento. Recarregue a pagina.' }}
            </div>
            <div class="bg-yellow-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <p>
                    A API pode não ter funcionado corretamente. 
                    Recarregue a página para conferir.
                </p>
            </div>
        @endif

    </div>
</body>

</html>