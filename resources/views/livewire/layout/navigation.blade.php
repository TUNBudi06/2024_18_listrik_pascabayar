<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<header class="topbar">
    <nav x-data="{ open: true }" class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('dashboard')}}">
                <!-- Logo icon -->
                <b>
                    <x-application-logo></x-application-logo>
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span>
            <h2 class="light-logo">Pasca Bayar</h2>
            </span>
            </a>
        </div>
        <x-navbar.collapse></x-navbar.collapse>
    </nav>
</header>
