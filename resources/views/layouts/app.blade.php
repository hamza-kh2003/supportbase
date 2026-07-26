<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SupportBase — {{ $title ?? 'Knowledge Base' }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&family=DM+Sans:wght@300;400;500;600&display=swap"
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

            {{-- ═══ SIDEBAR BACKDROP FOR MOBILE ═══ --}}
            <div class="sb-sidebar-backdrop" onclick="toggleSidebar()"></div>

            {{-- ═══ MAIN CONTENT ═══ --}}
            <main class="sb-main">
                {{ $slot }}
            </main>

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function applyMobileSidebarDefault() {
            if (window.innerWidth <= 768) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) sidebar.classList.add('collapsed');
                document.body.classList.remove('sb-sidebar-open');
            }
        }

        document.addEventListener('DOMContentLoaded', applyMobileSidebarDefault);

        document.addEventListener('livewire:navigated', () => {
            applyMobileSidebarDefault();
            
            window.toggleSidebar = function() {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('collapsed');
                    if (!sidebar.classList.contains('collapsed')) {
                        document.body.classList.add('sb-sidebar-open');
                    } else {
                        document.body.classList.remove('sb-sidebar-open');
                    }
                }
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