@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome to 360ºDashboard!</h1>
        <p>This is the 360 Dashboard application.</p>
        <p><a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Login</a>
          @if (Route::has('register'))
          <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">Register</a></p>
          @endif
    </div>
@endsection
