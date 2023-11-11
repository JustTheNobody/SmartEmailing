<!DOCTYPE html>
<html lang="cs">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="MartinM">

    <script src="{{ asset('/js/jquery-3.6.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/uikit.min.js') }}"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/uikit.min.css') }}" />
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <title>Test | @yield('title')</title>
</head>
<body>

    <div id="app" class="uk-padding-large-top uk-padding-large" uk-height-viewport="min-height: 100%;">

        {{--Header--}}
        @include('header')
        {{--Content--}}
        <main class="uk-margin-bottom uk-height uk-content">
            @yield('content')

        </main>
        {{--Footer--}}
        <footer class="uk-margin-large-top uk-background-muted">
            @include('footer')
        </footer>
    </div>

    {{--uk-notification-message TO ReDO - is it in use now?--}}
    @foreach( ['success', 'fail', 'info'] as $type )
        @if(session($type))
            <script>
                internalMessage('{{ $type }}', "{{ session($type) }}");
            </script>
        @endif
    @endforeach

</body>
</html>