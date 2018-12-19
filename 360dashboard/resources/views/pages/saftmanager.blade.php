@extends('layouts.app')

@section('content')


    <form action = "{{route('file.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="input-group mb-3">
  <div class="custom-file">
    <input type="file" class="custom-file-input" name="file" id="file">
    <label class="custom-file-label" for="file">Choose file</label>
  </div>
  <div class="ml-2 input-group-prepend">
    <button class="input-group-text" type="submit"> Submit file</button>
  </div>
</div>
</form>


@endsection
