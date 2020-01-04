<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['date', 'time'];

    public function scopeComing($query)
    {
        return $query->where('date', '>', now());
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
