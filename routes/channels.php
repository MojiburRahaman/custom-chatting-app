<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
Use App\Models\User;


// Broadcast::channel('users.{user}', function ($user, $id) {
//     return true;
// });
// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
