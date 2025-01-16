<?php

namespace App\Livewire\Forms;

use App\Models\Pelanggan;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegisterForm extends Form
{
    #[Validate('required|string')]
    public string $name;

    #[Validate('required|string|unique:users,username')]
    public string $username;

    #[Validate('required|string|min:11|max:20')]
    public string $no_kwh;

    #[Validate('required|string')]
    public string $alamat;

    #[Validate(rule: ['required','string','confirmed'])]
    public $password;
    public $password_confirmation;

    #[Validate('required|numeric|exists:tarif_kwh,id',)]
    public $tarif_kwh;

    public function register()
    {
        Pelanggan::create([
            'nama_pelanggan' => $this->name,
            'username' => $this->username,
            'nomor_kwh' => $this->no_kwh,
            'alamat' => $this->alamat,
            'password' => \Hash::make($this->password),
            'tarif_kwh_id' => $this->tarif_kwh,
        ]);
    }
}
