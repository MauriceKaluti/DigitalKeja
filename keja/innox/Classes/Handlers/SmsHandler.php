<?php


namespace Innox\Classes\Handlers;

use Innox\Contracts\ShouldSendNotification;
use RuntimeException;

class SmsHandler
{

    public static function __callStatic($method, $args)
    {
        $instance = static::self();

        return $instance->$method(...$args);
    }
    public function send(ShouldSendNotification $sendNotification , $to , $message)
    {
        return $sendNotification->send($to , $message);
    }

}
