<?php

namespace App;

use App\Traits\CategoryElements;
use Illuminate\Database\Eloquent\Model;

class SkillsCard extends Model
{
    use CategoryElements;

    protected $fillable = ['number', 'category_id', 'used'];

    public function scopeUnused($query)
    {
        $query->where('used', 0);
    }
}
