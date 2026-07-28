<div class="d-flex border rounded overflow-hidden" style="height: 80vh;">

    {{-- قائمة المستخدمين --}}
    <div class="border-end bg-light" style="width: 260px; overflow-y: auto;">
        <h6 class="p-3 mb-0 border-bottom">💬 Conversations</h6>
        @foreach ($users as $user)
            <div wire:click="selectUser({{ $user->id }})"
                class="d-flex align-items-center gap-2 p-3 border-bottom {{ $selectedUserId == $user->id ? 'bg-white' : '' }}"
                style="cursor: pointer; transition: background 0.15s;">

                <div class="position-relative">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                        style="width:36px;height:36px;font-size:14px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <span class="online-dot" data-user-id="{{ $user->id }}"
                        style="position:absolute;bottom:0;right:0;width:10px;height:10px;border-radius:50%;background:#ccc;border:2px solid white;"></span>
                </div>

                <span>{{ $user->name }}</span>
            </div>
        @endforeach
    </div>

    {{-- صندوق المحادثة --}}
    <div class="flex-grow-1 d-flex flex-column bg-white">
        @if ($selectedUserId)

            {{-- Header --}}
            <div class="p-3 border-bottom fw-semibold">
                {{ $users->firstWhere('id', $selectedUserId)?->name }}
            </div>

            {{-- الرسائل --}}
            {{-- الرسائل --}}
            <div id="messages-box" class="flex-grow-1 overflow-auto p-3" style="background:#f8f9fa;">
                @foreach ($messages as $msg)
                    @if ($firstUnreadId && $msg->id == $firstUnreadId)
                        <div class="d-flex align-items-center my-3">
                            <div class="flex-grow-1 border-top"></div>
                            <span class="px-2 small text-danger fw-semibold">New</span>
                            <div class="flex-grow-1 border-top"></div>
                        </div>
                    @endif

                    <div
                        class="d-flex mb-2 {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="px-3 py-2 rounded-3 {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-white border' }}"
                            style="max-width: 65%;">
                            {{ $msg->body }}
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- مؤشر الكتابة --}}
            <div id="typing-indicator" class="px-3 fst-italic text-muted small"
                style="height: 22px; line-height: 22px;"></div>

            {{-- إدخال الرسالة --}}
            <form wire:submit.prevent="send" class="d-flex gap-2 p-3 border-top">
                <input type="text" wire:model="body" id="chat-input" class="form-control rounded-pill px-3"
                    placeholder="Type a message..." autocomplete="off">
                <button type="submit" class="btn btn-primary rounded-circle" style="width:42px;height:42px;">
                    <i class="ti ti-send"></i>
                </button>
            </form>
        @else
            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                <div class="text-center">
                    <i class="ti ti-message-circle" style="font-size: 48px;"></i>
                    <p class="mt-2">Select a conversation to start chatting</p>
                </div>
            </div>
        @endif
    </div>
</div>
