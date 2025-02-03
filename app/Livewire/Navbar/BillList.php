<?php

namespace App\Livewire\Navbar;

use App\Http\Controllers\users\guardItems;
use App\Models\TagihanKWH;
use Livewire\Component;

class BillList extends Component
{
    public array $example = ['status' => false, 'bulan' => 'Januari', 'tahun' => '2021', 'jumlah_meter' => 2000];

    public $bills;

    public function boot()
    {
        $this->bills = TagihanKWH::with(['PembayaranKWH'])->where('pelanggan_id', guardItems::checkGuardsIfLoginResultId())->where('status', 0)->get()
            ->filter(function ($item) {
                return isset($item->PembayaranKWH);
            });
        if ($this->bills->count() > 0) {
            $this->dispatch('notifyBills');
        }
    }

    public function render()
    {
        return view('livewire.navbar.bill-list');
    }
}
