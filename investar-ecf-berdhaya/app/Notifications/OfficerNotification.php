<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfficerNotification extends Notification
{
    use Queueable;

    var $obj = null;

    var $req = 'RECIPIENT';

    var $notif = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($obj, $tmpl ,$req)
    {
        $this->obj = $obj;
        $this->tmpl = $tmpl;
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
        $it = $this->obj;
        $doc = null;
        $wa = null;
        $tpl = $this->tmpl->toArray();
        $tplId = $tpl['slug'];
        $message = $tpl['body'] ?? '';

        $recipient = $notifiable->toArray();

        $msisdn = $recipient['mobile'];

        $url = 'fms/cattle-profile';

        if(is_object($it)){
            $doc = [
                '_id'=>$it->_id,
                'notification_id'=>$this->id,
                'notification'=>$this->tmpl,
                'farmNo'=>$it->farmNo ?? '',
                'cattleId'=>($it->cattleId ?? ''),
                'farmName'=>$it->farmName ?? '',
                'ownerName'=>$it->ownerName ?? '',
                'req'=>$this->req,
                'url'=>url( $url.'?q='.($it->cattleId ?? '') ),
            ];

            $wa = [
                1=>$it->farmNo ?? '',
                2=>($it->cattleId ?? ''),
                3=>$it->farmName ?? '',
                4=>$it->ownerName ?? '',
            ];

            foreach ($wa as $k=>$ob){
                $src = '{{'.$k.'}}';
                $message = str_replace( $src, $ob, $message );
            }


        }elseif(is_array($it)){
            $doc = [
                '_id'=>$it['_id'],
                'notification_id'=>$this->id,
                'notification'=>$this->tmpl,
                'farmNo'=>$it['farmNo'] ?? '',
                'cattleId'=>($it['cattleId'] ?? ''),
                'farmName'=>$it['farmName'] ?? '',
                'ownerName'=>$it['ownerName'] ?? '',
                'req'=>$this->req,
                'url'=>url( $url.'?q='.($it['cattleId'] ?? '') ),
            ];

            $wa = [
                1=>$it['farmNo'] ?? '',
                2=>($it['cattleId'] ?? ''),
                3=>$it['farmName'] ?? '',
                4=>$it['ownerName'] ?? 'SapiMoo',
            ];

            foreach ($wa as $k=>$ob){
                $src = '{{'.$k.'}}';
                $message = str_replace( $src, $ob, $message );
            }

        }
        return [ 'cattle'=>$doc, 'tpl'=>$tpl, 'tpl_id'=>$tplId , 'from'=>env('SITE_TITLE'), 'msisdn'=>$msisdn ,'sendTo'=>$recipient ,'wa'=>$wa , 'msg'=>$message ];
    }

    public function toWhatsApp($notifiable){



    }
}
