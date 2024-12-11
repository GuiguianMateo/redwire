@extends('layouts.app')

@section('content')

<div id="calendar"></div>
{{-- <div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex justify-between items-center p-4 bg-gray-100">
            <div class="flex items-center space-x-2">
                <a href="{{ route('calendrier.index', ['year' => $prevYear, 'month' => $month]) }}"
                   class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    &lt; Année
                </a>
                <a href="{{ route('calendrier.index', ['year' => $year, 'month' => $prevMonth]) }}"
                   class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    &lt; Mois
                </a>
            </div>

            <h2 class="text-xl font-bold">{{ $currentMonth }} {{ $year }}</h2>

            <div class="flex items-center space-x-2">
                <a href="{{ route('calendrier.index', ['year' => $year, 'month' => $nextMonth]) }}"
                   class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Mois &gt;
                </a>
                <a href="{{ route('calendrier.index', ['year' => $nextYear, 'month' => $month]) }}"
                   class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Année &gt;
                </a>
            </div>
        </div>

        <div class="p-4 relative">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse relative">
                    <thead>
                        <tr>
                            <th class="p-2 border text-center">Lun.</th>
                            <th class="p-2 border text-center">Mar.</th>
                            <th class="p-2 border text-center">Mer.</th>
                            <th class="p-2 border text-center">Jeu.</th>
                            <th class="p-2 border text-center">Ven.</th>
                            <th class="p-2 border text-center">Sam.</th>
                            <th class="p-2 border text-center">Dim.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($calendar as $week)
                            <tr>
                                @foreach ($week as $day)
                                    <td class="p-4 border relative {{ $day['isCurrentMonth'] ? '' : 'bg-gray-100' }}">
                                        <div class="flex justify-center">
                                            <span>{{ $day['date']->day }}</span>
                                        </div>

                                        <!-- Affichage des absences dans les cases -->
                                        @foreach ($absences as $absence)
                                            @if ($day['date']->between($absence->date_debut, $absence->date_fin))
                                                <!-- Utilisation de divs avec position relative et absolute -->
                                                <div class="absolute bottom-0 left-0 right-0 bg-red-500 text-white text-xs text-center py-1 px-2 rounded">
                                                    {{ $absence->user->name }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}
@endsection
