<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Article $article)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('articles'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ArticleCreated';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->article->id,
            'title' => $this->article->title,
            'user' => $this->article->user->name ?? 'Unknown',
        ];
    }
}