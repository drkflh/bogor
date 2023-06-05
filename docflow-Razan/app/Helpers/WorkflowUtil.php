<?php


namespace App\Helpers;

use App\Models\Sms\SalesOperation\JobRegister;
use App\Models\Core\Mongo\User;
use App\Models\Pmc\Client;
use App\Models\Pmc\Reference\TaskType;
use App\Models\Pmc\Project;
use App\Models\Pmc\Task;
use App\Models\Pmc\Reference\ProjectType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkflowUtil
{
    public static function getDefaultApprovers()
    {
        $apprs = User::get();
        foreach ($apprs as $a){
            $obj = [
//                'key'=>$a->_id,
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

    public static function getTester()
    {
        $auth = Auth::user();
        if ($auth->roleName == 'QA Tester') {
            $sv = User::where('_id', $auth->_id)->get();
        }
        else {
            $sv = User::whereIn('roleName', ['QA Tester', 'Superuser'])->get();
        }

        return $sv;
    }

    public static function getDeveloper()
    {
        $auth = Auth::user();
        if ($auth->roleName == 'Intern' || $auth->roleName == 'Developer') {
            $sv = User::where('_id', $auth->_id)->get();
        }
        else {
            $sv = User::whereIn('roleName', ['Intern', 'Developer', 'Superuser'])->get();
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
        if( env('WITH_SALES_PROJECT', true)){
            $coy = JobRegister::where('jobStatus','!=','Closed')->get();
        }else{
            $coy = Project::where('progressStatus','!=','CLOSED')->get();
        }
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

        if( env('WITH_SALES_PROJECT', true)){

            $project = JobRegister::where('jobStatus','!=','Closed')
                ->orderBy('urut', 'desc')
                ->get();
            $coy[] = [ 'text'=>'General', 'value'=>'General' ];
            foreach ($project as $r){
                $coy[] = ['text'=>$r['jobNo'].' '.$r['project'],'value'=>$r['jobNo'].' '.$r['project']];
            }

        }

        if( env('WITH_DEV_PROJECT', false)){

            $project = Task::whereNotIn('progressStatus', ['CLOSED', 'READY_TO_TEST']);
            if( !AuthUtil::isAdmin() ){
                $project = $project->where('assignedTo.value','=',$user->_id);
            }
            $project = $project->where('projectName','!=','General')
                ->groupBy('projectName')
                ->get();
            $coy[] = [ 'text'=>'General', 'value'=>'General' ];
            if($project){
                foreach ($project as $r){
                    $coy[] = [
                        'text'=>$r['projectName'], 'value'=>$r['projectName']
                    ];
                }
            }
        }

        return $coy;
    }

    public static function getTaskType(){
        $coy = TaskType::get();

        return $coy;
    }

}
