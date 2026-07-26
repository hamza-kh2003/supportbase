<div style="display:flex; flex-direction:column; flex:1; overflow:hidden;">

    {{-- Page Header --}}
    <div class="sb-page-header">

        <h1>Users</h1>
        <button class="sb-btn-primary" wire:click="create">
            <i class="ti ti-plus"></i> Add user
        </button>


    </div>
    @if (session()->has('error'))
        <div class="sb-alert-error mt-3">
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('updateError'))
        <div class="sb-alert-error mt-3">
            {{ session('updateError') }}
        </div>
    @endif
    
    {{-- Table --}}
    <div class="sb-table-wrap">
        <table class="sb-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach($users as $user)
                    <tr>
                        <td data-label="Name"><strong>{{ $user['name'] }}</strong></td>
                        <td data-label="Email">{{ $user['email'] }}</td>
                        <td data-label="Role">
                            <span class="sb-tag {{ $user['role'] === 'admin' ? 'sb-tag-role-admin' : 'sb-tag-role-user' }}">
                                {{ ucfirst($user['role']) }}
                            </span>
                        </td>
                        <td data-label="Actions">
                            <div class="sb-actions">
                                <button class="sb-action-btn" wire:click="edit({{ $user->id }})">
                                    <i class="ti ti-edit"></i> Edit
                                </button>
                                <button class="sb-action-btn del"
                                    onclick="return confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()"
                                    wire:click="delete({{ $user->id }})">
                                    <i class="ti ti-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>



    {{-- ═══ MODAL ═══ --}}
    @if($showModal)
        <div class="sb-modal-overlay" wire:click.self="$set('showModal', false)">
            <div class="sb-modal">

                <div class="sb-modal-header">
                    <span>{{ $modalTitle }}</span>
                    <button wire:click="$set('showModal', false)">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <div class="sb-modal-body">

                    {{-- Name --}}
                    <div class="sb-form-group">
                        <label>Name</label>
                        <input type="text" wire:model="form.name" placeholder="Full name" />
                        @error('form.name')
                            <div class="sb-alert-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="sb-form-group">
                        <label>Email</label>
                        <input type="email" wire:model="form.email" placeholder="Email address" />
                        @error('form.email')
                            <div class="sb-alert-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="sb-form-group">
                        <label>Role</label>
                        <select wire:model="form.role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('form.role')
                            <div class="sb-alert-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="sb-form-group">
                        <label>Password</label>
                        <input type="password" wire:model="form.password" placeholder="Password" />
                        @error('form.password')
                            <div class="sb-alert-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="sb-form-group">
                        <label>Confirm Password</label>
                        <input type="password" wire:model="form.password_confirmation" placeholder="Confirm password" />
                    </div>

                </div>

                <div class="sb-modal-footer">
                    <button class="sb-btn-outline" wire:click="$set('showModal', false)">
                        Cancel
                    </button>

                    <button class="sb-btn-primary" wire:click="save">
                        <i class="ti ti-check"></i> Save user
                    </button>
                </div>

            </div>
        </div>
    @endif


</div>