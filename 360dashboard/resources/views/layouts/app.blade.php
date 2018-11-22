<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Company Dashboard</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>


    </head>

    <body>
        @include('inc.navbar')
        <div class="container">
            @yield('content')
        </div>
    </body>

</html>
