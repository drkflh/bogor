<?php

namespace App\Console\Commands;

use App\Helpers\App\LoyaltyUtil;
use App\Models\Loyalty\Deploy\DeployQueue;
use Illuminate\Console\Command;

class deployDMN extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dmn:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy Dmn to Camunda';

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
        $queue = DeployQueue::where("status","=","PENDING")->get();

        foreach ($queue as $q){
            LoyaltyUtil::triggerDmn($q->endpoint,$q->host,$q->port,$q->_id);
        }
        return 0;
    }
}
