<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'patient_id',
        'title',
        'message',
        'type',
        'is_read',
    ];

    // A notification belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
