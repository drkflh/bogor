<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Workflow\Approval;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Workflow\ApprovalRequest;
use App\Models\Core\Mongo\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApprovalRequestController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/workflow';

        $this->yml_file = 'approvalrequest_controller';

        $this->entity = 'Approval Request';

        $this->auth_entity = 'approval-request';

        $this->controller_base = 'workflow/approval/approval-request';

        $this->view_base = 'workflow.approval.approvalrequest';

        $this->model = new ApprovalRequest();
    }

    public function getIndex()
    {
        $this->title = 'Approval Request';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'workflow.approval.approvalrequest.form_layout';
        $this->form_dialog_size = 'xl';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'workflow.approval.approvalrequest.view_layout';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_add = false;
        $this->can_update = true;
        $this->can_upload = false;
        $this->can_delete = false;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_multi_delete = false;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['approverDecisionOptions'] = config('util.approval_status_list');

        $formOptions['approverDecisionListFields'] = [
            'label'=>'Name', 'key'=>'approverName',
            'label'=>'Decision', 'key'=>'approverDecision',
        ];

        $this->aux_data = $formOptions;

        $this->add_filler = true;

        $this->add_title_fields = '"<h4> Add '.__($this->entity).'</h4>"';
        $this->view_title_fields = '"'.__('View').'"  + " " + this.entity + ": " + this.docTitle';
        $this->update_title_fields = '"'.__('Approve').'" +  " " + this.entity + ": " + this.docTitle';

        return parent::getIndex();
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {
        if(!isset($data['approverDecisionList'])){
            $data['approverDecisionList'] = [];
        }

        $ts = Carbon::now($data['tz'])->shiftTimezone('UTC')->toDateTimeString();

        $data['approverDecisionList'][] = [
            'approverId' => Auth::user()->id,
            'approverName' => Auth::user()->name,
            'approverDecision' => $data['approverDecision']['value'],
            'approverNote' => $data['approverNote'],
            'approverPin' => $data['approverPin'],
            'approverSignature' => $data['approverSignature'],
            'approverTime' => $ts,
            'approverTz' => $data['tz']
        ];

        $data['approverDecision'] = [];
        $data['approverNote'] = '';
        $data['approverPin'] = '';
        $data['approverSignature'] = '';

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

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

}
