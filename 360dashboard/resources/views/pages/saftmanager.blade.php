@extends('layouts.app')

@section('content')
    <h1>Upload SAFT</h1>
    {!! Form::open(['action' => 'SaftController@store', 'method' => 'POST'] ) !!}
        <div class="form-group">
        </div>
    {!! Form::close() !!}
@endsection