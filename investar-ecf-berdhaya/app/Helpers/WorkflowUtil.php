<?php


namespace App\Helpers;

use App\Models\Sms\SalesOperation\JobRegister;
use App\Models\Core\Mongo\User;
use App\Models\Pmc\Client;
use App\Models\Pmc\Reference\TaskType;
use App\Models\Pmc\Project;
use App\Models\Pmc\Task;
use App\Models\Pmc\Reference\ProjectType;
use App\Models\Workflow\Time\SpentTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkflowUtil
{
    public static function getCurrentAttStatus(){
        if( Auth::check()){
            $trclock = SpentTime::where('userId', '=', Auth::user()->_id)
                ->where('event','=','CLOCK_IN')
                ->where('isActive','=',true)
                ->orderBy('createdAt','desc')->first();
            if($trclock){
                return ($trclock->attStatus ?? 'OUT');
            }else{
                return 'OUT';
            }
        }else{
            return 'OUT';
        }
    }
    public static function getDefaultApproverIds()
    {
        $apprs = User::get();
        foreach ($apprs as $a){
            $obj = [
                'text'=>$a->name,
                'value'=>$a->_id
            ];
            $approvers[] = $obj;
        }

        return $approvers;
    }

    public static function getDefaultApprovers()
    {
        $apprs = User::get();
        foreach ($apprs as $a){
            $obj = [
                'text'=>$a->name,
                'value'=> [
                        '_id'=>$a->_id,
                        'email'=>$a->email,
                        'name'=>$a->name,
                        'username'=>$a->username,
                        'employeeId'=>($usr->employeeId ?? ''),
                        'jobTitle'=>($a->jobTitle ?? ''),
                        'jobTitleCode'=>($a->jobTitleCode ?? ''),
                        'avatar'=>$a->avatar,
                        'seq'=>( $a->jobTitleSeq ?? '000' ) ,
                        'dataType'=>'person'
                    ]
            ];
            $approvers[] = $obj;
        }

        return $approvers;
    }

    public static function getDefaultApproverMap()
    {
        $apprs = User::get();
        foreach ($apprs as $a){
            $obj = [
                'text'=>$a->name,
                'value'=> [
                        '_id'=>$a->_id,
                        'email'=>$a->email,
                        'name'=>$a->name,
                        'username'=>$a->username,
                        'employeeId'=>($usr->employeeId ?? ''),
                        'jobTitle'=>($a->jobTitle ?? ''),
                        'jobTitleCode'=>($a->jobTitleCode ?? ''),
                        'avatar'=>$a->avatar,
                        'seq'=>( $a->jobTitleSeq ?? '000' ) ,
                        'dataType'=>'person'
                    ]
            ];
            $approvers[$a->_id] = $obj;
        }

        return $approvers;
    }

    public static function getRoleApproverIds($roleName)
    {
        $roleId = AuthUtil::getRoleId($roleName);
        $apprs = User::where('roleId', '=', $roleId )->get();
        $approvers=[];
        // $apprs = User::get();
        foreach ($apprs as $a){
            $obj = [
                'text'=>$a->name,
                'value'=>$a->_id
            ];
            $approvers[] = $obj;
        }

        return $approvers;
    }

    public static function getRoleApprovers()
    {
        $apprs = User::get();
        foreach ($apprs as $a){
            $obj = [
                'text'=>$a->name,
                'value'=> [
                        '_id'=>$a->_id,
                        'email'=>$a->email,
                        'name'=>$a->name,
                        'username'=>$a->username,
                        'employeeId'=>($usr->employeeId ?? ''),
                        'jobTitle'=>($a->jobTitle ?? ''),
                        'jobTitleCode'=>($a->jobTitleCode ?? ''),
                        'avatar'=>$a->avatar,
                        'seq'=>( $a->jobTitleSeq ?? '000' ) ,
                        'dataType'=>'person'
                    ]
            ];
            $approvers[] = $obj;
        }

        return $approvers;
    }

    public static function getRoleApproverMap($roleName)
    {
        $roleId = AuthUtil::getRoleId($roleName);
        $apprs = User::where('roleId', '=', $roleId )->get();
        $approvers=[];

        foreach ($apprs as $a){
            $obj = [
                'text'=>$a->name,
                'value'=> [
                        '_id'=>$a->_id,
                        'email'=>$a->email,
                        'name'=>$a->name,
                        'username'=>$a->username,
                        'employeeId'=>($usr->employeeId ?? ''),
                        'jobTitle'=>($a->jobTitle ?? ''),
                        'jobTitleCode'=>($a->jobTitleCode ?? ''),
                        'avatar'=>$a->avatar,
                        'seq'=>( $a->jobTitleSeq ?? '000' ) ,
                        'dataType'=>'person'
                    ]
            ];
            $approvers[$a->_id] = $obj;
        }

        return $approvers;
    }

    public static function getDefaultApproverObjects()
    {
        $apprs = User::get();
        foreach ($apprs as $a){
            $obj = [
                '_id'=>$a->_id,
                'email'=>$a->email,
                'name'=>$a->name,
                'username'=>$a->username,
                'employeeId'=>($usr->employeeId ?? ''),
                'jobTitle'=>($a->jobTitle ?? ''),
                'jobTitleCode'=>($a->jobTitleCode ?? ''),
                'avatar'=>$a->avatar,
                'seq'=>( $a->jobTitleSeq ?? '000' ) ,
                'dataType'=>'person'
            ];
            $approvers[] = $obj;
        }

        return $approvers;
    }

    public static function getUserObject($usr, $isObject = true)
    {
        if($isObject){
            return [
                '_id'=>$usr->_id,
                'email'=>$usr->email,
                'name'=>$usr->name,
                'username'=>$usr->username,
                'employeeId'=>($usr->employeeId ?? ''),
                'jobTitle'=>($usr->jobTitle ?? ''),
                'jobTitleCode'=>($usr->jobTitleCode ?? ''),
                'avatar'=>$usr->avatar,
                'seq'=>( $usr->jobTitleSeq ?? '000' ) ,
                'dataType'=>'person'
            ];
        }else{
            return [
                '_id'=>$usr['_id'],
                'email'=>$usr['email'],
                'name'=>$usr['name'],
                'username'=>$usr['username'],
                'employeeId'=>($usr['employeeId'] ?? ''),
                'jobTitle'=>($usr['jobTitle'] ?? ''),
                'jobTitleCode'=>($usr['jobTitleCode'] ?? ''),
                'avatar'=>$usr['avatar'],
                'seq'=>( $usr['jobTitleSeq'] ?? '000' ) ,
                'dataType'=>'person'
            ];
        }
    }

    public static function getTask()
    {
        $task = Task::get();
        return $task;
    }

    public static function getIssueTaskOptions()
    {
        $data = [];
        $data = [
            [ 'text'=>'Error Report', 'value'=>'Error Report' ],
            [ 'text'=>'User Finding & Request', 'value'=>'User Finding & Request' ]
        ];

        return $data;
    }

    public static function getProjectTasks()
    {
        $user = null;
        if(Auth::check()){
            $user = Auth::user();
        }else{
            return [];
        }
        /**
         * TODO : buat query untuk mendapatkan projek dan task untuk user, dibentuk menjadi struktyur array data spt contoh dibawah
         */
        $coyTask = Task::where('assignedTo.value','=',$user->_id)
                        ->whereNotIn('progressStatus', ['Closed', 'CLOSED', 'READY_TO_TEST', 'Ready to Test'])
                        ->get()
                        ->groupBy('projectName');
        $data = [];
        $data[] = [ 'text'=>'General', 'value'=>'General' ];

        foreach($coyTask as $k => $v){
            $coy = [];
            foreach($v as $r){
                $coy[] =
                [
                    'text'=>$r['taskName'], 'value'=>$r['projectName'].":".$r['taskName']
                ];
            }
            $data[] =
            [
                'label'=>$k,
                'options'=> $coy
            ];
        }

        return $data;

    }

    public static function getSupervisor()
    {
        $auth = Auth::user();
        if ($auth->roleName == 'Supervisor') {
            $sv = User::where('_id', $auth->_id)->get();
        }
        else {
            $sv = User::whereIn('roleName', ['Supervisor', 'Superuser'])->get();
        }

        return $sv;
    }

    public static function getPIC()
    {
        $auth = Auth::user();
        if ($auth->roleName == 'PIC') {
            $sv = User::where('_id', $auth->_id)->get();
        }
        else {
            $sv = User::whereIn('roleName', ['PIC', 'Superuser'])->get();
        }

        return $sv;
    }

    public static function getUser()
    {
        $auth = Auth::user();
        $sv = User::where('_id', $auth->_id)->first();

        return $sv->useTimeTracker;
    }

    public static function getPersonnel(){
        $role = Auth::user()->roleName;
        $id = Auth::user()->_id;
        if ($role == 'Developer' || $role == 'Intern') {
            $coy = User::where('_id', $id)->get();
        }
        else {
            $coy = User::get();
        }

        return $coy;
    }

    public static function getClient(){
        $coy = Client::get();

        return $coy;
    }

    public static function getTaskId(){
        $task = Task::get();

        return $task;
    }

    public static function getProjectType(){
        $coy = ProjectType::get();

        return $coy;
    }

    public static function getProjectName(){
        $coy = JobRegister::where('jobStatus','!=','Closed')->get();
        return $coy;
    }

    public static function getProjectNameByRole(){

        $auth = Auth::user();

        if($auth->roleName == 'Supervisor'){
            $prj = Project::where('projectSupervisor.value', $auth->_id)
                        ->whereNotIn('progressStatus',['CLOSED', 'SUSPENDED'])->get();

        } else if($auth->roleName == 'PIC'){
            $prj = Project::where('projectPIC.value', $auth->_id)
                        ->whereNotIn('progressStatus',['CLOSED', 'SUSPENDED'])->get();

        } else if($auth->roleName == 'QA Tester' || $auth->roleName == 'Developer' || $auth->roleName == 'Intern'){
            $prj = Project::where('projectPersonnel.value', $auth->_id)
                        ->whereNotIn('progressStatus',['CLOSED', 'SUSPENDED'])->get();
        }

        $prj = Project::whereNotIn('progressStatus',['CLOSED', 'SUSPENDED'])->get();


        return $prj;
    }

    public static function getProjectNameQuickTask(){
        $user = null;
        if(Auth::check()){
            $user = Auth::user();
        }else{
            return [];
        }

        $project = JobRegister::where('jobStatus','!=','Closed')
            ->orderBy('urut', 'desc')
            ->get();
        $coy[] = [ 'text'=>'General', 'value'=>'General' ];
        foreach ($project as $r){
            $coy[] = ['text'=>$r['jobNo'].' '.$r['project'],'value'=>$r['jobNo'].' '.$r['project']];
        }

        return $coy;
    }

    public static function getTaskType(){
        $coy = TaskType::get();

        return $coy;
    }

}
