<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class cacheStore extends Controller
{
    public static function PelangganListCache(){
        return Cache::store('redis')->flexible('PelangganList',[ 60 * 60 * 24,60 * 60 * 24 *2],function (){
            return Pelanggan::with(['getTarif'])->orderBy('nama_pelanggan')->get();
        });
    }

    public static function PelangganListCacheClear(){
        return Cache::forget('PelangganList');
    }
}
