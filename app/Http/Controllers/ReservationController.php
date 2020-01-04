<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Reservation;
use App\Subject;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return $this->respond('All Exams Fetched Successfully', $this->applyFilters(Reservation::query())->get()->sortBy('exam.date')->sortBy('exam.time'));
    }

    public function create()
    {
        return $this->respond('Fetched Successfully', [
            'exams' => Exam::coming()->get(),
        ]);
    }

    public function store()
    {
        $id = Reservation::create(request()->all())->id;
        return $this->respond('Created Successfully', Reservation::where('id', $id)->first());
    }

    public function update($id)
    {
        Reservation::find($id)->update(request()->all());

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        Reservation::find($id)->delete();

        return $this->respond('Deleted Successfully');
    }

    public function applyFilters($builder)
    {
        if (\request()->candidate){
            $builder->where('candidate_id', \request()->candidate);
        }
        if (\request()->exam){
            $builder->where('exam_id', \request()->exam);
        }
        if (\request()->subject){
            $builder->where('subject_id', \request()->subject);
        }
        return $builder;
    }
}
