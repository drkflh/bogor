<?php

namespace App\Console\Commands;

use App\Helpers\App\MmsUtil;
use App\Helpers\App\QontakUtil;
use App\Helpers\Util;
use App\Jobs\SendWaQontak;
use App\Models\Core\Mongo\User;
use App\Models\Mms\NotificationTemplate;
use App\Models\Qontak\Category;
use App\Models\Qontak\Channel;
use App\Models\Qontak\FileUpload;
use App\Models\Qontak\Lang;
use App\Models\Qontak\WaBroadcastStatusLog;
use App\Models\Qontak\WaSendLog;
use App\Models\Qontak\WaSendStatusLog;
use App\Models\Qontak\WaTemplate;
use App\Models\Qontak\WaTemplateResponse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class TestWaQontak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:wa  {--m=} {--wa=} {--to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Qontak connection tester';

    protected $token = '';

    protected $auth = '';

    protected $m = '';

    protected $wa = '';

    protected $to = '';

    private $base_url = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->base_url = env('QONTAK_API_URL');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->m = $this->option('m') ?? 'send';

        $this->to = $this->option('to') ?? false;

        $this->wa = $this->option('wa') ?? 'WA-001';

        if($this->m == 'sendwag'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'test';

            $body_params = [
                'name'=>'Joni Weismuller',
                'code'=> Str::random(6)
            ];

            $data = [];

            $data['messageId'] = Str::random();

            MmsUtil::sendWhatsAppLocal($recs, $data, $templateId, $body_params );

            //SendWhatsApp::dispatch($recs, $templateId, $body_params);

            return 0;


        }

        if($this->m == 'sendmsg'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'test';

            $body_params = [
                'name'=>'Joni Weismuller',
                'code'=> Str::random(6)
            ];

            $data = [];

            $data['messageId'] = Str::random();

            MmsUtil::sendWhatsApp($recs, $data, $templateId, $body_params );

            //SendWhatsApp::dispatch($recs, $templateId, $body_params);

            return 0;
        }

        if($this->m == 'sendfcm'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'test';

            $body_params = [
                'name'=>'Joni Weismuller',
                'otp'=> Str::random(6)
            ];

            $data = [];

            MmsUtil::sendWhatsApp($recs, $data, $templateId ,$body_params);

            return 0;
        }

        if($this->m == 'sendloc'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'test';

            $body_params = [
                'name'=>'Joni Weismuller',
                'code'=> Str::random(6)
            ];

            $data = [];

            MmsUtil::sendWhatsApp($recs, $data, $templateId ,$body_params);

            return 0;
        }

        if($this->m == 'sendtw'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'test';

            $body_params = [
                'name'=>'Joni Weismuller',
                'code'=> Str::random(6)
            ];

            $data = [];

            $sid    = env("TWILIO_AUTH_SID");
            $token  = env("TWILIO_AUTH_TOKEN");
            $wa_from= env("TWILIO_WHATSAPP_FROM");
            $twilio = new Client($sid, $token);

            $body = "Hello, welcome to temanQu.id";

            //$twilio->messages->create("whatsapp:$this->to",["from" => "whatsapp:$wa_from", "body" => $body]);

            $message = $twilio->messages
                ->create('whatsapp:+'.$this->to, // to
                    [
                        "from" => "whatsapp:$wa_from",
                        "body" => "Hello there!"
                    ]
                );

            print($message->sid);
            print_r($message->toArray());

            return 0;
        }

        if($this->m == 'sendsms'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'test';

            $body_params = [
                'name'=>'Joni Weismuller',
                'code'=> Str::random(6)
            ];

            $data = [];

            $sid    = env("TWILIO_AUTH_SID");
            $token  = env("TWILIO_AUTH_TOKEN");
            $sms_from= env("TWILIO_NUMBER");
            $twilio = new Client($sid, $token);

            $body = "Hello, welcome to temanQu.id";

            //$twilio->messages->create("whatsapp:$this->to",["from" => "whatsapp:$wa_from", "body" => $body]);

            $message = $twilio->messages
                ->create('+'.$this->to, // to
                    [
                        "from" => $sms_from,
                        "body" => "Twilio Test SMS Message!"
                    ]
                );

            print($message->sid);
            print_r($message->toArray());

            return 0;
        }

        if($this->m == 'sendlocd'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'OTP';

            $body_params = [
                'name'=>'Joni Weismuller',
                'code'=> Str::random(6)
            ];

            $data = [];

            print $templateId."\r\n";

            MmsUtil::sendWhatsAppDirect($recs, $data, $templateId ,$body_params);

            return 0;
        }

        if($this->m == 'sendsmtw'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'OTP';

            $body_params = [
                'name'=>'Joni Weismuller',
                'code'=> Str::random(6)
            ];

            $data = [];

            print $templateId."\r\n";

            MmsUtil::sendSMSTwilio($recs, $data, $templateId ,$body_params);

            return 0;
        }
        if($this->m == 'sendwatw'){

            $this->to = $this->to ?? '6281380909339';

            $recs = [$this->to];

            $templateId = $this->wa ?? 'OTP';

            $body_params = [
                'name'=>'Joni Weismuller',
                'code'=> Str::random(6)
            ];

            $data = [];

            print $templateId."\r\n";

            MmsUtil::sendWhatsAppTwilio($recs, $data, $templateId ,$body_params);

            return 0;
        }

        // test WA via Qontak

        $auth = QontakUtil::getToken();

        print_r($auth);

        $this->token = $auth->access_token;


        if($this->m == 'send'){
            $recs = [
                [
                    'to'=>$this->to,
                    'name'=>'WA Tester'
                ],
//                [
//                    'to'=>'62 811-1981-894',
//                    'name'=>'Pak Firdaus'
//                ],
//                [
//                    'to'=>'+62 816-1122-851',
//                    'name'=>'Pak Dito'
//                ],
//                [
//                    'to'=>'62 811-1725-771',
//                    'name'=>'Aditya Hartanto'
//                ]
            ];

            $tplobj = NotificationTemplate::where('slug', '=', $this->wa)->first();
            $tpl = $tplobj->qontakTplId;

            $entity = CattleProfile::first();
            $entity = $entity->toArray();

            print_r($tplobj->toArray());
            print_r($recs);
            print_r($entity);
            $tplobj = $tplobj->toArray();


            foreach ($recs as $rec){

                $body_params = [];
                if($entity){
                    $entity['recipientMSISDN'] = $rec['to'];
                    $entity['recipientName'] = $rec['name'];
                    $paramlist = $tplobj['paramList'] ?? false;
                    if($paramlist){
                        $body_params = $this->getBodyParams($entity, $paramlist);
                    }
                }

                print_r($body_params);

                //SendWaQontak::dispatch([$rec], $tpl, $body_params );
                $this->sendMessage( $rec['to'], $rec['name'], $tpl, $body_params );
            }

        }

        if($this->m == 'qsend'){

            $tpl = NotificationTemplate::where('slug', '=', $this->wa)->first();

            if($tpl){
                $users = User::where('notificationSubs.slug', '=', $this->wa )
                    ->where( 'mobile','=', '81380909339' )
                    ->get();
                $recs = [];
                foreach ($users as $u){
                    $mc = $u->mobileCountry ?? '+62';
                    $mn = $u->mobile ?? false;

                    if($mn){
                        $mn = preg_replace('/^0|[a-zA-Z]/i', '', $mn );
                        $mobile = '';
                        if(preg_match('/^\+62/i', $mn)){
                            $mobile = $mn;
                        }else{
                            $mobile = $mc.$mn;
                        }
                        $mobile = preg_replace('/^\+/i', '', $mobile );

                        if( preg_match('/[\d]|\+|\s/i', $mobile) ){
                            if( strlen($mobile) > 3 ){
                                $recs[] = [
                                    'to'=>$mobile,
                                    'name'=>$u->name
                                ];
                            }
                        }

                    }
                }

                $entity = Doc::first();
                $entity = $entity->toArray();

                print_r($tpl->toArray());
                print_r($recs);
                print_r($entity);
                $tpl = $tpl->toArray();

                $body_params = [];
                if($entity){
                    $paramlist = $tpl['paramList'] ?? false;
                    if($paramlist){
                        $body_params = $this->getBodyParams($entity, $paramlist);
                    }
                }

                print_r($body_params);

                if( $tpl['qontakTplId'] != ''){
                    SendWaQontak::dispatch($recs, $tpl['qontakTplId'], $body_params );
                }
            }

//            $recs = [
//                [
//                    'to'=>'+62 813 8090 9339',
//                    'name'=>'Andy Awidarto'
//                ],
//            ];
//            $tpl = "d419a2d3-0eaf-4330-9d3b-800aeca296ac";
//
//            SendWaQontak::dispatch($recs, $tpl);

        }

        // list template
        if($this->m == 'lsend'){

            $response = Http::withToken($this->token)
                ->get( $this->base_url.'/v1/broadcasts/whatsapp');

            $tpl = json_decode($response->body(), true);

            print_r($tpl);

            $msgids = [];
            foreach ($tpl['data'] as $tpx){
                try {
                    $tpx['mid'] = $tpx['id'];
                    $msgids[] = $tpx['id'];
                    WaSendStatusLog::create($tpx);
                }catch (\Exception $exception){
                    print $exception->getMessage();
                }
            }

            foreach ($msgids as $mid){
                $this->getMsgLog($mid);
            }

        }

        // add template
        if($this->m == 'atpl'){
            $response = Http::withToken($this->token)
                ->post( $this->base_url.'/v1/templates/whatsapp',
                    [
                        "name" => "wa009rev".strtolower(Util::randomstring(4, 'alphanumeric')),
                        "category" => "ALERT_UPDATE",
                        "attributes" => [
                            [
                                "components" => [
                                    [
                                        "type" => "BODY",
                                        "text" => "Hubungi tenaga kesehatan ternak untuk observasi atau hubungi call center sapimoo di {{1}}untuk konsultasi.Lakukan pengecek birahi secara teratur setiap hari, klik link www.sapimoo.com\/gagalbunting untuk keterangan lebih lanjut"
                                    ]
                                ],
                                "language" => "id"
                            ]
                        ]
                    ]
                );

            $tpl = json_decode($response->body(), true);

            print_r($tpl);

            WaTemplateResponse::create($tpl);

        }

        // delete template
        if($this->m == 'dtpl'){

        }

        // list template
        if($this->m == 'ltpl'){

            $response = Http::withToken($this->token)
                ->get( $this->base_url.'/v1/templates/whatsapp');

            $tpl = json_decode($response->body(), true);

            print_r($tpl);

            foreach ($tpl['data'] as $tpx){
                try {
                    $tpx['template_id'] = $tpx['id'];
                    WaTemplate::create($tpx);
                }catch (\Exception $exception){
                    print $exception->getMessage();
                }
            }
        }

        // list channel
        if($this->m == 'channel'){

            $response = Http::withToken($this->token)
                ->get( $this->base_url.'/v1/integrations');

            $langs = json_decode($response->body(), true);

            foreach ($langs['data'] as $lang){
                $c = new Channel();
                foreach ($lang as $k=>$v){
                    if( $k == 'id'){
                        $c->channel_id = $v;
                    }
                    $c->{$k} = $v;
                }
                try {
                    $c->save();
                }catch (\Exception $exception){
                    print $exception->getMessage();
                }
            }

        }

        // list language
        if($this->m == 'lang'){

            $response = Http::withToken($this->token)
                ->get( $this->base_url.'/v1/templates/language');

            $langs = json_decode($response->body(), true);

            foreach ($langs['data'] as $lang){
                $c = new Lang();
                foreach ($lang as $k=>$v){
                    $c->{$k} = $v;
                }
                try {
                    $c->save();
                }catch (\Exception $exception){
                    print $exception->getMessage();
                }
            }

        }

        // list category
        if($this->m == 'cat'){

            $response = Http::withToken($this->token)
                ->get( $this->base_url.'/v1/templates/category');

            $cats = json_decode($response->body(), true);

            foreach ($cats['data'] as $cat){
                $c = new Category();
                foreach ($cat as $k=>$v){
                    $c->{$k} = $v;
                }
                try {
                    $c->save();
                }catch (\Exception $exception){
                    print $exception->getMessage();
                }
            }

        }

        // upload file
        if($this->m == 'upload'){

            $response = Http::withToken($this->token)
            ->attach('file',
                file_get_contents(storage_path('test.png')),
                'test'.Str::random(3).'.png')
            ->post($this->base_url.'/v1/file_uploader');

            $uploaded = json_decode($response->body(), true);

            $fud = $uploaded['data'];

            print_r($fud);

            $fu = new FileUpload();

            $fu->filename = $fud['filename'];
            $fu->url = $fud['url'];

            $fu->save();

        }

        return 0;
    }

    private function getBodyParams($entity, $paramlist){
        $body_params = [];
        foreach ($paramlist as $p){
            $paramVal = $entity[ $p['paramField'] ] ?? $p['paramText'];
            $body_params[] = [
                "key" => $p['paramKey'],
                "value_text" => $paramVal,
                "value" => strtolower($p['paramField'])
            ];
        }
        return $body_params;
    }

    private function getMsgLog($id){
        $response = Http::withToken($this->token)
            ->get( $this->base_url.'/v1/broadcasts/'.$id.'/whatsapp/log');

        $tpl = json_decode($response->body(), true);

        print_r($tpl);

        foreach ($tpl['data'] as $tpx){
            try {
                $tpx['mid'] = $tpx['id'];
                WaBroadcastStatusLog::create($tpx);
            }catch (\Exception $exception){
                print $exception->getMessage();
            }
        }
    }

    private function sendMessage($to_number,$to_name, $tpl_id, $body_params){
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
                        "body" => $body_params,
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

        print_r($msg);

        $msgLog = $msg['data'] ?? 'no data';
        $msgLog['status'] = $msg['status'];

        WaSendLog::create($msgLog);

    }
}
