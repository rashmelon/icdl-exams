@extends('Layouts.app')

@section('content')
    <skills-card :category="{{$category}}"></skills-card>
@endsection
