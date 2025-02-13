<?php

use App\Models\AdminLevel;
use App\Models\Pelanggan;
use App\Models\TarifKWH;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public $dataTable = [];
    public bool $isEdit = false;
    public $id = null;
    public $name = null;
    public $username = null;
    public $password = null;
    public $confirm_password = null;
    public $adminLevelId = null;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => ['string', 'max:255', Rule::unique('users', 'username')->ignore($this->id)],
            'password' => [Rule::requiredIf(!$this->isEdit), 'nullable', 'string', 'confirmed:confirm_password'],
            'confirm_password' => [Rule::requiredIf(!$this->isEdit), 'nullable', 'string'],
            'adminLevelId' => ['required', 'exists:admin_levels,id'],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => 'Admin Name',
            'username' => 'Username',
            'password' => 'Password',
            'adminLevelId' => 'Admin Level',
        ];
    }

    public function submitBtn()
    {
        try {
            $this->validate();

            if ($this->isEdit) {
                $user = User::findOrFail($this->id);
                $user->name = $this->name;
                $user->username = $this->username;
                $user->admin_level_id = $this->adminLevelId;
                if ($this->password) {
                    $user->password = Hash::make($this->password);
                }
                $user->save();
                $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Admin Successfully Edited']);
            } else {
                $user = new User();
                $user->name = $this->name;
                $user->username = $this->username;
                $user->password = Hash::make($this->password);
                $user->admin_level_id = $this->adminLevelId;
                $user->save();
                $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Admin Successfully created']);
            }

            $this->reset();
            $this->dispatch('closeModal')->self();
        } finally {
            $this->loadAdmin();
        }
    }

    public function editAdmin($id)
    {
        try {
            $user = User::findOrFail($id);
            $this->id = $user->id;
            $this->username = $user->username;
            $this->name = $user->name;
            $this->adminLevelId = $user->admin_level_id;
            $this->isEdit = true;
        } finally {
            $this->dispatch('openModal')->self();
        }

    }

    public function deleteAdmin($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            $this->dispatch('AlertNotify', ['type' => 'success', 'message' => 'Successfully Admin Deleted']);
        } finally {
            $this->loadAdmin();
        }
    }

    #[Computed()]
    public function adminLevel()
    {
        return AdminLevel::all();
    }

    public function resetForm()
    {
        $this->reset(['name', 'username', 'password', 'adminLevelId']);
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
        $data = User::with(['adminLevel'])->get();
        $this->dataTable = $data;
    }

    public function boot()
    {
        $this->loadAdmin();
    }
}; ?>

@use(\App\Http\Controllers\users\guardItems)


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
                            <th>Admin Name</th>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataTable as $key => $data)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->username}}</td>
                                <td>{{$data->adminLevel->nama}}</td>
                                <td>
                                    <button class="btn btn-info" wire:click="editAdmin({{$data->id}})">Edit</button>
                                    @if(!(guardItems::checkGuardsIfLoginResultAuthClass()->id() == $data->id))
                                        <button class="btn btn-danger" wire:click="deleteAdmin({{$data->id}})"
                                                wire:confirm="Are you sure to delete this? (other data is associateed with this account will be deleted)">
                                            Delete
                                        </button>
                                    @endif
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
                <form wire:submit="submitBtn" class="form-bordered my-2">
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
                                <div class="col-12 mb-2">
                                    <x-form.input-text label="Admin Name" id="name" placeholder="Admin Name"
                                                       wireModel="name"/>
                                </div>
                                <div class="col-7 mb-2">
                                    <x-form.input-text label="Username" id="username" placeholder="Username"
                                                       wireModel="username"/>
                                </div>
                                <div class="col-5 mb-2">
                                    <x-form.input-dropdown label="Admin Level" id="adminLevelId"
                                                           wireModel="adminLevelId">
                                        @foreach($this->adminLevel() as $item)
                                            <option value="{{$item->id}}">{{$item->nama}}</option>
                                        @endforeach
                                    </x-form.input-dropdown>
                                </div>
                                <div class="col-6 mb-2">
                                    <x-form.input-text label="Password" id="password" placeholder="Password"
                                                       wireModel="password"/>
                                </div>
                                <div class="col-6 mb-2">
                                    <x-form.input-text label="Confirm Password" id="confirmPassword"
                                                       placeholder="Confirm Password" wireModel="confirm_password"/>
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
        $wire.on('closeModal', function () {
            bsModal.hide();
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
