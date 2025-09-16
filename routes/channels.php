<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('admin.{adminId}', function ($admin, $adminId) {
    return Auth::guard('admin')->check() && Auth::guard('admin')->id() == (int) $adminId;
});


Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
