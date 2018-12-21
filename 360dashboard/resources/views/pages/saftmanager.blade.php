@extends('layouts.app')

@section('content')


    <form action = "{{route('file.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <h3> Upload SAFT and check there is connection with VM (API) on port 4001 </h3>
        <div class="input-group mb-3">
            <div class="custom-file">
              <input required type="file" class="custom-file-input" name="file" id="file">
              <label class="custom-file-label" for="file">Choose file</label>
            </div>
            <div class="ml-2 input-group-prepend">
              <button class="input-group-text" type="submit"> Submit file</button>
            </div>
        </div>
      </form>


@endsection
