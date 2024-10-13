<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $titre
 * @property int $is_accessible_salarie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Absence> $absence
 * @property-read int|null $absence_count
 *
 * @method static \Database\Factories\MotifFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif query()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereIsAccessibleSalarie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Motif extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the absences associated with the motif.
     *
     * @return HasMany<\App\Models\Absence>
     */
    public function absence(): HasMany
    {
        return $this->hasMany(Absence::class);
    }
}
