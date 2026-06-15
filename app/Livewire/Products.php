<?php

namespace App\Livewire;

use Livewire\Component;

class Products extends Component
{
    // سيتم ربطها بالداتابيس لاحقاً
    public function render()
    {
        return view('livewire.products')
            ->layout('layouts.app', ['title' => 'Products']);
    }
}