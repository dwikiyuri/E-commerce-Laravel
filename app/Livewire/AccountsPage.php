<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\addressuser;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
#[Title('My Account - YuriGshop')]
class AccountsPage extends Component
{
    public $user;
    public $currentpassword;
    public $newpassword;
    public $newpassword_confirmation;
    public function mount()
    {
        $this->user = Auth::user();
    }
    public function updatePassword()
    {
        $this->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|min:8|confirmed',

        ]);
        $user = User::find($this->user->id);
        if (Hash::check($this->currentpassword, $user->password)) {
            $user->password = Hash::make($this->newpassword);
            $user->save();
            session()->flash('status', 'Password successfully updated');
            return redirect()->route('my-account');
        } else {
            session()->flash('error', 'Old password is incorrect');
        }
    }
    public function render()
    {
        $myaddress = addressuser::where('user_id', $this->user->id)->first();

        return view('livewire.my-account-page', [
            'user' => $this->user,
            'myaddress' => $myaddress,
        ]);
    }


}
