<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;


class RecipientNotification extends Notification
{
    use Queueable;

    var $document = null;

    var $req = 'RECIPIENT';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($document, $req)
    {
        $this->document = $document;
        $this->req = $req;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $it = $this->document;
        $doc = null;

        $userName =  Auth::user()->name;

        $url = 'ecf/verification/tes';
        if($this->req == 'CAMPAIGN-VERIFIED' ){
            $url = 'ecf/campaign';
        }
        if($this->req == 'CAMPAIGN-DECLINED' ){
            $url = 'ecf/campaign/edit/'.$it->_id;
        }
        if(is_object($it)){
            $doc = [
                '_id'=>$it->_id,
                'notification_id'=>$this->id,
                'docType'=>$it->docType,
                'docDate'=>$it->docDate,
                'docNo'=>($it->docNo ?? ''),
                'subject'=>$it->subject,
                'ownerName'=>$it->ownerName,
                'req'=>$this->req,
                'from'=>$userName,
                'url'=>url( $url )
            ];
        }elseif(is_array($it)){
            $doc = [
                '_id'=>$it['_id'],
                'docType'=>$it['docType'],
                'docDate'=>$it['docDate'],
                'docNo'=>($it['docNo'] ?? ''),
                'subject'=>$it['subject'],
                'ownerName'=>$it['ownerName'],
                'req'=>$this->req,
                'from'=>$userName,
                'url'=>url( $url )
            ];
        }
        return $doc;
    }
}
