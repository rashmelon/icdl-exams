<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return $this->respond('All Records Fetched Successfully', $this->applyFilters(Payment::query())->get());
    }

    public function store()
    {
        return $this->respond('Created Successfully', Payment::create(request()->all()));
    }

    public function update($id)
    {
        $category = Payment::find($id);

        $category->update(request()->all());

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        Payment::find($id)->delete();

        return $this->respond('Deleted Successfully');
    }

    private function applyFilters($builder)
    {
        if (\request()->candidate){
            $builder->where('candidate_id', \request()->candidate);
        }
        return $builder;
    }
}
