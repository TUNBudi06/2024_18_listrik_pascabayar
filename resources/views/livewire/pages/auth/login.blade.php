<?php

use App\Http\Controllers\users\checkGuards;
use App\Livewire\Forms\LoginForm;
use App\Livewire\Notify\Alert;
use Livewire\Form;
use function Livewire\Volt\{state, layout, form, boot, protect};


layout("layouts.guest");

form(LoginForm::class, 'login');

$submitLogin = function () {
    $this->validate();
    $this->login->authenticate();
    $this->dispatch('AlertNotify', ['icon' => 'success', 'message' => 'Login Success','link'=>route('dashboard')])->to(Alert::class);
//    $this->redirectIntended(default: route('dashboard', absolute: false));
};
?>

<div class="login-register" style="background-image:url({{asset('assets/images/background/login-register.jpg')}});">
    <div class="login-box card">
        <div class="card-body">
            <form class="form-horizontal form-material" wire:submit="submitLogin">
                <h3 class="text-center m-b-20">Sign In</h3>
                <x-form.input-text name="username" label="Username" placeholder="Username" required autofocus
                                   wireModel="login.username" :messages="$errors->get('login.username')[0] ?? null"/>
                <x-form.input-text name="password" label="Password" placeholder="Password" wireModel="login.password"
                                   :messages="$errors->get('login.password')[0] ?? null" type="password"/>
                <div class="d-flex no-block align-items-center">
                    <x-form.input-checkbox name="remember" wireModel="login.remember">Remember Me?
                    </x-form.input-checkbox>
                </div>
                <div class="form-group text-center">
                    <div class="col-xs-12 p-b-20">
                        <x-form.button-submit class="btn w-100 btn-lg btn-info btn-rounded text-white" type="submit">
                            Log In
                        </x-form.button-submit>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        Don't have an account?
                        <a href="{{route('register')}}"
                           class="text-info m-l-5"
                           >
                            <b>
                                Sign Up
                            </b>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
