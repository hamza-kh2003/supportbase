<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationsPage extends Component
{
    public function render()
    {
        $notifications = Notification::with('article')
            ->latest()
            ->get();

        return view('livewire.notifications-page', [
            'notifications' => $notifications,
        ])->layout('layouts.app', ['title' => 'Notifications']);
    }
}