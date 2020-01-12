<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Reservation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class ReservationController extends Controller
{
    public function create($id)
    {
//        $file_name = Reservation::where('id', $id)->first()->candidate->english_name;
//        $pdf_name = "$file_name.pdf";
//        Browsershot::url(route('reservation-pdf', $id))->savePdf('storage/users/'.$pdf_name);

//        $pdf = PDF::loadHtml('<h1>koko wawa</h1>');

        $pdf = PDF::loadView('pdf.reservation', [
            'reservation' =>\App\Reservation::where('id', $id)->first(),
            'instructions' => \App\Instruction::orderBy('order')->get()
        ]);
        return $pdf->download('invoice.pdf');


//        return '/storage/users/'.$pdf_name;
//
//        return Browsershot::url('/reservation-pdf/1')->save('/users');
    }
}
