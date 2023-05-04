<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .login-container{
            margin-top: 5%;
            margin-bottom: 5%;
        }
        .login-logo img{
            position: absolute;
            width: 20%;
            margin-top: 19%;
            background: #282726;
            border-radius: 4.5rem;
            padding: 5%;
        }
        .login-form-1{
            padding: 9%;
            background:#f05837;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }
        .login-form-1 h3{
            text-align: center;
            margin-bottom:12%;
            color:#fff;
        }
        .login-form-2{
            padding: 9%;
            background:#282726;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }
        .login-form-2 h3{
            text-align: center;
            margin-bottom:12%;
            color: #fff;
        }
        .btnSubmit{
            font-weight: 600;
            width: 50%;
            color: #282726;
            background-color: #fff;
            border: none;
            border-radius: 1.5rem;
            padding:2%;
        }

    </style>

</head>
<body>
<div id="app">

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
