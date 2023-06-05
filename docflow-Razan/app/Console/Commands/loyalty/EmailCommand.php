<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 22/04/20
 * Time: 12.34
 */

namespace App\Console\Commands\loyalty;

use App\Models\Loyalty\EmailLog;
use App\Helpers\EmailUtils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Helpers\App\LoyaltyUtil;

class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:globalMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear unsent email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $list = EmailLog::where('status', 'unsent')->get();
        foreach($list as $arr) {
            try {
                $attach = isset($arr['attachment']) ? $arr['attachment'] : [];
                Mail::send($arr['template'], ['title' => $arr['title'], 'content' => $arr['content'] ], function ($message) use ($arr, $attach)
                {
                    $message->subject($arr['subject']);
                    $message->from($arr['senderMail'], $arr['senderMail']);
                    $message->to($arr['receiver']);
                    if( count($attach)>0 ) {
                        foreach($attach as $val) {
                            $message->attach($val);
                        }
                    }
                });
                $log = EmailLog::find($arr['_id']);
                $log->status =  'sent';
                $log->response =  '201';
                $log->save();
            } catch(\Exception $e) {
                $log = EmailLog::find($arr['_id']);
                $log->status = 'failed';
                $log->response =  $e->getMessage();
                $log->save();
            }
        }
    }
}
