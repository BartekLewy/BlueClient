<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blue Client - Panel</title>
    <link rel="stylesheet" href="{{asset('vendor/blue/bootstrap/dist/css/bootstrap.min.css')}}">
    <style>
        nav {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

@component('blue::partials/navbar')
@endcomponent

<div class="container">

@component('blue::partials/flash')
@endcomponent

@yield('content')

</div>

@section('scripts')
    <script src="{{asset('vendor/blue/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/blue/bootstrap/dist/js/bootstrap.min.js')}}"></script>
@endsection
</body>
</html>