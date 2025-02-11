<?php

use App\Models\TarifKWH;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public $dataTable = [];

    #[Validate(rule: ['required', 'unique:tarif_kwh,daya', 'numeric'], as: "Watt")]
    public $daya = null;
    public $tarif_id = null;

    #[Validate(rule: ['required', 'numeric'], as: "Price")]
    public $tarif_perkwh = null;

    public $isEdit = false;


    public function submitBtn()
    {
        try {
            $this->daya = str_replace(' VA', '', $this->daya);
            $this->validate();

            if ($this->isEdit) {
                $tariff = TarifKWH::findOrFail($this->tarif_id);
                Debugbar::info($tariff);
                $tariff->daya = $this->daya;
                $tariff->tarif_perkwh = $this->tarif_perkwh;
                $tariff->save();
                $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Tariff Updated']);
                $this->resetForm();
                $this->loadTariff();
            } else {
                TarifKWH::create([
                    'daya' => $this->daya,
                    'tarif_perkwh' => $this->tarif_perkwh
                ]);
                $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Tariff Created']);
                $this->resetForm();
                $this->loadTariff();
            }
        } finally {
            if ($this->daya) {
                $this->daya = $this->daya . " VA";
            };
        }
    }

    public function editTariff($id)
    {
        $this->isEdit = true;
        $this->tarif_id = $id;
        $tariff = TarifKWH::find($id);
        $this->daya = $tariff->daya . " VA";
        $this->tarif_perkwh = $tariff->tarif_perkwh;
        $this->dispatch('openModal')->self();
    }

    public function deleteTariff($id)
    {
        $tariff = TarifKWH::find($id);
        $tariff->delete();

        $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Tariff Deleted']);
        $this->loadTariff();
    }

    public function resetForm()
    {
        $this->reset(['daya', 'isEdit', 'tarif_perkwh', 'tarif_id']);
    }

    public function AddModal()
    {
        try {
            if ($this->isEdit) {
                $this->resetForm();
            }
        } finally {
            $this->dispatch('openModal')->self();
        }
    }

    public function loadTariff()
    {
        $data = TarifKWH::withCount(['getPelanggan'])->get();
        $this->dataTable = $data;
    }

    public function mount()
    {
        $this->loadTariff();
    }
}; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title waves-effect">Add Tariff Price</h4>
                <button class="btn btn-info form-control" wire:click="AddModal()">Add Price</button>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">List of Tariff Price</h4>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered table-striped" wire:ignore.self>
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Daya</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataTable as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->daya }} Va</td>
                                <td x-clipboard>Rp. {{ number_format($value->tarif_perkwh,2,',','.') }}</td>
                                <td>
                                    <button class="btn btn-info"
                                            wire:click="editTariff({{$value->id}})">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger"
                                            wire:click="deleteTariff({{ $value->id }})"
                                            wire:confirm="Are you sure to delete this Tariff? all user associated with this will be deleted ({{ $value->get_pelanggan_count ?? 0 }} Users) ">
                                        Delete
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form wire:submit="submitBtn">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            @if($isEdit)
                                (Edit Tariff Price)
                            @else
                                Add new Price
                            @endif</h3>
                        <button class="close" type="button" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-lg-start">
                            Form Data
                            <div class="mb-3">
                                <label for="daya" class="form-label">Wattage (VA)</label>
                                <input type="text" wire:model="daya" id="daya" class="form-control"
                                       placeholder="Enter wattage (e.g., 900 VA)">
                                @error('daya') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tarif_perkwh" class="form-label">Price per kWh</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" wire:model="tarif_perkwh" id="tarif_perkwh"
                                           class="form-control"
                                           placeholder="Enter price (e.g., 1,200)">
                                    <span class="input-group-text">/ kWh</span>
                                </div>
                                @error('tarif_perkwh') <span class="text-danger">{{ $message }}</span> @enderror
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
