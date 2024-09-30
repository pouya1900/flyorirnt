<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\SendEmailEvent $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
        try {
            Mail::to($event->email)->send($event->email_class);
        } catch (\Exception) {
            return;
        }
    }
}
