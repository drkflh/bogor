<?php

namespace App\Jobs;

use App\Helpers\App\MmsUtil;
use App\Models\Mms\NotificationTemplate;
use App\Models\Mms\WaMessageLog;
use App\Models\Qontak\WaSendLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $templateId = '';
    protected $recipients = [];
    protected $subject = '';
    protected $entity = null;
    protected $body_params = [];
    protected $broadcastId = null;

    private $base_url = '';

    protected $token = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipients, $templateId, $body_params = [], $broadcastId = null)
    {
        $this->base_url = env('WA_API_URL');
        $this->recipients = $recipients;
        $this->templateId = $templateId;
        $this->body_params = $body_params;
        $this->broadcastId = $broadcastId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recs = $this->recipients;
        $tpl = $this->templateId;

        if( env('MMS_GW') == 'TWILIO_SMS' ){
            MmsUtil::sendSMSTwilio($recs, null, $this->templateId, $this->body_params, $this->broadcastId );
        }elseif( env('MMS_GW') == 'TWILIO_WA' ){
            MmsUtil::sendWhatsAppTwilio($recs, null, $this->templateId, $this->body_params, $this->broadcastId );
        }elseif( env('MMS_GW') == 'LOCAL_WA' ){
            MmsUtil::sendWhatsAppLocal($recs, null, $this->templateId, $this->body_params, $this->broadcastId );
        }else{
            foreach ($recs as $rec){

                $message = $this->compileMessage();

                $this->sendMessage( $rec, $message );
            }
        }

    }

    private function sendMessage($to_number,$message){

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
            $msgLog['tpl_id'] = $this->templateId;
            $msgLog['to_number'] = $to_number;
            $msgLog['status'] = $msg['success'] ? 'success':'failed' ;
            $msgLog['success'] = $msg['success'] ;
            $msgLog['message'] = $msg['message'] ?? '' ;
            $msgLog['data'] = $msg['data'] ?? '' ;
            $msgLog['raw'] = $msg;

            WaSendLog::create($msgLog);

            $msgLog = $msg['data'] ?? [];
            $msgLog['tpl_id'] = $this->templateId;
            $msgLog['to_number'] = $to_number;
            $msgLog['status'] = $msg['success'] ? 'success':'failed' ;
            $msgLog['success'] = $msg['success'] ? true:false ;
            $msgLog['message'] = $msg['message'] ?? '' ;
            $msgLog['data'] = $msg['data'] ?? '' ;
            $msgLog['raw'] = $msg;

            WaMessageLog::create($msgLog);


    }

    public function compileMessage()
    {
        $tpl = NotificationTemplate::where('slug', '=', $this->templateId)->first();

        if($tpl){
            $tpl = $tpl->toArray();
            $body = $tpl['body'];
            $dt = $this->body_params;

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

}
