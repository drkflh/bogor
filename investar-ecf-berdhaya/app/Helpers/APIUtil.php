<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 22/04/20
 * Time: 12.34
 */

namespace App\Helpers;


use App\Models\Core\Mongo\APILog;
use Carbon\Carbon;
use Symfony\Component\Yaml\Yaml;

class APIUtil
{
    public static $yml;
    public static $ymlfile = "";
    public static $addDataModel = [];

    public static function log($url, $method ,$req, $resp, $actor = null)
    {
        $apilog = new APILog();
        $apilog->method = $method;
        $apilog->url = $url;
        $apilog->request_data = $req;
        $apilog->response_data = $resp;
        $apilog->actor = $actor;
        $apilog = TimeUtil::createTime($apilog, date_default_timezone_get());
        $apilog->save();
    }

    public static function addGeoLocation($data, $isArray = true){
        if($isArray){
            if(isset( $data['lat'] ) && isset( $data['lng'] )){
                $g1 = doubleval($data['lat']);
                $g2 = doubleval($data['lng']);

                $data['lat'] = $g1;
                $data['lng'] = $g2;
                $data['lngLat'] = [$g2,$g1];
                $data['latLng'] = [$g1,$g2];

                $data['location'] = [
                    'type'=>'Point',
                    'coordinates'=>[$g2, $g1]
                ];
            }
        }else{
            if(isset( $data->lat ) && isset( $data->lng )){
                $g1 = doubleval($data->lat);
                $g2 = doubleval($data->lng);

                $data->lat = $g1;
                $data->lng = $g2;
                $data->lngLat = [$g2,$g1];
                $data->latLng = [$g1,$g2];

                $data->location = [
                    'type'=>'Point',
                    'coordinates'=>[$g2, $g1]
                ];
            }
        }


        return $data;
    }

    public static function loadResYaml($filename = 'fields', $base_path = null, $additive = false){
        if(is_null($base_path)){
            self::$yml = false;
        }else{
            $path = resource_path($base_path).'/'.$filename.'.yml';

            try{
                $ymlfile = file_get_contents( $path );
                if($additive){
                    if(self::$ymlfile == ""){
                        self::$ymlfile = $ymlfile;
                    }else{
                        self::$ymlfile .= "\r\n".$ymlfile;
                    }
                }else{
                    self::$ymlfile = $ymlfile;
                }
                self::$yml = Yaml::parse(self::$ymlfile);
            }catch (\Exception $exception){
                print $exception->getMessage();
                self::$yml = false;
            }
            return new self;
        }
    }

    public function toApiEntity($mode = 'all')
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k=>$v){
                if(!is_null($k) && $k != ''){
                    if( ( isset($v['name']) && $v['name'] != '' && isset($v['api']) && isset($v['api']['show']) ) && ( $v['api']['show'] == true || $v['api']['show'] == 1) ){
                        $field = [
                            'name'=>$v['name'],
                            'type'=>$v['type'] ?? 'string',
                            'nullable'=> $v['nullable'] ?? true,
                            'default'=> $v['api']['default'] ,
                            'show'=> $v['api']['show'] ?? true,
                            'create'=> boolval( $v['api']['create']) ?? false,
                            'edit'=> boolval($v['api']['edit'] ) ?? false,
                            'view'=> boolval($v['api']['view'] ) ?? false,
                            'validator'=> $v['api']['validator'] ?? true,
                            'transform'=> $v['api']['transform'] ?? false,
                        ] ;

                        if($mode == 'edit'){
                            if($field['edit']){
                                $fields[$v['name']] = $field;
                            }
                        }
                        if($mode == 'create'){
                            if($field['create']){
                                $fields[$v['name']] = $field;
                            }
                        }
                        if($mode == 'view'){
                            if($field['view']){
                                $fields[$v['name']] = $field;
                            }
                        }
                        if($mode == 'list'){
                            if($field['show']){
                                $fields[$v['name']] = $field;
                            }
                        }
                        if($mode == 'all'){
                            $fields[$v['name']] = $field;
                        }
                    }
                }
            }
        }

        return $fields;
    }

    public function toApiTypeList()
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k=>$v){
                if(!is_null($k) && $k != ''){
                    $field = [
                        'name'=>$v['name'],
                        'type'=>$v['type'] ?? 'string',
                        'nullable'=> $v['nullable'] ?? true,
                        'default'=> $v['api']['default'] ,
                        'show'=> $v['api']['show'] ?? true,
                        'create'=> boolval( $v['api']['create']) ?? false,
                        'edit'=> boolval($v['api']['edit'] ) ?? false,
                        'view'=> boolval($v['api']['view'] ) ?? false,
                        'validator'=> $v['api']['validator'] ?? true,
                        'transform'=> $v['api']['transform'] ?? false,
                    ] ;
                    $fields[$v['name']] = $field;
                }
            }
        }

        return $fields;
    }

    public function toObjectSchema()
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k=>$v){
                if( ( isset($v['name']) && isset($v['api']) && (  (isset($v['api']['show']) ) && $v['api']['show'] == 1 ) ||  (isset($v['api']['view']) ) && $v['api']['view'] == 1  )  ){
                    $attr = [
                        'type'=>$v['type'] ?? 'string',
                        'create'=>$v['api']['create'],
                        'edit'=>$v['api']['edit'],
                        'view'=>$v['api']['view'],
                        'list'=>$v['api']['show'],
                        'default'=>$v['api']['default'],
                    ];
                    $fields[$v['name']] =$attr;
                }
            }
        }

        return $fields;
    }

}
