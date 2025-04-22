<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'complaint'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
