@use(\App\Http\Controllers\users\guardItems)

<x-app-layout>
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
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Info box -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            @if(guardItems::checkGuardsIfLoginResultTypeUser() === "pelanggan")
                <livewire:pages.dashboard.info-box-user type="totalUsageThisYearNow" class="round align-self-center round-primary" lazy />
                <livewire:pages.dashboard.info-box-user type="totalUsageYearBefore" class="round align-self-center round-info" lazy />
                <livewire:pages.dashboard.info-box-user type="paymentAndKWHLastMonth" class="round align-self-center round-info" lazy />
                <livewire:pages.dashboard.info-box-user type="tarifKWHShown" class="round align-self-center round-info" lazy />
            @else
                <livewire:pages.dashboard.info-box-user type="totalAllUsagesInYear" class="round align-self-center round-primary" lazy />
                <livewire:pages.dashboard.info-box-user type="totalAllUsagesLastYear" class="round align-self-center round-info" lazy />
                <livewire:pages.dashboard.info-box-user type="totalPaymentHasBeenPayout" class="round align-self-center round-success" lazy />
                <livewire:pages.dashboard.info-box-user type="totalPelanggans" class="round align-self-center round-info" lazy />
            @endif
            <div class="col-12">
                <livewire:pages.dashboard.datatableusersshown type="ListAllCustomer" lazy />
            </div>
        <!-- Row -->
        </div>
    </div>
</x-app-layout>
