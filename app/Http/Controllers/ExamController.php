<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        return $this->respond('All Exams Fetched Successfully', $this->applyFilters(Exam::orderBy('date', 'asc')->orderBy('time', 'asc'))->get());
    }

    public function store()
    {
        return $this->respond('Created Successfully', Exam::create(request()->all()));
    }

    public function update($id)
    {
        Exam::find($id)->update(request()->all());

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        Exam::find($id)->delete();

        return $this->respond('Deleted Successfully');
    }

    public function applyFilters($builder)
    {
        if (\request()->coming){
            $builder->coming();
        }
        return $builder;
    }
}
