<?php

namespace App\Services\Message;

interface SendMessageServiceInterface
{
    public function executeSendMessage($message_id) : bool ;
}
