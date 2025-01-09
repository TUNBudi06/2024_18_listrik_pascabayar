<nav class="sidebar-nav">
    <ul id="sidebarnav">
        <x-sidebar.nav-link href="{{route('dashboard')}}" icon="icon-home" title="--- Dashboard" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-sidebar.nav-link>
        <x-sidebar.nav-link :active="false" icon="fas fa-calendar-alt" href="">
            Electricity bill
        </x-sidebar.nav-link>
    </ul>
</nav>
<!-- End Sidebar navigation -->
