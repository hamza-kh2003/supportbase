<header class="sb-topbar">
    <div class="sb-topbar-left">
        <button class="sb-menu-toggle" onclick="toggleSidebar()">
            <i class="ti ti-menu-2"></i>
        </button>
        <div class="sb-logo">
            <i class="ti ti-book-2"></i>
            Support<b>Base</b>
        </div>
    </div>

    <div class="sb-topbar-center">
        <div class="sb-search">
            <i class="ti ti-search"></i>
            <input type="text" wire:model.live="search" placeholder="Search articles..." />
        </div>
    </div>

    <div class="sb-topbar-right">
        {{-- Role badge --}}
        <span class="sb-role-badge admin">Admin</span>
        {{-- change to class="sb-role-badge user" for user role --}}

        {{-- Avatar + dropdown --}}
        <div class="sb-avatar-wrap" id="avatarWrap">
            <div class="sb-avatar" onclick="toggleProfileMenu()">HA</div>
            <div class="sb-profile-menu" id="profileMenu" style="display:none">
                <div class="sb-pm-info">
                    <div class="sb-pm-name">Hamza Admin</div>
                    <div class="sb-pm-email">admin@sb.com</div>
                </div>
                <hr />
                <a href="{{ route('profile') }}" class="sb-pm-btn">
                    <i class="ti ti-user"></i> My profile
                </a>
                <a href="{{ route('logout') }}" class="sb-pm-btn danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ti ti-logout"></i> Sign out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>