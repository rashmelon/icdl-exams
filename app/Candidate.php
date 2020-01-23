<?php

namespace App;

use App\Traits\ReservationElements;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Candidate extends Model
{
    use ReservationElements;

    protected $fillable = ['national_id','english_name','arabic_name','mobile1','mobile2','tests','money','notes','skills_card_id', 'certificate_state', 'finished', 'absence'];

    protected $with = ['skillsCard'];

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery()->reservationsCount()->paymentCount()->paidSum();
    }

    public function skillsCard()
    {
        return $this->belongsTo(SkillsCard::class, 'skills_card_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
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

    public function scopeCategory($query, $id)
    {
        $query->whereHas('skillsCard', function ($query) use($id){
            $query->where('category_id', $id);
        });
    }

    public function scopePaymentCount($query)
    {
        $query->withCount('payments');
    }

    public function scopePaidSum($query)
    {
        $query->withCount([
            'payments AS paid_sum' => function ($query) {
                $query->select(DB::raw("SUM(amount) as paid_sum"));
            }
        ]);
    }

    public function scopeUnAssigned($query)
    {
        $query->where('skills_card_id', null);
    }
}
