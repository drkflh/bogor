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
use App\Models\Workflow\Time\SpentTime;
use App\Models\Core\Mongo\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TimeTrackerController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/workflow/time';

        $this->yml_file = 'timetracker_controller';

        $this->entity = 'Time Record';

        $this->auth_entity = 'time-tracker';

        $this->controller_base = 'workflow/time/tracker';

        $this->view_base = 'workflow.time.timetracker';

        $this->model = new SpentTime();
    }

    public function getIndex()
    {
        $this->title = 'Time Tracker';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'workflow.time.timetracker.form_layout';
        $this->form_dialog_size = 'md';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'workflow.time.timetracker.view_layout';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_add = true;
        $this->can_multi_clone = false;
        $this->can_multi_delete = false;
        $this->can_print = true;
        $this->can_upload = true;

        $this->extra_query['userFilter'] = '';
        $this->extra_query['projectFilter'] = '';
        $this->extra_query['clientFilter'] = '';
        $this->extra_query['dateFilter'] = '';
        $this->extra_query['eventFilter'] = '';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['projectTaskOptions'] = \App\Helpers\WorkflowUtil::getProjectTasks();
        $formOptions['eventOptions'] = [
            [ 'text'=>'Clock / Attendance Record', 'value'=>'CLOCK_ADJ'],
            [ 'text'=>'Time Record', 'value'=>'TIMER_ADJ'],
        ];
        $formOptions['eventFilterOptions'] = [
            [ 'text'=>'All','value'=>''],
            [ 'text'=>'Clock / Attendance Record', 'value'=>'CLOCK'],
            [ 'text'=>'Time Record', 'value'=>'TIMER'],
        ];

        $formOptions['userNameOptions'] = CentralUtil::toOptions(WorkflowUtil::getPersonnel(),'name','name', false);
        $formOptions['projectFilterOptions'] = array_merge([ [ 'text'=>'all','value'=>''] , ['text'=>'General','value'=>'General']] ,CentralUtil::toOptions(WorkflowUtil::getProjectNameByRole(),'projectName','projectName', true));
        $formOptions['userFilterOptions'] = array_merge([ [ 'text'=>'NA','value'=>''] ] ,CentralUtil::toOptions(WorkflowUtil::getPersonnel(),'name','name', false));
        $formOptions['clientFilterOptions'] = array_merge([ [ 'text'=>'all','value'=>''] ] ,CentralUtil::toOptions(WorkflowUtil::getClient(),'clientName','clientId', false));

        $this->aux_data = $formOptions;

        $this->with_advanced_search = true;

        $this->print_template = [
            ['label'=>'Time Sheet','template'=>'time-sheet-template', 'modal'=>'xl'],
            ['label'=>'Summary','template'=>'time-summary-template', 'modal'=>'xl'],
        ];
        $this->print_modal_size = 'xl';

        $this->non_closing_save = true;

        $this->add_title_fields = '"<h4> Add Time Spent</h4>"';
        $this->view_title_fields = '"Lihat"  + " " + this.userName';
        $this->update_title_fields = '"Update" +  " " + this.namaLansia';

        return parent::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
        $adv = $request->get('advancedSearch') ?? false;
        $ext = $request->get('extraData') ?? false;
        if( $adv && $ext &&  (isset($adv['enable']) && $adv['enable']) && $adv['isOpen']){
            // query hanya dilakukan jika advanced search aktif dan panel terbuka
            $model = $this->advQuery($model , $ext);
        }

        if(!AuthUtil::isAdmin()){
            $model = $model->where('userId', '=', Auth::user()->id);
        }

        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function advQuery($model , $ext){

        if( isset($ext['eventFilter']) && ( $ext['eventFilter'] != '' || $ext['eventFilter'] != 'all' ) ){
            $model = $model->where('event','like',$ext['eventFilter'].'%');
        }
        if( isset($ext['userFilter']) && $ext['userFilter'] != '' ){
            $model = $model->where('userName','=', $ext['userFilter']);
        }
        if( isset($ext['projectFilter']) && $ext['projectFilter'] != '' ){
            $model = $model->where('projectTask','=',$ext['projectFilter']);
        }
//        if( isset($ext['clientFilter']) && $ext['clientFilter'] != '' ){
//            $model = $model->where('clientFilter','=',$ext['clientFilter']);
//        }
        if( isset($ext['dateFilter']) && $ext['dateFilter'] != '' ){
            if(is_array($ext['dateFilter']) && count($ext['dateFilter']) == 2 ){
                $dr = $ext['dateFilter'];

                $timeFrom = Carbon::parse($dr[0]);
                $timeUntil = Carbon::parse($dr[1]);

                $model = $model->where( function($q) use ( $timeFrom, $timeUntil) {
                    $q->whereBetween('clockInTime', [ $timeFrom , $timeUntil ] )
                        ->orWhereBetween('timerStart', [ $timeFrom , $timeUntil ]);
                });


            }
        }

//        $model = $model->orderBy('participatingCompany', 'asc')
//            ->orderBy('status', 'asc')
//            ->orderBy('inquiryDate', 'desc')
//            ->orderBy('jobNo', 'desc');

        return $model;
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {
        $data['userName'] = Auth::user()->name;
        $data['userId'] = Auth::user()->id;
        $data['user'] = Auth::user()->toArray();

        if($data['event'] == 'CLOCK_ADJ' ){
            $data['attStatus'] = 'IN';
            $data['clockInTime'] = $data['timerStart'];
            $data['clockOutTime'] = $data['timerStop'];
            $data['clockSec'] = Carbon::make($data['timerStop'])->diffInSeconds( Carbon::make($data['timerStart']) );
        }

        if($data['event'] == 'TIMER_ADJ' ){
            $data['attStatus'] = 'IN';
            $data['timerSec'] = Carbon::make($data['timerStop'])->diffInSeconds( Carbon::make($data['timerStart']) );
        }

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {
        $data['userName'] = Auth::user()->name;
        $data['userId'] = Auth::user()->id;
        $data['user'] = Auth::user()->toArray();

        if($data['event'] == 'CLOCK_ADJ' ){
            $data['attStatus'] = 'IN';
            $data['clockInTime'] = $data['timerStart'];
            $data['clockOutTime'] = $data['timerStop'];
            $data['clockSec'] = Carbon::make($data['timerStop'])->diffInSeconds( Carbon::make($data['timerStart']) );
        }

        if($data['event'] == 'TIMER_ADJ' ){
            $data['attStatus'] = 'IN';
            $data['timerSec'] = Carbon::make($data['timerStop'])->diffInSeconds( Carbon::make($data['timerStart']) );
        }
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

    public function beforeImportCommit($data)
    {
        $data['userName'] = $data['userName'] ?? Auth::user()->name;
        $data['userId'] = $data['userId'] ?? Auth::user()->id;
        $data['user'] = Auth::user()->toArray();

        if($data['event'] == 'CLOCK_IN' || $data['event'] == 'CLOCK_ADJ' ){
            $data['attStatus'] = 'IN';
            $data['clockSec'] = Carbon::make($data['clockInTime'])->diffInSeconds( Carbon::make($data['clockOutTime']) );
        }

        if($data['event'] == 'TIMER_START' || $data['event'] == 'TIMER_ADJ' ){
            $data['attStatus'] = 'IN';
            $data['timerSec'] = Carbon::make($data['timerStop'])->diffInSeconds( Carbon::make($data['timerStart']) );
        }

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


    public function postPrintTemplate(Request $request)
    {
        $this->print_as_pdf = true;
        return parent::postPrintTemplate($request); // TODO: Change the autogenerated stub
    }


    public function beforeSetPrintData(array $data, $template, $request = null)
    {
        if($template == 'time-summary-template' || $template == 'time-sheet-template'){
            $dm = new SpentTime();
            if($request->has('serverParams')){
                $sp = $request->get('serverParams');
                if(isset($sp['searchTerm']) && $sp['searchTerm'] != ''){

                    $sk = $sp['searchTerm'];

//                    if(strpos($this->yml_file, '_controller') === false){
//                        $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFieldSearchable();
//                    }else{
                        $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFieldSearchable();
//                    }

                    $dm = $this->filterBs4($dm, $sk, $searchFields);
                    $dm->orderBy('clockInTime', 'asc')
                        ->orderBy('timerStart', 'asc');
                }

                if(isset($sp['extraData']) ){
                    $ext = $sp['extraData'];
                    $dm = $this->advQuery($dm , $ext);
                }

                $tdata = $dm->get();
                $tdata = $tdata->toArray();

                $data = [];
                foreach ($tdata as $dt){

                    if($dt['event'] == 'CLOCK_IN' || $dt['event'] == 'CLOCK_ADJ' ){
                        $dt['attStatus'] = 'IN';
                        $dt['clockSec'] = Carbon::make($dt['clockInTime'])->diffInSeconds( Carbon::make($dt['clockOutTime']) );
                        $dt['durationText'] = CarbonInterval::seconds( $dt['clockSec'])->cascade()->forHumans(['short' => true]);
                        //$dt['durationMinute'] = number_format($dt['clockSec'] / 60, 2, ',', '.') ;
                        $dt['durationMinute'] = floatval($dt['clockSec'] / 60) ;

                        $dt['start'] = Carbon::make($dt['clockInTime'])->format( env('DATETIME_FORMAT', 'd-m-Y H:i:s') );
                        $dt['end'] = Carbon::make($dt['clockOutTime'])->format( env('DATETIME_FORMAT', 'd-m-Y H:i:s') );

                    }

                    if($dt['event'] == 'TIMER_START' || $dt['event'] == 'TIMER_ADJ' ){
                        $dt['attStatus'] = 'IN';
                        $dt['timerSec'] = Carbon::make($dt['timerStop'])->diffInSeconds( Carbon::make($dt['timerStart']) );
                        $dt['durationText'] = CarbonInterval::seconds( $dt['timerSec'])->cascade()->forHumans(['short' => true]);
                        //$dt['durationMinute'] = number_format($dt['timerSec'] / 60, 2, ',', '.') ;
                        $dt['durationMinute'] = floatval($dt['timerSec'] / 60) ;

                        $dt['start'] = Carbon::make($dt['timerStart'])->format( env('DATETIME_FORMAT', 'd-m-Y H:i:s' ));
                        $dt['end'] = Carbon::make($dt['timerStop'])->format( env('DATETIME_FORMAT', 'd-m-Y H:i:s') );

                    }


                    $data[] = $dt;
                }

            }
        }
        return parent::beforeSetPrintData($data, $template, $request); // TODO: Change the autogenerated stub
    }


    public function postTimeLog(Request $request){

        $data = $request->all();


        if($data['event'] == 'TIMER_START' || $data['event'] == 'CLOCK_IN' || $data['event'] == 'START_BREAK'){

            if( $data['event'] == 'CLOCK_IN') {
                $data = TimeUtil::spreadTime($data, 'clockInTime', $data['tz']);
                $data['timerStart'] = null;
                $data['timerStop'] = null;
            }

            if( $data['event'] == 'START_BREAK') {
                $data = TimeUtil::spreadTime($data, 'clockInTime', $data['tz']);
                $data['timerStart'] = null;
                $data['timerStop'] = null;
            }

            if( $data['event'] == 'TIMER_START' && $data['timerVal']){
                $data = TimeUtil::spreadTime($data, 'timerVal', $data['tz']);
                $data = TimeUtil::spreadTime($data, 'timerStart', $data['tz']);
                $data['timerStop'] = null;
            }

            $model = new SpentTime();
            foreach ($data as $k=>$v){
                $model->{$k} = $v;
            }

            $model->user = Auth::user();
            $model->userId = Auth::user()->id;
            $model->userName = Auth::user()->name;
            $model->isActive = true;

            $model = TimeUtil::createTime($model, $data['tz'] );

            if(Auth::check()){
                if($model->save()){
                    return response()->json(
                        [
                            'result'=>'OK',
                            'message'=>'Time Log saved',
                            'data'=>$model->toArray()

                        ], 200
                    );
                }else{
                    return response()->json(
                        [
                            'result'=>'ERR',
                            'message'=>'Time Log failed to save',
                            'data'=>$model->toArray()

                        ], 200
                    );

                }
            }else{
                return response('Unauthorized', 401);
            }



        }else{
            /**
             * if event is terminating event
             */
            $success = true;



            if($data['event'] == 'TIMER_STOP' ){

                if($data['timetrackSession'] != ''){

                    $data = TimeUtil::spreadTime($data, 'timerStop', $data['tz']);
                    $data = TimeUtil::spreadTime($data, 'timerVal', $data['tz']);

                    $model = SpentTime::where( 'event', '=', 'TIMER_START' )
                        ->where('timetrackSession','=', $data['timetrackSession'])
                        ->where('userId', '=', Auth::user()->id)
                        ->orderBy('createdAt', 'desc')->first();

                    if($model){

                        $model->timerStop = $data['timerStop'];
                        $model->timerStop_local = $data['timerStop_local'];
                        $model->timerStop_utc = $data['timerStop_utc'];

                        $st = Carbon::parse( $data['timerStart'], 'UTC' );
                        $ed = Carbon::make( $data['timerStop'] ) ;

                        $sec = $st->diffInSeconds( $ed );

                        $model->timerSec = $sec;
                        $model->isActive = false;
                        $model->save();
                    }else{
                        $success = false;
                    }

                }else{
                    $success = false;
                }

            }
            if($data['event'] == 'CLOCK_OUT' ){

                debug($data['attendanceSession']);
                if($data['attendanceSession'] != ''){

                    $data = TimeUtil::spreadTime($data, 'clockOutTime', $data['tz']);

                    $model = SpentTime::where( 'event', '=', 'CLOCK_IN' )
                        ->where('attendanceSession','=', $data['attendanceSession'])
                        ->where('userId', '=', Auth::user()->id)
                        ->orderBy('createdAt', 'desc')->first();

                    if($model){

                        $model->clockOutTime = $data['clockOutTime'];
                        $model->clockOutTime_local = $data['clockOutTime_local'];
                        $model->clockOutTime_utc = $data['clockOutTime_utc'];

                        $st = Carbon::parse( $data['clockInTime'], 'UTC' );
                        $ed = Carbon::make( $data['clockOutTime'] ) ;

                        $sec = $st->diffInSeconds( $ed );

                        $model->clockSec = $sec;
                        $model->isActive = false;
                        $model->save();
                    }else{
                        $success = false;
                    }

                }else{
                    $success = false;
                }


            }
            if($data['event'] == 'STOP_BREAK' ){

                if($data['breakSession'] != ''){

                    $data = TimeUtil::spreadTime($data, 'breakStop', $data['tz']);

                    $model = SpentTime::where( 'event', '=', 'START_BREAK' )
                        ->where('breakSession','=', $data['breakSession'])
                        ->where('userId', '=', Auth::user()->id)
                        ->orderBy('createdAt', 'desc')->first();

                    if($model){
                        $model->breakStop = $data['breakStop'];
                        $model->breakStop_local = $data['breakStop_local'];
                        $model->breakStop_utc = $data['breakStop_utc'];

                        $st = Carbon::parse( $data['breakStart'], 'UTC' );
                        $ed = Carbon::make( $data['breakStop'] ) ;

                        $sec = $st->diffInSeconds( $ed );

                        $model->breakSec = $sec;
                        $model->isActive = false;
                        $model->save();
                    }else{
                        $success = false;
                    }

                }else{
                    $success = false;
                }

            }

            if(Auth::check()){

                if($success){
                    return response()->json(
                        [
                            'result'=>'OK',
                            'message'=>'Time Log saved',
                            'data'=>$model->toArray()

                        ], 200
                    );
                }else{
                    return response()->json(
                        [
                            'result'=>'ERR',
                            'message'=>'Time Log failed to save',
                            'data'=>null

                        ], 200
                    );

                }


            }else{
                return response('Unauthorized', 401);
            }



        }

    }

    public function postTimeLogState(Request $request)
    {
        $trclock = SpentTime::where('userId', '=', Auth::user()->_id)
            ->where('event','=','CLOCK_IN')
            ->where('isActive','=',true)
            ->where('userId','=', Auth::user()->id )
            ->orderBy('createdAt','desc')->first();
        $trtime = SpentTime::where('userId', '=', Auth::user()->_id)
            ->where('event','=','TIMER_START')
            ->where('isActive','=',true)
            ->where('userId','=', Auth::user()->id )
            ->orderBy('createdAt','desc')->first();
        $trbreak = SpentTime::where('userId', '=', Auth::user()->_id)
            ->where('event','=','START_BREAK')
            ->where('isActive','=',true)
            ->where('userId','=', Auth::user()->id )
            ->orderBy('createdAt','desc')->first();

        if($trclock){
            $tstate = $trclock->toArray();

            if($trtime){
                $tstate['timerRunning'] = $trtime->timerRunning || is_null($trtime->timerStop) ?? false;
                $tstate['timetrackSession'] = $trtime->timetrackSession ?? "";
                $tstate['timerVal'] = $trtime->timerVal ?? false;
                $tstate['timerSec'] = $trtime->timerSec ?? 0;
            }else{
                $tstate['timerRunning'] = false;
                $tstate['timetrackSession'] = "";
                $tstate['timerVal'] = false;
                $tstate['timerSec'] = 0;
            }

            if($trbreak){
                $tstate['breakSession'] = $trbreak->breakSession;
                $tstate['breakStart'] = $trbreak->breakStart;
                $tstate['breakStop'] = $trbreak->breakStop;
            }else{
                $tstate['breakSession'] = "";
                $tstate['breakStart'] = null;
                $tstate['breakStop'] = null;
            }

            if(Auth::check()){
                return response()->json(
                    [
                        'result'=>'OK',
                        'message'=>'Time Log saved',
                        'data'=>$tstate

                    ], 200
                );
            }else{
                return response('Unauthorized', 401);
            }


        }else{

            if(Auth::check()){
                return response()->json(
                    [
                        'result'=>'ERR',
                        'message'=>'No time record found',
                        'data'=>[]

                    ], 200
                );
            }else{
                return response('Unauthorized', 401);
            }

        }

    }

}
