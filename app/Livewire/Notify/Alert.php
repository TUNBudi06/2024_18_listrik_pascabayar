<?php

namespace App\Livewire\Notify;

use App\Http\Controllers\users\checkGuards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportEvents\Event;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\View as ViewView;

class Alert extends Component
{

    public $json_send = ['heading'=>'','message'=>'','icon'=>'info','nextLink'=>null];
    /**
     * @param array $array ['heading'=>null,'message'=>null,'icon'=>'info' | 'success' | 'warning' | 'error','nextLink'=>null]
     * @return Event
     */
    #[On('AlertNotify')]
    public function alert($array = ['heading'=>null,'message'=>null,'icon'=>'info','link'=>null]): Event
    {
        if (isset($array['link'])) {
            $this->json_send['nextLink'] = $array['link'];
        }
        if (isset($array['heading'])) {
            $this->json_send['heading'] = $array['heading'];
        }
        if(isset($array['message'])){
            $this->json_send['message'] = $array['message'];
        }
        if(isset($array['icon'])){
            $this->json_send['icon'] = $array['icon'];
        }
        return $this->dispatch('alertSelf',$this->json_send);
    }

    public function render(): Application|Factory|View|ViewView
    {
        return view('livewire.notify.alert');
    }
}
