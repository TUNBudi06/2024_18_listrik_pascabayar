<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PelangganPaymentConfirmation extends Form
{
    #[Validate(['integer', 'required'])]
    public $total_bayar;

    #[Validate(['integer'])]
    public $total_tagihan;

    public function ValidatePay()
    {
        $this->validate(); // Validasi input

        \Debugbar::info((int) $this->total_tagihan > (int) $this->total_bayar);

        if ((int) $this->total_tagihan > (int) $this->total_bayar) {
            throw ValidationException::withMessages([
                'payment.total_bayar' => 'Your Money cant be lower than the Bill',
            ]);
        }
    }
}
