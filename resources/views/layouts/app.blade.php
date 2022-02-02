<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ str_replace('-', ' ', config('app.name')) }} @yield('title')</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('layout/img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap-responsive.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/datepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/jquery.datetimepicker.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('layout/css/uniform.css') }}" />
    <link rel="stylesheet" media="all and (min-width: 701px)" href="{{ asset('layout/css/select2.css') }}">
    <link rel="stylesheet" media="screen and (max-width: 700px)" href="{{ asset('layout/css/select21.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/matrix-style.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/matrix-media.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap-tagsinput.css') }}" />
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
    <link rel="stylesheet" href="{{ asset('layout/css/jquery-ui.css') }}" />

   <!-- <script src="{ asset('layout/js/sweetalert.min.js') }}"></script>-->
   <script src="{{ asset('layout/js/jquery.min.js') }}"></script>
   <link rel="stylesheet" href="{{ asset('layout/css/sweetalert2.min.css') }}" />
   
   <script src="{{ asset('layout/js/sweetalert2.all.min.js') }}"></script>
   
   <link rel="stylesheet" href="{{ asset('layout/css/main.css') }}" />
</head>

<body>

    @include('layouts.dashboard.preloader')
    @include('layouts.dashboard.header')
    <div id="content">
        @yield('content')
    </div>

    @include('layouts.dashboard.footer')

   
    
    <script src="{{ asset('layout/js/bootstrap.js') }}"></script>
    <script src="{{ asset('layout/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('layout/js/jquery.uniform.js') }}"></script>
    <script src="{{ asset('layout/js/select2.min.js') }}"></script>
    <script src="{{ asset('layout/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('layout/js/matrix.js') }}"></script>
    <script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
    <script src="{{ asset('layout/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('layout/js/jquery.datetimepicker.min.js') }}"></script>
    <script src="{{ asset('layout/js/jquery-ui.js') }}"></script>
    <script>
        
    </script>

   
   


    {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
    
</body>

</html>
