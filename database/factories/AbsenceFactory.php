<?php

namespace Database\Factories;

use App\Models\Motif;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absence>
 */
class AbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'motif_id' => Motif::factory()->create()->id,
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->dateTimeBetween($date_debut, 'now'),
        ];
    }
}
