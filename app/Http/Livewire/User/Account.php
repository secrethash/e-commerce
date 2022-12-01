<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Account extends Component
{

    public User $user;

    public $password;
    public $password_confirmation;
    public $current_password;

    protected function rules(): array
    {
        return [
            'user' => ['array'],
            'user.first_name' => ['required'],
            'user.last_name' => ['string', 'nullable'],
            'user.email' => ['required', 'email'],
            'user.phone_number' => ['required', 'numeric'],
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function savePersonal(): void
    {
        $this->validateOnly('user');
        $this->validateOnly('user.first_name');
        $this->validateOnly('user.last_name');
        $this->validateOnly('user.email');
        $this->validateOnly('user.phone_number');
        $this->user->save();
    }

    public function savePassword(): void
    {
        $this->validateOnly('current_password');
        $this->validateOnly('password');
        $this->user->update([
            'password' => Hash::make($this->password),
        ]);
    }

    public function render()
    {
        return view('livewire.user.account')
            ->extends('layouts.app');
    }
}
