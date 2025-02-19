<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $motif_id
 * @property string $date_debut
 * @property string $date_fin
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Motif $motif
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\AbsenceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Absence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereMotifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence withoutTrashed()
 * @mixin \Eloquent
 */
class Absence extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the user that owns the absence.
     *
     * @return BelongsTo<User, Absence>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the motif associated with the absence.
     *
     * @return BelongsTo<Motif, Absence>
     */
    public function motif(): BelongsTo
    {
        return $this->belongsTo(Motif::class);
    }

    protected static function booted()
    {
        static::created(function ($absence) {
            $absence->updateUserConge();
        });

        static::updated(function ($absence) {
            $absence->updateUserConge();
        });


    }
    public function updateUserConge()
{
    $user = $this->user; // Assurez-vous que cette relation fonctionne

    // Calcul des jours pris
    $joursPris = $user->absence->sum(function ($absence) {
        return Carbon::parse($absence->date_debut)->diffInDays(Carbon::parse($absence->date_fin)) + 1;
    });

    $quotaConges = $user->jours_conge_initial ?? 50; // Quota initial
    $joursRestants = max(0, $quotaConges - $joursPris);

    // Mise à jour des jours restants
    $user->jour_conge = $joursRestants;
    $user->save();

    // Création de la notification
    $message = "Votre solde de congés a été mis à jour : {$joursRestants} jours restants. Raison : " .
               ($this->wasRecentlyCreated ? "Nouvelle absence ajoutée" : "Absence modifiée");

    \App\Models\Notification::create([
        'user_id' => $user->id,
        'message' => $message,
    ]);
}





}

