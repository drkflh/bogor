<?php

namespace App\Console\Commands;

use App\Helpers\App\LoyaltyUtil;
use App\Helpers\Util;
use App\Models\Voucher\Data\VoucherRepo;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateVoucherCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:voucher {--program=} {--class=} {--qty=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate voucher for particular voucher program ID';

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


        if(!$programId){
            //print "Program ID not specified\r\n";
            return 1;
        }

        if(!$programClass){
            //print "Program Class unspecified, using default \r\n";
            $programClass = config( 'app.loyalty.programClass.internal' );
        }

        //print $programClass."\r\n";

        $program = LoyaltyUtil::voucherProgram($programId, $programClass);

        //print_r($program);

        if($program){
            $programCategory = $program['programCategory'] ?? '';
            $pointValue = $program['pointValue'] ?? 1;
            $voucherUnitValue = $program['voucherUnitValue'] ?? 0;
        }else{
            $programCategory = $program['programCategory'] ?? '';
            $pointValue = 1;
            $voucherUnitValue = 0;
        }

        $programQty = LoyaltyUtil::getVoucherQty($programId);

        $repoQty = LoyaltyUtil::getRepoQty($programId);

        //print "max qty ". $programQty. "\r\n";

        //print "in repo qty ". $repoQty. "\r\n";


        if( $programQty > 0 && ( $programQty > $repoQty  ) ){

            $gc = $programQty - $repoQty;

            //print "generating ". $gc. " codes\r\n";

            $now =  Carbon::now(env('DEFAULT_TIME_ZONE'));

            $until = Carbon::now(env('DEFAULT_TIME_ZONE'))->endOfYear();

            if(env('DEFAULT_TIME_ZONE') != 'UTC'){
                $now = $now->shiftTimezone('UTC');
                $until = $until->shiftTimezone('UTC');
            }

            ////print $now->toDateTimeString()."\r\n";

            $now = new \MongoDB\BSON\UTCDateTime( $now->timestamp * 1000 );
            $until = new \MongoDB\BSON\UTCDateTime( $until->timestamp * 1000 );

            for( $i = 0; $i < $gc; $i++ ){

                $model = new VoucherRepo();

                $model->voucherCode = strtoupper( Util::randomstring(10, 'alphanumeric') );
                $model->programId = $programId;
                $model->programClass = $programClass;
                $model->releaseDateTime = $now;
                $model->validUntil = $until;
                $model->voucherStatus = 'RELEASED';
                $model->voucherValueType = 'NOMINAL';
                $model->pointValue = $pointValue;
                $model->programCategory = $programCategory;
                $model->voucherUnitValue = $voucherUnitValue;
                $model->_class = 'com.cronostar.loyalty.domain.VoucherCodeRepo';

                $model->createdDate = $now;
                $model->lastUpdate = $now;
                $model->createdAt = $now;
                $model->updatedAt = $now;
                $model->created_at = $now;
                $model->updated_at = $now;

                $model->save();

            }

        }else{
            //print "max qty ". $programQty. " already available in repo, no need to generate\r\n";
        }

        return 0;
    }

    protected function newVoucher($now, $until){
        $model = new VoucherRepo();

        $model->voucherCode = strtoupper( Util::randomstring(10, 'alphanumeric') );
        $model->programId = $programId;
        $model->programClass = $programClass;
        $model->releaseDateTime = $now;
        $model->validUntil = $until;
        $model->voucherStatus = 'RELEASED';
        $model->voucherValueType = 'NOMINAL';
        $model->pointValue = $pointValue;
        $model->programCategory = $programCategory;
        $model->voucherUnitValue = $voucherUnitValue;
        $model->_class = 'com.cronostar.loyalty.domain.VoucherCodeRepo';

        $model->createdDate = $now;
        $model->lastUpdate = $now;
        $model->createdAt = $now;
        $model->updatedAt = $now;
        $model->created_at = $now;
        $model->updated_at = $now;

        $model->save();

    }
}
