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

    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('complaint')->nullable();
            $table->timestamps();
        });
    }

    
}
