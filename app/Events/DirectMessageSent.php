<?php

namespace App\Events;

use App\Models\DirectMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DirectMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public DirectMessage $message)
    {
        //
    }

   public function broadcastOn(): array
{
    $ids = [$this->message->sender_id, $this->message->receiver_id];
    sort($ids);

    return [
        new PrivateChannel('chat.' . $ids[0] . '.' . $ids[1]),
    ];
}

    public function broadcastAs(): string
    {
        return 'DirectMessageSent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'body' => $this->message->body,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->name,
            'created_at' => $this->message->created_at->diffForHumans(),
        ];
    }
}