<?php
namespace App\Helpers;


use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Core\Mongo\APILog;
use App\Models\Core\Mongo\Sequence;
use App\Models\Inventory\InventoryCategory;
use App\Models\Reference\CompanyType;
use App\Models\Reference\Uom;
use App\Models\Reference\Currency;
use App\Models\Reference\Area;
use App\Models\Reference\Company;
use App\Models\Reference\JobStatus;
use App\Models\Directory\DistributorDirectory;

class InventoryUtil {

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

    public static function getCurrency()
    {
        $coycodes = Currency::orderBy('name', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getInventoryCategory()
    {
        $coycodes = InventoryCategory::orderBy('categoryCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function toOptions($data, $text, $value, $all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'All', 'value'=>'all'  ];
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

}
