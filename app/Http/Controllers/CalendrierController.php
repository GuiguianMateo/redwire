<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absence;

class CalendrierController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer le mois et l'année (ou utiliser le mois/année courant)
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Créer une instance de Carbon pour la date
        $date = Carbon::create($year, $month, 1);

        // Générer les jours du mois
        $calendar = $this->generateCalendarDays($date);

        // Récupérer les absences pour le mois et l'année en cours
        $absences = Absence::whereMonth('date_debut', '<=', $month)
                           ->whereMonth('date_fin', '>=', $month)
                           ->whereYear('date_debut', '<=', $year)
                           ->whereYear('date_fin', '>=', $year)
                           ->with('user')
                           ->get();

        // Passer les données à la vue
        return view('calendrier.calendrier', [
            'calendar' => $calendar,
            'currentMonth' => $date->translatedFormat('F'),
            'year' => $year,
            'month' => $month,
            'prevYear' => $date->copy()->subYear()->year,
            'nextYear' => $date->copy()->addYear()->year,
            'prevMonth' => $date->copy()->subMonth()->month,
            'nextMonth' => $date->copy()->addMonth()->month,
            'absences' => $absences, // On passe bien la variable absences ici
        ]);
    }



    private function generateCalendarDays(Carbon $date)
    {
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $calendar = [];
        $weekIndex = 0;

        // Commencer à partir du début de la semaine (Lundi)
        $current = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);

        while ($current <= $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY)) {
            $calendar[$weekIndex][] = [
                'date' => $current->copy(),
                'isCurrentMonth' => $current->month === $date->month,
                'isToday' => $current->isToday(),
            ];

            if ($current->dayOfWeek === Carbon::SUNDAY) {
                $weekIndex++;
            }

            $current->addDay();
        }

        return $calendar;
    }

    private function calculateAbsenceBars($absences, $calendar)
    {
        $absenceBars = [];

        foreach ($absences as $absence) {
            $startDate = $absence->date_debut;
            $endDate = $absence->date_fin;

            // Trouver les indices des jours dans le calendrier
            $daysInAbsence = [];

            // Parcourir chaque semaine et chaque jour dans le calendrier
            foreach ($calendar as $week) {
                foreach ($week as $day) {
                    // Si la date du jour est dans la période de l'absence, on l'ajoute
                    if ($day['date']->between($startDate, $endDate)) {
                        $daysInAbsence[] = $day['date']->day;
                    }
                }
            }

            // Ajouter les données de l'absence avec les jours spécifiques
            $absenceBars[] = [
                'user' => $absence->user->name,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'days' => $daysInAbsence,  // Jours spécifiques où l'absence est active
            ];
        }

        return $absenceBars;
    }


}

