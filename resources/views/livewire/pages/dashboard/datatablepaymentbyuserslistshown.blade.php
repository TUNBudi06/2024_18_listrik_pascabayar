<?php

use App\Http\Controllers\cacheStore;
use App\Http\Controllers\users\guardItems;
use App\Models\Pelanggan;
use App\Models\PembayaranKWH;
use App\Models\TagihanKWH;
use Livewire\Volt\Component;
use function Livewire\Volt\{state};


new class extends Component {
    public $dataTable;
    public array $columnTable = ["No", "Total KWH", "Month", "Year", 'bills', "Tax", 'payment', 'Payout Date', 'status'];

    public function callData()
    {
        $idPelanggan = guardItems::checkGuardsIfLoginResultAuthClass()->id();
        $payment = TagihanKWH::with(['PembayaranKWH', 'PelangganKWH'])->where('pelanggan_id', $idPelanggan)->orderBy('id', 'desc')->get();
        $penggunaan = TagihanKWH::with(['PembayaranKWH', 'PelangganKWH'])->where('pelanggan_id', $idPelanggan)->orderBy('id', 'desc')->get();
        $this->dataTable = collect(['payment' => $payment, "penggunaan" => $penggunaan]);
    }

    public function mount()
    {
        $this->callData();
    }

    public function placeholder()
    {
        return view('placeholder.dashboard.dataTableUserShown', ['title' => 'Loading Data Payments']);
    }
};
?>

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">
                Payment List
            </h3>
            <x-table.datatables name="IdTablePayment" :columns="$columnTable">
                @foreach($dataTable['payment'] as $index => $table)
                    <tr>
                        <td>{{$index}}</td>
                        <td>{{$table->jumlah_meter}} KWH</td>
                        <td>{{$table->bulan}}</td>
                        <td>{{$table->tahun}}</td>
                        <td>Rp. {{number_format($table->PembayaranKWH->total_tagihan?? 0,0,',','.')}}</td>
                        <td>Rp. {{number_format($table->PembayaranKWH->biaya_admin?? 0,0,',','.')}}</td>
                        <td>Rp. {{number_format($table->PembayaranKWH->total_bayar?? 0,0,',','.')}}</td>
                        <td>{{$table->PembayaranKWH->tanggal_pembayaran ?? ''}}</td>
                        <td>
                            @if($table->status == true)
                                <div class="btn btn-success rounded-3">Success</div>
                            @else
                                <div class="btn btn-danger rounder">N\A</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-table.datatables>
        </div>
    </div>
</div>
