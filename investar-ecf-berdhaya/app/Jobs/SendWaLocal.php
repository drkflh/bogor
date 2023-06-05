<?php

namespace App\Jobs;

use App\Models\Qontak\WaSendLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendWaLocal implements ShouldQueue
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
        $this->base_url = env('WA_API_URL', 'localhost:8000' );
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

    private function sendMessage($to_number,$to_name, $tpl_id = null){

        $sendurl = url( $this->base_url.'/v1/broadcasts/whatsapp/direct' );
        $response = Http::withToken($this->token)
            ->post( $sendurl,
                [
                    "receiver" => $to_number,
                    "message" => [
                        "body" => $this->body_params ,
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
