<?php

namespace App\Traits;

use App\Category;

trait CategoryElements
{
    public function scopeCategoryElements($query, $id)
    {
        $query->where('category_id', $id);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
