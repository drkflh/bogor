<?php

namespace App\Helpers\App;

use App\Helpers\Util;
use App\Models\Qontak\WaSendLog;
use App\Models\Qontak\WaTemplate;
use App\Models\Qontak\WaTemplateResponse;
use Illuminate\Support\Facades\Http;

class QontakUtil
{
    protected $token = '';

    protected $auth = '';

    private $base_url = '';

    public function __construct()
    {
        $this->base_url = env('QONTAK_API_URL');
        $auth = $this->getToken();
        $this->token = $auth->access_token;
    }


    public static function doAuth()
    {
        $authUrl = env('QONTAK_AUTH_URL');
        $response = Http::post( $authUrl , [
            "username" => env('QONTAK_USER'),
            "password" => env('QONTAK_PASS'),
            "grant_type" => env('QONTAK_GRANT_TYPE'),
            "client_id" => env('QONTAK_CLIENT_ID'),
            "client_secret" => env('QONTAK_CLIENT_SECRET')
        ]);
        return $response;
    }

    public function getToken()
    {
        if(!file_exists( storage_path('qkey.json') )){
            touch( storage_path('qkey.json'));
        }

        $token_json = file_get_contents( storage_path('qkey.json') );

        if( trim($token_json) == ''){
            $response = $this->doAuth();
            file_put_contents( storage_path('qkey.json'), $response->body() );
            $token_json = $response->body();
        }
        return json_decode($token_json);
    }

    public function postTemplate($name, $body ,$category = 'ALERT_UPDATE', $language = 'id'){

        $response = Http::withToken($this->token)
            ->post( $this->base_url.'/v1/templates/whatsapp',
                [
                    "name" => strtolower( $name.Util::randomstring(4, 'alphanumeric')),
                    "category" => $category,
                    "attributes" => [
                        [
                            "components" => [
                                [
                                    "type" => "BODY",
                                    "text" => $body
                                ]
                            ],
                            "language" => $language
                        ]
                    ]
                ]
            );

        $tpl = json_decode($response->body(), true);

        WaTemplateResponse::create($tpl);

        return $tpl;

    }

    public function getWARec($rec){
        $mc = $rec->mobileCountry ?? '+62';
        $mn = $rec->mobile ?? false;

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
                    return [
                        'to'=>$mobile,
                        'name'=>$rec->name
                    ];
                }
            }
        }

        return false;
    }


    public function listTemplate()
    {
        $response = Http::withToken($this->token)
            ->get( $this->base_url.'/v1/templates/whatsapp');

        $tpl = json_decode($response->body(), true);

        $res = [];
        foreach ($tpl['data'] as $tpx){
            try {
                $tpx['template_id'] = $tpx['id'];
                WaTemplate::create($tpx);
                $res[] = $tpx;
            }catch (\Exception $exception){

            }
        }

        return $res;
    }

    public function sendWAMessage($to_number,$to_name, $tpl_id, $body_params){
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

        $msgLog = $msg['data'];
        $msgLog['status'] = $msg['status'];

        WaSendLog::create($msgLog);

    }

    public function getBodyParams($entity, $paramlist){
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
}
