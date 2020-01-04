<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['national_id','english_name','arabic_name','mobile1','mobile2','tests','money','notes','skills_card_id'];

    protected $with = ['skillsCard'];

    public function skillsCard()
    {
        return $this->belongsTo(SkillsCard::class, 'skills_card_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeSearch($query, $search)
    {
        $query
            ->orWhere('arabic_name', 'like', "%$search%")
            ->orWhere('english_name', 'like', "%$search%")
            ->orWhere('national_id', 'like', "%$search%")
            ->orWhere('mobile1', 'like', "%$search%")
            ->orWhere('mobile2', 'like', "%$search%")
            ->orWhereHas('skillsCard', function ($query) use($search){
                $query->where('number', 'like', "%$search%");
            });
    }
}
