@extends('layouts.app')

@section('content')
    <h1>Upload SAFT</h1>
    {!! Form::open(['action' => 'SaftController@store', 'method' => 'POST', 'enctype' => 'multipart/data'] ) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::file('saftFile')}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection


<script type="text/javascript" src="../dist/ParseXml.js">


let jsonfile = parsing('C:/xampp/htdocs/SINF/360dashboard/xmlfiles.moodleExample.xml');
console.log(jsonfile);
</script>