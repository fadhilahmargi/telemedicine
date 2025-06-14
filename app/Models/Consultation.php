<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $table = 'consultations'; // pastikan sesuai nama tabel

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function spesialis()
    {
        return $this->belongsTo(User::class, 'spesialis_id');
    }
    public function penjaga()
    {
        return $this->belongsTo(User::class, 'penjaga_id');
    }
}
