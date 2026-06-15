<?php

namespace App\Livewire;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class Users extends Component
{
    public $showModal = false;
    public $modalTitle = 'New User';
    public $editingId = null;

    public $form = [
        'name' => '',
        'email' => '',
        'role' => 'user',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function create()
    {
        $this->editingId = null;

        $this->form = [
            'name' => '',
            'email' => '',
            'role' => 'user',
        ];

        $this->showModal = true;

        $this->modalTitle = 'Add User';
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user = User::findOrFail($id);

        $user->email = $user->id . '_deleted_' . $user->email;

        $user->save();

        $user->delete();

        if ($this->editingId == $id) {
            $this->reset(['editingId', 'showModal', 'form']);
        }
    }
    public function edit($id)
    {

        $user = User::findOrFail($id);

        $this->editingId = $user->id;

        $this->form = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->modalTitle = 'Edit User';
        $this->showModal = true;
    }

    public function save()
    {
        $rules = [
            'form.name' => 'required|string|max:255|min:3',

            'form.email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($this->editingId),
            ],

            'form.role' => 'required|in:user,admin',
        ];

        // password rules تختلف بين create / edit
        if ($this->editingId) {
            $rules['form.password'] = 'nullable|min:8|confirmed';
        } else {
            $rules['form.password'] = 'required|min:8|confirmed';
        }

        $this->validate($rules);

        if ($this->editingId) {

          if ($this->editingId == auth()->id() && $this->form['role'] !== auth()->user()->role) {
    session()->flash('updateError', 'You cannot change your own role.');
    $this->showModal=false;
    return;
}

            $user = User::findOrFail($this->editingId);

            $data = [
                'name' => $this->form['name'],
                'email' => $this->form['email'],
                'role' => $this->form['role'],
            ];

            if (!empty($this->form['password'])) {
                $data['password'] = Hash::make($this->form['password']);
            }

            $user->update($data);

        } else {

            User::create([
                'name' => $this->form['name'],
                'email' => $this->form['email'],
                'role' => $this->form['role'],
                'password' => Hash::make($this->form['password']),
            ]);
        }

        $this->reset(['form', 'editingId', 'showModal']);

        $this->form = [
            'name' => '',
            'email' => '',
            'role' => 'user',
            'password' => '',
            'password_confirmation' => '',
        ];
    }
    public function render()
    {
        return view('livewire.users', ['users' => User::latest()->get()])
            ->layout('layouts.app', ['title' => 'Users']);
    }
}