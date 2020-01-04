<?php

namespace App;

use App\Traits\CategoryElements;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use CategoryElements;

    protected $fillable = ['name', 'office', 'category_id'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeCandidate($query, $id)
    {
        $query->categoryElements(Candidate::where('id', $id)->first()->skillsCard->category_id);
    }
}
