<?php

use App\Http\Controllers\users\guardItems;
use App\Models\TagihanKWH;
use Livewire\Volt\Component;

new class extends Component {
    public $columns = ['No', 'Month', 'Year', 'Total KWH', 'Bills', 'Status', 'Actions'];
    public $dataTable;

    public function loadHistory()
    {
        $data = TagihanKWH::with(['PembayaranKWH', 'PelangganKWH'])
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

    public function showLiveWirePrint($data)
    {
        Debugbar::info($data);
        $this->dispatch("modalInvoice", data: $data);
    }

    public function printPage()
    {
        $this->dispatch("PrintPageAreaClass");
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
        <div class="col-12" wire:ignore>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Payment History</h4>
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
                                <td><span class="btn btn-info"
                                          x-on:click="$wire.showLiveWirePrint(dataTab); $nextTick(() => { new bootstrap.Modal(document.getElementById('modalPrint')).show(); })">Print</span>
                                </td>
                            </tr>
                        </template>
                    </x-table.datatables>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div wire:ignore
                 class="modal fade"
                 id="modalPrint"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="livewireModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="livewireModalLabel">Invoice Show</h4>
                            <button type="button"
                                    class="btn-close"

                                    aria-hidden="true" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <livewire:pages.usagehistory.printdataonerow/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-info waves-effect text-black" wire:click="printPage"> Print
                                Invoice
                            </button>
                            <button type="button"
                                    class="btn btn-outline-warning waves-effect text-black" data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @script
            <script>
                Alpine.store('RowData', {
                    data: $wire.dataTable,
                });
            </script>
            @endscript
        </div>
    </div>
</div>
