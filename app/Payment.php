<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['candidate_id', 'amount'];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('d/m/Y', strtotime($date));
    }
}
