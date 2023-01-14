<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <script src="{{asset('public/js/bootstrap.bundle.js')}}"></script>
    <title>@yield('title')</title>
</head>
<body>
<script src="{{asset('public/js/vue.global.js')}}"></script>
@include('layout.navbar')
@yield('main')


</body>
</html>
