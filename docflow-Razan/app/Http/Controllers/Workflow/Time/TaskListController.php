<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Workflow\Time;

use App\Helpers\App\CentralUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\TimeUtil;
use App\Helpers\Util;
use App\Helpers\WorkflowUtil;
use App\Http\Controllers\Core\AdminController;
use App\Models\Central\Project\Project;
use App\Models\Central\Project\Task;
use App\Models\Core\Mongo\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Core\Mongo\Role;
use Illuminate\Support\Facades\Hash;

class TaskListController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/workflow/time';

        $this->yml_file = 'tasklist_controller';

        $this->entity = 'Task';

        $this->auth_entity = 'time-task';

        $this->controller_base = 'workflow/time/task-list';

        $this->view_base = 'workflow.time.tasklist';

        $this->model = new Task();

        $this->numbering_field = 'taskCode';

        $this->numbering_prefix = 'TSK-';

        $this->sequence_bounds = [];

        $this->sequence_pad = 3;
    }

    public function getIndex()
    {
        $this->title = 'Task List';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'workflow.time.tasklist.form_layout';
        $this->form_dialog_size = 'xl';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'workflow.time.tasklist.view_layout';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->with_workflow = true;
        $this->with_revision = false;

        $this->extra_query['projectFilter'] = '';
        $this->extra_query['projectStatusFilter'] = '';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['assignedToOptions'] = CentralUtil::toOptions(WorkflowUtil::getPersonnel(),'name','_id', false);
        $formOptions['progressStatusOptions'] = config('util.task_progress_status_list') ;
        $formOptions['progressStatusFilterOptions'] = array_merge([ [ 'text'=>'all','value'=>''] ] ,config('util.task_progress_status_list')) ;
        $formOptions['projectNameOptions'] = CentralUtil::toOptions(WorkflowUtil::getProjectName(),'projectName','projectName', false);
        $formOptions['projectCodeOptions'] = CentralUtil::toOptions(WorkflowUtil::getProjectNameByRole(),'projectName','projectName', true);
        $formOptions['taskTypeOptions'] = CentralUtil::toOptions(WorkflowUtil::getTaskType(),'name','name', false);

        $formOptions['approvalStatusOptions'] = config('util.approval_status_list');

        $this->table_grouped = true;
        $this->aux_data = $formOptions;

        $this->update_title_fields = '"<h4>'.__('Edit').' " + this.taskName + "</h4>" ';

        return parent::getIndex();
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function afterSave($data)
    {
        CentralUtil::log($data);

        return parent::afterSave($data);
    }

    public function beforeUpdate($id, $data)
    {
        CentralUtil::log($data);

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }


    public function getParam()
    {
        if(request()->has('projectName')){
            $projectName = request()->get('projectName');

            $project = Project::where('projectName', '=', trim($projectName))->pluck('_id')->first();

            if($project){
                $this->def_param['projectId'] = $project;
            }
        }

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

    public function additionalQuery($model, Request $request)
    {
        $filter = $request->get('extraData');

        $auth = Auth::user();
        if($auth->roleName == 'Developer' || $auth->roleName == 'Intern'){
            $model = $model->where('assignedTo.text',$auth->name)->orderBy('projectName', 'asc');
        }

        if(isset($filter['projectFilter']) && $filter['projectFilter'] != '' ){
            $model = $model->where('projectName', '=', $filter['projectFilter'] );
        }

        if(isset($filter['projectStatusFilter']) && $filter['projectStatusFilter'] != '' ){
            $model = $model->where('progressStatus', '=', $filter['projectStatusFilter'] );
        }

        $model = $model->orderBy('projectName', 'asc');

        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function postApprovalRequest(Request $request)
    {
        $this->approval_title_field = 'taskName';
        $this->approval_description_field = 'taskDescription';
        return parent::postApprovalRequest($request); // TODO: Change the autogenerated stub
    }

    public function externalData($data, $request)
    {
        $temp = [];

        for($i = 0; $i < count($data); $i++ ){
            $label = $data[$i]['projectName'];
            $temp[ $label ][] = $data[$i];
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

    public function postQuickAdd(Request $request)
    {
        $in = $request->all();

        $newTask = $this->model;

        foreach($in as $k=>$v){
            $newTask->{$k} = $v;
        }

        $newTask['assignedTo'] =[['text'=>Auth::user()->name,'value'=>Auth::user()->id]];
        $newTask['ownerName'] = Auth::user()->name;
        $newTask['ownerId'] = Auth::user()->id;

        $auth = Auth::user();
        $now = Carbon::now(date_default_timezone_get());
        if($auth->roleName == 'Superuser' || $auth->roleName == 'Supervisor' || $auth->roleName == 'PIC') {
            $newTask['approvalBy'] = $auth->name;
            $newTask['approvalAt'] = $now;
            $newTask['approvalStatus'] = "APPROVED";
        }



        if($newTask->save()){
            return response()->json([
                'result'=>'OK',
                'msg'=>'TASKSAVED'
            ]);
        }else{
            return response()->json([
                'result'=>'NOK',
                'msg'=>'FAILSAVED'
            ]);
        }


    }

    public function changeStat(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $pin = $request->get('pin');
        $note = $request->get('note');

        if( !Hash::check( $pin, Auth::user()->pin ) ){
            return response()->json( [
                'result'=>'ERR',
                'data'=> null,
                'message'=>'Wrong PIN'
            ], 200 );
        }

        if(Task::where('_id','=',$id)->update(['progressStatus' => $status,'note'=>$note]))
        {
            return response()->json([
                'result'=>'OK',
                'msg'=>'TASKSAVED'
            ]);
        }else{
            return response()->json([
                'result'=>'NOK',
                'msg'=>'FAILSAVED'
            ]);
        }
    }

}

