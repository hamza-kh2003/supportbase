<?php

namespace App\Livewire;

use Livewire\Component;

class Priorities extends Component
{
    // سيتم ربطها بالداتابيس لاحقاً
    public function render()
    {
        return view('livewire.priorities')
            ->layout('layouts.app', ['title' => 'Priorities']);
    }
}
