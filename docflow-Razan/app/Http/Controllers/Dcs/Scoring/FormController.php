<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dcs\Scoring;

use App\Helpers\AuthUtil;
use App\Helpers\DcsUtil;
use App\Helpers\ImportUtil;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Cms\Article;
use App\Models\Dcs\Admin\Category;
use App\Models\Dcs\Admin\Section;
use App\Models\Core\Mongo\User;
use App\Models\Dcs\Scoring\CollectedResult;
use App\Models\Dcs\Scoring\FormDefinition;
use App\Models\Obj\PrintTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/dcs/scoring';

        $this->yml_file = 'form_controller';

        $this->entity = 'Form';

        $this->auth_entity = 'scoring-form';

        $this->controller_base = 'dcs/scoring/form';

        $this->view_base = 'dcs.scoring.form';

        $this->model = new FormDefinition();
    }

    public function getIndex()
    {
        $this->title = 'Form Library';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dcs.scoring.form.form_layout';
        $this->form_dialog_size = 'fs';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'dcs.scoring.form.view_layout';
        $this->viewer_dialog_size = 'fs';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_multi_clone = false;
        $this->can_multi_delete = true;
        $this->can_clone = true;
        $this->can_delete = true;
        $this->can_upload = true;
        $this->can_print = false;

        /* slot view for cell formating
        */
        //$this->table_slot_view = 'loyalty.reference/productcategory.tableslot';
        // use injector to provide options for simpleselect / localselect
        $uiOptions =[];

        $uiOptions = Injector::setObject('formQuestions') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                [ 'label'=>'Product', 'key'=>'ProductID', 'class'=>'text-100' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Descriptions', 'key'=>'Descriptions', 'class'=>'text-200', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'Unit Price', 'key'=>'UnitPrice', 'class'=>'text-150 text-right', 'type'=>'Number', 'format'=>'currency' , 'validator'=>'required' ],
                [ 'label'=>'Amount Ordered', 'key'=>'AmountOrdered', 'class'=>'text-150 text-right', 'type'=>'Number', 'format'=>'currency' , 'validator'=>'' ]
            ]
        )->setObjDef( // set object default
            [
                'ProductID'=>'',
                'Descriptions'=>'',
                'Notes'=>'',
                'Delivery'=> 0,
                'Period'=>'',
                'QTY'=> 0,
                'uom'=> '',
                'UnitPrice'=> 0,
                'AmountOrdered'=> 0
            ]
        )->setObjParams(
            [
                'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
            ->setObjTemplate(file_get_contents( resource_path('views/sms/procurementlogistic/purchaserequisition/doc.html') )) // set template
            ->injectObject($uiOptions); // inject



        $uiOptions = Injector::setModel( Category::orderBy('categoryCode') ) // gunakan model sebagai input, set query disini
        ->toModelArray() // akan running query dan menghasilkan array object
        ->toOptions('categoryName', 'categoryCode', true) // jadikan option untuk select
        ->injectOption('category', $uiOptions); // inject ke uioptions, gunakan nama field biasa tanpa suffix, suffix & prefix akan dihandle di fungsi injectOption

        $uiOptions = Injector::setModel( Section::orderBy('sectionCode') ) // gunakan model sebagai input, set query disini
        ->toModelArray() // akan running query dan menghasilkan array object
        ->toOptions('sectionName', 'sectionCode', true) // jadikan option untuk select
        ->injectOption('section', $uiOptions); // inject ke uioptions, gunakan nama field biasa tanpa suffix, suffix & prefix akan dihandle di fungsi injectOption

        //$uiOptions['docListItemTemplate'] = '`'.file_get_contents( resource_path('views/dcs/scoring/form/item_template.html') ).'`';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['accessOptions'] = [['text'=>'Private', 'value'=>'private' ], ['text'=>'Public', 'value'=>'public' ]];
        $formOptions['statusOptions'] = [['text'=>'Active', 'value'=>'Active' ], ['text'=>'Inactive', 'value'=>'Inactive' ]];
        $formOptions['layoutOptions'] = [['text'=>'Linear', 'value'=>'Linear' ], ['text'=>'Custom', 'value'=>'Custom' ]];

        $formOptions['runFormData'] = '{}';
        $formOptions['runFormContent'] = "''";
        $formOptions['runFormTemplate'] = "''";
        $formOptions['runFormModel'] = '{}';
        $formOptions['runFormDefault'] = '{}';
        $formOptions['runFormCode'] = "''";
        $formOptions['runFormId'] = "''";

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

//        $this->view_title_fields = 'this.formCode';
//        $this->update_title_fields = 'this.formCode';
        $this->non_closing_save = true;

        return parent::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        return $model;
    }

    public function beforeUpdateForm($population)
    {
        $population['questions'] = DcsUtil::getQuestions($population['formCode']);

        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }


    public function getParam()
    {
        $this->def_param['validFrom'] = date('Y-m-d H:i:s', time());
        $this->def_param['validUntil'] = date('Y-m-d H:i:s', time());
        $this->def_param['access'] = [ 'text'=>'Private', 'value'=>'private'];
        $this->def_param['status'] = 'Active';
        $this->def_param['layout'] = 'Linear';
        $this->def_param['formHeader'] = [ 'text'=>'No Header', 'value'=>'noHeader'];
        $this->def_param['formFooter'] = [ 'text'=>'No Footer', 'value'=>'noFooter'];
        $this->def_param['formQuestions'] = [
                    [
                        'key' => 1,
                        'class' => 'item-block section',
                        'text' => 'Section',
                        'children' => [[
                        'key' => 2,
                            'class' => 'item-block category',
                            'text' => 'Category',
                            'children' => [
                                [
                                    'key' => 3,
                                    'class' => 'item-block item',
                                    'text' => 'Item 1'
                                ],
                                [
                                    'key' => 4,
                                    'class' => 'item-block item',
                                    'text' => '<h6>Title 2</h6><p>Looooong description</p>'
                                ],
                            ]
                        ]]
                    ]
                ];

        return parent::getParam(); // TODO: Change the autogenerated stub
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

    public function postFormDef(Request $request)
    {
        $form = $request->all();
        $questions = DcsUtil::getQuestions($form['formCode']);
        $tmpl = [];
        $index = 1;
        $model = [];
        $objDef = [];

        foreach ($questions as $q){
            $label = $q['question'];
            $mdl = 'question'.$index;
            $el['model'] = 'value.'.$mdl;
            $el['name'] = 'question'.$index;
            $el['type'] = $q['questionType'];
            $el['edit'] = false;
            $el['create'] = true;
            $el['inline'] = false;
            $opt = [];

            $model[$mdl] = $q['defaultAnswer'] ?? '';
            $objDef[$mdl] = $q['defaultAnswer'] ?? '';
            if($el['type'] == 'checkboxselect'){
                $model[$mdl] = [$q['defaultAnswer'] ?? '' ];
                $objDef[$mdl] = [$q['defaultAnswer'] ?? '' ];
            }
            if($el['type'] == 'number'){
                $el['class'] = 'text-150';
            }

            for( $i = 1; $i < 6; $i++ ){
                if($q['answer'.$i] != ''){
                    $opt[] = [ 'value'=>$q['answer'.$i], 'text'=>$q['answer'.$i] ];
                }
            }
            $model[$mdl.'Options'] = $opt;
            $tmpl[] = Util::staticFormElement( $el['type'], $label, $el );

            $index++;
        }

        $template = '<div>'.implode('', $tmpl).'</div>';

        return response()->json(
            [
                'result'=>'OK',
                'message'=>'Form Def',
                'data'=>[
                    'template'=>$template,
                    'model'=>$model,
                    'default'=>$objDef
                ]
            ],
            200
        );

    }

    public function postFormSave(Request $request)
    {
        $data = $request->all();

        $model = new CollectedResult();
        foreach ($data as $k=>$v){
            $model->{$k} = $v;
        }

        $model->ownerId = Auth::user()->id;
        $model->ownerName = Auth::user()->name;

        if($obj = $model->save()){
            return response()->json(
                [
                    'result'=>'OK',
                    'message'=>'Form data saved successfully',
                    'data'=>[]
                ],
                200
            );
        }else{
            return response()->json(
                [
                    'result'=>'NOK',
                    'message'=>'Failed to save data',
                    'data'=>[]
                ],
                415
            );

        }
    }

    public function getFormPage(Request $request, $id)
    {
        $this->res_path = 'models/controllers/dcs/scoring';
        $this->yml_file = 'form_page_controller';

        $this->view_base = 'dcs.scoring.form.page';


        $this->model = new FormDefinition();

        $id = $id ?? Auth::user()->id;

        $form = $this->model->find($id);

        if($form){

        }else{
            $form = $this->model->where('slug','=', $id)->orWhere('formCode','=',$id)->first();

        }

        $this->runPageViewSet();

        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'user/add';

        $this->update_url = 'user/edit';

        $this->item_id = $id;

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_layout = 'dcs.scoring.form.page.formlayout_profile';

        $this->form_mode = 'edit';

        $this->can_lock = false;

        $this->can_save = true;

        $this->print_template = [
            [
                'template'=>'user-detail',
                'modal'=>'xl',
                'label'=>'Print Detail'
            ],
            [
                'template'=>'user-card',
                'modal'=>'xl',
                'label'=>'Print Card'
            ]
        ];

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        $this->aux_data = $formOptions;

        return parent::formGenerator();
    }

}
