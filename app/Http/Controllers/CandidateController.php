<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\CandidateRequest;
use App\SkillsCard;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        $paginate = \request()->paginate;
        $builder = $this->applyFilters(Candidate::with(['skillsCard.category']));
        if ($paginate){
            $response = $builder->paginate($paginate);
        }
        else{
            $response = $builder->get();
        }
        return $this->respond('All Records Fetched Successfully', $response);
    }

    public function store(CandidateRequest $request)
    {
        $data = $request->validated();

        if (Candidate::where('skills_card_id', $data['skills_card_id'])->first()){
            return $this->respond('Skills card already assigned to a candidate', [], 422);
        }

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

        if (Candidate::where('skills_card_id', $data['skills_card_id'])->first()){
            return $this->respond('Skills card already assigned to a candidate', [], 422);
        }

        if (array_key_exists('skills_card_id', $data)){
            SkillsCard::where('id', $data['skills_card_id'])->first()->update(['used' => 1]);
        }

        $candidate->update($data);

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        $candidate = Candidate::find($id);

        SkillsCard::where('id', $candidate->skills_card_id)->first()->update(['used' => 0]);

        $candidate->delete();

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
        if (request()->unassigned){
            $builder->unAssigned();
        }
        return $builder;
    }
}
