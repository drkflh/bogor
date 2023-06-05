<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dcs\Scoring;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Dcs\Scoring\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/dcs/scoring';

        $this->yml_file = 'question_controller';

        $this->entity = 'Question';

        $this->auth_entity = 'scoring-question';

        $this->controller_base = 'dcs/scoring/question';

        $this->view_base = 'dcs.scoring.question';

        $this->defOrderField = 'seq';

        $this->defOrderDir = 'asc';

        $this->model = new Question();
    }

    public function getIndex()
    {
        $this->title = 'Scoring Question';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dcs.scoring.question.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'dcs.scoring.question.view_layout';
        $this->viewer_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_multi_clone = false;
        $this->can_multi_delete = true;
        $this->can_clone = true;
        $this->can_delete = false;
        $this->can_upload = true;
        $this->can_print = true;

        $this->non_closing_save = true;

        $this->table_grouped = true;

        $this->title_fields = 'question';

        return parent::getIndex();
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['questionTypeOptions'] = [
            ['text'=>'Radio', 'value'=>'radioselect'],
            ['text'=>'Checkbox', 'value'=>'checkboxselect'],
            ['text'=>'Text', 'value'=>'text'],
            ['text'=>'Text', 'value'=>'textarea'],
            ['text'=>'Number', 'value'=>'number'],
            ['text'=>'Tristate', 'value'=>'tristate'],
            ['text'=>'Date', 'value'=>'datepicker'],
            ['text'=>'Datetime', 'value'=>'datetimepicker'],
            ['text'=>'Sign Pad', 'value'=>'signpad'],
            ['text'=>'File Upload', 'value'=>'attachmentupload'],
        ];

        $formOptions['remarkTypeOptions'] = [
            ['text'=>'Radio', 'value'=>'radioselect'],
            ['text'=>'Checkbox', 'value'=>'checkboxselect'],
            ['text'=>'Text', 'value'=>'text'],
            ['text'=>'Text', 'value'=>'textarea'],
            ['text'=>'Number', 'value'=>'number'],
            ['text'=>'Tristate', 'value'=>'tristate'],
            ['text'=>'Date', 'value'=>'datepicker'],
            ['text'=>'Datetime', 'value'=>'datetimepicker'],
            ['text'=>'Sign Pad', 'value'=>'signpad'],
            ['text'=>'File Upload', 'value'=>'attachmentupload'],
        ];

        $formOptions['runFormData'] = '{}';
        $formOptions['runFormContent'] = "''";
        $formOptions['runFormTemplate'] = "''";
        $formOptions['runFormModel'] = '{}';
        $formOptions['runFormDefault'] = '{}';
        $formOptions['runFormCode'] = "''";
        $formOptions['runFormId'] = "''";

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }


    public function additionalQuery($model, Request $request)
    {
        $model = $model->whereNotIn( 'lineType', ['info', 'section', 'category'] )
                    ->orderBy('formCode', 'asc')
                    ->orderBy('seq', 'asc');
        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }


    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function postIndex(Request $request)
    {
        $this->with_workflow = false;
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

    public function externalData($data, $request)
    {
        $temp = [];

        for($i = 0; $i < count($data); $i++ ){
            if(isset($data[$i]['formCode'])){
                $label = $data[$i]['formCode'];
                $temp[ $label ][] = $data[$i];
            }else{
                $temp[ 'Ungrouped' ][] = $data[$i];
            }
        }

        $out = [];
        foreach($temp as $k=>$v){
            $out[] = [
                'label'=>$k,
                'mode'=>'span',
                'children'=>$v
            ];
        }

        return $out;
    }

    public function beforeImportCommit($data)
    {

        $data['score1'] = $data['score1'] ?? 0;
        $data['score2'] = $data['score2'] ?? 0;
        $data['score3'] = $data['score3'] ?? 0;
        $data['score4'] = $data['score4'] ?? 0;
        $data['score5'] = $data['score5'] ?? 0;
        $data['defaultScore'] = $data['defaultScore'] ?? 0;

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


}
