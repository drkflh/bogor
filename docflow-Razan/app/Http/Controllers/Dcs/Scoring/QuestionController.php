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

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        $formOptions['questionTypeOptions'] = [
            ['text'=>'Radio', 'value'=>'radioselect'],
            ['text'=>'Checkbox', 'value'=>'checkboxselect'],
            ['text'=>'Text', 'value'=>'text'],
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

        $this->aux_data = $formOptions;

//        $this->add_title_fields = '"<h4> Add A D L</h4>"';
//        $this->view_title_fields = '"Lihat"  + " " + this.question';
        //$this->update_title_fields = '"<h4>'.__('Edit').' + " " + this.question + "</h4>" ';

        return parent::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
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

}
