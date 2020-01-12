@extends('Layouts.app')

@section('content')
    <candidate-payment :candidate="{{$candidate}}"></candidate-payment>
@endsection
