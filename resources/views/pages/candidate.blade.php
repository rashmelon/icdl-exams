@extends('Layouts.app')

@section('content')
    <candidate :category="{{$category}}"></candidate>
@endsection
