<?php

namespace App\Http\Controllers;

use App\Models\Consultation;

class HistoryController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['patient', 'spesialis', 'penjaga'])->get();
        return view('history.index', compact('consultations'));
    }
}
