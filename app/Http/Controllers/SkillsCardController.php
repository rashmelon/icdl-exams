<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\SkillsCard;
use Illuminate\Http\Request;

class SkillsCardController extends Controller
{
    public function index()
    {
        return $this->respond('All Skills Fetched Successfully', $this->applyFilters(SkillsCard::orderBy('used', 'asc')->orderBy('number', 'asc')->with('category'))->get());
    }

    public function store()
    {
        return $this->respond('Created Successfully', SkillsCard::create(request()->all()));
    }

    public function update($id)
    {
        $skills_card = SkillsCard::find($id);

        $skills_card->update(request()->all());

        if (\request()->used == 0){
            $candidate = Candidate::where('skills_card_id', $id)->first();
            if ($candidate){
                $candidate->skills_card_id = null;
                $candidate->save();
            }
        }

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        SkillsCard::find($id)->delete();

        return $this->respond('Deleted Successfully');
    }

    public function applyFilters($builder)
    {
        if (\request()->category_id){
            $builder->categoryElements(\request()->category_id);
        }
        if (\request()->unused){
            $builder->unused();
        }
        return $builder;
    }
}
