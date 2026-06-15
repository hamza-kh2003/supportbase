<div style="display:flex; flex-direction:column; flex:1; overflow:hidden;">

    {{-- Page Header --}}
    <div class="sb-page-header">
        <h1>Products</h1>
        <button class="sb-btn-primary">
            <i class="ti ti-plus"></i> Add product
        </button>
    </div>

    {{-- Chips --}}
    <div class="sb-chips-grid">

        @php
            $products = ['ERP System', 'Email Server', 'VPN', 'HR Portal'];
        @endphp

        @foreach($products as $product)
            <div class="sb-chip">
                <i class="ti ti-box" style="font-size:15px; color:var(--text3)"></i>
                <span class="sb-chip-name">{{ $product }}</span>
                <div class="sb-chip-actions">
                    <button class="sb-chip-btn" title="Edit">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button class="sb-chip-btn del" title="Delete">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach

    </div>

</div>