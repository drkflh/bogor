<?php
namespace App\Helpers\App;


use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Core\Mongo\APILog;
use App\Models\Core\Mongo\Sequence;
use App\Models\Loyalty\Deploy\DeployLog;
use App\Models\Loyalty\Deploy\DeployQueue;
use App\Models\Loyalty\GenericRule\RuleParameter;
use App\Models\Reference\Area;
use App\Models\Reference\Company;
use App\Models\Reference\PaymentType;
use App\Models\Reference\Province;
use App\Models\Reference\City;
use App\Models\Reference\PaymentCategory;
use App\Models\Reference\ProductCategory;
use App\Models\Reference\ProductBrand;
use App\Models\Reference\Religion;
use App\Models\Reference\Store;
use App\Models\Reference\Location;
use App\Models\Voucher\Data\VoucherRepo;
use App\Models\Voucher\Program\VoucherProgram;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class LoyaltyUtil {

    public static function getLoyaltyId()
    {
        $prefix = env('LOYALTY_PREFIX');
        $seq = self::getSequence($prefix);
        return $prefix.$seq;
    }

    public static function voucherProgram($programId, $programClass)
    {
        $prg = VoucherProgram::where('programId', '=', trim($programId))
                ->where('programClass','=',$programClass)
                ->first();
        if($prg){
            return $prg->toArray();
        }else{
            return false;
        }
    }

    public static function voucherQtyCheck($programId, $maxQty)
    {
        $repoQty = VoucherRepo::where('programId', '=', trim($programId))->count();
//            ->where(function($q){
//                $q->where('voucherStatus','!=', 'REJECTED')
//                    ->where('voucherStatus','!=', 'REJECTED')
//            })->count();
        if(doubleval($maxQty) == 0){
            return true;
        }else{
            return ( doubleval($repoQty) < doubleval($maxQty) );
        }
    }

    public static function getVoucherQty($programId)
    {
        $vQty = VoucherProgram::where('programId','=', $programId)->first();
        if($vQty){
            $inv = $vQty->voucherQuantity ?? 0;
            return $inv;
        }else{
            return 0;
        }

    }

    public static function getVoucherQtyByStatus($programId)
    {
        $released = VoucherRepo::where('programId','=', $programId)->where('voucherStatus', '=', 'RELEASED')->count();
        $paired = VoucherRepo::where('programId','=', $programId)->where('voucherStatus', '=', 'PAIRED')->count();
        $redeemed = VoucherRepo::where('programId','=', $programId)->where('voucherStatus', '=', 'REDEEMED')->count();
        $used = VoucherRepo::where('programId','=', $programId)->where('voucherStatus', '=', 'USED')->count();
        $total = VoucherRepo::where('programId','=', $programId)->count();

        return [
            'released'=>$released,
            'paired'=>$paired,
            'redeemed'=>$redeemed,
            'used'=>$used,
            'total'=>$total
        ];
    }

    public static function getRepoQty($programId)
    {
        $repoQty = VoucherRepo::where('programId', '=', trim($programId))->count();
//            ->where(function($q){
//                $q->where('voucherStatus','!=', 'REJECTED')
//                    ->where('voucherStatus','!=', 'REJECTED')
//            })->count();
        return doubleval($repoQty);
    }

    // injeksi product category
    public static function getPaymentCategory()
    {
        $coycodes = PaymentCategory::orderBy('paymentCategoryCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getProductCategory()
    {
        $coycodes = ProductCategory::orderBy('categoryCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getReligion()
    {
        $coycodes = Religion::orderBy('religionName', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getLocation()
    {
        $coycodes = Location::orderBy('locationCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getProductBrand()
    {
        $coycodes = ProductBrand::orderBy('brandCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function normalPhone($phoneNumber){
        $pattern = '/\s|\D/gm';
        $ph1=preg_replace($pattern,"",$phoneNumber);
        $ph2=preg_replace('/^0/g',"62",$ph1);
        return $ph2;
    }

    public static function getCriteriaOptions($ruleName){
        $opts = RuleParameter::where($ruleName,'=', true)->orderBy('parameterLabel', 'asc')->get();
        return $opts->toArray();
    }

    public static function getLoyaltyCardId(){
        $prefix = env('LOYALTY_CARD_PREFIX', '0000 0000 0000 0000 ');
        $seq = self::getSequence($prefix);
        return $prefix.$seq;
    }

    public static function getPaymentType()
    {
        $coycodes = PaymentType::where('active', '=', true)->orderBy('paymentCode', 'asc')->get();
        return $coycodes->toArray();
    }


    public static function getProvince()
    {
        $coycodes = Area::groupBy('provinceName')->orderBy('provinceName', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getCity($provinceName)
    {
        $coycodes = Area::where('provinceName','=',$provinceName)->groupBy('cityName')->orderBy('cityName', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function toOptions($data, $text, $value, $all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'All', 'value'=>'all'  ];
        }

        foreach ($data as $d){
            if($value == '_object'){
                $opt[] = [ 'text'=>$d[$text], 'value'=>$d  ];
            }else{
                $opt[] = [ 'text'=>$d[$text], 'value'=>$d[$value]  ];
            }
        }

        return $opt;

    }

    public static function getDocType()
    {
        $doctypes = DocType::orderBy('DocType', 'asc')->get();
        return $doctypes->toArray();
    }

    public static function getCompany()
    {
        $coycodes = Company::orderBy('companyCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getStore()
    {
        $coycodes = Store::orderBy('storeCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getYearOptions()
    {
        $disposal = DocDisposal::orderBy('CoyCode', 'asc')->get();
        return $disposal->toArray();
    }

    public static function getTopic()
    {
        $disposal = CallCode::orderBy('Topic', 'asc')->get();

        $topics = $disposal->toArray();

        for($i = 0; $i < count($topics); $i++ ){
            $topics[$i]['LongDescr'] = $topics[$i]['Topic'] .' '.$topics[$i]['TopicDescr'];
        }
        return $topics;
    }

    public static function getSequence($entity, $padded = true, $pad = 4)
    {
        $sequencer = new Sequence();
        $seq = $sequencer->getNewId($entity);

        return ($padded)? str_pad($seq, $pad, '0', STR_PAD_LEFT ) : $seq;

    }

    public static function postToSBC($data){

        $url = env('SBC_EARN_URL');
        // $response = Http::post($url, $data);
        $response = Http::post($url, $data);


        $apilog = new APILog();
        $apilog->method = 'POST';
        $apilog->url = $url;
        $apilog->request_data = $data;
        $apilog->response_data = $response->json();
        $apilog->save();

        if ($response->successful()){
            return $response->json();
        } else {
            return false;
        }
    }

    public static function triggerDmn( $rule, $nodeIP, $nodePort, $queueID ){

        $url = url( $nodeIP.':'.$nodePort.'/'.$rule);


        $response = Http::get($url);


        $apilog = new APILog();
        $apilog->method = 'GET';
        $apilog->url = $url;
        $apilog->request_data = "";
        $apilog->response_data = ($response->successful()) ? $response->json(): $response->body() ;
        $apilog->save();


        $deplog = new DeployLog();
        $deplog->method = 'GET';
        $deplog->url = $url;
        $deplog->request_data = "";
        $deplog->response_data = ($response->successful()) ? $response->json(): $response->body() ;
        $deplog->save();


        if ($response->successful()){
            $que = DeployQueue::find($queueID);
            if ($que){
                $que->status="DEPLOYED";
                $que->save();
            }
            return true;
        } else {
            return false;
        }

    }

}
