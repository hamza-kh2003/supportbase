<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\KnowledgeBase;
use App\Livewire\Users;
use App\Livewire\Departments;
use App\Livewire\Products;
use App\Livewire\Priorities;
use App\Livewire\Profile;
use App\Livewire\NotificationsPage;
use App\Livewire\ChatPage;



Route::middleware(['auth'])->group(function () {
    Route::get('/', KnowledgeBase::class)->name('kb');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/notifications', NotificationsPage::class)->name('notifications');
    Route::get('/chat', ChatPage::class)->name('chat');
    // Admin only
    Route::middleware(['admin'])->group(function () {
        Route::get('/users', Users::class)->name('users');
        Route::get('/departments', Departments::class)->name('departments');
        Route::get('/products', Products::class)->name('products');
        Route::get('/priorities', Priorities::class)->name('priorities');
    });
});


require __DIR__ . '/auth.php';
