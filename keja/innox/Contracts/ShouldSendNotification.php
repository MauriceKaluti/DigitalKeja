<?php


namespace Innox\Contracts;


interface ShouldSendNotification
{

    public function send($to , $message);
}
