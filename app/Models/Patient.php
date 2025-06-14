<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'is_active'
    ];
    protected $casts = [
        'date_of_birth' => 'date',
    ];
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
    public function latestConsultation()
    {
        return $this->hasOne(Consultation::class)->latest();
    }
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? now()->diffInYears($this->date_of_birth) : null;
    }
    public function getFullNameAttribute()
    {
        return $this->name;
    }
}
