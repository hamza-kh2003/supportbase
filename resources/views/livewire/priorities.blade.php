<div style="display:flex; flex-direction:column; flex:1; overflow:hidden;">

    {{-- Page Header --}}
    <div class="sb-page-header">
        <h1>Priorities</h1>
        <button class="sb-btn-primary">
            <i class="ti ti-plus"></i> Add priority
        </button>
    </div>

    {{-- Chips --}}
    <div class="sb-chips-grid">

        @php
            $priorities = [
                ['name' => 'Low', 'color' => 'sb-tag-prior-low'],
                ['name' => 'Medium', 'color' => 'sb-tag-prior-medium'],
                ['name' => 'High', 'color' => 'sb-tag-prior-high'],
                ['name' => 'Critical', 'color' => 'sb-tag-prior-critical'],
            ];
        @endphp

        @foreach($priorities as $priority)
            <div class="sb-chip">
                <i class="ti ti-flag" style="font-size:15px; color:var(--text3)"></i>
                <span class="sb-chip-name">{{ $priority['name'] }}</span>
                <span class="sb-tag {{ $priority['color'] }}" style="margin-left:4px">
                    {{ $priority['name'] }}
                </span>
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