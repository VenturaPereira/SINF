@extends('layouts.app')

@section('content')
    <form action = "{{route('file.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="file" id="file">
        <button type="submit">Submit</button>
@endsection

