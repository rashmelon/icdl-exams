@extends('Layouts.app')

@section('content')
    <view-candidate :candidate="{{$candidate}}" :reservations="{{$reservations}}"></view-candidate>
@endsection
