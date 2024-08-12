<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    public $email, $password, $remember;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login(){
        $validate = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($validate, $this->remember)){
            session()->regenerate();
            session()->flash('success', translate('Logged in successfully!'));
            return redirect()->route('dashboard');
        }

        $this->addError('email', translate('Invalid Email or Password'));

    }
}
