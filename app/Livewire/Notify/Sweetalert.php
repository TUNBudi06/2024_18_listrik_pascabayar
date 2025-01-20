<?php

namespace App\Livewire\Notify;

use Livewire\Attributes\On;
use Livewire\Component;

class Sweetalert extends Component
{
    protected $TypeSA = 'redirect'; // 'redirect' or 'toast'

    #[On('alertSweetAlert')]
    public function alertSweetAlert($arr = ['tilte'=>null,'text'=>null])
    {

    }

    public function render()
    {
        return view('livewire.notify.sweetalert');
    }
}
