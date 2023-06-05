<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 22/04/20
 * Time: 12.34
 */

namespace App\Helpers;

use App\Models\Loyalty\EmailLog;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class EmailUtil
{

    protected $signature = 'sendmail:globalMail';

    public static function send($data)
    {
        try {
            self::setLog($data, 'unsent', '200');
            return response()->json(array(
                'action' => true,
                'message' => 'Message\'s still in the queue',
            ), 200);
        } catch(\Exception $e) {
            self::setLog($data, 'failed', $e->getMessage());
            return response()->json(array(
                'action' => false,
                'message' => $e->getMessage()
            ), 404);
        }
    }

    public static function setLog($data, $status, $response)
    {
        if(count($data['receiver'])>0) {
            foreach($data['receiver'] as $arr) {
                $log = new EmailLog();
                $log->status = $status;
                $log->response = $response;
                $log->title = $data['title'];
                $log->content = $data['content'];
                $log->subject = $data['subject'];
                $log->senderMail = $data['senderMail'];
                $log->senderName = $data['senderName'];
                $log->receiver = $arr;
                $log->template = $data['template'];
                $log->save();
            }
        }
    }
}
