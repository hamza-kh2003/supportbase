<?php

namespace App\Livewire;

use Livewire\Component;

class Departments extends Component
{
    // سيتم ربطها بالداتابيس لاحقاً
    public function render()
    {
        return view('livewire.departments')
            ->layout('layouts.app', ['title' => 'Departments']);
    }
}
