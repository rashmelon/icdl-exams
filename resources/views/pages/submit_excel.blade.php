@extends('Layouts.app')

@section('content')
    <form action="/api/excel" method="post">
        <input type="file" name="excel">
        <input type="submit" value="submit">
    </form>
@endsection
