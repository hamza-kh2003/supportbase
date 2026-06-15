<?php

namespace App\Livewire;

use Livewire\Component;

class Topbar extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->dispatch('searchUpdated', $this->search);
    }

    public function render()
    {
        return view('livewire.topbar');
    }
}