<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class guardItems extends Controller
{


    public static function checkGuardsIfLoginResultAuthClass(){
        if (auth()->guard('admin')->check()) {
            return Auth::guard('admin');
        } else if (auth()->guard('pelanggan')->check()) {
            return Auth::guard('pelanggan');
        }
        return false;
    }

    public static function checkGuardsIfLoginResultTypeUser(){
        if (auth()->guard('admin')->check()) {
            return 'admin';
        } else if (auth()->guard('pelanggan')->check()) {
            return 'pelanggan';
        }
        return false;
    }

    public static function getUserIfLoginResultName(){
        if (auth()->guard('admin')->check()) {
            return Auth::guard('admin')->getUser()['name'];
        } else if (auth()->guard('pelanggan')->check()) {
            return Auth::guard('pelanggan')->getUser()['nama_pelanggan'];
        }
        return null;
    }
}
