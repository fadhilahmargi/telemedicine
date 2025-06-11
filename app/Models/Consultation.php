<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'patient_id',
        'spesialis_id',
        'penjaga_id',
        'notes',
        'consultation_date',
    ];

    protected $casts = [
        'consultation_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
