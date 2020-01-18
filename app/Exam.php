<?php

namespace App;

use App\Traits\ReservationElements;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use ReservationElements;

    protected $fillable = ['date', 'time'];

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery()->reservationsCount();
    }

    public function scopeComing($query)
    {
        return $query->where('date', '>=', today());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', today());
    }
}
