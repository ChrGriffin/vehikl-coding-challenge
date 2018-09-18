<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        {!! SEO::generate(config('app.env') === 'production') !!}
        <link rel="shortcut icon" href="/favicon.png" />
        <link rel="dns-prefetch" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700" rel="stylesheet" type="text/css" />
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <main>
            @yield('content')
        </main>

        <div class="error-popup">
            <span></span>
        </div>
        
        @include('layouts.components.scripts')
        <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>