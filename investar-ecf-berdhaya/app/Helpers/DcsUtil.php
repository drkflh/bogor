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

    public static function getQuestionSection($formCode)
    {
        $sections = Question::where('formCode', '=', $formCode)
            ->where('lineType', '=', 'section')
            ->orderBy('seq', 'asc')
            ->get();
        return $sections->toArray();

    }

    public static function getQuestions($formCode, $section = false)
    {
        if($section && $section != ''){
            $questions = Question::where('formCode', '=', $formCode)
                ->where('lineType', '=', 'question')
                ->where('questionSection', '=', $section)
                //->orderBy('createdAt', 'asc')
                ->orderBy('seq', 'asc')
                ->get();
            return $questions->toArray();

        }else{
            $questions = Question::where('formCode', '=', $formCode)
                ->where('lineType', '=', 'question')
                //->orderBy('createdAt', 'asc')
                ->orderBy('seq', 'asc')
                ->get();
            return $questions->toArray();

        }
    }

}
