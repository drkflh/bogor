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
use App\Models\Core\Mongo\Sequence;
use App\Models\Sms\SalesOperation\JobRegister;
use App\Models\Directory\VendorDirectory;


class CedarUtil {

    public static function toOptions($data, $text, $value, $all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'All', 'value'=>'all'  ];
        }

        foreach ($data as $d){
            if( isset($d[$text]) ){
                if($value == '_object'){
                    $opt[] = [ 'text'=>$d[$text], 'value'=>$d  ];
                }else{
                    $opt[] = [ 'text'=>$d[$text], 'value'=>$d[$value]  ];
                }
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

}
