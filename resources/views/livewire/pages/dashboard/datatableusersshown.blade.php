<?php

use App\Http\Controllers\cacheStore;
use App\Models\Pelanggan;
use Livewire\Volt\Component;
use function Livewire\Volt\{state};


new class extends Component {
    public $dataTable;
    public array $columnTable = ["No", "Customer Name", "KWH Number", "PriceRate"];

    public function mount()
    {
        $this->dataTable = cacheStore::PelangganListCache();
    }

    public function placeholder()
    {
        return view('placeholder.dashboard.dataTableUserShown', ['title' => "Loading Data Users"]);
    }
};

?>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">
            Payment List
        </h3>
        <x-table.datatables name="IdUser" :columns="$columnTable">
            @foreach($dataTable as $index => $table)
                <tr>
                    <td>{{$index}}</td>
                    <td>{{$table->nama_pelanggan}}</td>
                    <td>{{$table->nomor_kwh}}</td>
                    <td>Rp. {{number_format($table->getTarif->tarif_perkwh,0,',','.')}}</td>
                </tr>
            @endforeach
        </x-table.datatables>
    </div>
</div>
