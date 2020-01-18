<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\SkillsCard;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        return $this->respond('All Records Fetched Successfully', $this->applyFilters(Candidate::with(['skillsCard.category']))->get());
    }

    public function store()
    {
        $data = request()->all();

        $candidate = Candidate::create($data);

        if (array_key_exists('skills_card_id', $data)){
            SkillsCard::where('id', $data['skills_card_id'])->first()->update(['used' => 1]);
        }

        return $this->respond('Created Successfully', Candidate::where('id', $candidate->id)->with('skillsCard')->first());
    }

    public function update($id)
    {
        $candidate = Candidate::find($id);

        $data = request()->all();

        if (array_key_exists('skills_card_id', $data)){
            SkillsCard::where('id', $data['skills_card_id'])->first()->update(['used' => 1]);
        }

        $candidate->update($data);

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        Candidate::find($id)->delete();

        return $this->respond('Deleted Successfully');
    }

    public function applyFilters($builder)
    {
        if (request()->search){
            $builder->search(\request()->search);
        }
        if (request()->category_id){
            $builder->category(\request()->category_id);
        }
        return $builder;
    }
}
