<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class TestRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run {--from=} {--days=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run SapiMoo cycle test';

    protected $dateStart;

    protected $days = 100;

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
        $this->days = $this->option('days') ?? 100;

        $this->dateStart = $this->option('from') ?? Carbon::now( env('DEFAULT_TIME_ZONE') );

        $this->dateStart = Carbon::make( $this->dateStart )->startOfDay();

        print "Start from ".$this->dateStart->toDateString()." run for ".$this->days." days\r\n";

        for( $i=0; $i <= $this->days; $i++ ){
            $thisDate = Carbon::make($this->dateStart)->addDays($i);
            print "Day ".$i." : ". $thisDate->toDateString()."\r\n";

            $this->call('cattle:state',[
                '--date'=>$thisDate->toDateString(),
                '--test'=>true
            ]);
        }

        return 0;
    }
}
