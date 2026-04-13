<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['user_id', 'speciality'];

    // A doctor belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A doctor has many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // A doctor has many medical documents
    public function medicalDocuments()
    {
        return $this->hasMany(MedicalDocument::class);
    }
}
