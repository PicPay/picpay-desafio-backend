<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Queue implements ShouldQueue
{
    public function __get(string $attribute)
    {
        if ($attribute == 'connection') {
            return config('queue.default');
        } elseif ($attribute == 'queue') {
            return config('app.queue_listener');
        } elseif (property_exists($this, $attribute)) {
            return $this->$attribute;
        }
    }
}
