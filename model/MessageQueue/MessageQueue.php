<?php

namespace Model\MessageQueue;

use Illuminate\Database\Eloquent\Model;

class MessageQueue extends Model
{
    protected $table = 'message_queue';
    protected $primaryKey = 'message_id';
    public $timestamps = false;
    protected $guarded = ['message_id'];

    public function user()
    {
        return $this->hasOne(\Model\Users\Users::classs, 'user_id', 'user_id');
    }
}
