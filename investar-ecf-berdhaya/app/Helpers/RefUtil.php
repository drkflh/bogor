<?php
namespace App\Helpers;


use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Core\Mongo\APILog;
use App\Models\Core\Mongo\Sequence;
use App\Models\Obj\EmailTemplate;
use App\Models\Obj\PrintTemplate;
use App\Models\Reference\AreaCode;
use App\Models\Reference\BizUnit;
use App\Models\Sfm\Reference\Levels;
use App\Models\Reference\CompanyType;
use App\Models\Reference\PaymentCategory;
use App\Models\Reference\ProductBrand;
use App\Models\Reference\ProductCategory;
use App\Models\Reference\SelectOptions;
use App\Models\Reference\Uom;
use App\Models\Halal\BizProfile;
use App\Models\Reference\Currency;
use App\Models\Reference\Area;
use App\Models\Reference\Company;
use App\Models\Reference\JobStatus;
use App\Models\Directory\DistributorDirectory;
use App\Models\Core\Mongo\User;

class RefUtil
{

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
                $opt[] = [ 'id'=>$d[$value], 'text'=>$label, 'value'=>$d[$value]  ];
            }
        }

        return $opt;
    }

    public static function toGroupOptions($data, $text, $value, $groupField ,$all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'None', 'value'=>'', 'id'=>''  ];
        }

        $gl = [];
        foreach ($data as $d){
            $gl[ $d[$groupField] ] = [
                'label'=>$d[$groupField],
                'options'=>[]
            ];
        }

        $opts = [];

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

            if( !isset( $opts[$d[$groupField]] ) ){
                $opts[$d[$groupField]] = [];
            }

            if($value == '_object'){
                $opts[$d[$groupField]][] = [ 'id'=>$label, 'text'=>$label, 'value'=>$d  ];
            }else{
                $opts[$d[$groupField]][] = [ 'id'=>$d[$value] , 'text'=>$label, 'value'=>$d[$value]  ];
            }

        }

        foreach($gl as $k=>$v){
            if(isset($gl[$k]) && isset($opts[$k])){
                $gl[$k]['options'] = $opts[$k];
            }
        }

        return $gl;

    }

    public static function toGroupOptions2($data, $text, $value, $groupField ,$all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'None', 'value'=>'', 'id'=>''  ];
        }

        $gl = [];
        foreach ($data as $d){
            $gl[ $d[$groupField] ] = [
                'text'=>$d[$groupField],
                'children'=>[]
            ];
        }

        $opts = [];

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

            if( !isset( $opts[$d[$groupField]] ) ){
                $opts[$d[$groupField]] = [];
            }

            if($value == '_object'){
                $opts[$d[$groupField]][] = [ 'id'=>$label, 'text'=>$label, 'value'=>$d  ];
            }else{
                $opts[$d[$groupField]][] = [ 'id'=>$d[$value] , 'text'=>$label, 'value'=>$d[$value]  ];
            }

        }


        $ops = [];
        foreach($gl as $k=>$v){
            if(isset($gl[$k]) && isset($opts[$k])){
                $gl[$k]['children'] = $opts[$k];
                $ops[] = $gl[$k];
            }
        }

        return $ops;

    }

    public static function toObjectMap($data, $key, $project = [])
    {
        $m = [];
        foreach ($data as $d){
            $k = $d[$key] ?? false;
            if($k){
                if(!empty($project)){
                    $fd = [];
                    foreach ( $project as $fk ){
                        $fd[ $fk ] = $d[ $fk ] ?? null;
                    }
                    $d = $fd;
                }
                $m[$k] = $d;
            }
        }
        return $m;
    }

    public static function getSelectOptions($group, $subgroup){
        $opts = SelectOptions::where('group','=', $group)
                ->where('subGroup', '=', $subgroup)
                ->orderBy('seq', 'asc')
                ->get();
        return $opts->toArray();
    }

    public static function getJobStatus($group = null)
    {
        if(is_null($group)){
            $coycodes = JobStatus::groupBy('name')->orderBy('name', 'asc')->get();
        }else{
            $coycodes = JobStatus::where('statusGroup', '=', $group)
                ->where('isActive',true)
                ->groupBy('name')
                ->orderBy('seq', 'asc')
                ->get();
        }
        return $coycodes->toArray();
    }
    public static function getDocDesc($doc)
    {
        $coycodes = Doc::where('name','=',$doc)->get();
        return $coycodes->toArray();
    }
    public static function getDocName()
    {
        $coycodes = Doc::groupBy('name')->orderBy('name', 'asc')->get();
        return $coycodes->toArray();
    }
    public static function getUom()
    {
        $coycodes = Uom::groupBy('uom')->orderBy('uom', 'asc')->get();
        return $coycodes->toArray();
    }
    public static function getCompanyType()
    {
        $coycodes = CompanyType::orderBy('seq', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getBizBusiness()
    {
        $coycodes = BizProfile::select('bizRegisteredName')->orderBy('bizRegisteredName ', 'asc')->groupBy('bizRegisteredName')->get();
        return $coycodes->toArray();
    }

    public static function getCompanyTypes()
    {
        $coycodes = CompanyType::groupBy('companyType')->orderBy('companyType', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getBizUnit($companyId = null)
    {
        $coycodes = BizUnit::orderBy('bizUnitCode', 'asc')->get([
            '_id',
            'bizUnitCode',
            'bizUnitName',
            'bizUnitType',
            'companyCode',
            'companyName',
            'companyPhone',
            'companyPhone2',
            'companyFax',
            'companyPhoneExt',
            'companyPhoneExt2',
            'companyFaxExt',
            'companyAddress',
            'companyAddress1',
            'companyAddress2',
            'companyLogo',
            'companyEmail',
            'companyWeb',
            'seq'
        ]);
        return $coycodes->toArray();
    }

    public static function getCurrency()
    {
        $coycodes = Currency::orderBy('name', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getDistributor()
    {
        $coycodes = DistributorDirectory::groupBy('coyName')->orderBy('coyName', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getProvince()
    {
        $coycodes = Area::groupBy('provinceName')->orderBy('provinceName', 'asc')->get();
        return $coycodes->toArray();
    }
    public static function getKabupaten()
    {
        $coycodes = AreaCode::orderBy('kabupatenName', 'asc')->get();
        return $coycodes->toArray();
    }
    // public static function getKabupaten($province = null)
    // {
    //     if (is_null($province)) {
    //         return [];
    //     }
    //     $coycodes = AreaCode::orderBy('kabupatenName', 'asc')
    //         ->where('provinceName', '', $province)
    //         ->get();
    //     return $coycodes->toArray();
    // }
    public static function getKecamatan($kabupaten = null)
    {
        if (is_null($kabupaten)) {
            return [];
        }
        $coycodes = Area::orderBy('kecamatanName', 'asc')
            ->where('cityName', '', $kabupaten)
            ->get();
        return $coycodes->toArray();
    }

    public static function getKelurahan($kecamatan = null)
    {
          if(is_null($kecamatan)){
              return [];
          }
          $coycodes = Area::orderBy('kelurahanName', 'asc')
              ->where('kecamatanName', '', $kecamatan)
              ->get();
          return $coycodes->toArray();
    }

    public static function getBizProfile()
    {
        $coycodes = BizProfile::orderBy('bizRegisteredName', 'asc')->get();
        return $coycodes->toArray();
    }
    public static function getJenisPendanaan()
    {
        $coycodes = JenisPendanaan::orderBy('jenispendanaan', 'asc')->get();
        return $coycodes->toArray();
    }
    public static function getCity($provinceName = null)
    {
        if (is_null($provinceName)) {
            return [];
        }
        $coycodes = Area::where('provinceName', '=', $provinceName)
            ->groupBy('cityName')
            ->orderBy('cityName', 'asc')
            ->get();
        return $coycodes->toArray();
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

    public static function getGroupCompany()
    {
        $coycodes = Company::orderBy('companyCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getCompanyByCode($code)
    {
        $company = Company::where('companyCode', '=', $code)->first();
        if($company){
            return $company->toArray();
        }else{
            return false;
        }
    }

    public static function getYearOptions()
    {
        $disposal = DocDisposal::orderBy('CoyCode', 'asc')->get();
        return $disposal->toArray();
    }

    public static function getEmailTemplate()
    {
        $etpl = EmailTemplate::orderBy('title', 'asc')->get();
        return $etpl->toArray();
    }

    public static function getPrintTemplate()
    {
        $dtpl = PrintTemplate::orderBy('title', 'asc')->get();
        return $dtpl->toArray();
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

    public static function getCompanies()
    {
        $companies = Company::orderBy('companyName', 'asc')->get();

        $company = $companies->toArray();

        for($i = 0; $i < count($company); $i++ ){
            $company[$i]['LongDescr'] = ($company[$i]['companyName'] ?? '') .' '.($company[$i]['companyCode'] ?? '');
        }
        return $company;
    }

    public static function getCompanyCodeMap()
    {
        $companies = Company::orderBy('companyName', 'asc')->get();

        foreach ($companies as $a){
            $obj = [
                'text'=>$a->companyName,
                'value'=> [
                    '_id'=>$a->_id,
                    'companyCode'=>$a->companyCode,
                    'companyName'=>$a->companyName,
                    'companyAddress'=>$a->companyAddress,
                    'companyAddress1'=>$a->companyAddress1,
                    'companyAddress2'=>$a->companyAddress2,
                    'companyLogo'=>$a->companyLogo,
                    'companyEmail'=>$a->companyEmail,
                    'companyFax'=>$a->companyFax,
                    'companyPhone'=>$a->companyPhone,
                    'companyPhone2'=>$a->companyPhone2,
                    'nib'=>$a->nib,
                    'noNpwp'=>$a->noNpwp,
                ]
            ];
            $coyCodes[$a->companyCode] = $obj;
        }

        return $coyCodes;
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
    public static function getSponsorName()
    {
        $coycodes = User::select('name')->where('roleName', '=' , 'Sponsor')
        ->groupBy('name')
        ->orderBy('name', 'asc')
        ->get();
        return $coycodes->toArray();
    }
    public static function getSponsorId()
    {
        $coycodes = User::select('roleId')->where('roleName', '=' , 'Sponsor')
        ->groupBy('roleId')
        ->orderBy('roleId', 'asc')
        ->get();
        return $coycodes->toArray();
    }




}
