<?php

namespace Model\MessageQueue\Repositories;

use Model\MessageQueue\MessageQueue;

class MessageQueueRepository implements MessageQueueRepositoryInterface
{
    private $model;

    public function __construct(MessageQueue $model)
    {
        $this->model = $model;
    }

    public function add($user_id, $content) : MessageQueue
    {
        $message = $this->model->create([
            'user_id'      => $user_id,
            'content'      => $content
        ]);

        return $message;
    }
    public function setSent($message_id) : MessageQueue
    {
        $message = $this->model->findOrFail($message_id);
        $message->sent = true;
        $message->send_date = date('Y-m-d H:i:s');
        $message->save();
        return $message;
    }
}
