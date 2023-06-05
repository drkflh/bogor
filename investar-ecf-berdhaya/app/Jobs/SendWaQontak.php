<?php

namespace App\Jobs;

use App\Helpers\App\QontakUtil;
use App\Models\Qontak\WaSendLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendWaQontak implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $templateId = '';
    protected $recipients = [];
    protected $subject = '';
    protected $entity = null;
    protected $body_params = [];

    private $base_url = '';

    protected $token = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipients, $templateId, $body_params = [])
    {
        //
        $auth = QontakUtil::getToken();

        $this->token = $auth->access_token ?? null;

        if(is_null($this->token)){

        }

        $this->base_url = env('QONTAK_API_URL');
        $this->recipients = $recipients;
        $this->templateId = $templateId;
        $this->body_params = $body_params;
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
        foreach ($recs as $rec){
            $this->sendMessage( $rec['to'], $rec['name'], $tpl );
        }
    }

    private function sendMessage($to_number,$to_name, $tpl_id){

        $response = Http::withToken($this->token)
            ->post( $this->base_url.'/v1/broadcasts/whatsapp/direct',
                [
                    "to_name" => $to_name,
                    "to_number" => $to_number,
                    "message_template_id" => $tpl_id,
                    "channel_integration_id" => "92f647bf-3ca3-42c0-a48c-6a394e88d0d6",
                    "language" => [
                        "code" => "id"
                    ],
                    "parameters" => [
//                            "header" => [
//                                "format" => "IMAGE",
//                                "params" => [
//                                    [
//                                        "key" => "url",
//                                        "value" => "https://qontak-hub-development.s3.amazonaws.com/uploads/direct/images/9663898d-800e-4711-a4f5-a417f5c64cd4/testHoH.png"
//                                    ],
//                                    [
//                                        "key" => "filename",
//                                        "value" => "testHoH.png"
//                                    ]
//                                ]
//                            ],
                        "body" => $this->body_params ,
//                            "buttons" => [
//                                [
//                                    "index" => "0",
//                                    "type" => "url",
//                                    "value" => "paymentUniqNumber"
//                                ]
//                            ]
                    ]
                ]
            );

        $msg = json_decode($response->body(), true);

        //print_r($msg);

        $msgLog = $msg['data'] ?? [];
        $msgLog['tpl_id'] = $tpl_id;
        $msgLog['to_name'] = $to_name;
        $msgLog['to_number'] = $to_number;
        $msgLog['status'] = $msg['status'];
        $msgLog['raw'] = $msg;


        WaSendLog::create($msgLog);

    }

}
