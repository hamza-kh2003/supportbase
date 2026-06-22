<div style="display:flex; flex-direction:column; flex:1; overflow:hidden;">

    {{-- Header --}}
    <div class="sb-page-header">
        <h1>Departments</h1>

        <button class="sb-btn-primary" wire:click="create">
            <i class="ti ti-plus"></i> Add department
        </button>
    </div>

    {{-- List --}}
    <div class="sb-chips-grid">

        @foreach($departments as $dept)
            <div class="sb-chip">
                <i class="ti ti-building" style="font-size:15px; color:var(--text3)"></i>

                <span class="sb-chip-name">{{ $dept->name }}</span>

                <div class="sb-chip-actions">

                    <button class="sb-chip-btn" wire:click="edit({{ $dept->id }})">
                        <i class="ti ti-edit"></i>
                    </button>

                    <button class="sb-chip-btn del"
                        onclick="confirmDelete({{ $dept->id }}, '{{ $dept->name }}')">
                        <i class="ti ti-trash"></i>
                    </button>

                </div>
            </div>
        @endforeach

    </div>

    {{-- Modal --}}
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

                    <div class="sb-form-group">
                        <label>Department Name</label>
                        <input type="text" wire:model="form.name" />

                        @error('form.name')
                            <div class="sb-alert-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="sb-modal-footer">

                    <button class="sb-btn-outline" wire:click="$set('showModal', false)">
                        Cancel
                    </button>

                    <button class="sb-btn-primary" wire:click="save">
                        Save
                    </button>

                </div>

            </div>
        </div>
    @endif

</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Delete Department?',
        text: `"${name}" will be removed`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes delete'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('triggerDelete', { id: id });
        }
    });
}
</script>