<?php

namespace App\Livewire;

use Livewire\Component;

class Profile extends Component
{
    // سيتم ربطها بالداتابيس لاحقاً
    public function render()
    {
        return view('livewire.profile')
            ->layout('layouts.app', ['title' => 'My Account']);
    }
}