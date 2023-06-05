<?php

namespace App\Listeners;

use App\Events\MailSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MailSentListener
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
     * @param  MailSent  $event
     * @return void
     */
    public function handle(MailSent $event)
    {
        //
    }
}
