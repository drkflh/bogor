<?php

namespace App\Console\Commands;

use App\Helpers\App\MmsUtil;
use App\Jobs\SendWhatsApp;
use App\Models\Mms\MessageQueue;
use Illuminate\Console\Command;

class executeBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:execute {--bid=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute message broadcasting from queue';

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
     * @return int
     */
    public function handle()
    {
        $bid = $this->option('bid');

        $queue = MessageQueue::where('broadcastId','=',$bid)->get();

        foreach($queue as $q){

            if($q->gatewayType == 'EMAIL'){
                $subject = $q->subject ?? 'No Subject';
                $rec = [
                        'to'=>$q->to,
                        'name'=>$q->recName,
                        'cc'=>[],
                        'bcc'=>[]
                    ];
                MmsUtil::sendEmail( $rec, $subject, $q->data, $q->templateId );
            }
            if($q->gatewayType == 'WHATSAPP'){
                MmsUtil::sendWhatsApp([$q->to], $q->data, $q->templateId, $q->data, $bid);
            }

            $q->sendCount = intval($q->sendCount) + 1;
            $q->save();
        }

        return 0;
    }
}
