<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PRISME 2026')</title>

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('img/logo/lgo.jpg') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('img/logo/lgo.jpg') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('img/logo/lgo.jpg') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('img/logo/lgo.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo/lgo.jpg') }}">
    <link rel="stylesheet" href="{{ asset('inspire.css') }}">
    <link rel="stylesheet" href="{{ asset('prisme-custom.css') }}">
    
    @stack('styles')
</head>

<body class="boxed">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRISME 2026 |SIPRISME.ORG |siprisme26@prisme.org
    
    <div class="body">
        @include('layouts.partials.header')

        <div class="text-center">
            <img src="{{ asset('img/sha.png') }}" class="slidershadow" alt="">
        </div>

        <!-- /end header -->

        <div class="container">
            @yield('content')
        </div>

        @include('layouts.partials.footer')
    </div>

    <!-- /.body -->

    <!-- Le javascript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('scripts')
</body>

</html>
