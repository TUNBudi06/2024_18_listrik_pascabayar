<?php

use App\Http\Controllers\users\guardItems;
use App\Livewire\Forms\PelangganPaymentConfirmation;
use App\Livewire\Notify\Alert;
use App\Models\PembayaranKWH;
use App\Models\TagihanKWH;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public $isOpen = true;
    public $columnsTable = ["NO", 'Month', 'Year', "Total KWH", "Bills", "Status", "Actions"];
    public $dataTable;

    #[Validate(['integer', 'required'], as: "Money", onUpdate: false)]
    public $total_bayar;

    #[Validate(['integer'], as: "Bill", onUpdate: false)]
    public $total_tagihan;

    #[Validate(['integer', 'exists:tagihan_kwh,id'], as: "Id Data", onUpdate: false)]
    public $id_data;

    protected function loadPayment()
    {
        $data = TagihanKWH::with(["PembayaranKWH"])->where('pelanggan_id', guardItems::checkGuardsIfLoginResultId())->where('status', 0)->get()
            ->map(function ($item) {
                if (isset($item->PembayaranKWH)) {
                    return $item;
                }
            });
        $this->dataTable = $data;
    }

    public function submitBtn()
    {
        try {
            $this->validate();

            if ((int)$this->total_tagihan > (int)$this->total_bayar) {
                throw ValidationException::withMessages([
                    'total_bayar' => 'Your Money cant be lower than the Bill',
                ]);
            }

            $data = TagihanKWH::find($this->id_data);
            $data->status = 1;
            $data->save();

            $data = PembayaranKWH::where('tagihan_kwh_id', $this->id_data)->first();
            $data->total_bayar = $this->total_bayar;
            $data->tanggal_pembayaran = now();
            $data->save();

            $this->dispatch('AlertNotify', ['icon' => 'success', 'message' => 'Payment Success'])->to(Alert::class);
            $this->redirect(route('electricBills'));
            if (!$this->getErrorBag()->any()) {
                $this->dispatch('closeModal');
            }
        } finally {
            $this->dispatch('validationFailed');
        }
    }

    public function mount()
    {
        $this->loadPayment();
    }
};
?>

<div>
    <div class="row">
        <div class="col-12" wire:ignore>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        List Payment Has Not Been Pay
                        <x-table.datatables name="listPaymentNotBeenPaid" :columns="$columnsTable">
                            @foreach($dataTable as $index => $data)
                                <tr wire:key="index-{{$data->id}}">
                                    <td>{{$index}}</td>
                                    <td>{{$data->bulan}}</td>
                                    <td>{{$data->tahun}}</td>
                                    <td>{{$data->jumlah_meter}} KWH</td>
                                    <td>
                                        Rp. {{number_format(($data->PembayaranKWH->total_tagihan + $data->PembayaranKWH->biaya_admin),0,',','.')}}</td>
                                    <td>
                                        @if(isset($data->status))
                                            <div class="btn btn-rounded btn-warning">Not Paid</div>
                                        @endif
                                    </td>
                                    <td>
                                        <button x-on:click="$store.RowData.toggleModalOpen({{$data->id}})" type="button"
                                                class="btn waves-effect waves-light btn-info">Pay?
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table.datatables>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div wire:ignore.self
                 class="modal fade"
                 id="livewireModal"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="livewireModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="livewireModalLabel">Modal Heading</h4>
                            <button type="button"
                                    class="btn-close"

                                    aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title bg-blend-darken">
                                        Payment Rp.
                                        <span x-text="$store.RowData.headerModal"></span>
                                        <form class="form-horizontal form-bordered" wire:submit="submitBtn()">
                                            <div class="row">
                                                <div class="col-5">
                                                    <input type="hidden" wire:model="id_data">
                                                    <x-form.input-text name="UangBayar" label="Pay your Money"
                                                                       placeholder="140000"
                                                                       type="number"
                                                                       wireModel="total_bayar"
                                                                       :messages="$errors->get('total_bayar')[0] ?? null"/>
                                                </div>
                                                <div class="col-5">
                                                    <x-form.input-text name="UangBayar" label="Your Current Bill"
                                                                       placeholder="140000"
                                                                       type="number"
                                                                       wireModel="total_tagihan"
                                                                       :messages="$errors->get('total_tagihan')[0] ?? null"
                                                                       readonly/>
                                                </div>
                                                <div class="col-4">
                                                    <x-form.button-submit class="btn btn-info mt-3">
                                                        Submit
                                                    </x-form.button-submit>
                                                </div>
                                            </div>
                                        </form>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-info waves-effect text-white"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    const modalElement = document.getElementById('livewireModal');
    const modal = new bootstrap.Modal(modalElement);

    Livewire.on('closeModal', () => {
        modal.hide();
    });

    Livewire.on('validationFailed', () => {
        modal.show();
    });

    Alpine.store('RowData', {
        listJson: @json($dataTable),
        headerModal: 0,


        toggleModalOpen(id) {
            const options = {style: 'currency', currency: 'IDR'};
            const idData = this.listJson.find(item => item.id === id);

            console.log(idData);
            this.headerModal = (idData['pembayaran_k_w_h']['total_tagihan'] + idData['pembayaran_k_w_h']['biaya_admin']).toLocaleString(options);
            $wire.total_tagihan = idData['pembayaran_k_w_h']['total_tagihan'] + idData['pembayaran_k_w_h']['biaya_admin'];
            $wire.id_data = id;

            modal.show()
        }
    })
</script>
@endscript
