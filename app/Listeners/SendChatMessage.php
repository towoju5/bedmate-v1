<?php

namespace App\Listeners;

use App\Events\ChatMessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChatMessage
{
    public $message;
    /**
     * Create the event listener.
     */
    public function __construct($message)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChatMessageSent $event): void
    {
        $message = $event->message;
    }
}
