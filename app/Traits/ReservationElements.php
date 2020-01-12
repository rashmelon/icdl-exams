<?php

namespace App\Traits;

use App\Category;
use App\Reservation;

trait ReservationElements
{
    public function scopeReservationsCount($query)
    {
        $query->withCount('reservations');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
