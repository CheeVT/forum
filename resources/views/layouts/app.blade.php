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

    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'loggedIn' => Auth::check(),
            'user' => Auth::user()
        ]) !!};
    </script>

    <style>
        .level { display: flex; align-items: center; }
        .flex { flex: 1; }
        .mr-1 { margin-right: 1em; }
        .ml-1 { margin-left: 1em; }
        .mr-a { margin-right: auto; }
        .article-header {
            display: flex;
            align-items: center;            
            justify-content: space-between;
        }
        .article-header--title {
            flex: 1;
        }

        .panel-footer--reply {
            display: flex;
            justify-content: flex-end;
            margin: 0 10px 10px 0;
        }
    </style>
</head>
<body>
    <div id="app">
        @include('layouts.partials._nav')

        <main class="py-4">
            @yield('content')

            <flash-message message="{{ session('flash') }}"></flash-message>
        </main>
    </div>
</body>
</html>
