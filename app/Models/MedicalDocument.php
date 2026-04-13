<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalDocument extends Model
{
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'diagnosis',
        'treatment_plan',
        'prescription'
    ];

    // A medical document belongs to an appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // A medical document belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // A medical document belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
