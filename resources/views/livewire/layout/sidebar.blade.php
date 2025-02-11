<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <x-sidebar.navigation>
            <x-sidebar.nav-link route="dashboard" icon="icon-home" title="--- Dashboard">
                Dashboard
            </x-sidebar.nav-link>
            @if(\App\Http\Controllers\users\guardItems::checkGuardsIfLoginResultTypeUser() == 'pelanggan')
                <x-sidebar.nav-link route="electricBills" icon="fas fa-calendar-alt">
                    Electricity bill
                </x-sidebar.nav-link>
                <x-sidebar.nav-link route="UsageHistory" icon=" fas fa-history">
                    Payment History
                </x-sidebar.nav-link>
            @endif
            @if(\App\Http\Controllers\users\guardItems::checkGuardsIfLoginResultTypeUser() == 'admin')
                <x-sidebar.nav-link route="listTariff" title="---- Bank Management" icon="fas fa-money-bill-wave">
                    Tariff Price
                </x-sidebar.nav-link>
                <x-sidebar.nav-link route="make-payment" icon="mdi mdi-contacts">
                    Make Billing
                </x-sidebar.nav-link>
                <x-sidebar.nav-link icon=" fas fa-check-square" route="confirm-and-pay">
                    Pay&Confirm
                </x-sidebar.nav-link>
                <x-sidebar.nav-link icon="fas fa-newspaper" route="generate-report">
                    Generate Report
                </x-sidebar.nav-link>
            @endif
            <x-sidebar.nav-link icon="fa fa-user" title="---  Master" route="customer-management">
                Manage Customer
            </x-sidebar.nav-link>
            <x-sidebar.nav-link icon="fa fa-user">
                Manage Admin
            </x-sidebar.nav-link>
        </x-sidebar.navigation>
    </div>
</aside>
