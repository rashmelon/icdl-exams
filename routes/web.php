<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/reserve', function () {
    return view('pages.reserve');
});


Route::group(['prefix' => 'category'], function (){
    Route::view('', 'pages.category');

    Route::get('{id}', function ($id){
        return view('pages.view_category', ['category' =>\App\Category::find($id)]);
    });

    Route::get('{id}/skills-card', function ($id){
        return view('pages.skills_card', ['category' =>\App\Category::find($id)]);
    });

    Route::get('{id}/subject', function ($id){
        return view('pages.subject', ['category' =>\App\Category::find($id)]);
    });

    Route::get('{id}/candidate', function ($id){
        return view('pages.candidate', ['category' =>\App\Category::find($id)]);
    });

});


Route::group(['prefix' => 'exam'], function (){
    Route::view('', 'pages.exam');

    Route::get('{id}', function ($id){
        return view('pages.view_exam', ['exam' =>\App\Exam::find($id)]);
    });

});

Route::get('payment/{id}', function ($id){
    return view('pages.candidate_payment', ['candidate' =>\App\Candidate::find($id)]);
});

Route::get('reservation-pdf/{id}', function ($id){
    return view('pdf.reservation', [
        'reservation' =>\App\Reservation::where('id', $id)->first(),
        'instructions' => \App\Instruction::orderBy('order')->get()
    ]);
})->name('reservation-pdf');

Route::get('generate-reservation-pdf/{id}', 'PDF\ReservationController@create');

Route::view('instruction', 'pages.instruction');


Route::get('candidate/{id}', function ($id){
    return view('pages.view_candidate', [
        'candidate' => \App\Candidate::where('id', $id)->with(['skillsCard.category'])->first(),
    ]);
})->name('reservation-pdf');

Route::view('excel', 'pages.submit_excel');
