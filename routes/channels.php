<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id || User::find($id)->id;
});
