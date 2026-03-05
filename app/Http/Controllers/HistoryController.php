<?php

namespace App\Http\Controllers;

use App\Models\Consultation;

class HistoryController extends Controller
{
    public function index()
    {
        $consultations = Consultation::all();
//        dd($consultations);
        return view('history.index', compact('consultations'));
    }
}
