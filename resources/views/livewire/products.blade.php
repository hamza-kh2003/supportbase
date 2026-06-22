<div style="display:flex; flex-direction:column; flex:1; overflow:hidden;">

    {{-- Page Header --}}
    <div class="sb-page-header">
        <h1>Products</h1>
        <button class="sb-btn-primary" wire:click="create">
    <i class="ti ti-plus"></i> Add product
</button>
    </div>

    {{-- Chips --}}
    <div class="sb-chips-grid">

        @foreach($products as $product)
            <div class="sb-chip">
                <i class="ti ti-box" style="font-size:15px; color:var(--text3)"></i>
                <span class="sb-chip-name">{{ $product->name }}</span>
                <div class="sb-chip-actions">
                   <button class="sb-chip-btn" wire:click="edit({{ $product->id }})">
    <i class="ti ti-edit"></i>
</button>
                    <button class="sb-chip-btn del" title="Delete" 
        onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')">
    <i class="ti ti-trash"></i>
</button>
                </div>
            </div>
        @endforeach

    </div>


    @if($showModal)
    <div class="sb-modal-overlay" wire:click.self="$set('showModal', false)">
        <div class="sb-modal">

            <div class="sb-modal-header">
                <span>{{$modalTitle}}</span>
                <button wire:click="$set('showModal', false)">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <div class="sb-modal-body">

                <div class="sb-form-group">
                    <label>Product Name</label>
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

{{-- استدعاء مكتبة SweetAlert عبر CDN إذا لم تكن مضافة بمشروعك مسبقاً --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id, productName) {
    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete "${productName}"`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // إرسال الحدث إلى كامبوننت Livewire لتنفيذ الحذف الفعلي
            Livewire.dispatch('triggerDelete', { id: id });
        }
    })
}
</script>