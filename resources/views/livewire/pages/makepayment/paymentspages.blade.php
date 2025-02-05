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
    public $dataPayment = [];
    public $dataBilling = [];
    public $ColumnBilling = ["No", "Customer Name", "Month", "Year", "Total kWh", "Bills", "Admin Bills", "Total Pay", "status", "Action"];

    #[Validate(['required', 'exists:tagihan_kwh,id'], as: 'Billing Type')]
    public $tagihan_id;

    #[Validate(['required', 'numeric'], as: 'Admin Bills')]
    public $admin_bills;

    #[Validate(['required', 'numeric'], as: 'Total Bill')]
    public $total_tagihan;

    protected function loadBilling()
    {
        $data = TagihanKWH::with(['PelangganKWH', 'PenggunaanKWH', 'PembayaranKWH'])
            ->get()
            ->filter(function ($data) {
                return !isset($data->PembayaranKWH);
            })
            ->values()
            ->toArray();
        $this->dataBilling = $data;
    }

    protected function loadPayment()
    {
        $data = TagihanKWH::with(['PelangganKWH', 'PenggunaanKWH', 'PembayaranKWH'])
            ->get()
            ->filter(function ($data) {
                return isset($data->PembayaranKWH);
            })
            ->values()
            ->toArray();
        $this->dataPayment = $data;
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
        $this->dispatch('AlertNotify', ['icon' => 'success', 'message' => 'Delete Billing Success', 'link' => route('confirm-and-pay')])->to(Alert::class);
    }

    public function submitBtn()
    {
        try {
            $this->validate();

            // Perform the submission logic here
            Debugbar::info($this->only('tagihan_id', 'admin_bills', 'total_tagihan'));

            // Create a new PembayaranKWH record
            $data = TagihanKWH::findOrFail($this->tagihan_id);
            $data->PembayaranKWH()->create([
                'pelanggan_id' => $data->pelanggan_id,
                'tagihan_id' => $this->tagihan_id,
                'biaya_admin' => $this->admin_bills,
                'total_tagihan' => $this->total_tagihan,
                'user_id' => auth()->id(),
            ]);
            $this->reset();
            $this->dispatch('closeModal')->self();
            $this->dispatch('AlertNotify', ['icon' => 'success', 'message' => 'Add New Billing Success', 'link' => route('confirm-and-pay')])->to(Alert::class);
        } catch (ValidationException $e) {
            throw $e;
            $this->dispatch('validationFailed')->self();
            $this->dispatch('AlertNotify', ['icon' => 'error', 'message' => 'Add Billing Failed'])->to(Alert::class);
        } finally {
            Cache::forget("listPaymentPelangganId");
            Cache::forget("listPenggunaanPelangganId");
        }
    }

    public function mount()
    {
        $this->loadBilling();
        $this->loadPayment();
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
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-info" x-on:click="$wire.dispatch('openModal')">
                                    <i class="fas fa-plus"></i>
                                    Add Billing
                                </button>
                                <div class="waves-effect btn-outline-warning text-black mx-2">
                                    Total Payment:
                                    <span>{{count($dataPayment)}}</span> Rows
                                </div>
                                <div class="waves-effect btn-outline-warning text-black m-2">
                                    Total Billing: <span>{{count($dataBilling)}}</span> Rows
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 col-12">
                            <x-table.datatables
                                :columns='$ColumnBilling'
                                name="Billing">
                                @foreach($dataPayment as $item)
                                    <tr wire:key="{{$item['id']}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item['pelanggan_k_w_h']['nama_pelanggan']}}</td>
                                        <td>{{$item['penggunaan_k_w_h']['bulan']}}</td>
                                        <td>{{$item['penggunaan_k_w_h']['tahun']}}</td>
                                        <td>{{$item['jumlah_meter']}} kWh</td>
                                        <td>
                                            Rp. {{number_format($item['pembayaran_k_w_h']['total_tagihan']?? 0)}}</td>
                                        <td>
                                            Rp. {{number_format($item['pembayaran_k_w_h']['biaya_admin']?? 0)}}</td>
                                        <td>
                                            Rp. {{number_format($item['pembayaran_k_w_h']['total_bayar']?? 0)}}</td>
                                        <td>
                                            @if($item['status'])
                                                <span class="badge badge-success bg-info">Paid</span>
                                            @else
                                                <span class="badge badge-warning bg-warning">Not Paid</span>
                                            @endif</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-warning"
                                                        wire:click="deleteTagihan({{$item['id']}})"
                                                        wire:confirm="Are you sure you want to delete this item?">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
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
                                <div class="card" x-data="{ billing: 0, admin: 0, total_kwh: 0, total: 0 }"
                                     x-init="$watch('$wire.tagihan_id', value => {
                                const data = $wire.dataBilling.find(item => item?.id == value);
                                if (data) {
                                    total_kwh = data.jumlah_meter;
                                    billing = data.pelanggan_k_w_h?.get_tarif?.tarif_perkwh;
                                    // Calculate admin bills automatically
                                    admin = (((total_kwh * billing) * 11 / 12) * 0.04);
                                    // Calculate total amount
                                    total = (total_kwh * billing) + admin;
                                    $wire.admin_bills = admin.toFixed(0);
                                    $wire.total_tagihan =total.toFixed(0);
                                }
                             })">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            Billing Form Input
                                        </h5>
                                        <x-form.input-dropdown name="Billings" label="Billing Type"
                                                               :messages="$errors->get('tagihan_id')[0] ?? null"
                                                               wireModel="tagihan_id">
                                            @foreach($dataBilling as $item)
                                                <option value="{{$item['id']}}">
                                                    {{$item['pelanggan_k_w_h']['id']}}
                                                    | {{$item['pelanggan_k_w_h']['nama_pelanggan']}}
                                                    | {{$item['jumlah_meter']}} kWh
                                                    | {{$item['status'] ? "Paid" : "Not Paid"}}
                                                    | {{$item['penggunaan_k_w_h']['bulan']}}
                                                    | {{$item['penggunaan_k_w_h']['tahun']}}
                                                </option>
                                            @endforeach
                                        </x-form.input-dropdown>
                                        <div class="text-start text-muted mb-4">
                                            <h5 class="fw-bold">Total Calculator</h5>
                                            <p class="text-muted mb-3">(Total kWh × Billing Cost) + Admin Bills</p>
                                            <div class="d-flex align-items-center gap-3">
                                                <!-- Total kWh -->
                                                <div class="input-group flex-grow-1">
                                                    <input type="text" readonly x-model="total_kwh"
                                                           class="form-control bg-light">
                                                    <span class="input-group-text">kWh</span>
                                                </div>
                                                <!-- Multiplication Symbol -->
                                                <div class="text-muted fs-5">×</div>
                                                <!-- Billing Cost -->
                                                <div class="input-group flex-grow-1">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text" readonly x-model="billing"
                                                           class="form-control bg-light">
                                                    <span class="input-group-text">/kWh</span>
                                                </div>
                                                <!-- Plus Symbol -->
                                                <div class="text-muted fs-5">+</div>
                                                <!-- Admin Bills -->
                                                <div class="input-group flex-grow-1">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text" readonly x-model="admin"
                                                           class="form-control bg-light">
                                                    <span class="input-group-text">Admin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Display Total Amount -->
                                        <div class="text-start text-muted mb-4">
                                            <h5 class="fw-bold">Total Amount</h5>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" readonly x-model="total"
                                                       class="form-control bg-light">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <x-form.button-submit type="submit" class="btn btn-outline-warning waves-effect">
                                    Make Payment
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


        $wire.on('closeModal', () => {
            bsModal.hide();
        });

        $wire.on('openModal', () => {
            bsModal.show();
        });
    </script>
    @endscript
</div>
