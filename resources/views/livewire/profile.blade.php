<div style="display:flex; flex-direction:column; flex:1; overflow:hidden;">

    {{-- Page Header --}}
    <div class="sb-page-header">
        <h1>My Account</h1>
    </div>

    {{-- Profile Content --}}
    <div class="sb-profile-wrap">

        {{-- Left: Avatar + Info --}}
        <div class="sb-profile-left">
            <div class="sb-avatar-big">HA</div>
            <div class="sb-prof-name">Hamza Admin</div>
            <span class="sb-prof-role admin">Admin</span>
            {{-- للـ user: <span class="sb-prof-role user">User</span> --}}

            <div class="sb-prof-meta">
                <div class="sb-prof-meta-row">
                    <i class="ti ti-mail"></i> admin@sb.com
                </div>
                <div class="sb-prof-meta-row">
                    <i class="ti ti-id-badge-2"></i> ID #1
                </div>
            </div>
        </div>

        {{-- Right: Sections --}}
        <div class="sb-profile-right">

            {{-- Personal Info --}}
            <div class="sb-prof-section">
                <div class="sb-prof-section-title">
                    <i class="ti ti-user"></i> Personal info
                </div>

                <div class="sb-prof-info-row">
                    <span class="sb-prof-info-label">Full name</span>
                    <span class="sb-prof-info-value">Hamza Admin</span>
                </div>
                <div class="sb-prof-info-row">
                    <span class="sb-prof-info-label">Email</span>
                    <span class="sb-prof-info-value">admin@sb.com</span>
                </div>
                <div class="sb-prof-info-row">
                    <span class="sb-prof-info-label">Role</span>
                    <span class="sb-prof-info-value">Admin</span>
                </div>

                <button class="sb-btn-outline" style="margin-top:14px">
                    <i class="ti ti-edit"></i> Edit profile
                </button>
            </div>

            {{-- Password --}}
            <div class="sb-prof-section">
                <div class="sb-prof-section-title">
                    <i class="ti ti-lock"></i> Password
                </div>
                <p style="font-size:13px; color:var(--text2); margin-bottom:14px">
                    Change your account password.
                </p>
                <button class="sb-btn-outline">
                    <i class="ti ti-key"></i> Change password
                </button>
            </div>

            {{-- Danger Zone --}}
            <div class="sb-prof-section danger-zone">
                <div class="sb-prof-section-title" style="color:var(--red)">
                    <i class="ti ti-alert-triangle"></i> Danger zone
                </div>
                <p style="font-size:13px; color:var(--text2); margin-bottom:14px">
                    Permanently delete your account. This cannot be undone.
                </p>
                <button class="sb-btn-danger">
                    <i class="ti ti-trash"></i> Delete my account
                </button>
            </div>

        </div>
    </div>

</div>