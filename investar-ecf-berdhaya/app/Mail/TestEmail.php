<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Mms\NotificationTemplate;

class GenericEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $template = 'default-email-template';
    private $data = null;
    private $subjectEmail = null;
    private $toEmail = null;
    private $toName = null;
    private $ccArray = [];
    private $bccArray = [];
    private $attachmentBin = null;
    private $attachmentId = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template = null, $data = null, $subject = '' ,$to = null, $toName = null, $cc = [], $bcc = [], $attachment = null, $attachmentId = '')
    {
        // $this->template = 'email.'.$template ?? 'email.generic' ;
        $this->template = $template ?? 'OTP';
        $this->data = $data;
        $this->subjectEmail = $subject ?? 'No Subject';
        $this->toEmail = $to ?? env('MAIL_TEST_RECIPIENT', '');
        $this->toName = $toName ?? env('MAIL_TEST_RECIPIENT_NAME', '');
        $this->ccArray = $cc;
        $this->bccArray = $bcc;
        $this->attachmentBin = $attachment;
        $this->attachmentId = $attachmentId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this
        //     ->to($this->toEmail,$this->toName)
        //     ->subject($this->subjectEmail)
        //     ->from( env('MAIL_FROM_ADDRESS'))
        //     ->attachData(base64_decode($this->attachmentBin), $this->attachmentId, [
        //         'mime' => 'application/pdf',
        //     ])
        //     ->cc($this->ccArray)
        //     ->bcc($this->bccArray)
        //     ->with('toEmail',$this->toEmail)
        //     ->with('toName',$this->toName)
        //     ->with($this->data)
        //     ->view($this->template);

        // $tpl = NotificationTemplate::where('slug', '=', $this->template)->first();
        // $tpl = $tpl->toArray();

        // if($tpl){
        //     $body = $tpl['body'];
            // $dt = $this->body_params;

            // $params = $tpl['paramList'];
            // foreach( $params as $p ){
            //     $k = $p['paramKey'];
            //     $r = $dt[ $p['paramField'] ] ?? '';
            //     $body = str_replace( '{{'.$k.'}}', $r, $body );
            // }
        //     return $body;
        // }else{
            return 'Hello this is a test message';
        // }

    }
}
