<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['patient_id', 'product_name', 'quantity', 'note'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
}
