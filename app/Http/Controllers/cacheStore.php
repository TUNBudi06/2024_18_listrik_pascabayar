<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PembayaranKWH;
use Illuminate\Support\Facades\Cache;

class cacheStore extends Controller
{
    public static function PelangganListCache()
    {
        return Cache::store('redis')->flexible('PelangganList', [60 * 60 * 24, 60 * 60 * 24 * 2], function () {
            return Pelanggan::with(['getTarif'])->orderBy('nama_pelanggan')->get();
        });
    }

    public static function PelangganListCacheClear()
    {
        return Cache::forget('PelangganList');
    }

    public static function PaymentPelangganListCache()
    {
        return Cache::store('redis')->flexible('PelangganPaymentList', [60 * 60 * 24, 60 * 60 * 24 * 2], function () {
            return PembayaranKWH::with(['pelangganKWH', 'tagihanKWH'])->orderBy('tanggal_pembayaran', 'desc')->get();
        });
    }
}
