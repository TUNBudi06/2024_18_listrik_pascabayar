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
                    <li class="breadcrumb-item active">Usage History</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container">
        <livewire:pages.Usagehistory.content lazy/>
    </div>
</x-app-layout>
