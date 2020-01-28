<?php

namespace App;

use App\Traits\ReservationElements;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use ReservationElements;

    protected $fillable = ['date', 'time'];

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery()->reservationsCount()->officeCount()->noOfficeCount();
    }

    public function scopeComingToday($query)
    {
        return $query->where('date', '>=', today());
    }

    public function scopeComing($query)
    {
        return $query->where('date', '>', today());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', today());
    }

    public function scopeOfficeCount($query)
    {
        $query->withCount(['reservations as office_count'=> function ($query){
            $query->whereHas('subject', function ($query){
                $query->where('office', 0);
            });
        }]);
    }

    public function scopeNoOfficeCount($query)
    {
        $query->withCount(['reservations as no_office_count' => function ($query){
            $query->whereHas('subject', function ($query){
                $query->where('office', 1);
            });
        }]);
    }
}
