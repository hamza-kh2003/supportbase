<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\DirectMessage;
use Livewire\Attributes\On;
use App\Events\DirectMessageSent;


class ChatPage extends Component
{
    public $selectedUserId = null;
    public $body = '';
    public $firstUnreadId = null;
 
    public function selectUser($userId)
{
    $this->selectedUserId = $userId;

    // نلاقي أول رسالة غير مقروءة *قبل* ما نعلمها مقروءة
    $firstUnread = DirectMessage::where('sender_id', $userId)
        ->where('receiver_id', auth()->id())
        ->whereNull('read_at')
        ->orderBy('created_at')
        ->first();

    $this->firstUnreadId = $firstUnread?->id;

    // هلق نعلم الكل كمقروء
    DirectMessage::where('sender_id', $userId)
        ->where('receiver_id', auth()->id())
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    $this->dispatch('user-selected', userId: $userId);
}

#[On('mark-message-read')]
public function markMessageRead($messageId)
{
    DirectMessage::where('id', $messageId)->update(['read_at' => now()]);
}

    public function send()
    {
        $this->validate([
            'body' => 'required|string|max:1000',
        ]);

        $message = DirectMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUserId,
            'body' => $this->body,
        ]);

        DirectMessageSent::dispatch($message);
        
        

        $this->body = '';
        $this->dispatch('message-sent'); 
    }

    public function render()
{
    $users = User::where('id', '!=', auth()->id())->get();

    $messages = $this->selectedUserId
        ? DirectMessage::where(function ($q) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $this->selectedUserId);
        })->orWhere(function ($q) {
            $q->where('sender_id', $this->selectedUserId)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get()
        : collect();

    return view('livewire.chat-page', [
        'users' => $users,
        'messages' => $messages,
    ])->layout('layouts.app', ['title' => 'Chat']);
}
}