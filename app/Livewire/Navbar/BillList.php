<?php

namespace App\Livewire\Navbar;

use Livewire\Component;

class BillList extends Component
{
    public array $example = ['status'=>false,'bulan'=>'Januari','tahun'=>'2021','jumlah_meter'=>2000];
    public $bills;

    public function boot()
    {
        $this->bills[] = $this->example;
        $this->bills[] = $this->example;
        $this->dispatch('notifyBills');
    }

    public function render()
    {
        return view('livewire.navbar.bill-list');
    }
}
