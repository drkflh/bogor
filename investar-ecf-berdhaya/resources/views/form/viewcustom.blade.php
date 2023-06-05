<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/01/20
 * Time: 17.32
 */

$form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toViewWithKey('name');

$form_page = \App\Helpers\Util::loadResYaml($yml_layout_file,$res_path)->viewWithLayout($form_fields) ;

print implode("\r\n", $form_page);

?>
