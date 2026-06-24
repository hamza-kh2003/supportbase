<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Department;

class Departments extends Component
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
        $this->modalTitle = 'Add Department';
        $this->showModal = true;
    }
  public function closeModal()
{
    $this->reset('showModal');
    $this->resetValidation();
}       
    public function edit($id)
    {
        $dept = Department::findOrFail($id);

        $this->editingId = $dept->id;

        $this->form = [
            'name' => $dept->name,
        ];

        $this->modalTitle = 'Edit Department';
        $this->showModal = true;
    }

    #[On('triggerDelete')]
    public function delete($id)
    {
        $dept = Department::findOrFail($id);

        // soft delete style name marking (optional like yours)
        $dept->name = $dept->name . "deleted {$id}";
        $dept->save();

        $dept->delete();

        if ($this->editingId == $id) {
            $this->reset(['editingId', 'form', 'showModal']);
        }
    }

    public function save()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:departments,name,' . $this->editingId,
        ]);

        if ($this->editingId) {

            $dept = Department::findOrFail($this->editingId);

            $dept->update([
                'name' => $this->form['name'],
            ]);

        } else {

            Department::create([
                'name' => $this->form['name'],
            ]);
        }

        $this->reset(['form', 'showModal', 'editingId']);
    }

    public function render()
    {
        return view('livewire.departments', [
            'departments' => Department::latest()->get(),
        ])->layout('layouts.app', ['title' => 'Departments']);
    }
}