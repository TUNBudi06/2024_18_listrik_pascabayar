<?php

use App\Models\Pelanggan;
use App\Models\TagihanKWH;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate(rule: 'required_if:endYear,!null', as: "Start Year")]
    public $startYear;
    #[Validate(rule: 'required_if:startYear,!null', as: "End Year")]
    public $endYear;
    public $status;
    // End year for the report
    public $username;  // Selected user (or "all" for all users)
    public $users;     // List of users fetched from the database

    // Load all users with related data
    public function loadUsers()
    {
        $this->users = Pelanggan::with(['TagihanKWH', 'getTarif'])->get();
    }

    public function submitBtn()
    {
        $this->validate();
    }

    // Computed property to load the report data
    #[Computed()]
    public function loadReport()
    {
        // Fetch cached data or query the database if not cached
        $users = Cache::store('redis')->remember("listReport:{$this->username}:{$this->startYear}:{$this->endYear}:{$this->status}", 120, function () {
            return TagihanKWH::with(['PelangganKWH', 'PembayaranKWH', 'PenggunaanKWH'])
                ->when($this->status, fn($query) => $query->where('status', $this->status))
                ->when($this->username && $this->username != 'all', fn($query) => $query->where('pelanggan_id', $this->username))
                ->when($this->startYear, fn($query) => $query->where('tahun', '>=', $this->startYear))
                ->when($this->endYear, fn($query) => $query->where('tahun', '<=', $this->endYear))
                ->get();
        });

        // Get user details if a specific user is selected
        $userModel = $this->username && $this->username != 'all' ? Pelanggan::find($this->username) : null;
        $name = $userModel->nama_pelanggan ?? 'All Users';
        $no_kwh = $userModel->nomor_kwh ?? 'All Users';
        $alamat = $userModel->alamat ?? null;

        // Aggregate data
        $uniquePelangganIds = $users->pluck('pelanggan_id')->unique();
        $totalCustomers = $uniquePelangganIds->count();

        $totalBill = Pelanggan::whereIn('id', $uniquePelangganIds)
            ->withCount('TagihanKWH')
            ->get()
            ->sum('tagihan_k_w_h_count') ?? 'No Information';

        $totalPayment = Pelanggan::whereIn('id', $uniquePelangganIds)
            ->withCount('PembayaranKWH')
            ->get()
            ->sum('pembayaran_k_w_h_count') ?? 'No Information';

        $totalIncome = $users->sum(fn($event) => $event->status ? $event->PembayaranKWH->total_tagihan : 0);
        $totalAdminIncome = $users->sum(fn($event) => $event->status ? $event->PembayaranKWH->biaya_admin : 0);

        $allUserInformation = [
            'total_customer' => $totalCustomers,
            'total_bill' => $totalBill,
            'total_payment' => $totalPayment,
        ];

        $result = [
            'paymentList' => $users,
            'user_list' => Pelanggan::whereIn('id', $uniquePelangganIds)->with('getTarif')->get(),
            'name' => $name,
            'alamat' => $alamat,
            'no_kwh' => $no_kwh,
            'totalIncome' => $totalIncome,
            'totalAdminIncome' => $totalAdminIncome,
            'allInformation' => $allUserInformation,
        ];

        Debugbar::info($result);

        return $result;
    }

    // Initialize the component by loading users
    public function mount()
    {
        $this->loadUsers();
    }
}; ?>

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Generate Report</h4>
                    <h6 class="card-subtitle">Generate report for all user</h6>
                    <form wire:submit="submitBtn()">
                        <div class="d-flex justify-content-around align-items-center">
                            <div>
                                <x-form.input-text label="Start Year" name="startYear"
                                                   placeholder="{{now()->subYear()->format('Y')}}"
                                                   type="number" wireModel="startYear"
                                                   :messages="$errors->get('startYear')[0] ?? null"/>
                            </div>
                            <div>
                                <x-form.input-text label="End Year" name="endYear" placeholder="{{now()->format('Y')}}"
                                                   type="number" wireModel="endYear"
                                                   :messages="$errors->get('endYear')[0] ?? null"/>
                            </div>
                            <div class="border-3 p-3">
                                <x-form.input-checkbox wireModel="status">
                                    Status is Paid
                                </x-form.input-checkbox>
                            </div>
                            <div>
                                <x-form.input-dropdown label="Select User" name="username" wireModel="username"
                                                       selected="selected">
                                    <x-form.input-dropdown-list label="All User" value="all"/>
                                    @foreach($users as $user)
                                        <x-form.input-dropdown-list label="{{$user->nama_pelanggan}}
                                    | {{$user->nomor_kwh}}
                                    | {{$user->TagihanKWH->count()}} Bills Count
                                    "
                                                                    value="{{$user->id}}"/>
                                    @endforeach
                                </x-form.input-dropdown>
                            </div>
                        </div>
                        <x-form.button-submit label="Search" class="btn btn-primary form-control">
                            Search
                        </x-form.button-submit>
                    </form>
                    <x-form.button-submit label="Generate print" class="my-4 btn btn-info form-control"
                                          x-on:click="$wire.dispatch('PrintPageArea')">
                        Print Page
                    </x-form.button-submit>
                </div>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="card">
                <div class="card card-body printableArea">
                    <h3><b>Customer:</b> <span class="pull-right">{{ $this->loadReport['name'] }}</span></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <address>
                                    <h3> &nbsp;<b class="text-danger">{{ $this->loadReport['no_kwh'] }}</b></h3>
                                    <p class="text-muted m-l-5">
                                        @if(!$this->loadReport['alamat'])
                                            Total Customer: {{ $this->loadReport['allInformation']['total_customer'] }}
                                            <br> Total Bill: {{ $this->loadReport['allInformation']['total_bill'] }}
                                            <br> Total
                                            Payment: {{ $this->loadReport['allInformation']['total_payment'] }}
                                        @else
                                            @php
                                                $address = $this->loadReport['alamat'];
                                                echo wordwrap($address, 36, "<br>\n", true);
                                            @endphp
                                        @endif

                                    </p>
                                </address>
                            </div>
                            <div class="pull-right text-end">
                                <address>
                                    @if($startYear)
                                        <p class="m-t-30">
                                            <b>Start Year :</b> <i class="fa fa-calendar"></i> {{$startYear}}
                                        </p>
                                    @endif
                                    @if($endYear)
                                        <p>
                                            <b>End Year :</b> <i class="fa fa-calendar"></i> {{$endYear}}
                                        </p>
                                    @endif
                                </address>
                            </div>
                        </div>
                        @if(is_null($this->username) || $this->username == 'all')
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40" style="clear: both;">
                                    <h3 class="card-title">List Customer</h3>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Customer Name</th>
                                            <th class="text-end">Nomor kWh</th>
                                            <th class="text-end">Rp / Kwh</th>
                                            <th class="text-end">Watt</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($this->loadReport['user_list'] as $item)
                                            @if(!is_null($item))
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->nama_pelanggan}}</td>
                                                    <td class="text-end">{{$item->nomor_kwh}}</td>
                                                    <td class="text-end">
                                                        Rp. {{number_format($item->getTarif->tarif_perkwh,0,',','.')}}</td>
                                                    <td class="text-end">{{$item->getTarif->daya}} VA</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <h3 class="card-title">List Payment</h3>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Customer Name</th>
                                        <th class="text-end">Month</th>
                                        <th class="text-end">Year</th>
                                        <th class="text-end">Total kWh</th>
                                        <th class="text-end">Total Payment</th>
                                        <th class="text-end">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($this->loadReport['paymentList']->toArray() as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item['pelanggan_k_w_h']['nama_pelanggan']}}</td>
                                            <td class="text-end">{{$item['bulan']}}</td>
                                            <td class="text-end">{{$item['tahun']}}</td>
                                            <td class="text-end">{{$item['jumlah_meter']}}</td>
                                            <td class="text-end">
                                                Rp. {{number_format($item['pembayaran_k_w_h']['total_tagihan'] ?? 0,0,',','.')}}</td>
                                            <td class="text-end">
                                                @if($item['status'])
                                                    <span class="badge badge-info bg-success">success</span>
                                                @else
                                                    <span class="badge badge-danger bg-danger">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pull-right m-t-30 text-end">
                                <p>Total All Paid Billing:
                                    Rp. {{ number_format($this->loadReport['totalIncome'] ?? 0, 0, ',', '.') }}</p>
                                <p>Total Admin Income:
                                    Rp. {{ number_format($this->loadReport['totalAdminIncome'] ?? 0, 0, ',', '.') }}</p>
                                <hr>
                                <h3><b>Total:</b>
                                    Rp. {{ number_format(($this->loadReport['totalIncome'] ?? 0) + ($this->loadReport['totalAdminIncome'] ?? 0), 0, ',', '.') }}
                                </h3>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                        </div>
                    </div>
                </div>
                @script
                <script>
                    $(document).ready(() => {
                        $wire.on('PrintPageArea', () => {
                            $('.printableArea').printArea({
                                mode: 'iframe',
                                popClose: false,
                                retainAttr: ['class', 'id', 'style'],
                            });
                        });
                    });
                </script>
                @endscript
            </div>
        </div>
    </div>
</div>
