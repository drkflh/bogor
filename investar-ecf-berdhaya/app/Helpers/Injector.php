<?php
namespace App\Helpers;

class Injector
{

    public static $objectName;
    public static $activeView;
    public static $optModel;
    public static $optArray;


    public static function setObject($objname)
    {
        self::$activeView = [
            $objname.'ObjDef'=>[],
            $objname.'Total'=>[],
            $objname.'Fields'=>[],
            $objname.'Template'=>'``',
            $objname.'Content'=>'``',
            $objname.'Params'=>[],
            $objname.'ImportFields'=>[],
            $objname.'ImportHeadings'=>[],
        ];
        self::$objectName = $objname;
        return new self;
    }

    public function setObjDef($objdef)
    {
        self::$activeView[ self::$objectName.'ObjDef' ] = $objdef;
        return new self;
    }

    public function setObjFields($objfields)
    {
        $impFields = [];
        $impHeads = [];
        foreach($objfields as $ob){
            $impFields[] = [
                'dataIndex'=>$ob['key'],
                'key'=>$ob['key'],
                'title'=>$ob['label']
            ];

            $impHeads[$ob['key']] = $ob['label'];
        }

        self::$activeView[ self::$objectName.'ImportFields' ] = $impFields;
        self::$activeView[ self::$objectName.'ImportHeadings' ] = $impHeads;

        self::$activeView[ self::$objectName.'Fields' ] = $objfields;
        return new self;
    }

    public function setObjTotal($objtotal)
    {
        self::$activeView[ self::$objectName.'Total' ] = $objtotal;
        return new self;
    }

    public function setObjTemplate($objtemplate)
    {
        if(is_string($objtemplate)){
            $objtemplate = '`'.$objtemplate.'`';
        }
        self::$activeView[ self::$objectName.'Template' ] = $objtemplate;
        return new self;
    }

    public function setObjContent($objcontent)
    {
        if(is_string($objcontent)){
            $objcontent = '`'.$objcontent.'`';
        }
        self::$activeView[ self::$objectName.'Content' ] = $objcontent ;
        return new self;
    }

    public function setObjParams($objparams)
    {
        self::$activeView[ self::$objectName.'Params' ] = $objparams;
        return new self;
    }

    public function getArray(){
        return self::$activeView;
    }

    public static function setModel($model)
    {
        self::$optModel = $model;
        return new self;
    }

    public function toModelArray()
    {
        if(!is_null(self::$optModel)){
            self::$optModel = self::$optModel->get()->toArray();
        }
        return new self;
    }

    public function toOptions($text, $value, $all = true)
    {
        $data = self::$optModel;

        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'', 'value'=>''  ];
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
            if($value == '_object'){
                $opt[] = [ 'text'=>$label, 'value'=>$d  ];
            }else{
                $opt[] = [ 'text'=>$label, 'value'=>$d[$value]  ];
            }
        }

        self::$optArray = $opt;
        return new self;

    }

    public function getOptionArray()
    {
        return self::$optArray ?? [];
    }

    public function injectOption($fieldname, $uimodel)
    {
        $uimodel[ $fieldname.'Options' ] = self::$optArray;
        return $uimodel;
    }

    public function injectObject($uimodel)
    {
        return array_merge(self::$activeView , $uimodel );
    }

}
