<?php

namespace App\Helpers;

use App\Models\Cms\Article;
use App\Models\Cms\Category;
use App\Models\Cms\Group;
use App\Models\Cms\Section;
use App\Models\Dms\DocType;

class CmsUtil
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

    public static function getSection()
    {
        $doctypes = Section::orderBy('createdAt', 'asc')->get();
        return $doctypes->toArray();
    }

    public static function getCategory($group = null)
    {
        if(is_null($group)){
            $doctypes = Category::whereNull('section')
                ->orWhere('DocTypeGroup','exists',false)
                ->orderBy('createdAt', 'asc')->get();
        }else{
            $doctypes = Category::where('section','=',$group)->orderBy('createdAt', 'asc')->get();
        }
        return $doctypes->toArray();
    }

    public static function getGroup($section = null, $category = null)
    {
        if(is_null($section) && is_null($category)){
            $group = Group::orderBy('groupName', 'asc')->get();
        }elseif(!is_null($section) && is_null($category)){
            $group = Group::where('sectionCode','=',$section)
                ->orderBy('groupName', 'asc')->get();
        }elseif(is_null($section) && !is_null($category)){
            $group = Group::where('categoryCode','=',$category)
                ->orderBy('groupName', 'asc')->get();
        }else{
            $group = Group::where('sectionCode','=',$section)
                ->where('categoryCode','=',$category)
                ->orderBy('groupName', 'asc')->get();
        }
        return $group->toArray();
    }

    public static function getArticle($group = null)
    {
        if(is_null($group)){
            $doctypes = Article::whereNull('category')
                ->orWhere('category','exists',false)
                ->orderBy('createdAt', 'asc')->get();
        }else{
            $doctypes = Article::where('category','=',$group)->orderBy('createdAt', 'asc')->get();
        }
        return $doctypes->toArray();
    }

    public static function getCmsOneLevelMenu($sectionCode, $base)
    {
        $archs = Category::where('sectionCode', '=', trim($sectionCode))
            ->orderBy('sectionCode', 'desc')
            ->orderBy('menuSeq','asc')
            ->get();

        $archs = $archs->toArray();

        $menu = [];
        foreach ($archs as $ar){
            $menu[] = [
                'title'=>$ar['menuTitle'],
                'url'=>$base.'/'.$ar['sectionCode'].'/'.$ar['categoryCode'],
                'icon'=>'<i class="link-icon"  data-feather="file-text"></i>',
                'auth'=>$ar['menuAuth'],//'children'=>[]
            ];
        }

        return $menu;
    }

}
