<?php

namespace App\Helpers;

use App\Models\Dcs\Scoring\Question;

class DcsUtil
{
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
                $opt[] = [ 'text'=>$label, 'value'=>$d[$value]  ];
            }

        }

        return $opt;

    }

    public static function getQuestions($formCode)
    {
        $questions = Question::where('formCode', '=', $formCode)
            //->orderBy('createdAt', 'asc')
            ->orderBy('seq', 'asc')
            ->get();
        return $questions->toArray();
    }

}
