<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecione uma Liga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-4">
        @if(!empty($competitions)) 
            <h1 class="text-3xl font-bold text-center mb-8">Selecione uma Liga</h1>
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

            <form action="/" method="GET" class="mb-8">
                <select name="competition" onchange="this.form.submit()" class="w-full p-2 border border-gray-300 rounded">
                    <option value="">Selecione uma liga</option>
                    @foreach ($competitions as $competition)
                        <option value="{{ $competition['id'] }}" {{ $selectedCompetitionId == $competition['id'] ? 'selected' : '' }}>
                            {{ $competition['name'] }}
                        </option>
                    @endforeach
                </select>
            </form>

            @if ($selectedCompetitionId && !isset($error))
                <h2 class="text-2xl font-bold mb-4">Próximos Jogos</h2>
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    @if (count($nextMatches) > 0)
                        <ul class="space-y-4">
                            @foreach ($nextMatches as $match)
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

                <h2 class="text-2xl font-bold mb-4">Últimos Resultados</h2>
                <div class="bg-white shadow-md rounded-lg p-6">
                    @if (count($latestResults) > 0)
                        <ul class="space-y-4">
                            @foreach ($latestResults as $match)
                                <li class="border-b border-gray-200 pb-4">
                                    <div class="flex justify-between items-center">
                                        <div class="flex-1 text-center">
                                            <a href="/team/{{ $match['homeTeam']['id'] }}" class="text-blue-500 hover:underline">
                                                <span class="font-semibold">{{ $match['homeTeam']['name'] }}</span>
                                            </a>
                                        </div>
                                        <div class="flex-1 text-center">
                                            <span class="text-gray-500">{{ $match['score']['fullTime']['home'] }} - {{ $match['score']['fullTime']['away'] }}</span>
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
            @endif
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $error ?? 'A API de futebol está indisponível no momento. Tente novamente.' }}
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