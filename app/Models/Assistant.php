<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    protected $fillable = ['user_id'];

    // An assistant belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An assistant has many work products
    public function workProducts()
    {
        return $this->hasMany(WorkProduct::class);
    }

    // An assistant has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
