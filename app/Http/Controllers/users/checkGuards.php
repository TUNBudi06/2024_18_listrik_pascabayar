<?php

namespace App\Http\Controllers\users;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Concurrency;

class checkGuards extends Controller
{
    /**
    * @var string $username The username to be checked.
    */
    public null|string $username;

    /**
     * Constructor to initialize the username.
     *
     * @param string|null $username The username to be set.
     */
    public function __construct($username = null)
    {
        if ($username) {
            $this->username = $username;
        } else {
            $this->username = null;
        }
    }

    /**
     * Check which guard is currently authenticated and return the guard's name.
     *
     * @return string Returns 'admin' if the 'admin' guard is authenticated,
     *                'pelanggan' if the 'pelanggan' guard is authenticated,
     *                and 'guest' if no guard is authenticated.
     */
    public function checkGuardsIfLoginResultGuardsName() : string
    {
        if (auth()->guard('admin')->check()) {
            return 'admin';
        } else if (auth()->guard('pelanggan')->check()) {
            return 'pelanggan';
        }
        return 'guest';
    }

    /**
     * Check which guard is currently authenticated and return a corresponding number.
     *
     * @return int Returns 1 if the 'admin' guard is authenticated,
     *             2 if the 'pelanggan' guard is authenticated,
     *             and 0 if no guard is authenticated.
     */
    public function checkGuardsIfLoginResultNumber() : int
    {
        if (auth()->guard('admin')->check()) {
            return 1;
        } else if (auth()->guard('pelanggan')->check()) {
            return 2;
        }
        return 0;
    }

    /**
     * Find the user in the guards and return the guard's name.
     *
     * @param string|null $username The username to be checked.
     * @return string Returns 'admin' if the user is found in the 'admin' guard,
     *                'pelanggan' if the user is found in the 'pelanggan' guard,
     *                and 'guest' if no user is found.
     */
    public function findUserInGuardsResultGuards($username = null) : string
    {
        if ($this->username) {
            $username = $this->username;
        }

        $admin = function () use ($username) {
            $admin = User::where('username', $username)->first();
            return $admin ? 'admin' : null;
        };

        $pelanggan = function () use ($username) {
            $pelanggan = Pelanggan::where('username', $username)->first();
            return $pelanggan ? 'pelanggan' : null;

        };

        [$admin,$pelanggan] = Concurrency::run([$admin,$pelanggan]);
        return $admin ?? $pelanggan;
    }

    /**
     * Find the user in the guards and return the corresponding model class.
     *
     * @param string|null $username The username to be checked.
     * @return string|bool Returns User::class if the user is found in the 'admin' guard,
     *                     Pelanggan::class if the user is found in the 'pelanggan' guard,
     *                     and false if no user is found.
     */
    public function findUserInGuardsResultDB($username = null)
    {
        if ($this->username) {
            $username = $this->username;
        }

        $admin = function () use ($username) {
            $admin = User::where('username', $username)->first();
            return $admin ? 'admin' : null;
        };

        $pelanggan = function () use ($username) {
            $pelanggan = Pelanggan::where('username', $username)->first();
            return $pelanggan ? 'pelanggan' : null;

        };

        [$admin,$pelanggan] = Concurrency::run([$admin,$pelanggan]);

        $result = $admin ?? $pelanggan;
        switch ($result) {
            case 'admin':
                return User::class;
                break;
            case 'pelanggan':
                return Pelanggan::class;
                break;
            default:
                return false;
        }
    }
}
