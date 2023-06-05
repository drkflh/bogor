<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/01/20
 * Time: 17.32
 */

$form_fields['_isCreate'] = $is_create;

if(strpos($yml_file,'_controller') === false){
    info('old yml', [$yml_file,$res_path] );
    $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toViewWithKey('name', $is_create);
    $form_page = \App\Helpers\Util::formWithBladeLayout($view_layout,$form_fields, $is_create) ;
}else{
    info('neo yml', [$yml_file,$res_path] );
    $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toViewElementWithKey('name', $is_create);
    $form_page = \App\Helpers\Util::formElementWithBladeLayout($view_layout,$form_fields, $is_create);
}

print $form_page;

?>
