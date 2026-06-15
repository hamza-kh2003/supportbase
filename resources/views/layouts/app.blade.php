<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SupportBase — {{ $title ?? 'Knowledge Base' }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet" />

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/supportbase.css') }}" />

    @livewireStyles
</head>

<body>

    <div class="sb-app">

        {{-- ═══ TOPBAR ═══ --}}
        <livewire:topbar />

        <div class="sb-body">

            {{-- ═══ SIDEBAR ═══ --}}
            <nav class="sb-sidebar" id="sidebar">
                <div class="sb-nav-section">
                    <a href="{{ route('kb') }}" class="sb-nav-item {{ request()->routeIs('kb') ? 'active' : '' }}">
                        <i class="ti ti-books"></i> Knowledge Base
                    </a>
                    <a href="{{ route('profile') }}"
                        class="sb-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="ti ti-user-circle"></i> My Account
                    </a>
                </div>

                {{-- Admin-only section --}}
                {{-- @if(auth()->user()->role === 'admin') --}}
                <div class="sb-nav-section">
                    <div class="sb-nav-label">Admin</div>
                    <a href="{{ route('users') }}"
                        class="sb-nav-item {{ request()->routeIs('users') ? 'active' : '' }}">
                        <i class="ti ti-users"></i> Users
                    </a>
                    <a href="{{ route('departments') }}"
                        class="sb-nav-item {{ request()->routeIs('departments') ? 'active' : '' }}">
                        <i class="ti ti-building"></i> Departments
                    </a>
                    <a href="{{ route('products') }}"
                        class="sb-nav-item {{ request()->routeIs('products') ? 'active' : '' }}">
                        <i class="ti ti-box"></i> Products
                    </a>
                    <a href="{{ route('priorities') }}"
                        class="sb-nav-item {{ request()->routeIs('priorities') ? 'active' : '' }}">
                        <i class="ti ti-flag"></i> Priorities
                    </a>
                </div>
                {{-- @endif --}}
            </nav>

            {{-- ═══ MAIN CONTENT ═══ --}}
            <main class="sb-main">
                {{ $slot }}
            </main>

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        function toggleProfileMenu() {
            const m = document.getElementById('profileMenu');
            m.style.display = m.style.display === 'none' ? 'block' : 'none';
        }

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#avatarWrap')) {
                const m = document.getElementById('profileMenu');
                if (m) m.style.display = 'none';
            }
        });
    </script>

    @livewireScripts
</body>

</html>