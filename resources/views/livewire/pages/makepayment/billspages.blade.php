<?php

use App\Http\Controllers\users\guardItems;
use App\Livewire\Notify\Alert;
use App\Models\Pelanggan;
use App\Models\PenggunaanKWH;
use App\Models\TagihanKWH;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public $dataTable = [];
    public $dataUser = [];

    #[Validate(['integer', 'required', 'exists:pelanggans,id'], as: "Pelanggan ID")]
    public $pelanggan;

    #[Validate(['string', 'required'], as: "Month")]
    public $bulan;

    #[Validate(['integer', 'required'], as: "Year")]
    public $tahun;

    #[Validate(['integer', 'required'], as: "Initial Meter")]
    public $meter_awal;

    #[Validate(['integer', 'required'], as: "Final Meter")]
    public $meter_akhir;

    #[Validate(['integer', 'required', 'gt:0'], as: "Total Kwh")]
    public $jumlah_meter;

    protected function loadBilling()
    {
        $data = TagihanKWH::with(['PelangganKWH', 'PenggunaanKWH'])
            ->where('pelanggan_id', guardItems::checkGuardsIfLoginResultId())
            ->get()
            ->values()
            ->toArray();
        $this->dataTable = $data;
    }

    public function deleteTagihan($id)
    {
        // Find the TagihanKWH record
        $data = TagihanKWH::findOrFail($id);

        // Delete related PembayaranKWH records (if any)
        if ($data->PembayaranKWH) {
            $data->PembayaranKWH->delete();
        }

        // Delete the TagihanKWH record itself
        $data->delete();

        // Delete the related PenggunaanKWH record
        if ($data->PenggunaanKWH) {
            $data->PenggunaanKWH->delete();
        }

        Cache::forget("listPaymentPelangganId");
        Cache::forget("listPenggunaanPelangganId");

        // Reload the billing data
        $this->dispatch('AlertNotify', ['icon' => 'success', 'message' => 'Delete Billing Success'])->to(Alert::class);
        $this->redirect(route('make-payment'));
    }

    public function submitBtn()
    {
        try {
            $this->validate();

            $penggunaan = new PenggunaanKWH();
            $penggunaan->pelanggan_id = $this->pelanggan;
            $penggunaan->bulan = $this->bulan;
            $penggunaan->tahun = $this->tahun;
            $penggunaan->meter_awal = $this->meter_awal;
            $penggunaan->meter_akhir = $this->meter_akhir;
            $penggunaan->save();

            Debugbar::info($penggunaan);

            $tagihan = new TagihanKWH();
            $tagihan->pelanggan_id = $this->pelanggan;
            $tagihan->penggunaan_kwh_id = $penggunaan->id;
            $tagihan->bulan = $this->bulan;
            $tagihan->tahun = $this->tahun;
            $tagihan->jumlah_meter = $this->jumlah_meter;
            $tagihan->save();

            // Perform the submission logic here
            $this->reset();
            $this->dispatch('closeModal')->self();
            $this->dispatch('AlertNotify', ['icon' => 'success', 'message' => 'Add New Billing Success'])->to(Alert::class);
            $this->redirect(route('make-payment'));
        } catch (ValidationException $e) {
            throw $e;
            $this->dispatch('validationFailed')->self();
            $this->dispatch('AlertNotify', ['icon' => 'error', 'message' => 'Add Billing Failed'])->to(Alert::class);
        } finally {
            Cache::forget("listPaymentPelangganId");
            Cache::forget("listPenggunaanPelangganId");
        }
    }

    protected function loadUser()
    {
        $data = Pelanggan::all()->values()->toArray();
        $this->dataUser = $data;
    }

    public function mount()
    {
        $this->loadBilling();
        $this->loadUser();
    }
}; ?>

<div>
    <div class="row">
        <div class="col-12" wire:ignore>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        List of Billing Costumer Usage
                    </div>
                    <div class="row">
                        <div class="col-12 waves-effect">
                            <button class="btn btn-outline-info text-black"
                                    x-on:click="$store.RowData.toggleModal()">
                                Add Billing Usage
                            </button>
                        </div>
                        <div class="pt-2 col-12">
                            <x-table.datatables
                                :columns='["No", "Customer Name", "Month", "Year", "Initial Meter", "Final Meter", "Total Kwh", "Created At", "Actions"]'
                                name="Billing">
                                @foreach($dataTable as $table)
                                    <tr>
                                        <td>#<span>{{ $table['id'] }}</span></td>
                                        <td>{{ $table['pelanggan_k_w_h']['nama_pelanggan'] }}</td>
                                        <td>{{ $table['bulan'] }}</td>
                                        <td>{{ $table['tahun'] }}</td>
                                        <td>{{ $table['penggunaan_k_w_h']['meter_awal'] }}</td>
                                        <td>{{ $table['penggunaan_k_w_h']['meter_akhir'] }}</td>
                                        <td><span>{{ $table['jumlah_meter'] }}</span> kWh</td>
                                        <td>{{ $table['created_at'] }}</td>
                                        <td>
                                            <button class="btn btn-outline-danger text-black"
                                                    wire:click="deleteTagihan({{ $table['id'] }})"
                                                    wire:confirm="Do you want delete this data?">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </x-table.datatables>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="modal fade" wire:ignore.self
                 id="modalBillsPages"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="modalBillsPagesLabels"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <form class="form-bordered form-horizontal" wire:submit="submitBtn()">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Billing Information</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-content">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            Billing Form Input
                                        </h5>
                                        <x-form.input-dropdown name="pelanggan_id" label="Customer Name"
                                                               :messages="$errors->get('pelanggan')[0] ?? null"
                                                               wireModel="pelanggan">
                                            @foreach($dataUser as $data)
                                                <x-form.input-dropdown-list :value="$data['id']"
                                                                            :label="$data['nama_pelanggan']"/>
                                            @endforeach
                                        </x-form.input-dropdown>
                                        <x-form.input-dropdown name="bulan" label="Month" wireModel="bulan"
                                                               :messages="$errors->get('bulan')[0] ?? null">
                                            <x-form.input-dropdown-list value="January" label="January"/>
                                            <x-form.input-dropdown-list value="February" label="February"/>
                                            <x-form.input-dropdown-list value="March" label="March"/>
                                            <x-form.input-dropdown-list value="April" label="April"/>
                                            <x-form.input-dropdown-list value="May" label="May"/>
                                            <x-form.input-dropdown-list value="June" label="June"/>
                                            <x-form.input-dropdown-list value="July" label="July"/>
                                            <x-form.input-dropdown-list value="August" label="August"/>
                                            <x-form.input-dropdown-list value="September" label="September"/>
                                            <x-form.input-dropdown-list value="October" label="October"/>
                                            <x-form.input-dropdown-list value="November" label="November"/>
                                            <x-form.input-dropdown-list value="December" label="December"/>
                                        </x-form.input-dropdown>
                                        <x-form.input-text name="tahun" label="Year" wireModel="tahun"
                                                           type="number"
                                                           :messages="$errors->get('tahun')[0] ?? null"/>
                                        <x-form.input-text name="meter_awal" label="Initial Meter"
                                                           wireModel="meter_awal"
                                                           type="number"
                                                           value="" :messages="$errors->get('meter_awal')[0] ?? null"/>
                                        <x-form.input-text name="meter_akhir" label="Final Meter"
                                                           :messages="$errors->get('meter_akhir')[0] ?? null"
                                                           wireModel="meter_akhir"
                                                           type="number"
                                                           value=""/>
                                        <x-form.input-text name="jumlah_meter" label="Total Kwh"
                                                           :messages="$errors->get('jumlah_meter')[0] ?? null"
                                                           wireModel="jumlah_meter"
                                                           type="number" readonly
                                                           value=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <x-form.button-submit type="submit" class="btn btn-outline-warning waves-effect">
                                    Submit
                                </x-form.button-submit>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @script
    <script>
        const elementModal = $('#modalBillsPages');
        const bsModal = new bootstrap.Modal(elementModal);
        Alpine.store('RowData', {
            toggleModal() {
                bsModal.show();
            },
        });

        $wire.on('closeModal', () => {
            bsModal.hide();
        });

        $wire.on('validationFailed', () => {
            bsModal.show();
        });

        $watch('$wire.meter_akhir', (value) => {
            const meterAkhir = parseInt(value);
            const meterAwal = parseInt($wire.meter_awal);
            const totalKwh = meterAkhir - meterAwal;
            $wire.jumlah_meter = totalKwh;
        });
    </script>
    @endscript
</div>
