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
        return $this->respond('All Exams Fetched Successfully', $this->applyFilters(Reservation::query())->get());
    }

    public function create()
    {
        return $this->respond('Fetched Successfully', [
            'exams' => Exam::coming()->orderBy('date', 'asc')->orderBy('time', 'asc')->get(),
        ]);
    }

    public function store()
    {
        if (Reservation::where('exam_id', \request()->exam_id)->where('candidate_id', \request()->candidate_id)->first()){
            return $this->respond('Candidate already assigned in this exam', [], 422);
        }

        if (Reservation::where('subject_id', \request()->subject_id)
            ->where('candidate_id', \request()->candidate_id)
            ->whereHas('exam', function($query){
                $query->where('date', '>', today());
            })->first()){
            return $this->respond('Candidate already assigned to this subject', [], 422);
        }

        if (Reservation::where('exam_id', \request()->exam_id)->count() < 20){
            $id = Reservation::create(request()->all())->id;
            return $this->respond('Created Successfully', Reservation::where('id', $id)->with([
                'candidate' => function ($query){
                    $query->reservationsCount()->paymentCount()->paidSum();
                }])->first());
        }
        else{
            return $this->respond('Exam is full', [], 422);
        }
    }

    public function update($id)
    {
         $reservation = Reservation::find($id);
        if (Reservation::where('exam_id', \request()->exam_id)->where('candidate_id', $reservation->candidate_id)->where('id', '!=', $id)->first()){
            return $this->respond('Candidate already assigned in this exam', [], 422);
        }

        if (Reservation::where('subject_id', \request()->subject_id)
            ->where('candidate_id', $reservation->candidate_id)
            ->where('id', '!=', $id)
            ->whereHas('exam', function($query){
                $query->where('date', '>', today())->where('id', '!=', \request()->exam_id);
            })->first()){
            return $this->respond('Candidate already assigned to this subject', [], 422);
        }

        if (Reservation::where('exam_id', \request()->exam_id)->count() < 20 || $reservation->exam_id == \request()->exam_id){
            Reservation::find($id)->update(request()->all());

            return $this->respond('Updated Successfully');
        }
        else{
            return $this->respond('Exam is full', [], 422);
        }
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
