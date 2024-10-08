<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $motif_id
 * @property string $date_debut
 * @property string $date_fin
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \App\Models\Motif $motif
 * @property-read \App\Models\User $user
 *
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
 *
 * @mixin \Eloquent
 */
class Absence extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function motif()
    {
        return $this->belongsTo(Motif::class);
    }
}
