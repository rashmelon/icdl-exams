<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return $this->respond('All Subjects Fetched Successfully', $this->applyFilters(Subject::orderBy('name', 'desc'))->get());
    }

    public function store()
    {
        return $this->respond('Created Successfully', Subject::create(request()->all()));
    }

    public function update($id)
    {
        $skills_card = Subject::find($id);

        $skills_card->update(request()->all());

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        Subject::find($id)->delete();

        return $this->respond('Deleted Successfully');
    }

    public function applyFilters($builder)
    {
        if (request()->category_id){
            $builder->categoryElements(\request()->category_id);
        }
        if (request()->candidate){
            $builder->candidate(request()->candidate);
        }
        return $builder;
    }
}
