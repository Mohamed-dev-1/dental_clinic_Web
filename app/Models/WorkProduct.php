<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkProduct extends Model
{
    protected $fillable = [
        'assistant_id',
        'material_name',
        'material_qty',
        'material_unit_price',
        'material_expiration_date',
        'material_low_stock_alert',
    ];

    // A work product belongs to an assistant
    public function assistant()
    {
        return $this->belongsTo(Assistant::class);
    }
}
