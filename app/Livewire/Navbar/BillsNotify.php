<?php

namespace App\Livewire\Navbar;

use Livewire\Attributes\On;
use Livewire\Component;

class BillsNotify extends Component
{
    public bool $notify = false;

    #[On('notifyBills')]
    public function notifyBills(): void
    {
        $this->notify = true;
    }
    public function render()
    {
        return view('livewire.navbar.bills-notify');
    }
}
