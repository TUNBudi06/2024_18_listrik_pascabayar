<?php

use App\Http\Controllers\users\guardItems;
use App\Models\TagihanKWH;
use Livewire\Volt\Component;

new class extends Component {
    public $columns = ['No', 'Month', 'Year', 'Total KWH', 'Bills', 'Status', 'Actions'];
    public $dataTable;

    public function loadHistory()
    {
        $data = TagihanKWH::with(['PembayaranKWH'])
            ->where('pelanggan_id', guardItems::checkGuardsIfLoginResultId())
            ->where('status', 1)
            ->get()
            ->filter(function ($item) {
                return isset($item->PembayaranKWH); // Hanya ambil data yang memiliki PembayaranKWH
            })
            ->values() // Reset array keys
            ->toArray(); // Konversi ke array
        $this->dataTable = $data;
    }

    public function mount()
    {
        $this->loadHistory();
    }

    public function placeholder()
    {
        return view('placeholder.dashboard.dataTableUserShown', ['title' => 'Usage History']);
    }
};
?>

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Usage History</h4>
                    <x-table.datatables :columns="$columns" name="usageHistory">
                        <template x-for="(dataTab, index) in $store.RowData.data">
                            <tr>
                                <td x-text="index + 1"></td>
                                <td x-text="dataTab['bulan']"></td>
                                <td x-text="dataTab['tahun']"></td>
                                <td x-text="dataTab['jumlah_meter'] + ' VA'"></td>
                                <td>Rp.
                                    <span
                                        x-text="Intl.NumberFormat('id-ID').format(dataTab['pembayaran_k_w_h']?.total_tagihan + dataTab['pembayaran_k_w_h']?.biaya_admin || 0)">
                                    </span>
                                </td>
                                <td>
                                    <span class="btn btn-success disabled">Success</span>
                                </td>
                                <td><span class="btn btn-info">Print</span></td>
                            </tr>
                        </template>
                    </x-table.datatables>
                </div>
                @script
                <script>
                    Alpine.store('RowData', {
                        data: @json($dataTable), // Pastikan data dikirim dalam format JSON
                    });
                </script>
                @endscript
            </div>
        </div>
        <div class="col-12">
            
        </div>
    </div>
</div>
