<?php

namespace App\Listeners;

use App\Events\FreeGiftEvent;
use App\Mail\SendGiftToUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class FreeGiftListner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FreeGiftEvent $event): void
    {
        Mail::to($event->user->email)->send(new SendGiftToUser);
    }
}