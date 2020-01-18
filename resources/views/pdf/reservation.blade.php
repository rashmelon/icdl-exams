@extends('Layouts.app')

@section('content')
    <div dir="rtl" id="main-container-pdf">
        <div id="exam-data">
            <div>
                <img src="{{asset('logo.png')}}" id="reservation-logo">
                <h1 class="text-center my-5">
                    ايصال حضور امتحان
                </h1>
            </div>
            <table class="text-center w-100" id="reservation-table">
                <tr>
                    <td>الحجز</td>
                    <td>:</td>
                    <td>{{date('d-m-Y')}}</td>
                </tr>
                <tr>
                    <td>المادة</td>
                    <td>:</td>
                    <td>{{$reservation->subject->name}}</td>
                </tr>
                <tr>
                    <td>ميعاد الامتحان</td>
                    <td>:</td>
                    <td>{{date('d-m-Y', strtotime($reservation->exam->date))}}  الساعة  {{date('g:i', strtotime($reservation->exam->time))}}</td>
                </tr>
                <tr>
                    <td>الاسم</td>
                    <td>:</td>
                    <td>{{$reservation->candidate->english_name}}</td>
                </tr>
                @if($reservation->candidate->skillsCard)
                <tr>
                    <td>رقم بطاقة المهارة</td>
                    <td>:</td>
                    <td>{{$reservation->candidate->skillsCard->number}}</td>
                </tr>
                @endif
            </table>

        </div>

        <h2 style="text-align: right;text-decoration: underline; margin-top: 30px;">تعليمات هامة:-</h2>

        <div>
            <ol dir="rtl">
                @foreach($instructions as $instruction)
                    <li>{{$instruction->name}}</li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection
