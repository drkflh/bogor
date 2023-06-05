<?php

namespace App\Console\Commands;

use App\Helpers\TimeUtil;
use App\Models\Workflow\Time\SpentTime;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;

class TimeGuard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time:guard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watchdog agent to guard timer and attendance overflow';

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

        $att_age = Carbon::now()->subMinutes( intval( env('ATTENDANCE_MAX', 8)) );


        $att = SpentTime::where('isActive','=',true)
            ->where('event','like','CLOCK%')
//            ->whereRaw( [ 'clockInTime'=> [ '$lte'=> $att_age ] ] )
            ->where('clockInTime','>', $att_age)
            ->get();

        echo "active personnel\r\n";
        echo "older than ".$att_age->toDateTimeString()."\r\n";
        if($att){
            foreach($att as $p){
                echo ($p->userName ?? 'no name')." ".($p->clockInTime ?? '')." ".Carbon::now()->toDateTimeString()."\r\n";
                echo Carbon::make($p->clockInTime)->diffInMinutes( Carbon::now() )."\r\n";
                $diff = Carbon::make($p->clockInTime)->diffInMinutes( Carbon::now() );
                if( $diff > ( intval( env('ATTENDANCE_MAX', 8) ) * 60 ) ){
                    echo $p->userName." exceeds max timer hours\r\n";
                    if(env('PREVENT_EXCESS_TIME', true)){
                        $p->isActive = false;
                        $p = TimeUtil::spreadTime($data, 'clockOutTime', env('DEFAULT_TIME_ZONE'));
                        $p->save();
                    }
                }
            }
        }

        $tmr_age = Carbon::now()->subMinutes( intval( env('TIMER_MAX', 4)) );


        $tmr = SpentTime::
            where('isActive','=',true)
            ->where('event','like','TIMER%')
            //->where('timerStart','>=', $tmr_age)
            ->get();

        echo "+++++++++++++++++++++++++++++++++\r\n";
        echo "active timer\r\n";
        echo "older than ".$tmr_age->toDateTimeString()."\r\n";

        if($tmr){
            foreach($tmr as $p){
                echo ($p->userName ?? 'no name')." ".($p->timerStart ?? '')." ".Carbon::now()->toDateTimeString()."\r\n";
                echo Carbon::make($p->timerStart)->diffInMinutes( Carbon::now() )."\r\n";
                $diff = Carbon::make($p->timerStart)->diffInMinutes( Carbon::now() );
                if( $diff > ( intval( env('TIMER_MAX', 4) ) * 60 ) ){
                    echo $p->userName." exceeds max timer hours\r\n";
                    if(env('PREVENT_EXCESS_TIME', true)){
                        $p->isActive = false;
                        $p = TimeUtil::spreadTime($data, 'timerStop', env('DEFAULT_TIME_ZONE'));
                        $p->save();
                    }
                }
            }
        }

        return Command::SUCCESS;
    }
}
