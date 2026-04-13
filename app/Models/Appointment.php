<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'complaint',
        'consultation_room',
        'speciality',
        'status'
    ];

    // An appointment belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // An appointment belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // An appointment has one medical document
    public function medicalDocument()
    {
        return $this->hasOne(MedicalDocument::class);
    }
}
