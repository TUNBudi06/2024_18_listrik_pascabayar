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

    public function rules(): array
    {
        return [

        ];
    }

    public function submitBtn()
    {
        try {
            $this->validate();

            $this->reset();
            $this->dispatch('closeModal')->self();
        } finally {
            $this->loadAdmin();
        }
    }

    public function editAdmin($id)
    {
        try {

        } finally {
            $this->dispatch('openModal')->self();
        }

    }

    public function deleteAdmin($id)
    {
        try {

        } finally {
            $this->loadAdmin();
        }
    }

    public function resetForm()
    {
        $this->reset();
    }

    public function AddModal()
    {
        if ($this->isEdit) {
            $this->isEdit = false;
            $this->resetForm();
        }
        $this->dispatch('openModal')->self();
    }

    public function loadAdmin()
    {
        $data = Pelanggan::with(['getTarif'])->get();
        $this->dataTable = $data;
    }

    public function boot()
    {
        $this->loadAdmin();
    }
}; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title waves-effect">Add Admin Page</h4>
                <button class="btn btn-info form-control" wire:click="AddModal()">Add Admin</button>
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
                            <th>Admin Name</th>
                            <th>kWh Number</th>
                            <th>Alamat</th>
                            <th>Watt</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
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
                                (Edit Admin)
                            @else
                                Add new Admin
                            @endif</h3>
                        <button class="close" type="button" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-lg-start">
                            Form Data
                            <div class="row">

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
