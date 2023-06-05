<?php
namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\Fcm;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group FCM Messaging
 *
 * APIs for managing FCM based cloud messaging
 */
class FcmController extends Controller {
    public $controller_name = '';

    public function  __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );

    }

    /**
     * Register FCM token to the platform
     *
     * FCM service token will be granted upon device signin and eventually changed periodically.
     * 1. The app must implement local storage to store this token in the device
     * 2. This token is device specific, therefore must me connected to logged in user account by sending it to the server upon user login process
     * 3. Everytime the token is changed by FCM service , the device must report the changes to the server
     *
     * @param Request $request
     * @queryParam token string required FCM token assigned to the device, usually set by FCM service upon device hook up
     * @queryParam prevToken string previously stored FCM token,to identify which token must be updated at the server
     */
    public function postRegister(Request $request)
    {
        $token = $request->input('token');
        $prevToken = $request->input('prevToken');

        if($prevToken == 'new'){
            $fcm = new Fcm();

            $fcm->token = $token;
            $fcm->prevToken = $prevToken;
            $fcm->save();
        }else{

            $efcm = Fcm::where('token','=', $prevToken)->first();

            if($efcm ){
                $efcm->token = $token;
                $efcm->prevToken = $prevToken;
                $efcm->save();

            }else{
                $fcm = new Fcm();
                $fcm->token = $token;
                $fcm->prevToken = $prevToken;
                $fcm->save();
            }

        }

        return response()->json(
            [
                'result'=>'OK',
                'message'=>'Token registered od updated',
                'data'=>[
                    'token'=>$token
                ]
            ],
            200
        );

    }

}
