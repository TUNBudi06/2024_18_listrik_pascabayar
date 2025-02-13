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
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- ============================================================== -->
        <!-- Info box -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            @if(guardItems::checkGuardsIfLoginResultTypeUser() === "pelanggan")
                <livewire:pages.dashboard.info-box-user type="totalUsageThisYearNow"
                                                        class="round align-self-center round-primary" lazy/>
                <livewire:pages.dashboard.info-box-user type="totalUsageYearBefore"
                                                        class="round align-self-center round-info" lazy/>
                <livewire:pages.dashboard.info-box-user type="paymentAndKWHLastMonth"
                                                        class="round align-self-center round-info" lazy/>
                <livewire:pages.dashboard.info-box-user type="tarifKWHShown" class="round align-self-center round-info"
                                                        lazy/>
                <livewire:pages.dashboard.datatablepaymentbyuserslistshown lazy/>
            @else
                <livewire:pages.dashboard.info-box-user type="totalAllUsagesInYear"
                                                        class="round align-self-center round-primary" lazy/>
                <livewire:pages.dashboard.info-box-user type="totalAllUsagesLastYear"
                                                        class="round align-self-center round-info" lazy/>
                <livewire:pages.dashboard.info-box-user type="totalPaymentHasBeenPayout"
                                                        class="round align-self-center round-success" lazy/>
                <livewire:pages.dashboard.info-box-user type="totalPelanggans"
                                                        class="round align-self-center round-info" lazy/>
                <div class="col-12">
                    <livewire:pages.dashboard.datatableusersshown lazy/>
                </div>
                <div class="col-12">
                    <livewire:pages.dashboard.datatablelatestpaymentsshown lazy/>
                </div>
                <div class="col-12">
                    <livewire:pages.dashboard.datatableadminslistshown lazy/>
                </div>
            @endif
            <!-- Row -->
        </div>
    </div>
    <x-slot name="scriptJS">
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
