<?php
namespace App\Helpers\App;


use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Reference\Area;
use App\Models\Reference\ProductCategory;
use App\Models\Reference\Province;
use App\Models\Reference\City;
use App\Models\Reference\Company;
use App\Models\Core\Mongo\Sequence;
use App\Models\Reference\CostCenter;

use App\Models\Reference\Uom;
use App\Models\Reference\VendorDirectory;

class SfmUtil {

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
    public static function toGroupOptions($data, $text, $value, $groupField ,$all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'None', 'value'=>''  ];
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
                $opts[$d[$groupField]][] = [ 'text'=>$label, 'value'=>$d  ];
            }else{
                $opts[$d[$groupField]][] = [ 'text'=>$label, 'value'=>$d[$value]  ];
            }

        }

        foreach($gl as $k=>$v){
            if(isset($gl[$k]) && isset($opts[$k])){
                $gl[$k]['options'] = $opts[$k];
            }
        }

        return $gl;

    }


    public static function roleRedirect($role = null)
    {
        if (is_null($role)) {
            return '/';
        }

        if ($role->roleSlug = 'penerbit') {
            return 'ecf/profile/penerbit/step/1';
        }

        if ($role->roleSlug = 'pemodal') {
            return 'ecf/profile/pemodal/step/1';
        }

        return '/';

    }

    public static function getUnits()
    {
        $units = Uom::orderBy('uom','asc')->get();
        return $units->toArray();
    }

    public static function getCategories()
    {
        $categories = ProductCategory::orderBy('category', 'asc')->get();
        return $categories->toArray();
    }

    public static function getVendors()
    {
        $categories = VendorDirectory::orderBy('vendorName', 'asc')->get();
        return $categories->toArray();
    }

    public static function getArea()
    {
        $area = Area::orderBy('cityName', 'asc')->get();
        return $area->toArray();
    }

    public static function getDeliveryAddress()
    {
        $area = Area::orderBy('cityName', 'asc')->get();
        return $area->toArray();
    }

    public static function getCartSession()
    {

    }

    public static function addProductToCart($product, $cartSession)
    {

    }

    public static function updateProductQty( $qty, $product, $cartSession)
    {

    }

    public static function removeProductFromCart($productId)
    {

    }


}
