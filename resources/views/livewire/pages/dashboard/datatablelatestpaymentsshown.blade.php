<?php

use App\Http\Controllers\cacheStore;
use App\Models\Pelanggan;
use Livewire\Volt\Component;
use function Livewire\Volt\{state};


new class extends Component {
    public $dataTable;
    public array $columnTable = ["No", "Customer Name", "Total KWH", "Payout Date", "Price", 'status'];

    public function mount()
    {
        $this->dataTable = cacheStore::PaymentPelangganListCache();
    }

    public function placeholder()
    {
        return view('placeholder.dashboard.dataTableUserShown', ['title' => 'Loading Data Payments']);
    }
};

?>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">
            User List
        </h3>
        <x-table.datatables name="IdUser" :columns="$columnTable">
            @foreach($dataTable as $index => $table)
                <tr>
                    <td>{{$index}}</td>
                    <td>{{$table->PelangganKWH->nama_pelanggan}}</td>
                    <td>{{$table->tagihanKWH->jumlah_meter}}</td>
                    <td>{{$table->tanggal_pembayaran}}</td>
                    <td>Rp. {{number_format($table->total_tagihan,0,',','.')}}</td>
                    <td>
                        @if($table->tagihanKWH->status == true)
                            <div class="btn btn-success rounded-3">Success</div>
                        @else
                            <div class="btn btn-danger rounder">Failed</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table.datatables>
    </div>
</div>
