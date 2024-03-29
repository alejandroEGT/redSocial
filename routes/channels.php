<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    //return (int) $user->id === (int) $id;
    return true;
});

Broadcast::channel('chat.{id}.{id_otra}', function ($user) {
    return true;
});
Broadcast::channel('chat.{id}', function ($user) {
    return true;
});

Broadcast::channel('notificar_solicitud.{id}', function ($user) {
    return true;
});

Broadcast::channel('notificar_solicitud_cancel.{id}', function ($user) {
    return true;
});
Broadcast::channel('notificar_solicitud_return.{id}', function ($user) {
    return true;
});


