<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/01/20
 * Time: 17.32
 */

$form_fields['_isCreate'] = $is_create;

if(strpos($yml_file,'_controller') === false){
    $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormWithKey('name', $is_create);
    $form_page = \App\Helpers\Util::formWithBladeLayout($form_layout,$form_fields, $is_create) ;
}else{
    $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormElementWithKey('name', $is_create);
    $form_page = \App\Helpers\Util::formElementWithBladeLayout($form_layout,$form_fields, $is_create) ;
}


print $form_page;

?>
