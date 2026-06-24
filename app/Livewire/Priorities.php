<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Priority;

class Priorities extends Component
{
    public $modalTitle;
    public $showModal = false;
    public $editingId = null;

    public $form = [
        'name' => '',
    ];

    public function create()
    {
        $this->reset('form');
        $this->form['name'] = '';
        $this->modalTitle = 'Add Priority';
        $this->showModal = true;
    }
    public function closeModal()
{
    $this->reset('showModal');
    $this->resetValidation();
}       

    public function edit($id)
    {
        $priority = Priority::findOrFail($id);

        $this->editingId = $priority->id;

        $this->form = [
            'name' => $priority->name,
        ];

        $this->modalTitle = 'Edit Priority';
        $this->showModal = true;
    }

    #[On('triggerDelete')]
    public function delete($id)
    {
        $priority = Priority::findOrFail($id);

        $priority->name = $priority->name . "deleted {$id}";
        $priority->save();

        $priority->delete();

        if ($this->editingId == $id) {
            $this->reset(['editingId', 'form', 'showModal']);
        }
    }

    public function save()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:priorities,name,' . $this->editingId,
        ]);

        if ($this->editingId) {

            $priority = Priority::findOrFail($this->editingId);

            $priority->update([
                'name' => $this->form['name'],
            ]);

        } else {

            Priority::create([
                'name' => $this->form['name'],
            ]);
        }

        $this->reset(['form', 'showModal', 'editingId']);
    }

    public function render()
    {
        return view('livewire.priorities', [
            'priorities' => Priority::latest()->get(),
        ])->layout('layouts.app', ['title' => 'Priorities']);
    }
}