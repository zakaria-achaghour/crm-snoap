<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('layout/img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap-responsive.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/datepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/uniform.css') }}" />
    <link rel="stylesheet" media="all and (min-width: 701px)" href="{{ asset('layout/css/select2.css') }}">
    <link rel="stylesheet" media="screen and (max-width: 700px)" href="{{ asset('layout/css/select21.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/matrix-style.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/matrix-media.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('layout/css/main.css') }}" />
    <script src="{{ asset('layout/js/jquery.min.js') }}"></script>
</head>

<body>
    <div id="error_content">
        <div class="container-fluid">
            <div class="error_widget-content">
                <div class="error_ex">
                    <h1>403</h1>
                    <h3>Opps, vous êtes perdu</h3>
                    <p>L'accès à cette page est interdit</p>
                    <a class="btn btn-warning btn-big" href="{{ url()->previous() }}">Retour</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('layout/js/bootstrap.js') }}"></script>
    <script src="{{ asset('layout/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('layout/js/jquery.uniform.js') }}"></script>
    <script src="{{ asset('layout/js/select2.min.js') }}"></script>
    <script src="{{ asset('layout/js/matrix.js') }}"></script>
    <script src="{{ asset('layout/js/matrix.tables.js') }}"></script>
    <script src="{{ asset('layout/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('layout/js/jquery.datetimepicker.min.js') }}"></script>



</body>

</html>
