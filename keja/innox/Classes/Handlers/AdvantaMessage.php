<?php


namespace Innox\Classes\Handlers;


use Illuminate\Support\Facades\Notification;

class AdvantaMessage
{
    public function send($notifiable , Notification $notification)
    {
        $notification->toAdvantaMessage($notifiable);

    }
}
