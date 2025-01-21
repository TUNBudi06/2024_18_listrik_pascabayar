<?php

use App\Livewire\Forms\RegisterForm;
use App\Models\TarifKWH;
use function Livewire\Volt\{state, form, layout};

layout('layouts.guest');

form(RegisterForm::class, 'register');

state([
    'tarif_kwh' => TarifKWH::all(),
]);

$validateStep = function ($step) {
    $rules = [];

    if ($step === 1) {
        $rules = [
            'register.name' => 'required',
            'register.username' => 'required|unique:users,username|unique:pelanggans,username',
            'register.password' => ['required', 'confirmed',\Illuminate\Validation\Rules\Password::default()],
        ];
    } elseif ($step === 2) {
        $rules = [
            'register.alamat' => 'required',
            'register.tarif_kwh' => 'required|numeric|exists:tarif_kwh,id',
        ];
    } elseif ($step === 3) {
        $rules = [
            'register.no_kwh' => 'required|numeric',
        ];
    }

    $this->validate($rules,['register.username.unique'=>'Username already taken']);

    // Increment the step after successful validation
    $this->dispatch('step_increment',step: $step + 1);
};

$submitRegister = function () {
    $this->register->validate();

    $this->register->register();

    $this->redirect(route('login'));
};

?>

<div class="login-register" style="background-image:url({{asset('assets/images/background/login-register.jpg')}});">
    <div class="login-box card">
        <div class="card-body">
            <form class="form-horizontal form-material">
                <h3 class="text-center m-b-20">Sign Up</h3>

                <!-- Step 1 -->
                <div x-show="$store.step_panel.step === 1">
                    <x-form.input-text name="name" label="Name" placeholder="Name" required autofocus
                                       wireModel="register.name" :messages="$errors->get('register.name')[0] ?? null"/>
                    <x-form.input-text name="username" label="Username" placeholder="Username" required
                                       wireModel="register.username"
                                       :messages="$errors->get('register.username')[0] ?? null"/>
                    <x-form.input-text name="password" label="Password" placeholder="Password" type="password" required
                                       wireModel="register.password"
                                       :messages="$errors->get('register.password')[0] ?? null"/>
                    <x-form.input-text name="password_confirmation" label="Password Confirmation" type="password" required
                                       wireModel="register.password_confirmation"
                                       :messages="$errors->get('register.password_confirmation')[0] ?? null"/>
                    <button type="button" class="btn btn-info w-100"
                            wire:click="validateStep(1)">
                        Next
                    </button>
                </div>

                <!-- Step 2 -->
                <div x-show="$store.step_panel.step  === 2">
                    <x-form.input-textarea name="alamat" label="Alamat" placeholder="Alamat" required
                                           wireModel="register.alamat"
                                           :messages="$errors->get('register.alamat')[0] ?? null"/>
                    <x-form.input-dropdown name="tarif_kwh" label="Tarif KWH" wireModel="register.tarif_kwh"
                                           :messages="$errors->get('register.tarif_kwh')[0] ?? null">
                        @foreach($tarif_kwh as $index => $tarif)
                            <x-form.input-dropdown-list value="{{$tarif->id}}"
                                                        label="{{$index}}. {{$tarif->daya}}VA / Rp.{{$tarif->tarif_perkwh}}"></x-form.input-dropdown-list>
                        @endforeach
                    </x-form.input-dropdown>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" @click="$store.step_panel.step = 1">Back</button>
                        <button type="button" class="btn btn-info"
                                wire:click="validateStep(2)">
                            Next
                        </button>
                    </div>
                </div>

                <!-- Step 3 -->
                <div x-show="$store.step_panel.step  === 3">
                    <x-form.input-text type="number" name="no_kwh" label="No KWH" placeholder="No KWH" required
                                       wireModel="register.no_kwh"
                                       :messages="$errors->get('register.no_kwh')[0] ?? null"/>
                    <small class="form-control-feedback">minimal 12 digit</small>
                    <small class="form-control-feedback">maximal 20 digit</small>
                    <small class="form-control-feedback">your digits: <span x-text="$wire.register.no_kwh.length"></span></small>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" @click="$store.step_panel.step = 2">Back</button>
                        <x-form.button-submit type="button" class="btn btn-success w-100"
                                wire:click="submitRegister">
                            Sign Up
                        </x-form.button-submit>
                    </div>
                </div>
            </form>
            <div class="form-group m-b-0 text-center">
                <div class="col-sm-12">
                    Already have an account? <a href="{{route('login')}}" class="text-info m-l-5" wire:navigate><b>Sign
                            In</b></a>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('livewire:init',() =>{
                Alpine.store('step_panel',{
                    step: 1,

                    toggle(step){
                        this.step = step;
                    },
                })
            })
        </script>
        @script
            <script type="text/javascript">
                $wire.on('step_increment',(param) =>{
                    Alpine.store('step_panel').toggle(param.step);
                })
            </script>
        @endscript
    </div>
</div>
