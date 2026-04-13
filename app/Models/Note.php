<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'patient_id',
        'allergies',
        'chronic_diseases',
    ];

    // A note belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
