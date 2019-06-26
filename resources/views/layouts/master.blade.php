<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    @yield('stylesheets')
</head>

<body class="d-flex h-100 wrapper">
        @include('partials.sidebar')
        <div class="page-content-wrapper d-flex flex-column">
            @include('partials.header')
            <main role="main" class="container-fluid">
                @yield('content')
            </main>
            @include('partials.footer')
        </div>

@yield('scripts')
</body>
</html>
