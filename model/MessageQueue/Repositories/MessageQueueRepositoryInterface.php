<?php

namespace Model\MessageQueue\Repositories;

use Model\MessageQueue\MessageQueue;

interface MessageQueueRepositoryInterface
{
    public function add($user_id, $content) : MessageQueue;
    public function setSent($message_id) : MessageQueue;
}
