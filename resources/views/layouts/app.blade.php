<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="user-name" content="{{ auth()->user()->name }}">
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
    <link rel="icon" href="{{ asset('images/download.png') }}" type="image/png">
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/supportbase.css') }}" />

    @vite(['resources/js/app.js'])

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
                if (m) m.style.display = m.style.display === 'none' ? 'block' : 'none';
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('#avatarWrap')) {
                    const m = document.getElementById('profileMenu');
                    if (m) m.style.display = 'none';
                }
            });
        });
    </script>

    {{-- ═══ LIVE NOTIFICATIONS ═══ --}}
    <div id="live-notifications" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 320px;"></div>

    <script type="module">
        window.addEventListener('load', () => {
            window.Echo.channel('articles')
                .listen('.ArticleCreated', (e) => {
                    const container = document.getElementById('live-notifications');

                    const toast = document.createElement('div');
                    toast.className = 'alert alert-info shadow';
                    toast.style.marginBottom = '10px';
                    toast.innerHTML = `
                    <strong>🔔 New Article</strong><br>
                    "${e.title}" — added by ${e.user}
                `;

                    container.appendChild(toast);

                    setTimeout(() => {
                        toast.remove();
                    }, 5000);
                });
        });
    </script>
    {{-- ═══ LIVE CHAT ═══ --}}
    <script type="module">
        window.addEventListener('load', () => {

            let currentChatChannel = null;
            let typingTimeout = null;

            Livewire.on('message-sent', () => {
                const input = document.getElementById('chat-input');
                if (input) input.value = '';
            });

            // ═══ 1. Presence Channel: مين أونلاين هلأ ═══
            let onlineUserIds = new Set();
            window.Echo.join('online')
                .here((users) => {
                    users.forEach(u => {
                        onlineUserIds.add(u.id);
                        markOnline(u.id);

                    });
                })
                .joining((user) => {
                    onlineUserIds.add(user.id);
                    markOnline(user.id);
                })
                .leaving((user) => {
                    onlineUserIds.delete(user.id);
                    markOffline(user.id);
                });

            function markOnline(userId) {
                const dot = document.querySelector(`.online-dot[data-user-id="${userId}"]`);
                if (dot) dot.style.background = '#28a745';
            }

            function markOffline(userId) {
                const dot = document.querySelector(`.online-dot[data-user-id="${userId}"]`);
                if (dot) dot.style.background = '#ccc';
            }

            // ⭐ الجزء الجديد: إعادة تلوين الدوائر بعد كل تحديث Livewire
            document.addEventListener('livewire:navigated', reapplyOnlineStatus);
            Livewire.hook('morph.updated', () => {
                reapplyOnlineStatus();
            });

            function reapplyOnlineStatus() {
                onlineUserIds.forEach(id => markOnline(id));
            }

            // ═══ 2. لما يتغير المستخدم المختار بالشات ═══
            Livewire.on('user-selected', (event) => {
                const userId = event.userId;

                if (currentChatChannel) {
                    window.Echo.leave(currentChatChannel);
                }

                const myId = parseInt(document.querySelector('meta[name="user-id"]').content);
                const otherId = parseInt(userId);

                const ids = [myId, otherId].sort((a, b) => a - b);
                currentChatChannel = 'chat.' + ids[0] + '.' + ids[1];

                window.Echo.private(currentChatChannel)
                    .listen('.DirectMessageSent', (e) => {
                        const myId = parseInt(document.querySelector('meta[name="user-id"]').content);

                        // لو أنا يلي بعت الرسالة، تجاهلها (Livewire أصلا عرضها)
                        if (e.sender_id === myId) {
                            return;
                        }

                        appendMessage(e);

                        Livewire.dispatch('mark-message-read', {
                            messageId: e.id
                        });
                    })
                    .listenForWhisper('typing', (e) => {
                        showTypingIndicator(e.name);
                    });


                // ⭐ سطر جديد: تأكد إنه الصندوق ينزل لآخر رسالة فور فتح المحادثة
                setTimeout(() => {
                    const box = document.getElementById('messages-box');
                    if (box) box.scrollTop = box.scrollHeight;
                }, 100);
            });

            function appendMessage(e) {
                const box = document.getElementById('messages-box');
                if (!box) return;

                const wrapper = document.createElement('div');
                wrapper.className = 'd-flex mb-2 justify-content-start';

                const bubble = document.createElement('div');
                bubble.className = 'px-3 py-2 rounded-3 bg-white border';
                bubble.style.maxWidth = '65%';
                bubble.textContent = e.body;

                wrapper.appendChild(bubble);
                box.appendChild(wrapper);
                box.scrollTop = box.scrollHeight;
            }

            function showTypingIndicator(name) {
                const el = document.getElementById('typing-indicator');
                if (!el) return;

                el.textContent = name + ' is typing...';

                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => {
                    el.textContent = '';
                }, 2000);
            }

            // ═══ 3. إرسال whisper "عم يكتب" لما تكتب بالإنبوت ═══
            document.addEventListener('input', (e) => {
                if (e.target.id === 'chat-input' && currentChatChannel) {
                    const myName = document.querySelector('meta[name="user-name"]').content;

                    window.Echo.private(currentChatChannel)
                        .whisper('typing', {
                            name: myName
                        });
                }
            });

        });
    </script>



    @livewireScripts
</body>

</html>
