<?php
namespace App\Helpers\App;


use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Reference\Area;
use App\Models\Reference\Province;
use App\Models\Reference\City;
use App\Models\Reference\Company;
use App\Models\Core\Mongo\Sequence;
use App\Models\Reference\CostCenter;
use App\Models\Directory\VendorDirectory;
use App\Models\Sms\Reference\Incoterm;
use App\Models\Sms\SalesOperation\JobRegister;
use App\Models\Sms\ProcurementLogistic\PurchaseRequisition;
use App\Models\Sms\ProcurementLogistic\ServiceRequisition;

class SmsUtil {

    public static function toOptions($data, $text, $value, $all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'None', 'value'=>''  ];
        }

        foreach ($data as $d){
            $label = '';
            if( is_array( $text ) ){
                $lbl = [];
                foreach($text as $f){
                    $lbl[] = $d[$f]?? '';
                }
                $label = implode(' ', $lbl);
            }else{
                if(!is_null($text)){
                    $label = $d[$text]??'';
                }
            }

            debug('label '.$label);
            if(strlen($label) > 50){
                $label = substr($label, 0, 50).' ...';
            }

            if($value == '_object'){
                $opt[] = [ 'text'=>$label, 'value'=>$d  ];
            }else{
                $opt[] = [ 'text'=>$label, 'value'=>$d[$value]  ];
            }

        }

        return $opt;

    }

    //Purchase Order
    public static function getRequestNo()
    {
        $coycodes = PurchaseRequisition::where('revLock' , '!=', 1)
            ->orderBy('updated_at','desc')
            ->orderBy('requestNo', 'desc')
            ->orderBy('rev', 'desc')
        ->get();
        return $coycodes->toArray();
    }

    public static function getIncoterm()
    {
        $coycodes = Incoterm::get();
        return $coycodes->toArray();
    }

    public static function getPrVendors()
    {
        $disposal = PurchaseRequisition::orderBy('vendorCode', 'asc')->get();

        $vendors = $disposal->toArray();

        for($i = 0; $i < count($vendors); $i++ ){
            $vendors[$i]['LongDescr'] = ($vendors[$i]['vendorCode'] ?? '') .' '.$vendors[$i]['coyName'];
        }
        return $vendors;
    }

    public static function getPrCompanies()
    {
        $disposal = PurchaseRequisition::orderBy('companyName', 'asc')->get();

        $company = $disposal->toArray();

        for($i = 0; $i < count($company); $i++ ){
            $company[$i]['LongDescr'] = ($company[$i]['companyName'] ?? '') .' '.$company[$i]['companyCode'];
        }
        return $company;
    }



    public static function getPrCostCenter()
    {
        $coycodes = PurchaseRequisition::where( 'costCenter','exists',true )
                    ->whereNotNull('costCenter')
                    ->where('costCenter', '!=', '')
                    ->orderBy('costCenter', 'asc')->get();
        return $coycodes->toArray();
    }

    //end Purchase Order

    public static function getServiceRequestNo()
    {
        $coycodes = ServiceRequisition::orderBy('serviceRequestNo', 'asc')
        ->where('revLock' , '!=' ,1)
        ->get();
        return $coycodes->toArray();
    }

    //Purchase Requistion
    public static function getPrJobNumber()
    {
        $coycodes = JobRegister::orderBy('jobNo', 'asc')
        ->where('jobNo','NOT LIKE','B%')
        ->where('jobStatus','NOT LIKE','Closed')
        ->get();
        return $coycodes->toArray();
    }

    public static function getCostCenter()
    {
        $coycodes = CostCenter::orderBy('costCenterCode', 'asc')->get();
        return $coycodes->toArray();
    }

    // injeksi jobno from jobregister
    public static function getJobNumber()
    {
        $coycodes = JobRegister::orderBy('jobNo', 'asc')->get();
        return $coycodes->toArray();
    }

    // injeksi vendor code from vendor code
    public static function getVendorCode()
    {
        $coycodes = VendorDirectory::where( 'vendorCode','exists',true )
                    ->whereNotNull('vendorCode')
                    ->where('vendorCode', '!=', '')
                    ->orderBy('vendorCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getDocType()
    {
        $doctypes = DocType::orderBy('DocType', 'asc')->get();
        return $doctypes->toArray();
    }

    public static function getCompany()
    {
        $coycodes = CoyCode::orderBy('CoyCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getYearOptions()
    {
        $disposal = DocDisposal::orderBy('CoyCode', 'asc')->get();
        return $disposal->toArray();
    }

  public static function getProvince()
  {
    $coycodes = Area::groupBy('provinceName')->orderBy('provinceName', 'asc')->get();
    return $coycodes->toArray();
  }

  public static function getCity($provinceName)
  {
    // if(count($province)) {
    //     $coycodes = City::where('_id', '=', $province[0]['_id'])->orderBy('cityCode', 'asc')->get();
    //     return $coycodes->toArray();
    // }
    $coycodes = Area::where('provinceName','=',$provinceName)->groupBy('cityName')->orderBy('cityName', 'asc')->get();
    return $coycodes->toArray();
  }

    public static function getTopics()
    {
        $disposal = CallCode::orderBy('Topic', 'asc')->get();

        $topics = $disposal->toArray();

        for($i = 0; $i < count($topics); $i++ ){
            $topics[$i]['LongDescr'] = $topics[$i]['Topic'] .' '.$topics[$i]['TopicDescr'];
        }
        return $topics;
    }

    public static function getTopic($topic)
    {
        $topic = CallCode::where('Topic','=', trim($topic))->first();

        if($topic){
            return $topic->toArray();
        }else{
            return false;
        }
    }

    public static function getSequence($entity, $padded = true)
    {
        $sequencer = new Sequence();
        $seq = $sequencer->getNewId($entity);

        return ($padded)? str_pad($seq, env('NUM_PAD', 5), '0', STR_PAD_LEFT ) : $seq;

    }

    public static function getVendors()
    {
        $disposal = vendorDirectory::orderBy('vendorCode', 'asc')->get();

        $vendors = $disposal->toArray();

        for($i = 0; $i < count($vendors); $i++ ){
            $vendors[$i]['LongDescr'] = ($vendors[$i]['vendorCode'] ?? '') .' '.$vendors[$i]['coyName'];
        }
        return $vendors;
    }

    public static function getCompanies()
    {
        $disposal = Company::orderBy('companyName', 'asc')->get();

        $company = $disposal->toArray();

        for($i = 0; $i < count($company); $i++ ){
            $company[$i]['LongDescr'] = ($company[$i]['companyName'] ?? '') .' '.$company[$i]['companyCode'];
        }
        return $company;
    }
}
