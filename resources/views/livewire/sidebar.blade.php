<nav class="sb-sidebar" id="sidebar">
    {{-- روابط المستخدمين المسجلين فقط --}}
    @auth
        <div class="sb-nav-section">
            <a href="{{ route('kb') }}" wire:navigate class="sb-nav-item {{ request()->routeIs('kb') ? 'active' : '' }}">
                <i class="ti ti-books"></i> Knowledge Base
            </a>
            <a href="{{ route('profile') }}" wire:navigate
                class="sb-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="ti ti-user-circle"></i> My Account
            </a>
            <a href="{{ route('notifications') }}" wire:navigate
                class="sb-nav-item {{ request()->routeIs('notifications') ? 'active' : '' }}">
                <i class="ti ti-bell"></i> Notifications
            </a>
            <a href="{{ route('chat') }}" wire:navigate
                class="sb-nav-item {{ request()->routeIs('chat') ? 'active' : '' }}">
                <i class="ti ti-message-circle"></i> Chat
            </a>
        </div>
    @endauth

    {{-- Admin-only section --}}
    @if (auth()->user()->role === 'admin')
        <div class="sb-nav-section">
            <div class="sb-nav-label">Admin</div>
            <a href="{{ route('users') }}" wire:navigate
                class="sb-nav-item {{ request()->routeIs('users') ? 'active' : '' }}">
                <i class="ti ti-users"></i> Users
            </a>
            <a href="{{ route('departments') }}" wire:navigate
                class="sb-nav-item {{ request()->routeIs('departments') ? 'active' : '' }}">
                <i class="ti ti-building"></i> Departments
            </a>
            <a href="{{ route('products') }}" wire:navigate
                class="sb-nav-item {{ request()->routeIs('products') ? 'active' : '' }}">
                <i class="ti ti-box"></i> Products
            </a>
            <a href="{{ route('priorities') }}" wire:navigate
                class="sb-nav-item {{ request()->routeIs('priorities') ? 'active' : '' }}">
                <i class="ti ti-flag"></i> Priorities
            </a>
        </div>
    @endif
</nav>
