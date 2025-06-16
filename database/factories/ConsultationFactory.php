<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultation>
 */
class ConsultationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::factory(),
            'spesialis_id' => \App\Models\User::factory()->state(['role' => 'spesialis']),
            'penjaga_id' => \App\Models\User::factory()->state(['role' => 'penjaga']),
            'consultation_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'notes' => $this->faker->text(200),
        ];
    }
}
