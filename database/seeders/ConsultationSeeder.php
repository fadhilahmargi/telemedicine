<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // You can use a factory to create consultations if you have one defined
        // For example:
         \App\Models\Consultation::factory()->count(50)->create();

        // If you don't have a factory, you can manually create some sample data
        // \App\Models\Consultation::create([
        //     'patient_id' => 1,
        //     'doctor_id' => 1,
        //     'date' => now(),
        //     'time' => '10:00',
        //     'notes' => 'Initial consultation',
        // ]);

        // Add more sample data as needed
    }
}
