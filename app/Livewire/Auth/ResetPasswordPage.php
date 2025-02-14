<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

#[Title('Reset Passwod - YuriGshop')]
class ResetPasswordPage extends Component
{
    public $token;
    #[Url]
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token){
        $this->token = $token;
    }

    public function save(){
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required'
            ]);

            $status = Password::reset([
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function(User $user, string $password){
                $password = $this->password;
                $user->forceFill([
                    'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));
                    $user->save();

            });

            return $status === Password::PASSWORD_RESET?redirect('/login'):session()->flash('error' , 'somthing went wrong');

    }
    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
