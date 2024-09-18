<?php

namespace App\Listeners;

use App\Events\RegisterEvent;
use App\Mail\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCodeListner
{

    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(RegisterEvent $event): void
    {

        Mail::to($event->user->email)->send(new VerifyEmail($event->user->code, now()->addMinutes(60)));
    }
}