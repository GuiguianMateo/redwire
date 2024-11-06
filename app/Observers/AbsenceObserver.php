<?php

namespace App\Observers;

use App\Models\Absence;
use Carbon\Carbon;

class AbsenceObserver
{
    /**
     * Handle the Absence "created" event.
     */
    public function created(Absence $absence): void
    {
        $this->updateUserJourConge($absence);
    }

    /**
     * Handle the Absence "updated" event.
     */
    public function updated(Absence $absence): void
    {
        $this->updateUserJourConge($absence);
    }

    /**
     * Calcule et met à jour les jours de congé de l'utilisateur.
     */
    protected function updateUserJourConge(Absence $absence): void
    {
        $user = $absence->user;

        // Calculer la durée de l'absence
        $dateDebut = Carbon::parse($absence->date_debut);
        $dateFin = Carbon::parse($absence->date_fin);
        $joursAbsence = $dateDebut->diffInDays($dateFin) + 1; // Inclure le jour de début et de fin

        // Mettre à jour les jours de congé restants
        $user->jour_conge -= $joursAbsence;
        $user->save();
    }
}
