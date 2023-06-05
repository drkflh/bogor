<?php

namespace App\Console\Commands;

use App\Helpers\App\LoyaltyUtil;
use App\Helpers\Util;
use App\Models\Voucher\Data\VoucherRepo;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveVoucherCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:voucher {--program=} {--class=} {--qty=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove voucher for particular voucher program ID';

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

        $qty = $this->option('qty');
        $programClass = $this->option('class');
        $programId = $this->option('program');

        $qty = $qty ?? 0;

        $qty = intval($qty);

        //print $qty."\r\n";

        if(!$programId){
            //print "Program ID not specified\r\n";
            return 1;
        }

        if(!$programClass){
            //print "Program Class unspecified, using default \r\n";
            $programClass = config( 'app.loyalty.programClass.internal' );
        }

        //print $programClass."\r\n";

        //$program = LoyaltyUtil::voucherProgram($programId, $programClass);

        //print_r($program);

        $programQty = LoyaltyUtil::getVoucherQty($programId);

        $repoQty = LoyaltyUtil::getRepoQty($programId);



        if( $programQty < $repoQty ){

            $rm = VoucherRepo::where('programId','=',$programId)
                ->where('programClass','=',$programClass)
                ->where('voucherStatus', '=', 'RELEASED')
                ->limit($qty)->select('_id')->get();
            $ids = [];

            foreach($rm->toArray() as  $r){
                $ids[] = $r['_id'];
            }

            debug($ids);

            $dels = VoucherRepo::destroy($ids);

            debug($dels);

            debug('in repo '.$repoQty.' actual remove '.count($rm->toArray()).' from instructed '.$qty."\r\n" );

//            $rm = VoucherRepo::where('programId','=',$programId)
//                ->where('programClass','=',$programClass)
//                ->where('voucherStatus', '=', 'RELEASED')
//                ->limit($qty)->delete();

            debug($rm);

        }else{
            debug('in repo '.$repoQty.' program '.$programQty."\r\n");
        }


        return 0;
    }
}
