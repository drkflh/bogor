<?php

namespace App\Http\Controllers\Core;

use App\Helpers\App\Kmn\KmnUtil;
use App\Helpers\AuthUtil;
use App\Helpers\Injector;
use App\Helpers\RefUtil;
use App\Helpers\TimeUtil;
use App\Helpers\Util;
use App\Helpers\WorkflowUtil;
use App\Jobs\ExportXlsJob;
use App\Jobs\QueriedExportXlsJob;
use App\Models\Core\Mongo\APILog;
use App\Models\Core\Mongo\AuthorizationStatusLog;
use App\Models\Core\Mongo\User;
use App\Models\Export\GenericExport;
use App\Models\Imports\Importsession;
use App\Models\Workflow\ApprovalRequest;
use App\Models\Workflow\FileDownload;
use App\Models\Core\PrintCache;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Former\Facades\Former;
use Illuminate\Bus\Batch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Laravie\SerializesQuery\Eloquent;
use Laravie\SerializesQuery\Query;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $title = "Untitled";
    protected $table_view = null;
    protected $table_component = null; //vue-good-table, vue-tables-2, vue-bootstrap4
    protected $layout = 'layouts.dashforge';
    protected $logo = 'images/app/logo.png';
    protected $logo_small = 'images/app/logo_small.png';

    protected $titles;
    protected $fields = null;

    protected $defOrderField = 'updated_at';
    protected $defOrderDir = 'desc';

    protected $col_attributes = [];
    protected $col_fields = [];
    protected $col_heads = [];
    protected $col_filtered = [];
    protected $col_sortable = [];

    protected $model;
    protected $collection_name = '';
    protected $connection_name = 'mongodb';

    protected $data = []; // page injected custom data, merged with reactive data model
    protected $aux_data = []; // page injected custom data as addition to reactive data model, not merged with data model
    protected $plugin_data = [];
    protected $test_data;

    protected $controller_base = '';
    protected $view_base = '';

    protected $clone_name_field = '';

    protected $data_url;
    protected $add_url;
    protected $update_url;
    protected $autosave_url;
    protected $del_url;
    protected $clone_url;
    protected $admin_setapproval_url = '';
    protected $admin_resetrev_url = '';

    protected $validate_url = '';

    protected $download_url;
    protected $download_export_url;
    protected $download_print_url;
    protected $download_summary_url;


    protected $can_add = true;
    protected $can_update = true;
    protected $can_view = true;
    protected $can_download_csv = true;
    protected $can_download_xls = true;
    protected $can_upload = true;
    protected $can_delete = true;
    protected $can_multi_delete = false;
    protected $can_clone = false;
    protected $can_multi_clone = false;
    protected $can_revise = false;
    protected $can_save = false;
    protected $can_print = true;

    protected $can_request_approval = false;
    protected $can_approve = false;

    //show or hide select checkbox column
    protected $can_multi_select = false;

    //show or hide action column
    protected $show_actions = true;

    protected $show_more_actions = true;

    protected $add_filler = false;

    protected $log_json = false;

    protected $can_autosave = false;

    protected $controller_name;

    protected $template_var = null;

    protected $nav_section = 'users';

    protected $show_title = true;

    protected $non_closing_save = false;

    protected $non_saving_close = false;

    protected $backlink = '';
    protected $validator = [];

    //form data populator
    protected $def_param = [];
    protected $sel_options = ['default'=>[]];

    protected $res_path = 'views/core/user';
    protected $yml_file = 'fields';
    protected $yml_layout_file = 'layout';

    protected $handle = '';

    protected $right_sidebar_header = '';
    protected $right_sidebar_model = [];
    protected $right_sidebar_data = [];
    protected $right_sidebar_params = [];
    protected $right_sidebar_template = '``';

    protected $info_topbar_show = false;
    protected $info_topbar_header = '';
    protected $info_topbar_model = [];
    protected $info_topbar_data = [];
    protected $info_topbar_params = [];
    protected $info_topbar_template = '``';

    protected $nav_path = null;
    protected $nav_file = null;

    protected $param_url;
    protected $item_data_url;

    //crud callback methods
    protected $uvm_methods = '';
    protected $vvm_methods = '';
    protected $tvm_methods = '';

    protected $uvm_watches = '';
    protected $vvm_watches = '';
    protected $tvm_watches = '';

    protected $uvm_computed = '';
    protected $vvm_computed = '';
    protected $tvm_computed = '';

    /* form template & view */
    protected $form_view = 'form.html';
    protected $form_layout = 'form.htmllayout';
    protected $form_mode = 'page';
    protected $form_type = 'html'; // flatgrid , custom
    protected $form_dialog_size = '';

    /* viewer template */
    protected $viewer_view = 'form.viewhtml';
    protected $viewer_layout = 'form.viewhtmllayout';
    protected $viewer_mode = 'page';
    protected $viewer_type = 'html'; // flatgrid , custom
    protected $viewer_dialog_size = '';
    protected $viewer_icon = '';
    protected $viewer_can_print = false;
    protected $viewer_as_document = false;

    protected $keyword0 = '';
    protected $keyword1 = '';
    protected $keyword2 = '';

    protected $item_id;

    protected $grid_item_view = '';

    protected $table_slot_view = '';
    protected $table_head_slot_view = '';

    protected $table_grid_slot_view = '';

    protected $add_methods_view = '';
    protected $add_watch_view = '';
    protected $add_event_view = '';
    protected $add_computed_view = '';
    protected $add_icon = '';
    protected $add_as_page = false;
    protected $add_page_base = '';
    protected $add_form_interval = 5000;

    protected $edit_methods_view = '';
    protected $edit_watch_view = '';
    protected $edit_event_view = '';
    protected $edit_computed_view = '';
    protected $edit_icon = '';
    protected $edit_as_page = false;
    protected $edit_page_base = '';

    /**
     * Form Generator params
     * @var string
     */
    protected $page_methods_view = '';
    protected $page_watch_view = '';
    protected $page_event_view = '';
    protected $page_computed_view = '';
    protected $page_modal_view = '';
    protected $page_action_view = '';
    protected $page_additional_view = '';

    protected $page_redirect_after_save = false;
    protected $page_save_redirect = '';
    protected $page_cancel_redirect = '';

    protected $page_refresh_button = false;

    protected $customLoader = false;

    protected $view_methods_view = '';
    protected $view_watch_view = '';
    protected $view_event_view = '';
    protected $view_computed_view = '';

    protected $tmplname_methods_view = '';
    protected $authorization_method_view = '';

    protected $table_column = null;
    protected $table_column_exclude = null;

    protected $table_methods_view = '';
    protected $table_watch_view = '';
    protected $table_computed_view = '';
    protected $table_modal_view = '';
    protected $table_action_view = '';
    protected $table_event_view = '';
    protected $table_additional_view = '';

    protected $table_advanced_search_view = '';
    protected $table_advanced_search_type = 'dialog';
    protected $table_advanced_search_size = 'md';

    protected $table_grouped = false;

    protected $table_grid = false;

    protected $js_load_transform = '';
    protected $js_post_transform = '';
    protected $js_data_replay = '';
    protected $js_tab_change = '';
    protected $js_pop_open = '';

    protected $grid = [ [ 'col'=>[12] ], [ 'col'=>[6,6] ], [ 'col'=>[4,4,4] ] ] ;
    protected $has_tab = false;
    protected $can_lock = false;

    /* print template */
    protected $print_template_url = null;
    protected $print_template = null;
    protected $print_modal_size = 'lg';
    protected $print_modal_class = '';
    protected $print_as_pdf = false;

    /* with advanced search */
    protected $with_advanced_search = false;

    /* workflow object keys */
    protected $with_workflow = false;
    protected $with_revision = false;
    protected $with_timetracking = false;
    protected $with_attendance = false;

    protected $wf_request_doc_type = '';
    protected $wf_request_doc_id = 'requestNo';
    protected $wf_request_doc_title = 'title';
    protected $wf_request_doc_desc = 'descr';

    protected $approval_param_url = '';
    protected $approval_request_url = '';
    protected $approval_commit_url = '';
    protected $approval_title_field = '';
    protected $approval_description_field = '';
    protected $approval_view_template = '';

    protected $import_src_url = 'api/v1/core/import/source';
    protected $import_preview_cols = [];
    protected $import_upload_url = 'api/v1/core/import/upload';
    protected $import_commit_url = 'api/v1/core/import/commit';
    protected $import_upload_multi_url = 'api/v1/core/import/upload-multi';
    protected $import_commit_multi_url = 'api/v1/core/import/commit-multi';
    protected $import_upload_cell_url = 'api/v1/core/import/upload-cell';
    protected $import_commit_cell_url = 'api/v1/core/import/commit-cell';
    protected $import_preview_heads = [];
    protected $show_print_button = false;
    protected $extra_view;
    protected $extra_view_params = '';
    protected $extra_query = [];

    protected $auto_sequence = false;
    protected $sequence_url = '';
    protected $sequence_field = 'seq';
    protected $sequence_pad = 4;
    protected $sequence_bounds = [];
    protected $numbering_field = 'fieldNo';
    protected $numbering_prefix = 'PRE-';

    protected $update_title_fields = null;
    protected $view_title_fields = null;
    protected $add_title_fields = null;
    protected $pdf_view_title_fields = null;

    protected $title_fields = null;
    protected $pdf_title_fields = null;

    protected $localStorageKey = 'lsKey';
    protected $entity = '';
    protected $auth_entity = '';
    protected $user_role_entity = null;

    protected $timefields = [];
    protected $fieldObject;

    protected $revision_key = '';
    protected $revision_id_val = '';

    protected $is_create = true; //for form page only, set mode to create or update

    protected $lang = null;
    protected $tz = null;
    protected $print_download_xls = false;
    protected $print_modal_title = 'Print Document';
    protected $print_summary_template = '';

    public function __construct()
    {
        $this->middleware('auth');
        $this->layout = env('DEFAULT_LAYOUT','layouts.dashforge');
        $this->logo = env('APP_LOGO','images/logo.png');
        $this->logo_small = env('APP_LOGO_SMALL','images/logo.png');

        $session = new \Symfony\Component\HttpFoundation\Session\Session();

        $controller = (new \ReflectionClass($this))->getShortName();
        $this->controller_name = str_ireplace('controller', '',  $controller);

        $this->with_revision = env('WITH_REVISION', false);
        $this->with_workflow = env('WITH_WORKFLOW', false);

        $this->print_as_pdf = env('PRINT_AS_PDF', false);

        $this->form_dialog_size = env('DIALOG_SIZE','lg');
        $this->viewer_dialog_size = env('DIALOG_SIZE','lg');

        $this->nav_path = env('APP_NAV_PATH','views/partials/app/default');
        $this->nav_file = env('APP_NAV_FILE','open');

        $this->tz = env('DEFAULT_TIME_ZONE', 'Asia/Jakarta');
        date_default_timezone_set($this->tz);

        $this->lang = $session->get('lang');
        $this->tz = $session->get('tz');

        Util::ajaxDebug();

    }

    /**
     * @hideFromAPIDocumentation
     * @return mixed
     */
    public function getIndex()
    {
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $request = Request::capture();

        if($request->has('lang')){
            $lang = $request->get('lang');
            $session->set('lang', $lang);
        }

        if($request->has('tz')){
            $tz = $request->get('tz');
            $session->set('tz', $tz);
        }

        $this->lang = $session->get('lang');
        App::setLocale($this->lang);
        $this->tz = $session->get('tz');

        info('current locale',[$this->lang, $this->tz, App::getLocale() ]);

        $this->user_role_entity = AuthUtil::loadRoleEntity(Auth::user()->roleId);

        Util::log(Auth::user()->toArray(), $request->url(), 'INIT' ,$request->toArray(), null , $this->auth_entity);

        $this->add_title_fields = $this->add_title_fields ?? '"<h4>'.__('Add').' '.$this->entity.'</h4>"';
        $this->update_title_fields = $this->update_title_fields ?? sprintf( '"<h4>%s " + this.%s +"</h4>"', __('Edit'), ($this->title_fields ?? '_id') );
        $this->view_title_fields = $this->view_title_fields ?? sprintf( '"<h4>%s " + this.%s +"</h4>"', __('View'), ($this->title_fields ?? '_id') );
        $this->pdf_view_title_fields = $this->pdf_view_title_fields ?? sprintf( '"<h4>%s " + _.get(this.pdfViewData, \'%s\') +"</h4>"', __('View'), ($this->pdf_title_fields ?? '_id') );

        $time_track = Auth::user()->useTimeTracker ?? false;

        $this->with_timetracking =  $time_track && env('WITH_TIMETRACKING', false);

        $attendance = Auth::user()->useAttendance ?? false;
        $this->with_attendance = $attendance && env('WITH_ATTENDANCE', false);

        if(AuthUtil::can('read', $this->auth_entity, Auth::user()->roleId)){

        }else{
            if(env('AUTH_ON_PAGE', false)){
                return redirect( AuthUtil::getRoleRedirect(Auth::user()->roleId) ) ;
            }
        }

        return $this->pageGenerator();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $request = Request::capture();

        if($request->has('lang')){
            $lang = $request->get('lang');
            $session->set('lang', $lang);
        }

        if($request->has('tz')){
            $tz = $request->get('tz');
            $session->set('tz', $tz);
        }

        $this->lang = $session->get('lang');
        App::setLocale($this->lang);
        $this->tz = $session->get('tz');

        info('current locale',[$this->lang, $this->tz, App::getLocale() ]);

        $this->user_role_entity = AuthUtil::loadRoleEntity(Auth::user()->roleId);

        Util::log(Auth::user()->toArray(), $request->url(), 'INIT' ,$request->toArray(), null , $this->auth_entity);

        $this->add_title_fields = $this->add_title_fields ?? '"<h4>'.__('Add').' '.$this->entity.'</h4>"';
        $this->update_title_fields = $this->update_title_fields ?? sprintf( '"<h4>%s " + this.%s +"</h4>"', __('Edit'), ($this->title_fields ?? '_id') );
        $this->view_title_fields = $this->view_title_fields ?? sprintf( '"<h4>%s " + this.%s +"</h4>"', __('View'), ($this->title_fields ?? '_id') );
        $this->pdf_view_title_fields = $this->pdf_view_title_fields ?? sprintf( '"<h4>%s " + _.get(this.pdfViewData, \'%s\') +"</h4>"', __('View'), ($this->pdf_title_fields ?? '_id') );

        $time_track = Auth::user()->useTimeTracker ?? false;
        $this->with_timetracking =  $time_track && env('WITH_TIMETRACKING', false);

        $attendance = Auth::user()->useAttendance ?? false;
        $this->with_attendance = $attendance && env('WITH_ATTENDANCE', false);

        info('ATT',[$this->with_attendance, $this->with_timetracking]);

        if(AuthUtil::can('read', $this->auth_entity, Auth::user()->roleId)){

        }else{
            if(env('AUTH_ON_PAGE', false)){
                return redirect( AuthUtil::getRoleRedirect(Auth::user()->roleId) ) ;
            }
        }

        $this->keyword0 = $keyword0;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        return $this->pageGenerator();
    }

    public function getAdd(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $request = Request::capture();

        if($request->has('lang')){
            $lang = $request->get('lang');
            $session->set('lang', $lang);
        }

        if($request->has('tz')){
            $tz = $request->get('tz');
            $session->set('tz', $tz);
        }

        $this->lang = $session->get('lang');
        App::setLocale($this->lang);
        $this->tz = $session->get('tz');

        info('current locale',[$this->lang, $this->tz, App::getLocale() ]);

        $this->user_role_entity = AuthUtil::loadRoleEntity(Auth::user()->roleId);

        Util::log(Auth::user()->toArray(), $request->url(), 'INIT' ,$request->toArray(), null , $this->auth_entity);

        $this->add_title_fields = $this->add_title_fields ?? '"<h4>'.__('Add').' '.$this->entity.'</h4>"';
        $this->update_title_fields = $this->update_title_fields ?? sprintf( '"<h4>%s " + this.%s +"</h4>"', __('Edit'), ($this->title_fields ?? '_id') );
        $this->view_title_fields = $this->view_title_fields ?? sprintf( '"<h4>%s " + this.%s +"</h4>"', __('View'), ($this->title_fields ?? '_id') );
        $this->pdf_view_title_fields = $this->pdf_view_title_fields ?? sprintf( '"<h4>%s " + _.get(this.pdfViewData, \'%s\') +"</h4>"', __('View'), ($this->pdf_title_fields ?? '_id') );

        $time_track = Auth::user()->useTimeTracker ?? false;
        $this->with_timetracking =  $time_track && env('WITH_TIMETRACKING', false);

        $attendance = Auth::user()->useAttendance ?? false;
        $this->with_attendance = $attendance && env('WITH_ATTENDANCE', false);

        info('ATT',[$this->with_attendance, $this->with_timetracking]);

        if(AuthUtil::can('read', $this->auth_entity, Auth::user()->roleId)){

        }else{
            if(env('AUTH_ON_PAGE', false)){
                return redirect( AuthUtil::getRoleRedirect(Auth::user()->roleId) ) ;
            }
        }

        $this->keyword0 = $keyword0;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        return $this->formGenerator();
    }

    public function getEdit(Request $request, $id ,$keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $request = Request::capture();

        if($request->has('lang')){
            $lang = $request->get('lang');
            $session->set('lang', $lang);
        }

        if($request->has('tz')){
            $tz = $request->get('tz');
            $session->set('tz', $tz);
        }

        $this->lang = $session->get('lang');
        App::setLocale($this->lang);
        $this->tz = $session->get('tz');

        info('current locale',[$this->lang, $this->tz, App::getLocale() ]);

        $this->user_role_entity = AuthUtil::loadRoleEntity(Auth::user()->roleId);

        Util::log(Auth::user()->toArray(), $request->url(), 'INIT' ,$request->toArray(), null , $this->auth_entity);

        $this->add_title_fields = $this->add_title_fields ?? '"<h4>'.__('Add').' '.$this->entity.'</h4>"';
        $this->update_title_fields = $this->update_title_fields ?? sprintf( '"<h4>%s " + this.%s +"</h4>"', __('Edit'), ($this->title_fields ?? '_id') );
        $this->view_title_fields = $this->view_title_fields ?? sprintf( '"<h4>%s " + this.%s +"</h4>"', __('View'), ($this->title_fields ?? '_id') );
        $this->pdf_view_title_fields = $this->pdf_view_title_fields ?? sprintf( '"<h4>%s " + _.get(this.pdfViewData, \'%s\') +"</h4>"', __('View'), ($this->pdf_title_fields ?? '_id') );

        $time_track = Auth::user()->useTimeTracker ?? false;
        $this->with_timetracking =  $time_track && env('WITH_TIMETRACKING', false);

        $attendance = Auth::user()->useAttendance ?? false;
        $this->with_attendance = $attendance && env('WITH_ATTENDANCE', false);

        info('ATT',[$this->with_attendance, $this->with_timetracking]);

        if(AuthUtil::can('read', $this->auth_entity, Auth::user()->roleId)){

        }else{
            if(env('AUTH_ON_PAGE', false)){
                return redirect( AuthUtil::getRoleRedirect(Auth::user()->roleId) ) ;
            }
        }

        $this->keyword0 = $keyword0;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        $this->form_view = 'form.htmlformpage';
        $this->form_mode = 'edit';

        return $this->formGenerator();
    }


    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postIndex(Request $request)
    {
        Util::ajaxDebug();
        Util::log(Auth::user()->toArray(), $request->url(), 'TABLE' ,$request->toArray(), null,$this->auth_entity );
        return $this->tableResponderBs4($request);
    }

    public function postList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        Util::ajaxDebug();
        $request->request->add(['keyword0'=>$keyword0],['keyword1'=>$keyword1],['keyword2'=>$keyword2]);
        return $this->tableResponderBs4($request);
    }

    /**
     * @hideFromAPIDocumentation
     * @param null $data
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postAdd($data = null, Request $request){

        Former::setOption('fetch_errors', true);

        Util::ajaxDebug();

        //print_r(Session::get('errors'));
        if(is_null($data)){
            $data = $request->input();
        }

        $ajax = false;
        //print_r($data);
        $ajax = ($request->has('ajax') && $request->input('ajax') == 1)?true:false;

        $route = Route::current();

        $data = $this->beforeValidateAdd($data);

        $controller_name = strtolower($this->controller_name);

        $this->backlink = ($this->backlink == '')? $route->getPrefix().'/'.$controller_name:$this->backlink;

        $validation = Validator::make($input = $data, $this->validator);

        $actor = (isset(Auth::user()->email))?Auth::user()->name.' - '.Auth::user()->email:'guest';

        $backlink = ( $this->backlink == '' )?$route->getPrefix().'/'.$controller_name:$this->backlink  ;

        if($validation->fails()){

            Util::log(Auth::user()->toArray(), $request->url(), 'ADD' ,$request->toArray(), 'ERR: '.$validation->errors()->getMessages(), $this->auth_entity );

            if($ajax){
                return response()->json( ['status'=>'VALERR','errors'=> $validation->errors()->getMessages() ] );
            }else{
                return redirect($route->getPrefix().'/'.$controller_name.'/add')
                    ->withErrors($validation)
                    ->withInput($request->all());
            }

        }else{

            unset($data['csrf_token']);

            $now =  Carbon::now(date_default_timezone_get());

            $data['createdDate'] = $now;
            $data['lastUpdate'] = $now;
            $data['ownerId'] = Auth::user()->_id;
            $data['ownerName'] = Auth::user()->name;
            $data['domainNs'] = env('APP_NAMESPACE', '');

            if(AuthUtil::is('owner') || AuthUtil::isAdmin()){
                $data['masterId'] = Auth::user()->_id;
                $data['masterName'] = Auth::user()->name;
            }

            // process tags by default
            if(isset($data['tags'])){
                $tags = $this->tagToArray($data['tags']);
                $data['tagArray'] = $tags;
            }

            $model = $this->model;

            $data = $this->beforeSave($data);

            foreach($data as $k=>$v){
                $model->{$k} = $v;
            }

            if($this->log_json){
                $model->raw_json = $data;
            }

            if($this->auto_sequence){
                if(isset($model->seq)){
                    $model->seq = intval($model->seq);
                }else{
                    $model->seq = 0;
                }
            }

            $model->rev = 0;

            // unset _id to avoid _id with null value
            unset($model->_id);

            debug('new model');
            debug($model);

            if($obj = $model->save()){
                debug('saved');
                debug($model);

                //$model->save();

                $now =  Carbon::now(date_default_timezone_get());

                $model->createdAt = $now;
                $model->updatedAt = $now;
                $model->created_at = $now;
                $model->updated_at = $now;
                $model->createdDate = $now;
                $model->lastUpdate = $now;
                $model->save();

                $obj = $this->afterSave($model->toArray());


                if($ajax){
                    $_id = $model->id;

                    Util::log(Auth::user()->toArray(), $request->url(), 'ADD' ,$request->toArray(), 'SUCCESS', $this->auth_entity, $_id );

                    return response()->json([ 'result'=>'OK','msg'=>'Item saved successfully', 'itemId'=>$_id, 'formMode'=>'update' ]);
                }else{
                    return redirect($backlink)->with('notify_success',ucfirst(Str::singular($controller_name)).' saved successfully');
                }
            }else{
                if($ajax){
                    return response()->json([ 'result'=>'ERR','msg'=>'Failed to save item' ]);
                }else{
                    return redirect($backlink)->with('notify_success',ucfirst(Str::singular($controller_name)).' saving failed');
                }
            }

        }

    }

    public function beforeSave($data)
    {
        $data['code'] = Str::random(24);
        $data['handle'] = (isset($data['handle']))?$data['handle']:Str::random(12);
        return $data;
    }

    public function afterSave($data)
    {
        return $data;
    }

    /**
     * @hideFromAPIDocumentation
     * @param null $data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAutosave($data = null, Request $request){

        $controller_name = strtolower($this->controller_name);

        $_id = ($request->has('itemId') && $request->input('itemId') != "")?$request->input('itemId'):'';

        $formMode = ($request->has('formMode') && $request->input('formMode') != "")?$request->input('formMode'):'create';

        $actor = (isset(Auth::user()->email))?Auth::user()->name.' - '.Auth::user()->email:'guest';

        if(is_null($data)){
            $data = $request->input();
        }

        if($_id != ''){
            // update record
            $model = $this->model;
            unset($data['csrf_token']);
            unset($data['_id']);
            $data = $this->beforeUpdate($_id,$data);
            $data['lastUpdate'] = Carbon::now(date_default_timezone_get());
            $obj = $model->find($_id);
            if($obj){
                foreach ($data as $key =>$value) {
                    $obj->{$key} = $value;
                }
                $obj = $obj->save();
                $obj = $this->afterUpdate($_id,$data);
                if($obj != false){
                    return response()->json([ 'result'=>'OK','msg'=>'Item saved successfully', 'itemId'=>$_id, 'formMode'=>'update'  ]);
                }
            }else{
                return response()->json([ 'result'=>'ERR','msg'=>'Failed to update item' ]);
            }

        }else{
            // add new record
            $model = $this->model;
            $data = $this->beforeSave($data);
            foreach($data as $k=>$v){
                $model->{$k} = $v;
            }
            if($obj = $model->save()){
                $obj = $this->afterSave($model->toArray());
                $_id = $model->_id;
                return response()->json([ 'result'=>'OK','msg'=>'Item saved successfully', 'itemId'=>$_id, 'formMode'=>'update', 'ts'=>time() ]);
            }else{
                return response()->json([ 'result'=>'ERR','msg'=>'Failed to save item', 'ts'=>time() ]);
            }

        }

    }

    /**
     * @hideFromAPIDocumentation
     * @param $_id
     * @param null $data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRelay( $_id, $data = null, Request $request){

        if(is_null($data)){
            $data = $request->all();
        }else{
            $data = array_merge( $data, $request->all() );
        }

        $result = KmnUtil::postData( json_encode($data));

        $obj = $this->model->find($_id);

        if($obj){

        }else{
            $obj = $this->model;
        }

        foreach($data as $k=>$v){
            $obj->{$k} = $v;
        }

        if($this->log_json){
            $obj->raw_json = json_encode($data);
        }

        if($obj->save()){
            return response()->json([ 'result'=>'OK','msg'=>'Item saved successfully', 'itemId'=>$_id, 'formMode'=>'update', 'ts'=>time() ]);
        }else{
            return response()->json([ 'result'=>'ERR','msg'=>'Failed to save item', 'ts'=>time() ]);
        }

    }

    /**
     * @hideFromAPIDocumentation
     * @param $_id
     * @param null $data
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEdit($_id, $data = null, Request $request){

        $controller_name = strtolower($this->controller_name);
        //print_r(Session::get('permission'));

        Util::ajaxDebug();

        $ajax = false;

        $_id = trim($_id);

        $ajax = ($request->has('ajax') && $request->input('ajax') == 1)?true:false;

        $route = Route::current();

        $backlink = ($this->backlink == '')?$route->getPrefix().'/'.$controller_name:$this->backlink;

        $validation = Validator::make($input = $request->all(), $this->validator);

        $actor = (isset(Auth::user()->email))?Auth::user()->name.' - '.Auth::user()->email:'guest';

        if($validation->fails()){
            $messages = $validation->messages();

            //Event::fire('log.a',array($controller_name, 'update' ,$actor,'validation failed'));
            Util::log(Auth::user()->toArray(), $request->url(), 'UPDATE' ,$request->toArray(), 'ERR: '.$validation->errors()->getMessages(), $this->auth_entity, $_id );


            if($ajax){
                return response()->json( ['status'=>'VALERR','errors'=> $validation->errors()->getMessages() ] );
            }else{
                return redirect($route->getPrefix().'/'.$controller_name.'/edit/'.$_id)
                    ->withInput($request->all())
                    ->withErrors($validation);
            }


        }else{


            if(is_null($data)){
                $data = $request->input();
            }

            $model = $this->model;

            unset($data['csrf_token']);
            unset($data['_id']);

            if(isset($data['tags'])){
                if(!is_array($data['tags'])){
                    $tags = $this->tagToArray($data['tags']);
                }else{
                    $tags = $data['tags'];
                }
                $data['tagArray'] = $tags;
                //$this->saveTags($tags);
            }

            if($data == false){

                if($ajax){
                    return response()->json([ 'result'=>'OK','msg'=>'Item saved successfully', 'itemId'=>$_id, 'formMode'=>'update'  ]);
                }else{
                    return redirect($backlink)->with('notify_success',ucfirst(str_singular($controller_name)).' saved successfully');
                }
            }

            $now =  Carbon::now(date_default_timezone_get());

            $obj = $model->find($_id);

            if($obj){

                $data = $this->beforeUpdate($_id,$data);

                if(!isset($data['domainNs']) || $data['domainNs'] == '' || is_null($data['domainNs'])){
                    $data['domainNs'] = env('APP_NAMESPACE', '');
                }

                foreach ($data as $key =>$value) {

                    $obj->{$key} = $value;
                }

                if($this->log_json){
                    $model->raw_json = $data;
                }

                if( !isset($obj->rev)){
                    $obj->rev = 0;
                }

                if($this->auto_sequence){
                    if( isset($obj->seq)){
                        $obj->seq = intval($obj->seq);
                    }
                }

                if(is_null($obj->createdAt) || empty($obj->createdAt)){
                    $obj->createdAt = $now;
                }
                $obj->updatedAt = $now;
                $obj->updated_at = $now;
                $obj->lastUpdate = $now;

                $obj->save();

                $obj = $this->afterUpdate($_id,$data);

                if($obj != false){

                    if($ajax){
                        Util::log(Auth::user()->toArray(), $request->url(), 'UPDATE' ,$request->toArray(), 'SUCCESS', $this->auth_entity, $_id );

                        return response()->json([ 'result'=>'OK','msg'=>'Item updated successfully', 'itemId'=>$_id, 'formMode'=>'update'  ]);
                    }else{
                        return redirect($backlink)->with('notify_success',ucfirst(str_singular($controller_name)).' saved successfully');
                    }

                }
            }else{

                if($ajax){
                    return response()->json([ 'result'=>'ERR','msg'=>'Failed to update item' ]);
                }else{
                    return redirect($backlink)->with('notify_success',ucfirst(str_singular($controller_name)).' saving failed');
                }

            }

        }

    }

    public function beforeUpdate($id,$data)
    {
        return $data;
    }

    public function afterUpdate($id,$data = null)
    {
        return $id;
    }

    public function beforeView($data)
    {
        return $data;
    }

    public function beforeUpdateForm($population)
    {
        $vuetype =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toVueType();

        //print_r($vuetype);

        foreach( $population as $k=>$v ){
            if(isset( $vuetype[$k] )){
                if( $vuetype[$k]['type'] == 'array') {
                    if( is_array( $population[$k] ) ){

                    }else{
                        $population[$k] = [];
                    }
                }

                if( $vuetype[$k]['type'] == 'object') {
                    if( is_object( $population[$k] ) ){

                    }else{
                        $population[$k] = new \ArrayObject();
                    }
                }
            }
        }

        if( !isset($population['handle']) || $population['handle'] == ''){
            $population['handle'] = Str::random(12);
        }

        if(isset($population['tags']) && is_array($population['tags']))
        {
            $population['tags'] = implode(',', $population['tags'] );
        }
        return $population;
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postClone(Request $request)
    {
        $data = $request->input('params')['data'];
        $type = $request->input('params')['type'];

        $ids = [];
        foreach($data as $d){
            if( isset($d['_id']) ){
                $ids[] = $d['_id'];
            }

            if( isset($d['id']) ){
                $ids[] = $d['id'];
            }

        }

        $ids = array_unique($ids);

        $model = $this->model;

        if(empty($ids)){
            return response()->json( ['status'=>'ERR','data'=>'NOID' ] );
        }else{

            if(!is_array($ids)){
                $ids = [$ids];
            }

            $res = $model->whereIn('_id',$ids)->orWhere(
                function($q) use ($ids) {
                    $q->whereIn('id', $ids);
                }
            )->get();


            try{

                $multiData = [];

                foreach ($res as $r){
                    $clone = clone $this->model;
                    $rc = $r->toArray();
                    unset($rc['_id']);

                    foreach($rc as $k=>$v){
                        if($k != 'id' || $k != '_id'){
                            $clone->{$k} = $v;
                        }
                    }

                    if ($this->clone_name_field != '' && isset( $clone->{$this->clone_name_field} ) ){
                        $clone->{$this->clone_name_field} = 'Copy of '.$clone->{$this->clone_name_field};
                    }

                    unset($clone->id);
                    unset($clone->_id);

                    try{
                        if(isset($clone->rev)){
                            $idVal = $clone->{$this->revision_key};
                            $nextRev = $this->getLastRev($this->revision_key, $idVal) + 1;
                            $clone->rev = $nextRev;
                            $clone->revLock = 0;
                        }else{
                            $clone->rev = 1;
                        }
                        $this->lockRev($this->revision_key, $idVal);
                    }catch (\Exception $exception){
                        debug($exception->getMessage());
                    }

                    $clone->save();

                    $multiData[] = $clone->toArray();
                    $singleData = $clone->toArray();
                }


                $retData = ($type == 'revision') ? $singleData: $multiData;

                Util::log(Auth::user()->toArray(), $request->url(), 'CLONE' ,$request->toArray(), 'SUCCESS', $this->auth_entity );

                return response()->json( ['result'=>'OK','data'=>['type'=>$type, 'data'=>$retData ] ] );

            }catch (\Exception $e){
                Util::log(Auth::user()->toArray(), $request->url(), 'CLONE' ,$request->toArray(), 'ERR: '.$e->getMessage(), $this->auth_entity );

                return response()->json( ['result'=>'ERR','data'=>$e->getMessage() ] );
            }
        }

    }

    /**
     * @hideFromAPIDocumentation
     */
    public function getLastRev($key, $idval){
        $lastRev = $this->model->where($key, '=', $idval)->orderBy('rev', 'desc')->first();
        if($lastRev){
            if(isset($lastRev->rev)){
                return intval($lastRev->rev);
            }else{
                return 1;
            }
        }
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function lockRev($key, $idval){
        $prevRev = $this->model->where($key, '=', $idval)->orderBy('rev', 'desc')->get();
        debug($prevRev->toArray());
        if($prevRev){
            foreach( $prevRev as $p){
                if( isset($p->rev) == false || $p->rev == '' || is_null($p->rev)){
                    $p->rev = 0;
                }
                $p->revLock = 1;
                $p->save();
            }
        }
    }

    public function postApprovalParam(Request $request)
    {
        $loadSession = request()->get('loadSession');
        if( !isset( $this->def_param['approvers'])){
            $this->def_param['approvers'] = WorkflowUtil::getDefaultApprovers();
        }
        if(Auth::check()){
            return response()->json( [
                'result'=>'OK',
                'data'=> $this->def_param,
                'message'=>'Approval Params'
            ], 200 );
        }else{
            return response('Unauthorized', 401);
        }
    }

    public function postApprovalRequest(Request $request)
    {
        $approvalRequest = request()->get('data');
        $tz = request()->get('tz');
        $requestData = $approvalRequest['requestData'];

        if(Auth::check()){
            if(!isset(Auth::user()->pin)){
                return response()->json( [
                    'result'=>'ERR',
                    'data'=> null,
                    'message'=>'PIN not set'
                ], 200 );
            }
            if( !Hash::check( $requestData['authorization'], Auth::user()->pin ) ){
                return response()->json( [
                    'result'=>'ERR',
                    'data'=> null,
                    'message'=>'Wrong PIN'
                ], 200 );
            }

            $exreq = ApprovalRequest::where('docId','=', $approvalRequest['doc']['_id'])
                    ->where('entity','=',$approvalRequest['entity'])
                    ->count();

            if($exreq > 0){
                return response()->json( [
                    'result'=>'ERR',
                    'data'=> null,
                    'message'=>'Pending request existed'
                ], 200 );
            }


            $approval = new ApprovalRequest();

            foreach ($requestData as $k=>$v){
                $approval->{$k} = $v;
            }

            unset($approval->authorization);
            $approval->commitUrl = $approvalRequest['commitUrl'];
            $approval->entity = $approvalRequest['entity'];
            $approval->requesterAuthorization = true;

            $approval->docView = $this->approval_view_template == '' ? '' : ( $approvalRequest['doc'][$this->approval_view_template] ?? '' );

            $approval->docTitle = $this->approval_title_field == '' ? '' : ( $approvalRequest['doc'][$this->approval_title_field] ?? $approvalRequest['entity'] );
            $approval->docDescription = $this->approval_description_field == '' ? '' : ( $approvalRequest['doc'][$this->approval_description_field] ?? '' );

            $approval->doc = $approvalRequest['doc'];
            $approval->docId = $approvalRequest['doc']['_id'];
            $approval->tz = $tz;

            $approval = TimeUtil::createTime($approval, $tz);

            $approval->save();

            $current = $this->model->find($approval->docId);

            if($current){
                $authRequest = new \stdClass();

                $approverIds = [];
                foreach($approvalRequest['requestData']['requestApprovers'] as $a){
                    $approverIds[] = $a['value'];
                }
                $approverIdStr = implode(',', $approverIds);
                foreach($approvalRequest['requestData'] as $k=>$v){
                    $authRequest->$k = $v;
                }
                $current->approverIds = $approverIds;

                $current->approvalSession = $approval->_id;

                $current->approverIdStr = $approverIdStr;
                $current->authRequestTime = Carbon::now();
                $current->authRequest = $authRequest;
                $current->save();
            }

            return response()->json( [
                'result'=>'OK',
                'data'=> $approval->toArray(),
                'message'=>'Request Submitted'
            ], 200 );
        }else{
            return response('Unauthorized', 401);
        }
    }

    public function processApprovalData($data, $request){

        return $data;
    }

    public function postApprovalCommit(Request $request, $data = null)
    {
        $data = $request->get('data');
        $tz = $request->get('tz');

        if(Auth::check()){
            if(!isset(Auth::user()->pin)){
                return response()->json( [
                    'result'=>'ERR',
                    'data'=> null,
                    'message'=>'PIN not set'
                ], 200 );
            }

            //dd($data['decisionData']['authorization'] , Auth::user()->pin );
            //dd(Auth::user()->pin);

            $auth = $data['decisionData']['authorization'];

            if( Hash::check($auth, Auth::user()->pin) ){

                $logdata = $data['decisionData'] ?? [];
                $logdata['doc'] = $data['doc'] ?? [];

                $logdata['postDoc'] = $this->processApprovalData($data ,$request);

                $logdata['upTs'] = time();
                $logdata['timestamp'] = $logdata['upTs'];

                $logmodel = new AuthorizationStatusLog();

                foreach ($logdata as $k=>$v){
                    $logmodel->$k = $v;
                }

                $logmodel = TimeUtil::createTime($logmodel, $tz);

                if($logmodel->save()){
                    return response()->json( [
                        'result'=>'OK',
                        'data'=> $data,
                        'message'=>'Decision Commited'
                    ], 200 );
                }else{
                    return response()->json( [
                        'result'=>'ERR',
                        'data'=> $data,
                        'message'=>'Faile to Commit Decision'
                    ], 200 );
                }

            }else{
                return response()->json( [
                    'result'=>'ERR',
                    'data'=> null,
                    'message'=>'Wrong PIN'
                ], 200 );
            }
        }else{
            return response('Unauthorized', 401);
        }

    }

    /**
     * @hideFromAPIDocumentation
     */
    public function postSetApprovalStatus(Request $request){
        $data = $request->input('params')['data'];
        $status = $request->input('params')['status'];

        $ids = [];
        foreach($data as $d){
            if( isset($d['_id']) ){
                $ids[] = $d['_id'];
            }

            if( isset($d['id']) ){
                $ids[] = $d['id'];
            }

        }

        $ids = array_unique($ids);

        $model = $this->model;

        if(empty($ids)){
            return response()->json( ['status'=>'ERR','data'=>'NOID' ] );
        }else{

            if(!is_array($ids)){
                $ids = [$ids];
            }

            $res = $model->whereIn('_id',$ids)
                ->orWhere(
                    function($q) use ($ids) {
                        $q->whereIn('id', $ids);
                    }
                )->get();

            try{

                foreach ($res as $r){
                    $r->approvalStatus = $status;
                    $r->revLock = $status == 'APPROVED' ? 1 : 0 ;
                    $r->save();
                }
                Util::log(Auth::user()->toArray(), $request->url(), 'APPROVE' ,$request->toArray(), 'SUCCESS: Status changed to '.$status, $this->auth_entity, $ids );
                return response()->json( ['status'=>'OK','data'=>'STATUSCHANGED' ] );

            }catch (\Exception $e){
                Util::log(Auth::user()->toArray(), $request->url(), 'APPROVE' ,$request->toArray(), 'ERR: '.$e->getMessage(), $this->auth_entity, $ids );
                return response()->json( ['status'=>'ERR','data'=>$e->getMessage() ] );
            }
        }

    }

    /**
     * @hideFromAPIDocumentation
     */
    public function postResetRevLock(Request $request){
        $data = $request->input('params')['data'];

        $ids = [];
        foreach($data as $d){
            if( isset($d['_id']) ){
                $ids[] = $d['_id'];
            }

            if( isset($d['id']) ){
                $ids[] = $d['id'];
            }

        }

        $ids = array_unique($ids);

        $model = $this->model;

        if(empty($ids)){
            return response()->json( ['status'=>'ERR','data'=>'NOID' ] );
        }else{

            if(!is_array($ids)){
                $ids = [$ids];
            }

            $res = $model->whereIn('_id',$ids)->orWhere(
                function($q) use ($ids) {
                    $q->whereIn('id', $ids);
                }
            )->get();


            try{

                foreach ($res as $r){
                    $r->revLock = 0;
                    $r->save();
                }
                Util::log(Auth::user()->toArray(), $request->url(), 'REVLOCKRESET' ,$request->toArray(), 'SUCCESS', $this->auth_entity, $ids );

                return response()->json( ['status'=>'OK','data'=>'REVLOCKRESET' ] );

            }catch (\Exception $e){
                Util::log(Auth::user()->toArray(), $request->url(), 'REVLOCKRESET' ,$request->toArray(), 'ERR: '.$e->getMessage(), $this->auth_entity, $ids );
                return response()->json( ['status'=>'ERR','data'=>$e->getMessage() ] );
            }
        }

    }

    public function postAutoSequence(Request $request)
    {
        $bounds = $request->get('bounds') ?? [];

        $pad = $this->sequence_pad ?? 4;
        $seq_field = $this->sequence_field ?? 'seq';

        $model = $this->model;
        if(!empty($bounds)){
            foreach($bounds as $k=>$v){
                $model = $model->where( $k, '=', $v);
            }
        }

        $currentmax = $model->max( $seq_field );

        $next = $currentmax + 1;

        $str = str_pad($next, $pad, '0', STR_PAD_LEFT);

        return response()->json(
            [
                'result'=>'OK',
                'data'=>[
                    'seq'=>$next,
                    'padded'=>$str
                ]
            ]
            ,200
        );


    }

    /**
     * @hideFromAPIDocumentation
     */
    public function postDel(Request $request){
        $data = $request->input('params')['data'];

        $ids = [];
        foreach($data as $d){
            if( isset($d['_id']) ){
                $ids[] = $d['_id'];
            }

            if( isset($d['id']) ){
                $ids[] = $d['id'];
            }

        }

        $ids = array_unique($ids);

        $model = $this->model;

        if(empty($ids)){
            Util::log(Auth::user()->toArray(), $request->url(), 'DELETE' ,$request->toArray(), 'ERR: No Id specified', $this->auth_entity );
            return response()->json( ['status'=>'ERR','data'=>'NOID' ] );
        }else{

            if(!is_array($ids)){
                $ids = [$ids];
            }

            $res = $model->whereIn('_id',$ids)->orWhere(
                function($q) use ($ids) {
                    $q->whereIn('id', $ids);
                }
            )->get();


            try{

                foreach ($res as $r){
                    $r->delete();
                }

                $this->afterDelete($ids, $data);

                debug(Auth::user()->toArray());
                debug($request->toArray());

                try {
                    $actor = Auth::user()->toArray();
                    Util::log( $actor['name'], $request->url(), 'DELETE', $request->toArray(), 'SUCCESS', $this->auth_entity, $ids);
                } catch (\Exception $e) {
                    debug($e->getMessage());
                }

                return response()->json( ['status'=>'OK','data'=>'CONTENTDELETED' ] );

            }catch (\Exception $e){
                debug($e->getMessage());
                try {
                    $actor = Auth::user()->toArray();
                    Util::log( $actor['name'], $request->url(), 'DELETE' ,$request->toArray(), 'ERR: '.$e->getMessage(), $this->auth_entity, $ids );
                } catch (\Exception $e) {
                    debug($e->getMessage());
                }
                return response()->json( ['status'=>'ERR','data'=>$e->getMessage() ] );
            }
        }

    }

    public function afterDelete($id, $data = null)
    {
        return false;
    }

    /* default autocomplete endpoint*/

    public function runUrlSet(){
        $this->data_url = $this->controller_base;

        $this->add_url = $this->controller_base.'/add';

        $this->update_url = $this->controller_base.'/edit';

        $this->del_url = $this->controller_base.'/del';

        $this->item_data_url = $this->controller_base.'/data';

        $this->param_url = $this->controller_base.'/param';

        $this->del_url = $this->controller_base.'/del';

        $this->clone_url = $this->controller_base.'/clone';

        $this->print_template_url = $this->controller_base.'/print-template';

        $this->download_print_url = $this->controller_base.'/print-xls';

        $this->download_summary_url = $this->controller_base.'/dl-summary';

        $this->admin_setapproval_url = $this->controller_base.'/admin/set-approval';

        $this->admin_resetrev_url = $this->controller_base.'/admin/reset-rev';

        $this->download_url = $this->controller_base.'/dlxl';

        $this->sequence_url = $this->controller_base.'/seq';

        $this->validate_url = $this->controller_base.'/validate';

        $this->import_commit_url = $this->controller_base.'/commit';

        $this->edit_page_base = $this->controller_base.'/edit/';
        $this->add_page_base = $this->controller_base.'/add/';

        $this->page_save_redirect = $this->controller_base;
        $this->page_cancel_redirect = $this->controller_base;

        $this->approval_param_url = $this->controller_base.'/approval/param';
        $this->approval_request_url = $this->controller_base.'/approval/request';
        $this->approval_commit_url = $this->controller_base.'/approval/commit';

    }

    public function runViewSet(){

        $this->table_slot_view = $this->view_base.'.table_slot';
        $this->table_head_slot_view = $this->view_base.'.table_head_slot';
        $this->table_action_view = $this->view_base.'.table_action';
        $this->table_additional_view = $this->view_base.'.table_additional';
        $this->table_modal_view = $this->view_base.'.table_modal';

        $this->table_methods_view = $this->view_base.'.table_methods';
        $this->table_computed_view = $this->view_base.'.table_computed';
        $this->table_watch_view = $this->view_base.'.table_watch';
        $this->table_event_view = $this->view_base.'.table_event';
        $this->table_advanced_search_view = $this->view_base.'.table_advanced_search';

        $this->add_methods_view = $this->view_base.'.add_methods';
        $this->add_computed_view = $this->view_base.'.add_computed';
        $this->add_watch_view = $this->view_base.'.add_watch';
        $this->add_event_view = $this->view_base.'.add_event';

        $this->edit_methods_view = $this->view_base.'.edit_methods';
        $this->edit_computed_view = $this->view_base.'.edit_computed';
        $this->edit_watch_view = $this->view_base.'.edit_watch';
        $this->edit_event_view = $this->view_base.'.edit_event';

        $this->view_methods_view = $this->view_base.'.view_methods';
        $this->view_computed_view = $this->view_base.'.view_computed';
        $this->view_watch_view = $this->view_base.'.view_watch';
        $this->view_event_view = $this->view_base.'.view_event';
        $this->tmplname_methods_view = $this->view_base.'.tmplname_method';
        $this->authorization_method_view = $this->view_base.'.authorization_method';


    }

    public function runPageViewSet(){

        $this->page_slot_view = $this->view_base.'.page_slot';
        $this->page_head_slot_view = $this->view_base.'.page_head_slot';
        $this->page_action_view = $this->view_base.'.page_action';
        $this->page_additional_view = $this->view_base.'.page_additional';
        $this->page_modal_view = $this->view_base.'.page_modal';

        $this->page_methods_view = $this->view_base.'.page_methods';
        $this->page_computed_view = $this->view_base.'.page_computed';
        $this->page_watch_view = $this->view_base.'.page_watch';
        $this->page_event_view = $this->view_base.'.page_event';

    }

    public function runAcl(){

        $this->user_role_entity = AuthUtil::loadRoleEntity(Auth::user()->roleId);

        $roleId = Auth::user()->roleId;

        $this->can_view = $this->user_role_entity->can('read', $this->auth_entity, $roleId);

        $this->can_add = $this->user_role_entity->can('create', $this->auth_entity, $roleId);

        $this->can_update = $this->user_role_entity->can('update', $this->auth_entity, $roleId);

        $this->can_delete = $this->user_role_entity->can('delete', $this->auth_entity, $roleId);

        $this->can_print = $this->user_role_entity->can('print', $this->auth_entity, $roleId);

        $this->can_multi_delete = $this->user_role_entity->can('multidelete', $this->auth_entity, $roleId);

        $this->can_revise = $this->user_role_entity->can('revise', $this->auth_entity, $roleId);

        $this->can_request_approval = $this->user_role_entity->can('request_approval', $this->auth_entity, $roleId);

        $this->can_approve = $this->user_role_entity->can('approve', $this->auth_entity, $roleId);

        $this->can_clone = $this->user_role_entity->can('clone', $this->auth_entity, $roleId);

        $this->can_multi_clone = $this->user_role_entity->can('multiclone', $this->auth_entity, $roleId);

        $this->can_upload = $this->user_role_entity->can('upload', $this->auth_entity, $roleId);

        $this->can_download_xls = $this->user_role_entity->can('downloadxls', $this->auth_entity, $roleId);

        $this->can_download_csv = $this->user_role_entity->can('downloadcsv', $this->auth_entity, $roleId);

    }

    public function runMoreMenu(){
        $this->show_more_actions =
             $this->can_print ||
             $this->can_delete ||
             $this->can_revise ||
             $this->can_approve ||
             $this->can_request_approval ||
             $this->can_clone ;

    }

    public function setupInjector($uiOptions, $data = null){

        return $uiOptions;
    }

    public function setupFormOptions($formOptions, $data = null){

        $formOptions['mobileCountryOptions'] = config('util.mobile_countries');

        return $formOptions;
    }


    public function setupPlugin(){

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuto(Request $request)
    {
        $global_query = $request->input('q');

        $data = $this->model;

        $colFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields();

        $this->col_attributes = \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColAttr();

        $fields = (is_null($this->fields))? $colFields: $this->fields ;

        if (isset($global_query) && $global_query) {
            $data = $this->filterBs4($data, $global_query, $fields);
        }

        $results = $data->get()->toArray();

        $output = [];

        foreach( $results as $r){
            $output[] = $this->rowPostProcess($r);
        }

        return response()->json($results);

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function postDlxl(Request $request)
    {
        Util::log(Auth::user()->toArray(), $request->url(), 'DOWNLOAD' ,$request->toArray(), 'INIT', $this->auth_entity );
        return $this->tableExportBs4($request, $this->res_path, $this->yml_file);
    }

    public function formGenerator(){

        $this->entity = ($this->entity == '')?$this->title: $this->entity;

        $this->data_url = strtolower((is_null($this->data_url))?$this->controller_name:$this->data_url );

        $this->download_url = strtolower((is_null($this->download_url))?$this->controller_name.'/dlxl':$this->download_url );

        $this->download_export_url = strtolower((is_null($this->download_export_url))?$this->controller_name.'/dl':$this->download_export_url );

        $this->param_url = strtolower((is_null($this->param_url))?$this->controller_name.'/param':$this->param_url );

        $this->item_data_url = strtolower((is_null($this->item_data_url))?$this->controller_name.'/data':$this->item_data_url );

        $this->update_url = strtolower((is_null($this->update_url))?$this->controller_name.'/edit':$this->update_url );

        $this->autosave_url = strtolower((is_null($this->autosave_url))?$this->controller_name.'/autosave':$this->autosave_url );

        $this->add_url = strtolower((is_null($this->add_url))?$this->controller_name.'/add':$this->add_url );

        $time_track = Auth::user()->useTimeTracker ?? false;
        $this->with_timetracking =  $time_track && env('WITH_TIMETRACKING', false);

        $attendance = Auth::user()->useAttendance ?? false;
        $this->with_attendance = $attendance && env('WITH_ATTENDANCE', false);

        return view($this->form_view)
            ->with('id',$this->item_id)
            ->with('handle', $this->handle )
            ->with('mode',$this->form_mode)
            ->with('data', $this->data)
            ->with('auxdata', $this->aux_data)
            ->with('lang', $this->lang)
            ->with('tz', $this->tz)
            ->with('js_load_transform', $this->js_load_transform)
            ->with('js_post_transform', $this->js_post_transform)
            ->with('js_data_replay', $this->js_data_replay)
            ->with('js_tab_change', $this->js_tab_change)
            ->with('js_pop_open', $this->js_pop_open)
            ->with('logo', $this->logo)
            ->with('logo_small', $this->logo_small)
            ->with('title', $this->title)
            ->with('entity', $this->entity)
            ->with('grid', $this->grid)
            ->with('layout', $this->layout)
            ->with('has_tab',$this->has_tab)
            ->with('res_path', $this->res_path)
            ->with('yml_file', $this->yml_file)
            ->with('yml_layout_file', $this->yml_layout_file)
            ->with('nav_path', $this->nav_path)
            ->with('nav_file', $this->nav_file)
            ->with('section', $this->nav_section)
            ->with('template_var', $this->template_var)
            ->with('dataurl', $this->data_url)
            ->with('downloadurl', $this->download_url)
            ->with('paramurl', $this->param_url)
            ->with('updateurl', $this->update_url)
            ->with('addurl', $this->add_url)
            ->with('delurl', $this->del_url)
            ->with('itemdataurl', $this->item_data_url)
            ->with('autosaveurl', $this->autosave_url)
            ->with('adminapprovalurl', $this->admin_setapproval_url)
            ->with('adminresetrevurl', $this->admin_resetrev_url)
            ->with('right_sidebar_header', $this->right_sidebar_header)
            ->with('right_sidebar_model', $this->right_sidebar_model)
            ->with('right_sidebar_data', $this->right_sidebar_data)
            ->with('right_sidebar_params', $this->right_sidebar_params)
            ->with('right_sidebar_template', $this->right_sidebar_template)

            ->with('backlink', $this->backlink)

            ->with('keyword0', $this->keyword0)
            ->with('keyword1', $this->keyword1)
            ->with('keyword2', $this->keyword2)

            ->with('is_create',$this->is_create)
            ->with('non_closing_save', $this->non_closing_save)
            ->with('non_saving_close', $this->non_saving_close)

            ->with('view_title_fields', $this->view_title_fields)
            ->with('update_title_fields', $this->update_title_fields)
            ->with('add_title_fields', $this->add_title_fields)
            ->with('pdf_view_title_fields', $this->pdf_view_title_fields)
            ->with('pdf_title_fields', $this->pdf_title_fields)
            ->with('title_fields', $this->title_fields)


            ->with('form_view',$this->form_view)
            ->with('form_layout',$this->form_layout)
            ->with('form_type',$this->form_type)

            ->with('view_layout',$this->viewer_layout)
            ->with('view_type',$this->viewer_type)

            ->with('print_template_url', $this->print_template_url)
            ->with('print_template', $this->print_template)
            ->with('print_modal_class', $this->print_modal_class)
            ->with('print_modal_size', $this->print_modal_size)
            ->with('print_modal_title', $this->print_modal_title)
            ->with('print_download_xls', $this->print_download_xls)

            ->with('with_workflow', $this->with_workflow)
            ->with('with_revision', $this->with_revision)
            ->with('with_timetracking', $this->with_timetracking)
            ->with('with_attendance', $this->with_attendance)
            ->with('with_advanced_search', $this->with_advanced_search)

            ->with('wf_request_doc_type', $this->wf_request_doc_type)
            ->with('wf_request_doc_id', $this->wf_request_doc_id)
            ->with('wf_request_doc_title', $this->wf_request_doc_title)
            ->with('wf_request_doc_desc', $this->wf_request_doc_desc)

            //hooks
            ->with('edit_methods_view' , $this->edit_methods_view )
            ->with('edit_watch_view' , $this->edit_watch_view )
            ->with('edit_computed_view' , $this->edit_computed_view )

            ->with('page_methods_view' , $this->page_methods_view )
            ->with('page_watch_view' , $this->page_watch_view )
            ->with('page_event_view' , $this->page_event_view )
            ->with('page_computed_view' , $this->page_computed_view )
            ->with('page_modal_view' , $this->page_modal_view )
            ->with('page_action_view' , $this->page_action_view )
            ->with('page_additional_view' , $this->page_additional_view )
            ->with('page_redirect_after_save' , $this->page_redirect_after_save )
            ->with('page_save_redirect' , $this->page_save_redirect )
            ->with('page_cancel_redirect' , $this->page_cancel_redirect )

            ->with('page_refresh_button', $this->page_refresh_button)

            ->with('tmplname_methods_view' , $this->tmplname_methods_view )
            ->with('authorization_method_view' , $this->authorization_method_view )

            ->with('customLoader', $this->customLoader)

            ->with('extra_view',$this->extra_view)
            ->with('extra_view_params',$this->extra_view_params)
            ->with('extra_query',$this->extra_query)
            ->with('show_actions', $this->show_actions )
            ->with('show_more_actions', $this->show_more_actions )
            ->with('show_print_button', $this->show_print_button )
            ->with('can_multi_select', $this->can_multi_select )

            ->with('info_topbar_show', $this->info_topbar_show)
            ->with('info_topbar_header', $this->info_topbar_header)
            ->with('info_topbar_model', $this->info_topbar_model)
            ->with('info_topbar_data', $this->info_topbar_data)
            ->with('info_topbar_params', $this->info_topbar_params)
            ->with('info_topbar_template', $this->info_topbar_template)

            ->with('import_src_url' , $this->import_src_url )
            ->with('import_preview_cols' , $this->import_preview_cols )
            ->with('import_preview_heads' , $this->import_preview_heads )
            ->with('import_upload_url' , $this->import_upload_url )
            ->with('import_commit_url' , $this->import_commit_url )

            ->with('validate_url' , $this->validate_url )

            ->with('import_upload_multi_url' , $this->import_upload_multi_url )
            ->with('import_commit_multi_url' , $this->import_commit_multi_url )

            ->with('import_upload_cell_url' , $this->import_upload_cell_url )
            ->with('import_upload_cell_url' , $this->import_upload_cell_url )

            ->with('approval_param_url' , $this->approval_param_url )
            ->with('approval_request_url' , $this->approval_request_url )
            ->with('approval_commit_url' , $this->approval_commit_url )

            ->with('add_filler', $this->add_filler )
            ->with('localStorageKey', $this->localStorageKey)

            ->with('show_title',$this->show_title)

            ->with('table_grid' , $this->table_grid )

            ->with('can_add', $this->can_add )
            ->with('can_update', $this->can_update )
            ->with('can_view', $this->can_view )
            ->with('can_save', $this->can_save )
            ->with('can_autosave', $this->can_autosave )
            ->with('can_lock', $this->can_lock )
            ->with('can_download_xls', $this->can_download_xls )
            ->with('can_download_csv', $this->can_download_csv )
            ->with('can_print', $this->can_print )
            ->with('can_upload', $this->can_upload )
            ->with('can_approve', $this->can_approve )
            ->with('can_request_approval', $this->can_request_approval )
            ->with('can_delete', $this->can_delete )
            ->with('can_multi_delete', $this->can_multi_delete );
    }

    protected function pageGenerator()
    {
        $model = $this->model;

        $this->entity = ($this->entity == '')?$this->title: $this->entity;

        $this->table_view  = is_null($this->table_view)? env('ADMIN_TABLE_VIEW', 'table.tablev2') : $this->table_view;

        $this->table_component  = is_null($this->table_component)? env('ADMIN_TABLE_COMPONENT', 'vue-good-table') : $this->table_component;

        $this->data_url = strtolower((is_null($this->data_url))?$this->controller_name:$this->data_url );

        $this->download_url = strtolower((is_null($this->download_url))?$this->controller_name.'/dlxl':$this->download_url );

        $this->download_print_url = strtolower((is_null($this->download_print_url))?$this->controller_name.'/print-xls':$this->download_print_url );

        $this->download_export_url = strtolower((is_null($this->download_export_url))?$this->controller_name.'/dl':$this->download_export_url );

        $this->param_url = strtolower((is_null($this->param_url))?$this->controller_name.'/param':$this->param_url );

        $this->item_data_url = strtolower((is_null($this->item_data_url))?$this->controller_name.'/data':$this->item_data_url );

        $this->update_url = strtolower((is_null($this->update_url))?$this->controller_name.'/edit':$this->update_url );

        $this->add_url = strtolower((is_null($this->add_url))?$this->controller_name.'/add':$this->add_url );

        $this->del_url = (is_null($this->del_url))? strtolower($this->controller_name).'/del': $this->del_url;

        $this->clone_url = (is_null($this->clone_url))? strtolower($this->controller_name).'/clone': $this->clone_url;

        $this->col_attributes = \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColAttr();

        if(strpos($this->yml_file, '_controller') === false){
            $this->import_preview_heads = \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toExportHeads();
            $ics = Util::loadResYaml($this->yml_file,$this->res_path)->toColLabel(false);

            $impCols = [];
            foreach($ics as $k=>$v){
                $impCols[] = [
                    'title'=> $v,
                    'dataIndex'=> $k,
                    'key'=> $k,
                    'width'=>'150px',
                    'ellipsis'=>true
                ];
            }

            $this->import_preview_cols = $impCols;

        }else{
            $this->import_preview_heads = \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toExportHeadings();
            $ics = $this->import_preview_heads;

            debug('ics');
            debug($ics);

            $impCols = [];
            foreach($ics as $v){
                $impCols[] = [
                    'title'=> $v,
                    'dataIndex'=> $v,
                    'key'=> $v,
                    'width'=>'150px',
                    'ellipsis'=>true
                ];
            }

            $this->import_preview_cols = $impCols;

        }


        //$this->import_preview_heads = Util::loadResYaml($this->yml_file,$this->res_path)->toColLabel(false);



        $col_filtered = Util::loadResYaml($this->yml_file,$this->res_path)->toColFieldFiltered(false);

        $this->col_filtered = $col_filtered;

        $col_sortable = Util::loadResYaml($this->yml_file,$this->res_path)->toColFieldSortable(false);

        $this->col_sortable = $col_sortable;

        $col_fields = Util::loadResYaml($this->yml_file,$this->res_path)->toColFieldName(false);

        if(!in_array('_id', $col_fields)){
            array_unshift($col_fields, '_id');
        }
        $this->col_fields = $col_fields;

        $col_heads = Util::loadResYaml($this->yml_file,$this->res_path)->toColLabel(false, true);

        if(!array_key_exists('_id', $col_heads) ){
            $col_heads['_id'] = 'Action';
        }

        $this->col_heads = $col_heads;

        $this->setupPlugin();

        $this->can_multi_select = ( $this->can_multi_delete || $this->can_multi_clone || $this->can_print ) ;

        $time_track = Auth::user()->useTimeTracker ?? false;
        $this->with_timetracking =  $time_track && env('WITH_TIMETRACKING', false);

        $attendance = Auth::user()->useAttendance ?? false;
        $this->with_attendance = $attendance && env('WITH_ATTENDANCE', false);

        if(is_null($this->table_column)){
            if(strpos($this->yml_file, '_controller') === false){
                $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields(false, $this->show_actions, $this->add_filler, $this->table_column_exclude);
            }else{
                $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFields(false, $this->show_actions, $this->add_filler, $this->table_column_exclude);
            }
        }

        return view($this->table_view)
            ->with('table_component', $this->table_component)
            ->with('data', $this->data)
            ->with('table_column' , $this->table_column )
            ->with('table_column_exclude' , $this->table_column_exclude )
            ->with('auxdata', $this->aux_data)
            ->with('plugindata', $this->plugin_data)
            ->with('lang', $this->lang)
            ->with('tz', $this->tz)
            ->with('js_load_transform', $this->js_load_transform)
            ->with('js_post_transform', $this->js_post_transform)
            ->with('js_data_replay', $this->js_data_replay)
            ->with('js_tab_change', $this->js_tab_change)
            ->with('logo', $this->logo)
            ->with('logo_small', $this->logo_small)
            ->with('title', __($this->title) )
            ->with('entity', $this->entity)
            ->with('grid', $this->grid)
            ->with('layout', $this->layout)
            ->with('has_tab',$this->has_tab)
            ->with('res_path', $this->res_path)
            ->with('yml_file', $this->yml_file)
            ->with('yml_layout_file', $this->yml_layout_file)
            ->with('nav_path', $this->nav_path)
            ->with('nav_file', $this->nav_file)
            ->with('section', $this->nav_section)
            ->with('template_var', $this->template_var)
            ->with('dataurl', $this->data_url)
            ->with('downloadurl', $this->download_url)
            ->with('downloadsummaryurl', $this->download_summary_url)
            ->with('downloadprinturl', $this->download_print_url)
            ->with('paramurl', $this->param_url)
            ->with('updateurl', $this->update_url)
            ->with('addurl', $this->add_url)
            ->with('delurl', $this->del_url)
            ->with('cloneurl', $this->clone_url)
            ->with('itemdataurl', $this->item_data_url)
            ->with('adminapprovalurl', $this->admin_setapproval_url)
            ->with('adminresetrevurl', $this->admin_resetrev_url)
            ->with('right_sidebar_header', $this->right_sidebar_header)
            ->with('right_sidebar_model', $this->right_sidebar_model)
            ->with('right_sidebar_data', $this->right_sidebar_data)
            ->with('right_sidebar_params', $this->right_sidebar_params)
            ->with('right_sidebar_template', $this->right_sidebar_template)

            ->with('non_closing_save', $this->non_closing_save)
            ->with('non_saving_close', $this->non_saving_close)


            ->with('view_title_fields', $this->view_title_fields)
            ->with('update_title_fields', $this->update_title_fields)
            ->with('add_title_fields', $this->add_title_fields)
            ->with('pdf_view_title_fields', $this->pdf_view_title_fields)
            ->with('pdf_title_fields', $this->pdf_title_fields)
            ->with('title_fields', $this->title_fields)

            ->with('page_refresh_button', $this->page_refresh_button)

            ->with('info_topbar_show', $this->info_topbar_show)
            ->with('info_topbar_header', $this->info_topbar_header)
            ->with('info_topbar_model', $this->info_topbar_model)
            ->with('info_topbar_data', $this->info_topbar_data)
            ->with('info_topbar_params', $this->info_topbar_params)
            ->with('info_topbar_template', $this->info_topbar_template)

            ->with('import_src_url' , $this->import_src_url )
            ->with('import_preview_cols' , $this->import_preview_cols )
            ->with('import_preview_heads' , $this->import_preview_heads )
            ->with('import_upload_url' , $this->import_upload_url )
            ->with('import_commit_url' , $this->import_commit_url )

            ->with('approval_param_url' , $this->approval_param_url )
            ->with('approval_request_url' , $this->approval_request_url )
            ->with('approval_commit_url' , $this->approval_commit_url )

            ->with('validate_url' , $this->validate_url )

            ->with('import_upload_multi_url' , $this->import_upload_multi_url )
            ->with('import_commit_multi_url' , $this->import_commit_multi_url )

            ->with('import_upload_cell_url' , $this->import_upload_cell_url )
            ->with('import_upload_cell_url' , $this->import_upload_cell_url )

            ->with('print_template_url', $this->print_template_url)
            ->with('print_template', $this->print_template)
            ->with('print_modal_class', $this->print_modal_class)
            ->with('print_modal_size', $this->print_modal_size)
            ->with('print_download_xls', $this->print_download_xls)
            ->with('print_modal_title', $this->print_modal_title)
            ->with('print_as_pdf', $this->print_as_pdf)
            ->with('print_summary_template', $this->print_summary_template)

            ->with('with_workflow', $this->with_workflow)
            ->with('with_revision', $this->with_revision)
            ->with('with_timetracking', $this->with_timetracking)
            ->with('with_attendance', $this->with_attendance)
            ->with('with_advanced_search', $this->with_advanced_search)

            ->with('wf_request_doc_id', $this->wf_request_doc_id)
            ->with('wf_request_doc_title', $this->wf_request_doc_title)
            ->with('wf_request_doc_desc', $this->wf_request_doc_desc)

            ->with('backlink', $this->backlink)

            ->with('keyword0', $this->keyword0)
            ->with('keyword1', $this->keyword1)
            ->with('keyword2', $this->keyword2)

            ->with('extra_view',$this->extra_view)
            ->with('extra_view_params',$this->extra_view_params)
            ->with('extra_query',$this->extra_query)
            ->with('show_actions', $this->show_actions )
            ->with('show_more_actions', $this->show_more_actions )
            ->with('show_print_button', $this->show_print_button )
            ->with('can_multi_select', $this->can_multi_select )

            ->with('add_filler', $this->add_filler )

            ->with('localStorageKey', $this->localStorageKey)

            ->with('show_title',$this->show_title)
            ->with('col_attributes', $this->col_attributes)
            ->with('col_heads', $this->col_heads)
            ->with('col_fields', $this->col_fields)
            ->with('col_filtered', $this->col_filtered)
            ->with('col_sortable', $this->col_sortable)

            ->with( 'auto_sequence',  $this->auto_sequence )

            ->with( 'sequence_url',  $this->sequence_url )
            ->with( 'sequence_field',  $this->sequence_field )
            ->with( 'sequence_pad',  $this->sequence_pad )
            ->with( 'sequence_bounds',  $this->sequence_bounds )
            ->with( 'numbering_field',  $this->numbering_field )
            ->with( 'numbering_prefix',  $this->numbering_prefix )

            ->with('form_view',$this->form_view)
            ->with('form_layout',$this->form_layout)
            ->with('form_type',$this->form_type)
            ->with('viewer_view',$this->viewer_view)
            ->with('viewer_layout',$this->viewer_layout)
            ->with('viewer_type',$this->viewer_type)
            ->with('viewer_icon',$this->viewer_icon)
            ->with('viewer_can_print',$this->viewer_can_print)
            ->with('viewer_as_document',$this->viewer_as_document)

            ->with('form_dialog_size', $this->form_dialog_size)
            ->with('viewer_dialog_size', $this->viewer_dialog_size)

            ->with('tableslotview',$this->table_slot_view)
            ->with('tableheadslotview',$this->table_head_slot_view)

            ->with('tablegridslotview',$this->table_grid_slot_view)

            ->with('add_methods_view' , $this->add_methods_view )
            ->with('add_watch_view' , $this->add_watch_view )
            ->with('add_event_view' , $this->add_event_view )
            ->with('add_computed_view' , $this->add_computed_view )
            ->with('add_icon',$this->add_icon)
            ->with('add_as_page',$this->add_as_page)
            ->with('add_page_base',$this->add_page_base)
            ->with('add_form_interval', $this->add_form_interval)

            ->with('edit_methods_view' , $this->edit_methods_view )
            ->with('edit_watch_view' , $this->edit_watch_view )
            ->with('edit_event_view' , $this->edit_event_view )
            ->with('edit_computed_view' , $this->edit_computed_view )
            ->with('edit_as_page',$this->edit_as_page)
            ->with('edit_page_base',$this->edit_page_base)
            ->with('edit_icon',$this->edit_icon)

            ->with('view_methods_view' , $this->view_methods_view )
            ->with('view_watch_view' , $this->view_watch_view )
            ->with('view_event_view' , $this->view_event_view )
            ->with('view_computed_view' , $this->view_computed_view)


            ->with('table_methods_view' , $this->table_methods_view )
            ->with('table_watch_view' , $this->table_watch_view )
            ->with('table_event_view' , $this->table_event_view )
            ->with('table_computed_view' , $this->table_computed_view )

            ->with('tmplname_methods_view' , $this->tmplname_methods_view )
            ->with('authorization_method_view' , $this->authorization_method_view )

            ->with('table_modal_view' , $this->table_modal_view )
            ->with('table_action_view' , $this->table_action_view )
            ->with('table_additional_view' , $this->table_additional_view )
            ->with('table_advanced_search_view' , $this->table_advanced_search_view )
            ->with('table_advanced_search_type' , $this->table_advanced_search_type )
            ->with('table_advanced_search_size' , $this->table_advanced_search_size )

            ->with('table_grouped' , $this->table_grouped )
            ->with('table_grid' , $this->table_grid )

            ->with('customLoader', $this->customLoader)

            ->with('grid_item_view' , $this->grid_item_view )

            ->with('can_add', $this->can_add )
            ->with('can_update', $this->can_update )
            ->with('can_view', $this->can_view )
            ->with('can_autosave', $this->can_autosave )
            ->with('can_download_xls', $this->can_download_xls )
            ->with('can_download_csv', $this->can_download_csv )
            ->with('can_upload', $this->can_upload )
            ->with('can_approve', $this->can_approve )
            ->with('can_request_approval', $this->can_request_approval )
            ->with('can_print', $this->can_print )
            ->with('can_delete', $this->can_delete )
            ->with('can_multi_delete', $this->can_multi_delete )
            ->with('can_revise', $this->can_revise )
            ->with('can_clone', $this->can_clone )
            ->with('can_multi_clone', $this->can_multi_clone );

    }

    private function tableResponder(Request $request)
    {
        set_time_limit(0);
        date_default_timezone_set('Asia/Jakarta');

        //extract($request->only(['query', 'limit', 'page', 'orderBy', 'ascending', 'byColumn']));

        $params = $request->input('params');

        $limit = intval($params['limit']);

        $page = intval($params['page']);

        $orderBy = isset($params['orderBy'])?$params['orderBy']:'_id';

        $ascending = $params['ascending'];

        $byColumn = $params['byColumn'];

        $query = $params['query'];

        $data = $this->model;

        $colFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields();

        $fields = (is_null($this->fields))? $colFields: $this->fields ;

        if (isset($query) && $query) {
            $data = $byColumn == 1 ?
                $this->filterByColumn($data, $query) :
                $this->filter($data, $query, $fields);
        }

        $count = $data->count();

        $data = $data->limit($limit)
            ->skip($limit * ($page - 1));

        if (isset($orderBy)) {
            $direction = $ascending == 1 ? 'ASC' : 'DESC';
            $data = $data->orderBy($orderBy, $direction);
        }

        $results = $data->get()->toArray();

        $json = [
                'data' => $results,
                'count' => $count,
                'limit' => $limit,
                'orderBy' =>$orderBy,
                'orderDir' => $direction
            ];

        return response()->json($json);
    }

    public function externalData($data, $request)
    {
        return $data;
    }

    private function tableResponderBs4(Request $request)
    {
        set_time_limit(0);

        date_default_timezone_set('Asia/Jakarta');

        //extract($request->only(['query', 'limit', 'page', 'orderBy', 'ascending', 'byColumn']));

        $page = 1;
        $limit = 10;
        $sorts = [];
        $query = [];
        $global_query = '';

        $echo = $request->get('echo');

        $colFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields();

        $data = $this->model;

        $this->col_attributes = \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColAttr();


            $params = $request->input();
            $sortObj = $params['sort'];

            foreach($sortObj as $st){
                debug('gtable sortObj',$st);
                if( !(empty($st['field']) && empty($st['type']) ) ){
                    $sorts[] = ['name'=>$st['field'], 'order'=>$st['type'], 'caseSensitive'=>false];
                }
            }

            //limit & pagination
            $page = (isset($params['page']))?intval($params['page']):1;
            $limit = intval($params['perPage']);

            debug($this->col_attributes);

            if(isset($params['columnFilters'])){
                $query = $params['columnFilters'];

                if(is_array($query) && !empty($query)){

                    $queries = [];
                    foreach($query as $k=>$v){

                        $type = $this->col_attributes[$k]['type'];

                        if(!empty($v)){
                            $queries[] = [
                                'name'=>$k,
                                'type'=>$type,
                                'text'=>$v
                            ];
                        }
                    }
                    $query = $queries;
                }

            }

            if(isset($params['searchTerm'])){
                $global_query = $params['searchTerm'];
            }


        $fields = (is_null($this->fields))? $colFields: $this->fields ;

        // add queries

        if (isset($query) && $query) {

            $data = $this->filterByColumnBs4($data, $query);
        }

        debug('global_query');
        debug($global_query);


        if (isset($global_query) && $global_query) {

            $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFieldSearchable();

            if(strpos($this->yml_file, '_controller') === false){
                $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFieldSearchable();
            }else{
                $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFieldSearchable();
            }

            info('searchyml', [ $this->yml_file, $this->res_path ]);
            info('searchcols', [$searchFields]);

            $data = $this->filterBs4($data, $global_query, $searchFields);
        }

        $data = $this->additionalQuery($data, $request);

        $total = $data->count();

        $count = $data->count();

        $data = $data->limit( intval($limit) )
            ->skip($limit * (intval($page) - 1));

        if (isset($sorts) && !empty($sorts)) {
            foreach ($sorts as $sort){
                $data = $data->orderBy($sort['name'], $sort['order']);
            }
        }else{
            if(!is_null($this->defOrderField)){
                $data = $data->orderBy($this->defOrderField, $this->defOrderDir);
            }

            if($this->with_workflow){
                $data = $data->orderBy('rev', 'desc');
            }
        }

        $results = $data->get()->toArray();

        $results = $this->externalData($results, $request);

        $output = [];

        foreach( $results as $r){
            $output[] = $this->rowPostProcess($r);
        }

        $json = [
            'echo'=>$echo,
            'data' => $output,
            'count' => count($output),
            'total' => $total,
            'sort'=>$sorts,
            'totalRecords'=> $total
        ];

        if(Auth::check()){
            return response()->json($json, 200);
        }else{
            return response()->json(['error'=>'Unauthorized'], 401);
        }

    }

    private function tableExportBs4(Request $request, $respath, $ymlpath)
    {
        set_time_limit(0);
        date_default_timezone_set('Asia/Jakarta');

        $payload = $request->input('params')['payload'];

        $downloadMethod = $request->input('params')['downloadMethod'];
        $downloadChunk = $request->input('params')['downloadChunk'] ?? intval( config('util.download_qty')) ;
        $totalRecords = $request->input('params')['totalRecords'];

        $page = 1;
        $limit = 10;
        $sorts = [];
        $query = [];
        $global_query = '';

        if(isset($payload['isGT']) && $payload['isGT']){
            debug('export GT');
            //vue-good-table
            $params = $payload;
            $sortObj = $params['sort'];

            foreach($sortObj as $st){
                debug('gtable sortObj',$st);
                if( !(empty($st['field']) && empty($st['type']) ) ){
                    $sorts[] = ['name'=>$st['field'], 'order'=>$st['type'], 'caseSensitive'=>false];
                }
            }

            $selectedRows = $request->input('params')['selectedRows'];

            debug('selRows');
            debug( $selectedRows );

            //limit & pagination
            $page = (isset($params['page']))?intval($params['page']):1;

            $page = $page - 1;

            $limit = intval($params['perPage']);

            if(isset($params['columnFilters'])){
                $query = $params['columnFilters'];
            }

            if(isset($params['searchTerm'])){
                $global_query = $params['searchTerm'];
            }

            $filetype = $params['filetype'];

        }else{

            $filetype = $payload['event_payload']['filetype'];

            $selectedRows = $payload['selectedItems'];

            $params = $request->input('params')['queryParams'];

            $limit = intval($params['per_page']);

            $page = intval($params['page']);

            $sorts = isset($params['sort'])?$params['sort']:['name'=>'_id', 'order'=>'asc', 'caseSensitive'=>false];

            $query = $params['filters'];

            $global_query = $params['global_search'];

        }

        if($this->collection_name == ''){
            $data = $this->model;
        }else{
            $data = DB::connection($this->connection_name)->table($this->collection_name);
        }

        $colFields =  \App\Helpers\Util::loadResYaml( $ymlpath,$respath )->toColFields();

        $this->col_attributes = \App\Helpers\Util::loadResYaml( $ymlpath,$respath )->toColAttr();


        // add queries

        if (isset($query) && $query) {
            $data = $this->filterByColumnBs4($data, $query);
        }

        if (isset($global_query) && $global_query) {

            $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFieldSearchable();

            if(strpos($this->yml_file, '_controller') === false){
                $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFieldSearchable();
            }else{
                $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFieldSearchable();
            }

            info('searchyml', [ $this->yml_file, $this->res_path ]);
            info('searchcols', [$searchFields]);

            $data = $this->filterBs4($data, $global_query, $searchFields);
        }

        $data = $this->additionalQuery($data, $request);

        if(!empty($selectedRows) ){
            $ids = [];
            foreach ($selectedRows as $sr){
                $ids[] = $sr['_id'];
            }
            info('ids',$ids);
            $data = $data->whereIn('_id', $ids);
        }

        if (isset($sorts)) {
            foreach ($sorts as $sort){
                $data = $data->orderBy($sort['name'], $sort['order']);
            }
        }

        //exported file headings
        if(strpos($this->yml_file, '_controller') === false){
            $headings = \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toExportHeads();
        }else{
            $headings = \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toExportHeadings();
        }

        info('export headings', $headings);

        //$downloadPageCount = intval( config('util.download_qty'));
        $downloadPageCount = $downloadChunk;

        $fname =  $this->controller_name.'_'.date('d-m-Y-H-m-s',time());

        $downloadMethod = ($totalRecords < $downloadPageCount) ? 'all': $downloadMethod;

        $route = Route::current();

        $export_xls = '';
        $export_csv = '';
        $export_xls_array = [];
        $export_csv_array = [];
        $multiple = false;
        $limit = intval($downloadChunk);

        if($downloadMethod == 'chunked'){
            $multiple = true;
            $cnt = ceil($totalRecords / $downloadPageCount);

            for( $t = 0; $t < $cnt; $t++){
                $pnum = str_pad( $t, 2, '0', STR_PAD_LEFT );
                $fpath = 'exports/'.$fname.'_page_'.$pnum;
                $page = $t;

                //$eximp = Excel::store(new GenericExport($data, $limit,$page, $headings, $this->timefields, $this->auth_entity), $fpath.'.xlsx','local',\Maatwebsite\Excel\Excel::XLSX);
                //$csvimp = Excel::store(new GenericExport($data, $limit,$page, $headings, $this->timefields, $this->auth_entity), $fpath.'.csv', 'local',\Maatwebsite\Excel\Excel::CSV);

                $fullpath = storage_path('app/'.$fpath);

                if($payload['filetype'] == 'csv'){
                    $csvimp = $this->exportModel($data, $limit,$page, $headings, $fullpath.'.csv', 'csv', $this->timefields);
                    $export_csv = 'api/v1/core/export/csv/'.$fname.'_page_'.$pnum.'.csv';
                    $csv_url = url($export_csv);
                    $export_csv_array[] = $csv_url;
                }else{
                    $eximp = $this->exportModel($data, $limit,$page, $headings, $fullpath.'.xlsx', 'xlsx', $this->timefields);
                    $export_xls = 'api/v1/core/export/xls/'.$fname.'_page_'.$pnum.'.xlsx';
                    $xls_url = url($export_xls);
                    $export_xls_array[] = $xls_url;
                }


                Util::logDownload($xls_url, $fname.'_page_'.$pnum.'.xlsx' );
                Util::logDownload($csv_url, $fname.'_page_'.$pnum.'.csv' );

            }

            $result = array(
                'status'=>'OK',
                'filename'=>$fname,
                'urlxls'=>url($export_xls),
                'multiple'=>$multiple,
                'urlxlsfiles'=>$export_xls_array,
                'urlcsv'=>url($export_csv),
                'urlcsvfiles'=>$export_csv_array
            );

            if(Auth::check()){
                return response()->json($result, 200);
            }else{
                return response('Unauthorized', 401);
            }


        }else{
            $limit = intval($totalRecords) + 1;

            $fpath = 'exports/'.$fname.'_page_00';

            if( env('WITH_EXPORT_QUEUE', true) && $this->collection_name != '' ){

                if($payload['filetype'] == 'csv'){
                    ExportXlsJob::dispatch($this->collection_name, $this->connection_name ,$headings ,$fpath.'.csv','local',\Maatwebsite\Excel\Excel::CSV );
                    $export_csv = 'api/v1/core/export/csv/'.$fname.'_page_00.csv';
                    $csv_url = url($export_csv);
                    $export_csv_array[] = $csv_url;
                }else{
                    ExportXlsJob::dispatch($this->collection_name, $this->connection_name ,$headings ,$fpath.'.xlsx','local',\Maatwebsite\Excel\Excel::XLSX );
                    $export_xls = 'api/v1/core/export/xls/'.$fname.'_page_00.xlsx';
                    $xls_url = url($export_xls);
                    $export_xls_array[] = $xls_url;
                }




                $result = array(
                    'status'=>'OK',
                    'filename'=>$fname,
                    'urlxls'=>url($export_xls),
                    'multiple'=>$multiple,
                    'urlxlsfiles'=>$export_xls_array,
                    'urlcsv'=>url($export_csv),
                    'urlcsvfiles'=>$export_csv_array
                );

                if(Auth::check()){
                    return response()->json($result, 200);
                }else{
                    return response('Unauthorized', 401);
                }
            }else{
                $fullpath = storage_path('app/'.$fpath);

                if($payload['filetype'] == 'csv'){
                    $csvimp = $this->exportModel($data, $limit,$page, $headings, $fullpath.'.csv', 'csv', $this->timefields);
                    $export_csv = 'api/v1/core/export/csv/'.$fname.'_page_00.csv';
                    $csv_url = url($export_csv);
                    $export_csv_array[] = $csv_url;
                    $datacount = $csvimp;
                }else{
                    $eximp = $this->exportModel($data, $limit,$page, $headings, $fullpath.'.xlsx', 'xlsx', $this->timefields);
                    $export_xls = 'api/v1/core/export/xls/'.$fname.'_page_00.xlsx';
                    $xls_url = url($export_xls);
                    $export_xls_array[] = $xls_url;
                    $datacount = $eximp;
                }

                $result = array(
                    'status'=>'OK',
                    'filename'=>$fname,
                    'urlxls'=>url($export_xls),
                    'multiple'=>$multiple,
                    'urlxlsfiles'=>$export_xls_array,
                    'urlcsv'=>url($export_csv),
                    'urlcsvfiles'=>$export_csv_array,
                    'exportcount'=>$datacount
                );

                if(Auth::check()){
                    return response()->json($result, 200);
                }else{
                    return response('Unauthorized', 401);
                }

            }

        }

    }

    protected function exportModel( $model , $limit ,$page, $headings, $fullpath, $format,  $timefields = []){

        if( is_array($model) ){
            $result = $model;
            $datacount = count($model);
            $headingsrow = array_values($headings);
            $headings = array_keys($headings);
        }else{
            $datacount = $model->count();
            $skip = $limit * intval($page);
            $result = $model->take($limit)->skip($skip)->get();
            $headingsrow = $headings;
        }

        $headStyle = (new StyleBuilder())
            ->setFontBold()
            ->setCellAlignment(CellAlignment::CENTER)
            ->setBackgroundColor(Color::rgb(200, 200, 200))
            ->build();

        if($format == 'xlsx' ){
            $writer = WriterEntityFactory::createXLSXWriter()
                ->setShouldCreateNewSheetsAutomatically(true)
                ->openToFile($fullpath);
        }else{
            $writer = WriterEntityFactory::createCSVWriter()
                ->openToFile($fullpath);
        }
        $headrow = WriterEntityFactory::createRowFromArray($headingsrow, $headStyle);
        $writer->addRow($headrow);
//            $writer->addRows($rows);
//
        foreach($result as $r){
            $cells = [];
            foreach($headings as $h){
                $val = isset($r[$h]) ? $r[$h] : '--';
                $val = $val ?? '--';
                if( $val instanceof UTCDateTime){
                    $val = $val->toDateTime()->format('Y-m-d H:is');
                }
                if($val instanceof ObjectId){
                    $val = $val->serialize();
                }
                if( is_array( $val ) ){
                    if(is_null( $val ) || empty($val) ){
                        $val = '--';
                    }else{
                        try {
                            $val = json_encode($val);
                        }catch(\Exception $exception){
                            $val = '--';
                        }
                    }
                }
                if( is_object( $val ) ){
                    if(is_null( $val ) || empty($val) ){
                        $val = '--';
                    }else{
                        try {
                            $val = serialize( $val );
                        }catch(\Exception $exception){
                            $val = '--';
                        }
                    }
                }
                if(is_null( $val ) || empty($val) ){
                    $val = '--';
                }
                $rx = $val;
                $cell = WriterEntityFactory::createCell($rx);
                if(is_null($cell)){
                    $cells[] = WriterEntityFactory::createCell('--');
                }else{
                    $cells[] = $cell ;
                }
            }
            $srow = WriterEntityFactory::createRow($cells);
            try {
                if(!is_null($srow)){
                    $writer->addRow($srow);
                }
            }catch (Exception $exception){

            }
        }
        $writer->close();

        return $datacount;
    }


    protected function getExportCollection($model, $limit, $page, $headings, $timefields, $entity )
    {
        $skip = $limit * intval($page);
        $result = $model->take($limit)->skip($skip)->get();

        $out = [];

        foreach($result as $r){
            $items = [];
            foreach ($headings as $h){
                if( in_array($h , $timefields)){
                    //info('TIME PARAM EXP', [ Carbon::make($r->{$h})->toDateTimeString(), $this->entity, $h]);

                    $item  =  TimeUtil::out( Carbon::make($r->{$h}) , $entity, $h );

                    //info('TIME PARAM EXP', [ $item->toDateTimeString(), $this->entity, $h]);
                }else{
                    $item = $r->{$h} ?? "";
                }

                $items[$h] = $item;
            }
            $out[] = $items;
        }

        return $out;
    }

    protected function filterByColumn($data, $queries)
    {
        return $data->where(function ($q) use ($queries) {
            foreach ($queries as $field => $query) {
                if (is_string($query)) {
                    $q->where($field, 'LIKE', "%{$query}%");
                } else {
                    $start = Carbon::createFromFormat('Y-m-d', $query['start'])->startOfDay();
                    $end = Carbon::createFromFormat('Y-m-d', $query['end'])->endOfDay();
                    $q->whereBetween($field, [$start, $end]);
                }
            }
        });
    }

    protected function filter($data, $query, $fields)
    {
        return $data->where(function ($q) use ($query, $fields) {
            foreach ($fields as $index => $field) {
                $method = $index ? 'orWhere' : 'where';
                $q->{$method}($field, 'LIKE', "%{$query}%");
            }
        });
    }

    protected function rowPostProcess($row)
    {

        $types = $this->col_attributes;
        foreach($types as $k=>$t){
            if( isset( $row[$k] )){
                if($t['type'] == 'dateranges'){
                    $kt = $row[$k];
                    //$row[$k] = print_r($row[$k]);
                    $row[$k] = ($kt->startDate?? '' ).' - '.($kt->endDate?? '');
                }
                if($t['type'] == 'action'){
                    $kt = $row[$k];
                    //$row[$k] = print_r($row[$k]);
                    $row[$k] = '<a class="btn btn-outline-primary" href="#" :onclick="'.$t['callback'].'" >'.$t['label'].'</a>';
                }
            }
        }

        return $row;

    }

    protected function filterByColumnBs4($data, $queries)
    {
        return $data->where(function ($q) use ($queries) {
            foreach ($queries as $query) {
                if( $query['type'] == 'simple' || $query['type'] == 'text' ){
                    $q->where($query['name'], 'LIKE', "%{$query['text']}%");
                }

                if( $query['type'] == 'select' ){
                    $q->whereIn($query['name'], $query['selected_options'] );
                }

                if ($query['type'] == 'date') {
                    $start = Carbon::createFromFormat('Y-m-d', $query['start'])->startOfDay();
                    $end = Carbon::createFromFormat('Y-m-d', $query['end'])->endOfDay();
                    $q->whereBetween($field, [$start, $end]);
                }
            }
        });
    }

    protected function filterBs4($data, $query, $fields)
    {

        if($query == ''){
            return $data;
        }
        $data = $data->where(function ($q) use ($query, $fields) {


            $fields = (is_string($fields))?json_decode($fields):$fields;
            $index = 0;

            //print_r($fields);

            foreach ($fields as $field) {

                $method = $index ? 'orWhere' : 'where';

                if(is_array($field)){

                    if( $field['datatype'] == 'text' || $field['datatype'] == 'string' ||
                        ( isset($field['datatype']['vue']['type']) && (
                                $field['datatype']['vue']['type'] == 'text' || $field['datatype']['vue']['type'] == 'string'
                            )
                        )
                    ){
                        if($field['name'] == '_id'){
                            $id_query = new ObjectId($query);
                            $q->{$method}($field['name'], '=', $id_query );
                            debug('A '.$field['name'].' id '."{$query}");
                        }else{
                            $q->{$method}($field['name'], 'LIKE', "%{$query}%");
                            debug('A '.$field['name'].' LIKE '."%{$query}%");
                        }

                    }else{
                        if($field['datatype'] == 'number' || $field['vue']['type'] == 'number'){
                            $numquery = doubleval($query);
                        }
                        if($field['datatype'] == 'double' || $field['vue']['type'] == 'double'){
                            $numquery = doubleval($query);
                        }
                        if($field['datatype'] == 'integer' || $field['vue']['type'] == 'integer'){
                            $numquery = intval($query);
                        }

                        $q->{$method}($field['name'], '=', $numquery );

                        debug('A '.$field['name'].' = '.$numquery);

                    }

                }else{

                    debug( $field );

                    if( $field->datatype == 'text' || $field->datatype == 'string' ||
                        (
                            isset($field->vue->type) && ( $field->vue->type == 'text' || $field->vue->type == 'string')
                        )
                    ){
                        if($field->name == '_id'){
                            try {
                                $id_query = new ObjectId($query);
                                $q->{$method}($field->name, '=', $id_query );
                            }catch (\Exception $exception){

                            }
                        }else{
                            $q->{$method}($field->name, 'LIKE', "%{$query}%");
                            debug('O '.$field->name.' LIKE '."%{$query}%");
                        }

                    }else{
                        $numquery = doubleval($query);

                        if($field->datatype == 'number' || ( isset($field->vue->type) &&  $field->vue->type == 'number' )){
                            $numquery = doubleval($query);
                        }
                        if($field->datatype == 'integer' || ( isset($field->vue->type) &&  $field->vue->type == 'integer')){
                            $numquery = intval($query);
                        }
                        $q->{$method}($field->name, '=', $numquery );

                        debug('O '.$field->name.' = '.$numquery);

                    }

                }

                $index++;
            }
        });

        return $data;
    }

    /*Additional query hook*/

    public function additionalQuery($model, Request $request){
        return $model;
    }

    /* used to load initial parameter for add form */
    /**
     * @hideFromAPIDocumentation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function getParam()
    {
        $loadSession = request()->get('loadSession');

        $handle = Str::random(12);
        $this->def_param['handle'] = $handle;
        $this->def_param['loadSession'] = $loadSession;

        $defaultData =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toVueDataModel('plain');

        //$this->def_param = array_merge( $this->def_param, $defaultData );

        if(Auth::check()){
            return response()->json( $this->def_param, 200 );
        }else{
            return response('Unauthorized', 401);
        }

    }

    public function getData($id, $additional_data = null){

        $request = Request::capture();
        $action = $request->get('action');

        $population = $this->model->find($id);

        if($population){
            $population = $population->toArray();
        }else{
            $population = [];
        }


        if(!is_null($additional_data) && is_array($additional_data)){
            foreach($additional_data as $k=>$v){
                $population[$k] = $v;
            }
        }

        $population = $this->beforeUpdateForm($population);

        $population['selOptions'] = $this->sel_options;

        unset($population['updated_at']);
        unset($population['updatedAt']);
        unset($population['lastUpdate']);
        unset($population['created_at']);
        unset($population['createdAt']);
        unset($population['createdDate']);

        if(Auth::check()){
            Util::log(Auth::user()->toArray(), $request->url(), $action ,$request->toArray(), 'OK', $this->auth_entity, $id );

            return response()->json($population, 200);
        }else{
            return response('Unauthorized', 401);
        }

    }


    public function postPrintTemplate(Request $request)
    {
        $key = $request->input('q');

        $data = $request->input('data');

        $doc = $data;

        unset($data['raw_json']);

        $d = new PrintCache();

        $jstr = json_encode($data);

        $jstr = preg_replace('/\$/', '', $jstr);

        $jdata = json_decode($jstr, true);

        $data = $jdata;

        $data = $this->beforeSetPrintData($data, $key, $request);

        $d->content = $data;

        $d->save();

        $doc = $doc[0] ?? false;

        if($doc){
            //print_r($doc);
            $_id = $doc['_id'] ?? null;
            $docType = $doc['docType'] ?? null;

            $next['approveAs'] = 'Reader';


            $next['approverId'] = Auth::user()->_id;
            $next['approverName'] = Auth::user()->name ?? '';
            $next['authorizationSign'] = null;
            $next['initialSign'] = null;
            $next['note'] = '';
            $next['decision'] = 'READ';

            Util::approvallog( $next, $doc , $_id, $docType, $this->auth_entity );

            $rlog = [];
            $rlog['key'] = Auth::user()->_id;
            $rlog['label'] = Auth::user()->name ?? '';
            $rlog['ts'] = time();
            $rlog['obj'] = $next;
            $this->afterLogPrintData($doc, $rlog);
        }

        if( $this->print_as_pdf ){
            return response()->json(['result'=>'OK', 'cacheid'=>$d->_id  ,'printurl'=>url( 'pdf/'.$key.'/'.$d->_id ) ], 200);
        }else{
            return response()->json(['result'=>'OK', 'cacheid'=>$d->_id , 'printurl'=>url( 'print/'.$key.'/'.$d->_id ) ], 200);
        }
    }

    public function postDlSummary(Request $request)
    {
        Util::ajaxDebug();

        $key = $request->input('q');

        $d = new PrintCache();

        $data = $this->beforeSetPrintData([], $key, $request);

        $d->content = $data;

        return $this->postPrintXls( $request, $d);
    }

    public function postPrintXls(Request $request, $data = null)
    {
        $templateslug = $request->get('q');

        $id = $request->get('id');

        if( is_null($data) ){
            $tdata = PrintCache::find($id);
        }else{
            $tdata = $data;
        }

        $headings = $this->prepareXlsHeadings($tdata, $templateslug, $request);

        $data = $this->prepareXlsRows($tdata, $headings, $templateslug, $request);

        $fname = $templateslug.'_prn_'.date('Ymd-His', time());

        $fpath = 'exports/'.$fname;

        $fullpath = storage_path('app/'.$fpath);

        $limit = 0;

        $page = 0;

        $eximp = $this->exportModel($data, $limit,$page, $headings, $fullpath.'.xlsx', 'xlsx', $this->timefields);
        $export_xls = 'api/v1/core/export/xls/'.$fname.'.xlsx';
        $xls_url = url($export_xls);
        $export_xls_array[] = $xls_url;
        $datacount = $eximp;

        $result = array(
            'status'=>'OK',
            'filename'=>$fname,
            'urlxls'=>url($export_xls),
            'multiple'=>false,
            'urlxlsfiles'=>$export_xls_array,
            'exportcount'=>$datacount
        );

        if(Auth::check()){
            return response()->json($result, 200);
        }else{
            return response('Unauthorized', 401);
        }
    }

    public function prepareXlsRows($data, $headings, $template, $request)
    {
        /* default automated action, should be overridden for actual summary download */
        if(is_object($data) && isset($data->content)){
            $rows = $data->content;

            $exrows = [];
            $count = 1;
            foreach($rows as $r){
                $rd['no'] = $count;
                foreach ($headings as $k=>$h){
                    $rd[$k] = $r[$k] ?? '';
                }

                $exrows[] = $rd;
                $count++;
            }

            $data = $exrows;
        }

        return $data;
    }

    public function prepareXlsHeadings($data, $template, $request)
    {
        /* default automated action, should be overridden for actual summary download */

        if(strpos($this->yml_file, '_controller') === false){
            $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields(false);
        }else{
            $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFields(false);
        }

        $heads = [];
        $tc = 0;
        foreach( $searchFields as $sf){
            if($sf['title'] != ''){
                $heads[ $sf['field'] ] = $sf['title'] ?? 'No Title '.$tc;
                $tc++;
            }
        }

        return $heads;
    }

    public function afterLogPrintData($doc, $next)
    {

    }

    public function beforeSetPrintData(Array $data, $template, $request = null)
    {
        info('print_template', [$template]);
        info('print_data', [$data]);
        info('print_request', [$request]);

        return $data;
    }

    /**
     * post data commits, selected data from preview screen will actually inserted / updated into target collection
     * it batch insertion success, it should be redirected to calling page
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     *
     */
    public function postCommit(Request $request)
    {
        set_time_limit(0);
        $importid = $request->get('importid');
        $params = $request->get('params');
        if( empty($params['selectedKeys'])){
            if($params['importAllData']){
                $res = Importsession::where('importid', '=', $importid)->get();
            }else{
                return response()->json(['result'=>'ERR', 'message'=>'No data imported' ,'data'=>null ], 409);
            }
        }else{
            $res = Importsession::where('importid', '=', $importid)
                ->whereIn('_id', $params['selectedKeys'] )
                ->get();
        }

        $importCount = $res->count();
        $commited = 0;

        debug('importCount', $importCount);

        try{
            foreach($res->toArray() as $r){

                $r = $this->beforeImportCommit($r);

                if($r){
                    unset($r['_id']);
                    unset($r['importid']);

                    $n = clone $this->model;

                    foreach($r as $k=>$v){
                        $n->{$k} = $v;
                    }

                    $now = Carbon::now(date_default_timezone_get());

                    $n->updated_at = $now;
                    $n->updatedAt = $now;
                    $n->lastUpdate = $now;
                    $n->created_at = $now;
                    $n->createdAt = $now;
                    $n->createdDate = $now;

                    $n->domainNs = env('APP_NAMESPACE', '');

                    $n->save();

                    $this->afterCommitSave($n);

                    $commited++;
                }

            }

        }catch(\Exception $exception){

            return response()->json(['result'=>'ERR', 'message'=>$exception->getMessage() ,'data'=>null ], 409);

        }

        //check total by group
        $totalGroup = 0;
        if($request->has('groupBy') && $request->has('aux')){
            if($request->get('groupBy') != '' ){
                $groupBy = $request->get('groupBy');
                $aux = $request->get('aux');
                if(isset($aux[$groupBy])){
                    $totalGroup = $this->model->where($groupBy, '=', $aux[$groupBy] )->count();
                }
            }
        }


        if(Auth::check()){
            Util::log(Auth::user()->toArray(), $request->url(), 'IMPORTCOMMIT' ,$request->toArray(), 'SUCCESS', $this->auth_entity );
            return response()->json(['result'=>'OK', 'data'=>[ 'commited'=>$commited, 'uploaded'=>$importCount, 'totalGroup'=>$totalGroup ] ], 200);
        }else{
            return response('Unauthorized', 401);
        }

    }

    public function afterCommitSave($dataObject){

    }

    /**
     * Commit callback for last minute processing before actual row insert
     * */
    public function beforeImportCommit($data)
    {
        unset( $data['sheet'] );
        unset( $data['raw_json'] );

        $data['handle'] = Util::alphaRandom(6);

        return $data;
    }


    /**
     * Download route for Excel data export
     * @hideFromAPIDocumentation
     * @param $filename
     * @return mixed
     */
    public function getDl($filename)
    {
        $headers = array(
            'Content-Type: application/vnd.ms-excel'
        );
        return Storage::download('exports/'.$filename, $filename, $headers);
    }

    /**
     * Download route for CSV data export
     * @hideFromAPIDocumentation
     * @param $filename
     * @return mixed
     */
    public function getCsv($filename)
    {
        $headers = array(
            'Content-Type: text/csv'
        );
        return Storage::download('exports/'.$filename, $filename, $headers);
    }

    public function postPrint(Request $request)
    {

    }

    public function beforeValidateAdd($data)
    {
        return $data;
    }

    public function beforeAddForm()
    {
        return null;
    }

    public function tagToArray($tags){
        return explode($tags, ",");
    }

    /**
     * front end to backend validation endpoints
     */

    public function postValidate(Request $request)
    {
        $email = $request->get('email');
        $exists = 1;
        if( trim($email) != ''){
            $exists = $this->model->where('email','=', trim($email))->count();
        }

        return response()->json([
            'result'=>'OK',
            'data'=>[
                'email'=>$exists
            ]
        ],200);
    }

    /**
     * Convert date object to displayable datetime string
     * @param $datetime mixed|string datetime object to convert to datetime string
     * @return mixed|string
     */
    public function mongoUTCtoDatetime($datetime)
    {
        try {
            if(is_null($datetime) ){
                debug('isNull');
                $datetime = Carbon::now('UTC')->startOfDay()->toDateTime()->format("Y-m-d H:i:s");
            }else{
                if( is_string($datetime) ){
                    debug('isDateString');
                    $datetime = Carbon::parse($datetime)->toDateTime()->format("Y-m-d H:i:s");
                }else{
                    debug('isMongoUTC');
                    $datetime = $datetime->toDateTime()->format("Y-m-d H:i:s");
                }
            }
            return $datetime;
        }catch (\Exception $exception){
            return $datetime;
        }

    }

    /**
     * Adjust datetimestring with timezone to UTC required for correct MongoDb store
     * @param $datetimestring string Datetime string in current default timezone
     * @param $tz string Origin Timezone name ie : Asia/Jakarta, UTC
     * @return float|int Milliseconds precision timestamp since Epoch
     *
     */
    public function nowToMongoUTC($tz = null)
    {
        debug('Now UTC');
        debug( date_default_timezone_get());

        $timezone = $tz ?? env('DEFAULT_TIME_ZONE', 'Asia/Jakarta');

        $tms = Carbon::now($timezone);

        debug($tms->toDateTimeString());

        $tms->shiftTimezone('UTC');

        debug($tms->toDateTimeString());

        //return $tms->toDateTime();

        $tms = $tms->getPreciseTimestamp(3);

        return new \MongoDB\BSON\UTCDateTime($tms);
    }

    /**
     * Adjust datetimestring with timezone to UTC required for correct MongoDb store
     * @param $datetimestring string Datetime string in current default timezone
     * @param $tz string Origin Timezone name ie : Asia/Jakarta, UTC
     * @return float|int Milliseconds precision timestamp since Epoch
     *
     */
    public function dateTimeToUTCTime($datetimestring, $tz)
    {

        $tms = strtotime($datetimestring) * 1000;

        if(date_default_timezone_get() == 'UTC' || !isset( $tz )){

        }else{
            if(isset( $tz )){
                $tms = Carbon::parse($datetimestring);
                $tms->shiftTimezone('UTC');
                $tms = $tms->getPreciseTimestamp(3);
            }
        }

        return   $tms;
    }



}
