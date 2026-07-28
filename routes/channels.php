<?php

use Illuminate\Support\Facades\Broadcast;

// قناة الشات الخاصة - بس صاحب الـ id يقدر يشترك فيها
Broadcast::channel('chat.{userA}.{userB}', function ($user, $userA, $userB) {
    return (int) $user->id === (int) $userA || (int) $user->id === (int) $userB;
});
// قناة الأونلاين - أي مستخدم مسجل دخول يقدر يشترك فيها
Broadcast::channel('online', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});