<?php

use App\Http\Controllers\cacheStore;
use App\Models\Pelanggan;
use App\Models\User;
use Livewire\Volt\Component;
use function Livewire\Volt\{state};


new class extends Component {
    public $dataTable;
    public array $columnTable = ["No", "Administrator Name", "Administrator Type"];

    public function mount()
    {
        $this->dataTable = Cache::store('redis')->flexible('AdminsList', [60 * 60 * 24, 60 * 60 * 24 * 2], function () {
            return User::with(['adminLevel'])->orderBy('name')->get();
        });;
    }

    public function placeholder()
    {
        return view('placeholder.dashboard.dataTableUserShown', ['title' => 'Loading Admins List']);
    }
};

?>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">
            Administrator List
        </h3>
        <x-table.datatables name="IdTableAdmins" :columns="$columnTable">
            @foreach($dataTable as $index => $table)
                <tr>
                    <td>{{$index}}</td>
                    <td>{{$table->name}}</td>
                    <td>{{$table->adminLevel->nama}}</td>
                </tr>
            @endforeach
        </x-table.datatables>
    </div>
</div>
