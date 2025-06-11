<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        // Logic for listing patients
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        \App\Models\Patient::create($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Patient successfully added!');
    }

    public function destroy($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient successfully deleted!');
    }
}
