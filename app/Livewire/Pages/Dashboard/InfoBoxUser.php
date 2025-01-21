<?php

namespace App\Livewire\Pages\Dashboard;

use App\Http\Controllers\users\guardItems;
use App\Models\Pelanggan;
use App\Models\PembayaranKWH;
use App\Models\PenggunaanKWH;
use App\Models\TagihanKWH;
use Illuminate\Support\Carbon;
use Livewire\Component;

class InfoBoxUser extends Component
{
    public string $icon;
    public string $class;
    public $count;
    public $message;
    protected $tanggal;



    protected function totalUsageThisYearNow(){
        $total = 0;
        $penggunaan = PenggunaanKWH::where('pelanggan_id', guardItems::checkGuardsIfLoginResultAuthClass()->user()->id)
            ->where('tahun', date('Y'))->get()->toArray();
        array_reduce($penggunaan, function($carry, $item) use (&$total){
            $total += $item['meter_akhir'] - $item['meter_awal'];
        });
        $this->icon = 'fa fa-bolt';
        $this->count = $total. ' KWH';
        $this->message = 'Total Energy Usage This Year';
    }

    protected function totalUsageYearBefore()
    {
        $total = 0;
        $penggunaan = PenggunaanKWH::where('pelanggan_id', guardItems::checkGuardsIfLoginResultAuthClass()->user()->id)
            ->where('tahun', date('Y') - 1)->get()->toArray();
        array_reduce($penggunaan, function($carry, $item) use (&$total){
            $total += $item['meter_akhir'] - $item['meter_awal'];
        });
        $this->icon = 'fa fa-bolt';
        $this->count = $total. ' KWH';
        $this->message = 'Total Energy Usage Last Year';
    }

    protected function paymentAndKWHLastMonth(){
        $bayar = 0;
        $kwh = 0;
        $getKwh = TagihanKWH::where('pelanggan_id', guardItems::checkGuardsIfLoginResultAuthClass()->user()->id)->with(['PembayaranKWH'])
            ->where('bulan', Carbon::now()->subMonth()->format('F'))
            ->where('tahun', Carbon::now()->subMonth()->format('Y'))->first();
        $kwh = $getKwh->jumlah_meter . ' KWH';
        $bayar = $getKwh->PembayaranKWH->total_bayar;
        $this->icon = 'far fa-money-bill-alt';
        $this->count = 'Rp. '.number_format($bayar, 0, ',', '.');
        $this->message = "Payment and {$kwh} KWH Usage Last Month";
    }

    protected function tarifKWHShown() {
        $tarif = Pelanggan::with('getTarif')->findOrFail(guardItems::checkGuardsIfLoginResultAuthClass()->getUser()->id);
        $this->icon = 'fa fa-money';
        $this->count = 'Rp. '.number_format($tarif->getTarif->tarif_perkwh, 0, ',', '.');
        $this->message = 'Tarif KWH';
    }

    public function totalAllUsagesInYear(){
        $total = 0;
        $penggunaan = PenggunaanKWH::where('pelanggan_id', guardItems::checkGuardsIfLoginResultAuthClass()->user()->id)
            ->where('tahun', date('Y'))->get()->toArray();
        array_reduce($penggunaan, function($carry, $item) use (&$total){
            $total += $item['meter_akhir'] - $item['meter_awal'];
        });
        $this->icon = 'fa fa-bolt';
        $this->count = $total. ' KWH';
        $this->message = "Total Energy Usage in ".date('Y')." Of All Customers";
    }

    public function totalAllUsagesLastYear(){
        $total = 0;
        $penggunaan = PenggunaanKWH::where('pelanggan_id', guardItems::checkGuardsIfLoginResultAuthClass()->user()->id)
            ->where('tahun', $this->tanggal->subYear()->format('Y'))->get()->toArray();
        array_reduce($penggunaan, function($carry, $item) use (&$total){
            $total += $item['meter_akhir'] - $item['meter_awal'];
        });
        $this->icon = 'fa fa-bolt';
        $this->count = $total. ' KWH';
        $this->message = "Total Energy Usage in ".$this->tanggal->subYear()->format('Y')." Of All Customers";
    }

    public function totalPaymentHasBeenPayout()
    {
        $total = 0;
        $year = $this->tanggal->subYear()->format('Y');
        $pembayaran = TagihanKWH::with('PembayaranKWH')->where('status',1)->where('tahun',$year)->get()->toArray();
        array_reduce($pembayaran, function($carry, $item) use (&$total){
            $total += $item['pembayaran_k_w_h']['total_tagihan'];
        });
        $this->count = $total;
        $this->icon = 'far fa-money-bill-alt';
        $this->message = 'Total Payment Has Been Payout in '.$year;
    }

    public function totalPelanggans()
    {
        $this->count = Pelanggan::count();
        $this->icon = 'mdi mdi-account-box';
        $this->message = "Total Customers";
    }

    public function mount($type,$class = '')
    {
        $this->tanggal = Carbon::now();

        $allowedMethods = ['totalUsageThisYearNow','totalUsageYearBefore','paymentAndKWHLastMonth','tarifKWHShown','totalAllUsagesInYear','totalAllUsagesLastYear','totalPaymentHasBeenPayout','totalPelanggans'];

        if (in_array($type, $allowedMethods) && method_exists($this, $type)) {
            $this->$type();
        } else {
            throw new \Exception("Method $type is not allowed or does not exist.");
        }
    }

    public function placeholder(){
        return view('placeholder.dashboard.info-box');

    }

    public function render()
    {
        return view('livewire.pages.dashboard.info-box-user');
    }
}
