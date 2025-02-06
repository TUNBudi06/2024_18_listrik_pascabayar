@use(\App\Http\Controllers\users\guardItems)

<x-app-layout>
    <x-slot name="styleCSS">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    </x-slot>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center ps-5">
            <h4 class="text-themecolor">Welcome, {{guardItems::getUserIfLoginResultName()}}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end pe-4">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Payment And Confirmation</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container">
        <livewire:pages.generetereport.content/>
    </div>

    <x-slot name="scriptJS">
        <script src="{{asset('dist/js/pages/jquery.PrintArea.js')}}" type="text/JavaScript"></script>
        <script src="{{ asset('assets/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net/lib/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net/lib/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net/lib/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net/lib/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net/lib/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net/lib/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/datatables.net/lib/buttons.flash.min.js') }}"></script>
    </x-slot>
</x-app-layout>
