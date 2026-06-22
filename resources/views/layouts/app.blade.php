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
   <link rel="icon" href="{{ asset('images/download.png') }}" type="image/png" >
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/supportbase.css') }}"  />

    @livewireStyles
</head>

<body>

    <div class="sb-app">

        {{-- ═══ TOPBAR ═══ --}}
        <livewire:topbar />

        <div class="sb-body">

            {{-- ═══ SIDEBAR ═══ --}}
           <livewire:sidebar />

            {{-- ═══ MAIN CONTENT ═══ --}}
            <main class="sb-main">
                {{ $slot }}
            </main>

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
       // في ملف app.blade.php، عدل السكريبت ليكون هكذا:
document.addEventListener('livewire:navigated', () => {
    
    // ضع أكواد التوجل والـ Click هنا لتضمن عملها بعد كل تنقل بدون ريفريش
    window.toggleSidebar = function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }

    window.toggleProfileMenu = function() {
        const m = document.getElementById('profileMenu');
        if(m) m.style.display = m.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#avatarWrap')) {
            const m = document.getElementById('profileMenu');
            if (m) m.style.display = 'none';
        }
    });
    
});
    </script>

    @livewireScripts
</body>

</html>