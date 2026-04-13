<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['user_id'];

    // A patient belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A patient has many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // A patient has many medical documents
    public function medicalDocuments()
    {
        return $this->hasMany(MedicalDocument::class);
    }

    // A patient has one note
    public function note()
    {
        return $this->hasOne(Note::class);
    }

    // A patient has many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // A patient belongs to many doctors
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctors_patients');
    }
}
