<?php

namespace App\Livewire\Actions;

use App\Http\Controllers\users\guardItems;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        guardItems::checkGuardsIfLoginResultAuthClass()->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}
