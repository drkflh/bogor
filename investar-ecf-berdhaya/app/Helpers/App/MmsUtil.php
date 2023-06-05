<?php

namespace App\Helpers\App;

use App\Jobs\SendWhatsApp;
use App\Models\Mms\NotificationTemplate;
use App\Models\Mms\WaMessageLog;
use App\Models\Obj\EmailTemplate;
use App\Models\Qontak\WaSendLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class MmsUtil
{
    protected $templateId = '';

    public static function sendNotification($users, $notificationType, $data, $req)
    {
        foreach($users as $user){
            $user->notify( new $notificationType($data, $req));
        }
    }

    public static function getNotificationTemplates()
    {
        $notifTempl = NotificationTemplate::orderBy('slug', 'asc')->get(
            [
                '_id',
                'title',
                'slug',
                'body',
                'paramList',
                'url',
                'attachment',
                'sound',
                'messageType',
                'description'
            ]
        );

        return $notifTempl->toArray();
    }

    public static function sendEmail($rec, $subject, $data, $template, $attachmentBin = null)
    {

        $toEmail = $rec['to'];
        $toName = $rec['name'] ?? 'Receiver';
        $cc = $rec['cc'] ?? [];
        $bcc = $rec['bcc'] ?? [];

        $attachmentId = null;

        if(env('MAIL_DEBUG', true)){
            $toEmail = env('MAIL_TEST_RECIPIENT');
            $toName = env('MAIL_TEST_RECIPIENT_NAME');
            $cc = [];
            $bcc = [];
        }

        if(is_null($attachmentBin)){

        }else{
            $attachmentId = ($data['_id'] ?? 'doc' ).'.pdf' ?? 'no-id.pdf';
            $attachmentBin = base64_encode($attachmentBin);
        }

        $data['messageId'] = Str::random();

        Mail::to($toEmail)
            ->queue(new \App\Mail\GenericEmail( $template, $data, $subject ,$toEmail, $toName, $cc, $bcc, $attachmentBin, $attachmentId ));

    }

    public static function sendWhatsApp( $recipients, $data, $template , $body_params , $broadcastId = null ,$gateway = null, $attachmentBin = null)
    {
//        $data['messageId'] = $data['messageId'] ?? Str::random();

        SendWhatsApp::dispatch($recipients, $template, $body_params, $broadcastId);
    }

    public static function sendWhatsAppDirect( $recipients, $data, $template , $body_params , $gateway = null, $attachmentBin = null)
    {
        $data['messageId'] = Str::random();

        foreach ($recipients as $rec){

            $message = self::compileMessage($template , $body_params);

            self::postDirectWAMessage( $rec, $message , $template );
        }

    }

    //Direct local WA sending
    private static function postDirectWAMessage($to_number,$message, $templateId){

        $sessionName = env('WA_API_SESSION_ID');

        $url = env('WA_API_URL').'/chats/send?'.$sessionName;

        $msgBody = [
            'receiver'=>$to_number,
            'message'=>[
                'text'=>$message
            ]
        ];

        $res = Http::withBasicAuth( env('WA_API_USER'), env('WA_API_PASS') )
            ->post( env('WA_API_URL').'/chats/send?id='.$sessionName , $msgBody );

        $msg = $res->object();

        $msg = json_decode(json_encode($msg), true);

        $msgLog = $msg['data'] ?? [];
        $msgLog['service'] = 'Local WA';
        $msgLog['tpl_id'] = $templateId;
        $msgLog['to_number'] = $to_number;
        $msgLog['status'] = $msg['success'] ? 'success':'failed' ;
        $msgLog['success'] = $msg['success'] ? true:false ;
        $msgLog['message'] = $msg['message'] ?? '' ;
        $msgLog['data'] = $msg['data'] ?? '' ;
        $msgLog['raw'] = $msg;

        WaMessageLog::create($msgLog);

    }

    public static function sendWhatsAppLocal( $recipients, $data, $template , $body_params , $broadcastId = null ,$gateway = null, $attachmentBin = null)
    {
        $data['messageId'] = Str::random();

        foreach ($recipients as $rec){

            $message = self::compileMessage($template , $body_params);

            self::postLocalWAMessage( $rec, $message , $template, $broadcastId );
        }

    }

    //Direct local WA sending
    private static function postLocalWAMessage($to_number,$message, $templateId, $broadcastId){
        //====================
        //$sessionName = env('WA_API_SESSION_ID');

        $url = env('WA_API_URL').'/message/text?key='.env('WA_API_SESSION_ID');

        $msgBody = [
            'id'=>$to_number.'@s.whatsapp.net',
            'message'=>$message
        ];

        $res = Http::withToken( env('WA_API_TOKEN') )
            ->post( $url , $msgBody );

        $msg = $res->object();

        $msg = json_decode(json_encode($msg), true);

        //print_r($msg);

        $msgLog = $msg['data'] ?? [];
        $msgLog['service'] = 'Local WA';
        $msgLog['tpl_id'] = $templateId;
        $msgLog['to_number'] = $to_number;
        $msgLog['broadcastId'] = $broadcastId;
        $msgLog['status'] = $msg['error'] ? 'FAILED':'SENT' ;
        $msgLog['success'] = !$msg['error'] ;
        $msgLog['message'] = $msg['message'] ?? '' ;
        $msgLog['data'] = $msg['data'] ?? '' ;
        $msgLog['ts'] = isset($msg['data']['messageTimestamp']) && !is_null($msg['data']['messageTimestamp']) ? date( 'Y-m-d H:i:s' , $msg['data']['messageTimestamp'] ) : '' ;
        $msgLog['raw'] = $msg;

        WaMessageLog::create($msgLog);

    }

    public static function sendWhatsAppTwilio( $recipients, $data, $template , $body_params , $broadcastId = null ,$gateway = null, $attachmentBin = null)
    {
        $data['messageId'] = Str::random();

        foreach ($recipients as $rec){

            $message = self::compileMessage($template , $body_params);

            self::postTwilioWAMessage( $rec, $message , $template, $broadcastId );
        }

    }
    //Direct local WA sending
    private static function postTwilioWAMessage($to_number,$message, $templateId, $broadcastId = null){

        $sid    = env("TWILIO_AUTH_SID");
        $token  = env("TWILIO_AUTH_TOKEN");
        $wa_from = env("TWILIO_WHATSAPP_FROM");
        $twilio = new Client($sid, $token);

        $body = "Hello, welcome to temanQu.id";

        print $to_number;

        $to_number = self::normalizeMSISDN($to_number);

        //$twilio->messages->create("whatsapp:$this->to",["from" => "whatsapp:$wa_from", "body" => $body]);

        $message = $twilio->messages
            ->create('whatsapp:+'.$to_number, // to
                [
                    "from" => "whatsapp:$wa_from",
                    "body" => $message
                ]
            );

        $msg = $message->toArray();

        $msgLog = $msg['data'] ?? [];
        $msgLog['service'] = 'Twilio WA';
        $msgLog['tpl_id'] = $templateId;
        $msgLog['to_number'] = $to_number;
        $msgLog['broadcastId'] = $broadcastId ;
        $msgLog['status'] = $msg['status'] ;
        $msgLog['success'] = $msg['status'] ? true:false ;
        $msgLog['message'] = $msg['message'] ?? '' ;
        $msgLog['data'] = $msg['data'] ?? '' ;
        $msgLog['raw'] = $msg;

        WaMessageLog::create($msgLog);

    }

    public static function sendSMSTwilio( $recipients, $data, $template , $body_params , $broadcastId = null ,$gateway = null, $attachmentBin = null)
    {
        $data['messageId'] = Str::random();

        foreach ($recipients as $rec){

            $message = self::compileMessage($template , $body_params);

            self::postTwilioSMSMessage( $rec, $message , $template, $broadcastId );
        }

    }
    //Direct local WA sending
    private static function postTwilioSMSMessage($to_number,$message, $templateId, $broadcastId = null){

        $sid    = env("TWILIO_AUTH_SID");
        $token  = env("TWILIO_AUTH_TOKEN");
        $sms_from= env("TWILIO_NUMBER");
        $twilio = new Client($sid, $token);

        $body = "Hello, welcome to temanQu.id";

        $to_number = self::normalizeMSISDN($to_number);

        //$twilio->messages->create("whatsapp:$this->to",["from" => "whatsapp:$wa_from", "body" => $body]);

        $message = $twilio->messages
            ->create('+'.$to_number, // to
                [
                    "from" => $sms_from,
                    "body" => $message
                ]
            );

        $msg = $message->toArray();

        $msgLog = $msg['data'] ?? [];
        $msgLog['service'] = 'Twilio SMS';
        $msgLog['tpl_id'] = $templateId;
        $msgLog['to_number'] = $to_number;
        $msgLog['broadcastId'] = $broadcastId ;
        $msgLog['status'] = $msg['status'] ;
        $msgLog['success'] = $msg['status'] ? true:false ;
        $msgLog['message'] = $msg['message'] ?? '' ;
        $msgLog['data'] = $msg['data'] ?? '' ;
        $msgLog['raw'] = $msg;

        WaMessageLog::create($msgLog);

    }

    public static function compileMessage($templateId, $body_params)
    {
        $tpl = NotificationTemplate::where('slug', '=', $templateId)->first();

        if($tpl){
            $tpl = $tpl->toArray();
            $body = $tpl['body'];
            $dt = $body_params;

            $params = $tpl['paramList'];
            foreach( $params as $p ){
                $k = $p['paramKey'];
                $r = $dt[ $p['paramField'] ] ?? '';
                $body = str_replace( '{{'.$k.'}}', $r, $body );
            }
            return $body;
        }else{
            return 'Hello this is a test message';
        }
    }

    public function normalizeMSISDN($num){
        $num = str_replace([' ', '-', '+'], '', $num);
        $num = preg_replace('/^0/i', '62', $num);
        $num = preg_match('/^8/i', $num) ? '62'.$num : $num;
        return $num;

    }

}
