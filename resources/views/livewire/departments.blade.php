<div style="display:flex; flex-direction:column; flex:1; overflow:hidden;">

    {{-- Page Header --}}
    <div class="sb-page-header">
        <h1>Departments</h1>
        <button class="sb-btn-primary">
            <i class="ti ti-plus"></i> Add department
        </button>
    </div>

    {{-- Chips --}}
    <div class="sb-chips-grid">

        @php
            $departments = ['Infrastructure', 'Security', 'Helpdesk', 'DevOps'];
        @endphp

        @foreach($departments as $dept)
            <div class="sb-chip">
                <i class="ti ti-building" style="font-size:15px; color:var(--text3)"></i>
                <span class="sb-chip-name">{{ $dept }}</span>
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