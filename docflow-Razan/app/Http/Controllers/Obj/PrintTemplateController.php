<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Obj;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Cms\Article;
use App\Models\Cms\Category;
use App\Models\Cms\Section;
use App\Models\Core\Mongo\User;
use App\Models\Obj\PrintTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PrintTemplateController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        //$this->res_path = 'views/obj/printtemplate';
        //$this->yml_file = 'fields';

        $this->res_path = 'models/controllers/obj';
        $this->yml_file = 'printtemplate_controller';

        $this->entity = 'Print Template';
        $this->auth_entity = 'print-template';

        $this->controller_base = 'obj/print-template';
        $this->view_base = 'obj.printtemplate';

        $this->model = new PrintTemplate();
    }

    /**
     * @hideFromAPIDocumentation
     * @return mixed
     */
    public function getIndex()
    {
        $this->title = 'Print Template';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        //$this->nav_section = 'assets';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->runUrlSet();
        $this->runAcl();
        $this->runViewSet();

        $this->can_clone = true;

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'obj.printtemplate.formlayout';

        /* Use custom form layout
        *  default to form.flatgrid
        *  change form_view & view_layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'obj.printtemplate.formlayout';
        $this->form_dialog_size = 'fs';


        /* slot view for cell formating
        */
        //$this->table_slot_view = 'loyalty.reference/productcategory.tableslot';
         // use injector to provide options for simpleselect / localselect
         $uiOptions =[];
         $uiOptions = Injector::setModel( Category::orderBy('categoryCode') ) // gunakan model sebagai input, set query disini
         ->toModelArray() // akan running query dan menghasilkan array object
         ->toOptions('categoryName', 'categoryCode', true) // jadikan option untuk select
         ->injectOption('category', $uiOptions); // inject ke uioptions, gunakan nama field biasa tanpa suffix, suffix & prefix akan dihandle di fungsi injectOption

         $uiOptions = Injector::setModel( Section::orderBy('sectionCode') ) // gunakan model sebagai input, set query disini
         ->toModelArray() // akan running query dan menghasilkan array object
         ->toOptions('sectionName', 'sectionCode', true) // jadikan option untuk select
         ->injectOption('section', $uiOptions); // inject ke uioptions, gunakan nama field biasa tanpa suffix, suffix & prefix akan dihandle di fungsi injectOption

        $uiOptions['docListItemTemplate'] = '`'.file_get_contents( resource_path('views/obj/printtemplate/item_template.html') ).'`';


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['headerFooterSettingOptions'] = [
            [ 'text'=>'First Page Only Header', 'value'=>'First Page Only Header' ],
            [ 'text'=>'First Page Only Footer', 'value'=>'First Page Only Footer' ],
            [ 'text'=>'First Page No Header', 'value'=>'First Page No Header' ],
            [ 'text'=>'First Page No Footer', 'value'=>'First Page No Footer' ],
            [ 'text'=>'No First Page Number', 'value'=>'No First Page Number' ],
            [ 'text'=>'No Page Number', 'value'=>'No Page Number' ],
            [ 'text'=>'Full Footer', 'value'=>'Full Footer' ],
        ];
        $formOptions['headerSettingOptions'] = [
            [ 'text'=>'First Page Header', 'value'=>'First Page Header' ],
            [ 'text'=>'With Header', 'value'=>'With Header' ],
        ];
        $formOptions['footerSettingOptions'] = [
            [ 'text'=>'First Page Footer', 'value'=>'First Page Footer' ],
            [ 'text'=>'With Footer', 'value'=>'With Footer' ],
            [ 'text'=>'Full Footer', 'value'=>'Full Footer' ],
        ];

        $formOptions['numberSettingOptions'] = [
            [ 'text'=>'First Page Number', 'value'=>'First Page Number' ],
            [ 'text'=>'With Page Number', 'value'=>'With Page Number' ],
        ];

        $formOptions['numberPositionOptions'] = [
            [ 'text'=>'Left', 'value'=>'Left' ],
            [ 'text'=>'Center', 'value'=>'Center' ],
            [ 'text'=>'Right', 'value'=>'Right' ],
        ];
        $formOptions['firstNumberPositionOptions'] = [
            [ 'text'=>'Left', 'value'=>'Left' ],
            [ 'text'=>'Center', 'value'=>'Center' ],
            [ 'text'=>'Right', 'value'=>'Right' ],
        ];

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->view_title_fields = 'this.title';
        $this->update_title_fields = "'<h4>Edit ' + this.title + '</h4>'";
        $this->non_closing_save = true;

        return parent::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        return $model;
    }

    public function beforeSave($data)
    {
        $template = "@extends('layouts.print')\r\n@section('content')\r\n".$data['body']."\r\n@endsection";

        $template .= "\r\n@section('headLeft')\r\n".$data['headLeft']."\r\n@endsection\r\n@section('headRight')\r\n".$data['headRight']."\r\n@endsection";
        $template .= "\r\n@section('footerLeft')\r\n".$data['footerLeft']."\r\n@endsection\r\n@section('footerCenter')\r\n".$data['footerCenter']."\r\n@endsection";

        $data['template'] = $template;

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {
        $template = "@extends('layouts.print')\r\n@section('content')\r\n".$data['body']."\r\n@endsection";

        $template .= "\r\n@section('headLeft')\r\n".$data['headLeft']."\r\n@endsection\r\n@section('headRight')\r\n".$data['headRight']."\r\n@endsection";
        $template .= "\r\n@section('footerLeft')\r\n".$data['footerLeft']."\r\n@endsection\r\n@section('footerCenter')\r\n".$data['footerCenter']."\r\n@endsection";

        $data['template'] = $template;

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }
}
