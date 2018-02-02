<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <title>FullStack Party</title>
</head>
<body>
    <div id="app" class="app">
        @if(auth()->check())
            <header>
                <a href="{{ route('issues') }}" class="logo" title="FullStack Party"></a>
                <a href="{{ route('logout') }}" class="logout">
                    <i class="icon icon-logout"></i>
                    Logout
                </a>
            </header>
        @endif
        @yield('content')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>