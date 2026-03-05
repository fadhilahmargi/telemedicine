<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Validate the request data
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'penjaga_id' => 'required|exists:users,id',
            'spesialis_id' => 'required|exists:users,id',
        ]);
        // Create a new consultation
        $newConsultation = Consultation::create([
            'patient_id' => $validated['patient_id'],
            'penjaga_id' => $validated['penjaga_id'], // Assuming penjaga_id is the guardian or caretaker
            'spesialis_id' => $validated['spesialis_id'], // Assuming spesialis_id is the specialist doctor
            'notes' => "Tulis Catatan Konsultasi di sini", // Default notes, can be changed later
            'consultation_date' => now(), // Set the current date and time
        ]);
        // Return a JSON response
        return response()->json([
            'message' => 'Consultation created successfully',
            'data' => $newConsultation,
        ], 201);
    }

    public function show($id): JsonResponse
    {
        // Find the consultation by ID
        $consultation = Consultation::findOrFail($id);

        // Return a JSON response with the consultation data
        return response()->json([
            'data' => $consultation,
        ], 200);
    }

    public function update(string $id): JsonResponse
    {
        // Find the consultation by ID
        $consultation = Consultation::findOrFail($id);

        // Validate the request data
        $validated = request()->validate([
            'notes' => 'required|string|max:255',
        ]);

        // Update the consultation notes
        $consultation->update([
            'notes' => $validated['notes'],
        ]);

        // Return a JSON response
        return response()->json([
            'message' => 'Consultation updated successfully',
            'data' => $consultation,
        ], 200);
    }
}
