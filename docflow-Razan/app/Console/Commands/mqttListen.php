<?php

namespace App\Console\Commands;

use App\Models\Mms\MqttMessageLog;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class mqttListen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $mqtt = MQTT::connection();
        $mqtt->subscribe('#', function (string $topic, string $message) {
            echo sprintf('Received QoS level 1 message on topic [%s]: %s'."\r\n", $topic, $message);

            $mq = new MqttMessageLog();
            $mq->topic = $topic;
            $mq->message = $message;
            try {
                $mq->msgobject = json_decode($message, true);
            } catch (\Exception $e) {
                $mq->msgobject = [];
                echo $e->getMessage();
            }

            $mq->save();

        }, 2);
        $mqtt->loop(true);
        return Command::SUCCESS;
    }
}
