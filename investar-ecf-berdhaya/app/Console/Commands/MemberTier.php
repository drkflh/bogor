<?php

namespace App\Console\Commands;

use App\Helpers\App\LoyaltyUtil;
use App\Models\Loyalty\Member\Member;
use App\Models\Loyalty\Member\MemberWallet;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MemberTier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'memberTier:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy memberTier';

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

        // jika volume member makin besar, perlu dibuat batasan update dengan menggunakan "tierModified" < today
        $mw = MemberWallet::all();

        $lowTier = \App\Models\Loyalty\Reference\MemberTier::orderBy('pointAmountFrom', 'asc')->first();
        if($lowTier){
            $lowestTier = [
                'memberTier' => $lowTier->memberTier,
                'memberTierTitle' => $lowTier->memberTierTitle
            ];
        }else{
            $lowestTier = [
                'memberTier' => 0,
                'memberTierTitle' => 'Regular'
            ];
        }

        $tierTable = $this->tierTable();

        foreach ($mw as $m) {
            //print_r($m->toArray());

            $tier = \App\Models\Loyalty\Reference\MemberTier::where('pointAmountFrom', '<=', $m->totalAvailablePoints )
                ->where('pointAmountTo', '>', $m->totalAvailablePoints )->first();

            $member = Member::where('loyaltyMemberId', '=', $m->loyaltyMemberId)->first();

            $now = Carbon::now()->toDateTimeString();
            if($tier){
                if($member){
                    if( intval($member->memberTier) < intval($tier->tierNumber) ){
                        $member->memberTier = intval($tier->tierNumber);
                        $member->memberTierTitle = $tier->tierTitle;
                        $member->tierModified = $now;
                        $member->save();
                        print $member->loyaltyMemberId. " " .$member->memberTier . " " .$member->memberTierTitle ."\r\n";
                    }
                    if( isset($member->memberTierTitle) && $member->memberTierTitle != '' ){

                    }else{
                        print $member->loyaltyMemberId. " " .$member->memberTier . " " .$member->memberTierTitle ."\r\n";
                        if($tierTable ){
                            if(isset( $tierTable[ $member->memberTier ] ) ){
                                $member->memberTierTitle = $tierTable[ $member->memberTier ];
                                $member->save();
                            }
                        }
                        print $member->loyaltyMemberId. " " .$member->memberTier . " " .$member->memberTierTitle ."\r\n";
                    }
                }
            }else{
                if($member){
                    if( intval($member->memberTier) < intval($lowestTier['memberTier']) ){
                        $member->memberTier = intval($lowestTier['memberTier']);
                        $member->memberTierTitle = $lowestTier['memberTierTitle'];
                        $member->tierModified = $now;
                        $member->save();
                        print $member->loyaltyMemberId. " " .$member->memberTier . " " .$member->memberTierTitle ."\r\n";
                    }

                    if( isset($member->memberTierTitle) && $member->memberTierTitle != '' ){

                    }else{
                        print $member->loyaltyMemberId. " " .$member->memberTier . " " .$member->memberTierTitle ."\r\n";
                        if($tierTable ){
                            if(isset( $tierTable[ $member->memberTier ] ) ){
                                $member->memberTierTitle = $tierTable[ $member->memberTier ];
                                $member->save();
                            }
                        }
                        print $member->loyaltyMemberId. " " .$member->memberTier . " " .$member->memberTierTitle ."\r\n";
                    }

                }
            }
        }

        // tier.pointMin < totalPoint < tier.pointMax
        return 0;
    }

    // Didalamnya query member_wallet , trus total point di query ke member_tiers buat dapet tier nya

    public function tierTable(){
        $tiers = \App\Models\Loyalty\Reference\MemberTier::orderBy('pointAmountFrom', 'asc')
            ->orderBy('memberTier', 'asc')
            ->get();

        $tierTab = [];

        foreach ($tiers as $t){
            $tierTab[$t->tierNumber] = $t->tierTitle;
        }

        return empty($tierTab) ? false: $tierTab ;
    }
}
