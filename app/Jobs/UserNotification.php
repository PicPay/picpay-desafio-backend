<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Log;
use App\Services\ThirdPartNotificationService;

class UserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    private $notification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $notification)
    {
        $this->notification = $notification;
    }

    public function handle(){

        foreach($this->notification as $item)
            $notificationService = new ThirdPartNotificationService($item);
            if(!$notificationService->userNotification()){
                Log::error('Error on send notification');
            }
    }

}