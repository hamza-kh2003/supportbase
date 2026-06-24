<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Product;

class Products extends Component
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
    $this->showModal = true;
    $this->modalTitle = 'Add Product';
}

public function closeModal()
{
    $this->reset('showModal');
    $this->resetValidation();
}       

public function edit($id)
{
    $product = Product::findOrFail($id);

    $this->editingId = $product->id;

    $this->form = [
        'name' => $product->name,
    ];
    $this->modalTitle = 'Edit Product';
    $this->showModal = true;
}

#[On('triggerDelete')] 
public function delete($id)
{
    $product = Product::findOrFail($id);

    $product->name = $product->name . "$id" . "Deleted";
    $product->save();
    $product->delete();

    if ($this->editingId == $id) {
        $this->reset(['editingId', 'form', 'showModal']);
    }

}
public function save()
{
   $this->validate([
        'form.name' => 'required|string|max:255|unique:products,name,' . $this->editingId,
    ]);

    if ($this->editingId) {

        $product = Product::findOrFail($this->editingId);

        $product->update([
            'name' => $this->form['name'],
        ]);

    } else {

        Product::create([
            'name' => $this->form['name'],
        ]);
    }

    $this->reset(['form', 'showModal', 'editingId']);
}
    
    public function render()
    {
        return view('livewire.products',['products' => Product::latest()->get()])
            ->layout('layouts.app', ['title' => 'Products']);
    }


}