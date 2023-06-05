<?php

namespace App\Listeners;

use App\Helpers\TimeUtil;
use App\Models\Mms\MessageLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageSendingListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $mlog = new MessageLog();
        $mlog->timestamp = TimeUtil::createTime( $mlog, env('DEFAULT_TIME_ZONE') );
        $mlog->event = $event;
        $mlog->messageId = $event->data['messageId'] ?? '';
        $mlog->message = $event->message->toString();
        $mlog->subject = $event->message->getSubject() ?? '';
        $mlog->to = $event->message->getTo() ?? '';
        $mlog->sender = $event->message->getSender() ?? '';
        $mlog->from = $event->message->getFrom() ?? '';
        $mlog->cc = $event->message->getCc() ?? '';
        $mlog->bcc = $event->message->getBcc() ?? '';
        $mlog->data = $event->data;
        $mlog->status = 'SENDING';
        $mlog->messageType = 'EMAIL';
        $mlog->save();

    }
}
