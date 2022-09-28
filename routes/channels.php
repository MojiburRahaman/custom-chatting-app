<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('message', function ($user, $id) {
    return true;
});

// Broadcast::channel('activity.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
// Broadcast::channel('message.{toUserId}', function ($user, $toUserId) {
//     return $user->id == $toUserId;
// });

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
