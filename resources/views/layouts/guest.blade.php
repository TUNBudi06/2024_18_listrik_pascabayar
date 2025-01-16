<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
        <title>Aplikasi Tagihan Listrik Pasca Bayar</title>

        <!-- page css -->
        <link href="{{asset("dist/css/pages/login-register-lock.css")}}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="skin-default card-no-border">
    <section id="wrapper">
        {{ $slot }}
    </section>

    <!-- ============================================================== -->
    <script src="{{asset('assets/node_modules/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{'assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'}}"></script>
    <!--Custom JavaScript -->
    </body>
</html>
