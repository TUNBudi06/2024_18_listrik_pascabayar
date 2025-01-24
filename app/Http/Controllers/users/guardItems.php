<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class guardItems extends Controller
{
    public static function checkGuardsIfLoginResultAuthClass()
    {
        if (auth()->guard('admin')->check()) {
            return Auth::guard('admin');
        } elseif (auth()->guard('pelanggan')->check()) {
            return Auth::guard('pelanggan');
        }

        return false;
    }

    public static function checkGuardsIfLoginResultId()
    {
        if (auth()->guard('admin')->check()) {
            return Auth::guard('admin')->id();
        } elseif (auth()->guard('pelanggan')->check()) {
            return Auth::guard('pelanggan')->id();
        }

        return false;
    }

    public static function checkGuardsIfLoginResultTypeUser()
    {
        if (auth()->guard('admin')->check()) {
            return 'admin';
        } elseif (auth()->guard('pelanggan')->check()) {
            return 'pelanggan';
        }

        return false;
    }

    public static function getUserIfLoginResultName()
    {
        if (auth()->guard('admin')->check()) {
            return Auth::guard('admin')->getUser()['name'];
        } elseif (auth()->guard('pelanggan')->check()) {
            return Auth::guard('pelanggan')->getUser()['nama_pelanggan'];
        }

        return null;
    }
}
