<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="{{ config('app.author', 'Laravel') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Aplikasi Tagihan Listrik Pasca Bayar</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        <!-- Styles -->
        <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="skin-default-dark fixed-layout">
        <div class="main-wrapper">
            <header class="topbar">
                <livewire:layout.navigation />
            </header>
        </div>
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="{{asset('assets/node_modules/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="{{asset("assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="{{asset('dist/js/perfect-scrollbar.jquery.min.js')}}"></script>
        <!--Wave Effects -->
        <script src="{{asset('dist/js/waves.js')}}"></script>
        <!--Menu sidebar -->
        <script src="{{asset('dist/js/sidebarmenu.js')}}"></script>
        <!--stickey kit -->
        <script src="{{asset('assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
        <script src="{{asset('assets/node_modules/sparkline/jquery.sparkline.min.js')}}"></script>
        <!--Custom JavaScript -->
        <script src="{{asset('dist/js/custom.min.js')}}"></script>
    </body>
</html>