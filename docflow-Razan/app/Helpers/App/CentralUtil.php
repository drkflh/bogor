<?php
namespace App\Helpers\App;


use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Core\Mongo\Sequence;
use App\Models\Central\Project\Client;
use App\Models\Central\Dcs\Question;
use App\Models\Central\Dcs\Responden;
use App\Models\Central\Dcs\Statement;
use App\Models\Central\Dcs\SettingForm;
use App\Models\Central\Project\TaskLog;
use App\Models\Central\Project\Project;
use App\Models\Central\Project\Task;
use App\Helpers\TimeUtil;
use App\Models\Central\Project\TimeReportLog;

class CentralUtil {

    public static function log($data)
    {
        $apilog = new TaskLog();
        $apilog->data = $data;
        $apilog = TimeUtil::createTime($apilog, date_default_timezone_get());
        $apilog->save();
    }

    public static function logTimeReport($data)
    {
        $apilog = new TimeReportLog();
        $apilog->data = $data;
        $apilog = TimeUtil::createTime($apilog, date_default_timezone_get());
        $apilog->save();
    }

    public static function getClient()
    {
        $client = Client::get();
        return $client->toArray();
    }

    public static function getIdResponden()
    {
        $idResponden = Responden::get();
        return $idResponden->toArray();
    }

    public static function getIdStatement()
    {
        $idStatement = Statement::get();
        return $idStatement->toArray();
    }

    public static function getIdQuestion()
    {
        $idQuestion = Question::get();
        return $idQuestion->toArray();
    }

    public static function getIdForm()
    {
        $idForm = SettingForm::get();
        return $idForm->toArray();
    }

    public static function toOptions($data, $text, $value, $all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'none', 'value'=>''  ];
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
                $opt[] = [ 'text'=>$label ?? '', 'value'=>$d[$value] ?? '' ];
            }

        }

        return $opt;

    }

    public static function sumTimeSec($data)
    {
        $sum = 0;
        foreach($data as $r){
            $sum += $r['timerSec'];
        }
        $hours = floor($sum / 3600);
        $minutes = floor(($sum / 60) % 60);
        $seconds = $sum % 60;

        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }

    public static function formatTimerSec($format,$data)
    {
        $hours = floor($data / 3600);
        $minutes = floor(($data / 60) % 60);
        $seconds = $data % 60;

        $minutesAll = floor($data / 60);

        if($format == 'H:i:s'){
            return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        }else if($format == 'i'){
            return sprintf("%02d", $minutes);
        }else if($format == 'H'){
            return sprintf("%02d", $hours);
        }else if($format == 'minutes-all'){
            return $minutesAll;
        }else{

        }
    }
}
