<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class MenuUtil
{
    public static $yml;
    public static $ymlfile = "";

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

    public static function clearYaml()
    {
        self::$ymlfile = '';
        return new self;
    }

    public function toArray(){
        return self::$yml;
    }

    public static function setMenuArray($menuArray){
        self::$yml = $menuArray;
        return new self;
    }

    public static function appendMenuArray($menuArray){
        if( is_array(self::$yml) ){
            self::$yml = array_merge( self::$yml , $menuArray );
        }
        return new self;
    }

    public function toMenu($section,$item, $subparent ,$subitem, $subtag = null, $grandtag = null)
    {
        if(Auth::check()){
            $roleEntity = AuthUtil::loadRoleEntity(Auth::user()->roleId);
            $roleId = Auth::user()->roleId;
        }else{
            $roleEntity = null;
            $roleId = null;
        }

        if( self::$yml ){
            $menu = self::$yml;
            $menustring = '';
            $menuarray = [];
            $next = true;
            foreach($menu as $m){
                if(isset($m['auth'])){
                    if($roleEntity->can('read', $m['auth'] , $roleId)){
                        $menuarray[] = sprintf($section, __($m['title']));
                        $next = true;
                    }else{
                        $next = false;
                    }
                }else{
                    $menuarray[] = sprintf($section, __($m['title']));
                    $next = true;
                }
                if(isset( $m['children'] ) && $next ){
                    if(is_array($m['children'])){
                        if(isset($m['children']['call'])){
                            $m_children = eval( 'return '.$m['children']['call'].';' );
                            if($m_children){
                                $m['children'] = $m_children;
                            }
                        }
                        foreach ($m['children'] as $c){
                            $submenustring = '';
                            $haschildren = false;
                            if(isset($c['children'])  && $next  ){
                                $submenu = [];
                                $submenu[] = $subtag ?? '<ul class="submenu">';

                                if(is_array($c['children'])){
                                    if(isset($c['children']['call'])){
                                        $c_children = eval( 'return '.$c['children']['call'].';' );
                                        if($c_children){
                                            $c['children'] = $c_children;
                                        }
                                    }
                                    foreach($c['children'] as $sm){
                                        debug(['sm',$sm]);
                                        if(isset($sm['children'])  && $next  ){

                                            $gc = $this->composeChildren($sm['children'], $subitem ,$grandtag, $roleId, $roleEntity);

                                            $gcmenustring = implode("\r\n", $gc);

                                            $badge = $sm['badge'] ?? '';


                                            if(isset( $sm['auth'] ) && !is_null($roleEntity) ){
                                                if($roleEntity->can('read', $sm['auth'] , $roleId)){
                                                    $submenu[] = sprintf($subparent, $icon , __($sm['title']) , $gcmenustring, $badge, $badge );
                                                }
                                            }else{
                                                $submenu[] = sprintf($subparent, $icon ,__($sm['title']) , $gcmenustring, $badge, $badge );
                                            }

                                        }else{
                                            if( isset($sm['click'])){
                                                $surl = '@click="'.$sm['click'].'"';
                                            }else{
                                                $surl = (isset($sm['url']))?url($sm['url']):'#';
                                                $surl = 'href="'.$surl.'"';

                                            }
                                            $badge = $sm['badge'] ?? '';

                                            //$surl = (isset($sm['url']))?url($sm['url']):'';
                                            if(isset( $sm['auth'] ) && !is_null($roleEntity)){
                                                info("MENU CHILDREN 01 HAS AUTH",$sm);

                                                if($roleEntity->can('read', $sm['auth'] , $roleId)){
                                                    if(isset($sm['title'])){
                                                        $submenu[] = sprintf($subitem, $surl, __($sm['title']), $badge, $badge );
                                                    }
                                                }
                                            }else{
                                                if(isset($sm['title'])){
                                                    $submenu[] = sprintf($subitem, $surl, __($sm['title']), $badge, $badge );
                                                }
                                            }


                                        }
                                    }
                                }
                                $submenu[] = '</ul>';
                                $submenustring = implode("\r\n", $submenu);
                                $haschildren = true;

                            }
                            if( isset($c['click'])){
                                $url = '@click="'.$c['click'].'"';
                            }else{
                                $url = (isset($c['url']))?url($c['url']):'#';
                                $url = 'href="'.$url.'"';
                            }
                            $icon = (isset($c['icon']))?$c['icon']:'';
                            $title = (isset($c['title']))?$c['title']:'No Title';
                            $title = __($title);

                            $badge = $c['badge'] ?? '';

                            if($haschildren){

                                if(isset($c['id']) && $c['id'] != ''){
                                    $randId = $c['id'];
                                }else{
                                    $randId = Util::randomstring(5, 'alpha');
                                }
                                $subparentx = str_replace('{{id}}', $randId, $subparent );

                                if(isset($c['auth'])){
                                    if($roleEntity->can('read', $c['auth'] , $roleId)){
                                        $menuarray[] = sprintf($subparentx, $icon , $title , $submenustring , $badge, $badge);
                                    }
                                }else{
                                    $menuarray[] = sprintf($subparentx, $icon , $title , $submenustring , $badge, $badge);
                                }

                            }else{
                                if(isset($c['auth'])){
                                    if($roleEntity->can('read', $c['auth'] , $roleId)){
                                        $menuarray[] = sprintf($item, $url, $icon , $title, $badge, $badge );
                                    }
                                }else{
                                    $menuarray[] = sprintf($item, $url, $icon , $title, $badge, $badge );
                                }
                            }
                        }
                    }
                }
            }
            //print_r($menuarray);
            $menustring = implode("\r\n", $menuarray );
            return $menustring;
        }else{
            return sprintf($section, 'No Menu' );
        }
    }

    public function composeChildren($children , $subitem ,$listtag, $roleId, $roleEntity)
    {
        debug('MENU CHILDREN');
        debug( $children );

        $gc = [];
        $gc[] = $listtag;
        foreach ($children as $ch){
            $target = isset($ch['target']) && $ch['target'] != '' ? ' target="'.$ch['target'].'"' :'';
            if( isset($ch['click'])){
                $surl = '@click="'.$ch['click'].'"';
            }else{
                $surl = (isset($ch['url']))?url($ch['url']):'#';
                $surl = 'href="'.$surl.'"'.$target;
            }
            $badge = $ch['badge'] ?? '';

            //$surl = (isset($ch['url']))?url($ch['url']):'';

            if(isset( $ch['auth'] ) && !is_null($roleEntity)){
                if($roleEntity->can('read', $ch['auth'] , $roleId)){
                    $gc[] = sprintf($subitem, $surl, __($ch['title']), $badge, $badge );
                }
            }else{
                $gc[] = sprintf($subitem, $surl, __($ch['title']), $badge, $badge );
            }


        }
        $gc[] = '</ul>';

        return $gc;
    }

}
