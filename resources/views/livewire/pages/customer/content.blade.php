<?php

use App\Models\Pelanggan;
use App\Models\TarifKWH;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public $dataTable = [];
    public bool $isEdit = false;

    public $pelanggan_id;

    public $customer;

    public $tarif_id;

    public $username;

    public $nomor_kwh;

    public $password;

    public $confirm_password;

    public $alamat;

    public function rules(): array
    {
        return [
            'pelanggan_id' => ['required_if:isEdit,true'],
            'customer' => ['required', 'string'],
            'tarif_id' => ['required', 'exists:tarif_kwh,id'],
            'username' => ['required', 'string', Rule::unique('pelanggans', 'username')->ignore($this->pelanggan_id)],
            'nomor_kwh' => ['required', 'numeric', Rule::unique('pelanggans', 'nomor_kwh')->ignore($this->pelanggan_id)],
            'password' => [Rule::requiredIf(!$this->isEdit), 'nullable', 'string', 'confirmed:confirm_password'],
            'confirm_password' => [Rule::requiredIf(!$this->isEdit), 'nullable', 'string'],
            'alamat' => ['required', 'string'],
        ];
    }

    public function submitBtn()
    {
        try {
            $this->validate();

            if ($this->isEdit) {
                $pelanggan = Pelanggan::findOrFail($this->pelanggan_id);
                $pelanggan->tarif_kwh_id = $this->tarif_id;
                $pelanggan->username = $this->username;
                $pelanggan->nomor_kwh = $this->nomor_kwh;
                $pelanggan->alamat = $this->alamat;
                $pelanggan->save();

                if ($this->password) {
                    $pelanggan->password = \Hash::make($this->password);
                    $pelanggan->save();
                }
                $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Customer Updated']);
            } else {
                Pelanggan::create([
                    'nama_pelanggan' => $this->customer,
                    'username' => $this->username,
                    'nomor_kwh' => $this->nomor_kwh,
                    'alamat' => $this->alamat,
                    'password' => \Hash::make($this->password),
                    'tarif_kwh_id' => $this->tarif_id,
                ]);
                $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Customer Created']);

            }
            $this->reset();
            $this->dispatch('closeModal')->self();
        } finally {
            $this->loadCustomer();
        }
    }

    public function editCustomer($id)
    {
        $data = Pelanggan::find($id);
        $this->pelanggan_id = $data->id;
        $this->customer = $data->nama_pelanggan;
        $this->username = $data->username;
        $this->nomor_kwh = $data->nomor_kwh;
        $this->alamat = $data->alamat;
        $this->tarif_id = $data->tarif_kwh_id;
        $this->isEdit = true;
        $this->dispatch('openModal')->self();
    }

    public function deleteCustomer($id)
    {
        Pelanggan::find($id)->delete();
        $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Customer Deleted']);
        $this->loadCustomer();
    }

    #[Computed]
    public function listTariff()
    {
        return TarifKWH::all();
    }

    public function resetForm()
    {
        $this->reset(['pelanggan_id', 'customer', 'username', 'nomor_kwh', 'alamat', 'tarif_id']);
    }

    public function AddModal()
    {
        if ($this->isEdit) {
            $this->isEdit = false;
            $this->resetForm();
        }
        $this->dispatch('openModal')->self();
    }

    public function loadCustomer()
    {
        $data = Pelanggan::with(['getTarif'])->get();
        $this->dataTable = $data;
    }

    public function boot()
    {
        $this->loadCustomer();
    }
}; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title waves-effect">Add Customer Page</h4>
                <button class="btn btn-info form-control" wire:click="AddModal()">Add Customer</button>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">List of Tariff Price</h4>
                <h5 class="text-muted">(click in the column to copy clipboard)</h5>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered table-striped" wire:ignore.self>
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Customer Name</th>
                            <th>kWh Number</th>
                            <th>Alamat</th>
                            <th>Watt</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataTable as $index => $d)
                            <tr>
                                <td x-clipboard>{{$index + 1}}</td>
                                <td x-clipboard>{{$d->username}}</td>
                                <td x-clipboard>{{$d->nama_pelanggan}}</td>
                                <td x-clipboard>{{$d->nomor_kwh}}</td>
                                <td x-clipboard class="text-break">{{$d->alamat}}</td>
                                <td x-clipboard>{{$d->getTarif->daya}} VA</td>
                                <td>
                                    <button class="btn btn-info" wire:click="editCustomer({{$d->id}})">Edit</button>
                                    <button class="btn btn-danger" wire:click="deleteCustomer({{$d->id}})"
                                            wire:confirm="are you sure want to delete this user?">Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" wire:ignore.self
         id="modalId"
         aria-hidden="true"
         role="dialog"
         tabindex="-1"
         aria-labelledby="modalLabel">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form wire:submit="submitBtn">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            @if($isEdit)
                                (Edit Customer)
                            @else
                                Add new Customer
                            @endif</h3>
                        <button class="close" type="button" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-lg-start">
                            Form Data
                            <div class="row">
                                <div class="mb-2 col-6">
                                    <x-form.input-dropdown label="Select User Tariff" name="tariff"
                                                           wireModel="tarif_id">
                                        @foreach($this->listTariff() as $tariff)
                                            <option value="{{$tariff->id}}">
                                                Rp. {{number_format($tariff->tarif_perkwh ?? 0,2,',','.')}}
                                                | {{$tariff->daya}} VA
                                            </option>
                                        @endforeach
                                    </x-form.input-dropdown>
                                </div>
                                <div class="mb-2 col-6">
                                    <x-form.input-text label="UserName" placeholder="UserName" name="username"
                                                       wireModel="username"/>
                                </div>
                                <div class="mb-2 col-12">
                                    <x-form.input-text label="Customer Name" placeholder="John Doe" name="customer_name"
                                                       wireModel="customer"/>
                                </div>
                                <div class="mb-2 col-12">
                                    <x-form.input-text label="Nomor kWh" placeholder="Nomor kWh" name="nomor_kwh"
                                                       wireModel="nomor_kwh"/>
                                </div>
                                <div class="mb-2 col-6">
                                    <x-form.input-text label="password" placeholder="password" name="password"
                                                       wireModel="password"/>
                                </div>
                                <div class="mb-2 col-6">
                                    <x-form.input-text label="Confirm Password" placeholder="Confirm Password"
                                                       name="confirm_password"
                                                       wireModel="confirm_password"/>
                                </div>
                                div
                                <div class="col-12 mb-2">
                                    <x-form.input-textarea label="Address" placeholder="Address" name="alamat"
                                                           wireModel="alamat"/>
                                </div>
                            </div>
                        </h3>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-info p-2">
                            Submit
                        </button>
                        <button class="btn btn-outline-danger p-2" type="button" wire:click="resetForm">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @script
    <script>
        const modal = $('#modalId');
        const bsModal = new bootstrap.Modal(modal);

        $wire.on('openModal', function () {
            bsModal.show();
        })
        $wire.on('closModal', function () {
            bsModal.show();
        })
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
        setInterval(function () {
            if (!$.fn.dataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable();
            }
        }, 1000);

    </script>
    @endscript
</div>
