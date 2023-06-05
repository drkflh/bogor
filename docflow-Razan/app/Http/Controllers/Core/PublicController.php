<?php

namespace App\Http\Controllers\Core;

use App\Helpers\App\Kmn\KmnUtil;
use App\Helpers\Util;
use App\Models\Core\Mongo\APILog;
use App\Models\Core\Mongo\User;
use App\Models\Export\GenericExport;
use App\Models\Imports\Importsession;
use Carbon\Carbon;
use DateTime;
use Former\Facades\Former;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PublicController extends BaseController
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

    protected $data = []; // page injected custom data, merged with reactive data model
    protected $aux_data = []; // page injected custom data as addition to reactive data model, not merged with data model
    protected $plugin_data = [];
    protected $test_data;

    protected $controller_base = '';
    protected $view_base = '';

    protected $data_url;
    protected $add_url;
    protected $update_url;
    protected $autosave_url;
    protected $del_url;
    protected $clone_url;

    protected $download_url;
    protected $download_export_url;

    protected $can_add = false;
    protected $can_update = false;
    protected $can_view = false;
    protected $can_download_csv = false;
    protected $can_download_xls = false;
    protected $can_upload = false;
    protected $can_delete = false;
    protected $can_multi_delete = false;
    protected $can_clone = false;
    protected $can_multi_clone = false;
    protected $can_revise = false;
    protected $can_save = false;
    protected $can_print = true;

    protected $can_request_approval = false;
    protected $can_approve = false;

    //show or hide select checkbox column
    protected $can_multi_select = true;

    //show or hide action column
    protected $show_actions = true;

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
    protected $form_type = 'flatgrid'; // flatgrid , custom
    protected $form_dialog_size = '';

    /* viewer template */
    protected $viewer_view = 'form.viewhtml';
    protected $viewer_layout = 'form.viewhtmllayout';
    protected $viewer_mode = 'page';
    protected $viewer_type = 'html'; // flatgrid , custom
    protected $viewer_dialog_size = '';
    protected $viewer_icon = '';
    protected $viewer_can_print = false;


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
    protected $add_form_interval = 5000;

    protected $edit_methods_view = '';
    protected $edit_watch_view = '';
    protected $edit_event_view = '';
    protected $edit_computed_view = '';
    protected $edit_icon = '';

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

    protected $page_save_redirect = '';

    protected $customLoader = false;

    protected $view_methods_view = '';
    protected $view_watch_view = '';
    protected $view_event_view = '';
    protected $view_computed_view = '';

    protected $table_methods_view = '';
    protected $table_watch_view = '';
    protected $table_computed_view = '';
    protected $table_modal_view = '';
    protected $table_action_view = '';
    protected $table_event_view = '';
    protected $table_additional_view = '';

    protected $table_advanced_search_view = '';

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

    /* with advanced search */
    protected $with_advanced_search = false;

    /* workflow object keys */
    protected $with_workflow = false;
    protected $with_timetracking = false;

    protected $wf_request_doc_type = '';
    protected $wf_request_doc_id = 'requestNo';
    protected $wf_request_doc_title = 'title';
    protected $wf_request_doc_desc = 'descr';

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

    protected $update_title_fields = '"<h4>Update " + this._id + "</h4>"';
    protected $view_title_fields = '"<h4>View " + this._id + "</h4>"';
    protected $add_title_fields = '"<h4>Create " + this._id + "</h4>"';

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

    public function __construct()
    {
//        $this->middleware('auth');
        $this->layout = env('DEFAULT_OPEN_LAYOUT','layouts.dashforge');
        $this->logo = env('APP_LOGO','images/logo.png');
        $this->logo_small = env('APP_LOGO_SMALL','images/logo.png');

        $controller = (new \ReflectionClass($this))->getShortName();
        $this->controller_name = str_ireplace('controller', '',  $controller);

        $this->form_dialog_size = env('DIALOG_SIZE','lg');
        $this->viewer_dialog_size = env('DIALOG_SIZE','lg');

        $this->nav_path = env('APP_NAV_PATH','views/partials/app/default');
        $this->nav_file = env('APP_OPEN_NAV_FILE','open');

        $this->tz = env('DEFAULT_TIME_ZONE', 'Asia/Jakarta');
        date_default_timezone_set($this->tz);

        $this->add_title_fields = '"<h4>Create '.$this->entity.'</h4>"';

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

        $this->lang = $session->get('lang');

        debug(['current locale', $this->lang, $session->all()]);

        App::setLocale($this->lang);

        if($request->has('tz')){
            $tz = $request->get('tz');
            $session->set('tz', $tz);
        }

        $this->tz = $session->get('tz');

        $this->add_title_fields = '"<h4>Create '.$this->entity.'</h4>"';

        return $this->pageGenerator();
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postIndex(Request $request)
    {
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

            Util::log('Anonymous', $request->url(), 'ADD' ,$request->toArray(), 'ERR: '.$validation->errors()->getMessages() );

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
            $data['ownerId'] = Auth::user()->id;
            $data['ownerName'] = Auth::user()->name;

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

                    Util::log('Anonymous', $request->url(), 'ADD' ,$request->toArray(), 'SUCCESS' );

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
                $_id = $model->id;
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
            Util::log('Anonymous', $request->url(), 'UPDATE' ,$request->toArray(), 'ERR: '.$validation->errors()->getMessages() );


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


            $data = $this->beforeUpdate($_id,$data);

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

                foreach ($data as $key =>$value) {

                    $obj->{$key} = $value;
                }

                if($this->log_json){
                    $model->raw_json = $data;
                }

                if( !isset($obj->rev)){
                    $obj->rev = 0;
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
                        Util::log('Anonymous', $request->url(), 'UPDATE' ,$request->toArray(), 'SUCCESS' );

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
                        $clone->{$k} = $v;
                    }

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

                Util::log('Anonymous', $request->url(), 'CLONE' ,$request->toArray(), 'SUCCESS' );

                return response()->json( ['result'=>'OK','data'=>['type'=>$type, 'data'=>$retData ] ] );

            }catch (\Exception $e){
                Util::log('Anonymous', $request->url(), 'CLONE' ,$request->toArray(), 'ERR: '.$e->getMessage() );

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

                return response()->json( ['status'=>'OK','data'=>'CONTENTDELETED' ] );

            }catch (\Exception $e){
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

        $this->download_url = $this->controller_base.'/dlxl';

        $this->import_commit_url = $this->controller_base.'/commit';
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
            ->with('right_sidebar_header', $this->right_sidebar_header)
            ->with('right_sidebar_model', $this->right_sidebar_model)
            ->with('right_sidebar_data', $this->right_sidebar_data)
            ->with('right_sidebar_params', $this->right_sidebar_params)
            ->with('right_sidebar_template', $this->right_sidebar_template)

            ->with('is_create',$this->is_create)
            ->with('non_closing_save', $this->non_closing_save)
            ->with('non_saving_close', $this->non_saving_close)

            ->with('view_title_fields', $this->view_title_fields)
            ->with('update_title_fields', $this->update_title_fields)

            ->with('form_view',$this->form_view)
            ->with('form_layout',$this->form_layout)
            ->with('form_type',$this->form_type)

            ->with('view_layout',$this->viewer_layout)
            ->with('view_type',$this->viewer_type)

            ->with('print_template_url', $this->print_template_url)
            ->with('print_template', $this->print_template)
            ->with('print_modal_class', $this->print_modal_class)
            ->with('print_modal_size', $this->print_modal_size)

            ->with('with_workflow', $this->with_workflow)
            ->with('with_timetracking', $this->with_timetracking)
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
            ->with('page_save_redirect' , $this->page_save_redirect )

            ->with('customLoader', $this->customLoader)

            ->with('extra_view',$this->extra_view)
            ->with('extra_view_params',$this->extra_view_params)
            ->with('extra_query',$this->extra_query)
            ->with('show_actions', $this->show_actions )
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

            ->with('import_upload_multi_url' , $this->import_upload_multi_url )
            ->with('import_commit_multi_url' , $this->import_commit_multi_url )

            ->with('import_upload_cell_url' , $this->import_upload_cell_url )
            ->with('import_upload_cell_url' , $this->import_upload_cell_url )

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

        $this->download_export_url = strtolower((is_null($this->download_export_url))?$this->controller_name.'/dl':$this->download_export_url );

        $this->param_url = strtolower((is_null($this->param_url))?$this->controller_name.'/param':$this->param_url );

        $this->item_data_url = strtolower((is_null($this->item_data_url))?$this->controller_name.'/data':$this->item_data_url );

        $this->update_url = strtolower((is_null($this->update_url))?$this->controller_name.'/edit':$this->update_url );

        $this->add_url = strtolower((is_null($this->add_url))?$this->controller_name.'/add':$this->add_url );

        $this->del_url = (is_null($this->del_url))? strtolower($this->controller_name).'/del': $this->del_url;

        $this->clone_url = (is_null($this->clone_url))? strtolower($this->controller_name).'/clone': $this->clone_url;

        $this->col_attributes = \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColAttr();

        $ics = Util::loadResYaml($this->yml_file,$this->res_path)->toColLabel(false);

        debug($ics);

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

        $this->import_preview_heads = Util::loadResYaml($this->yml_file,$this->res_path)->toColLabel(false);


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

        return view($this->table_view)
            ->with('table_component', $this->table_component)
            ->with('data', $this->data)
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
            ->with('paramurl', $this->param_url)
            ->with('updateurl', $this->update_url)
            ->with('addurl', $this->add_url)
            ->with('delurl', $this->del_url)
            ->with('cloneurl', $this->clone_url)
            ->with('itemdataurl', $this->item_data_url)
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

            ->with('import_upload_multi_url' , $this->import_upload_multi_url )
            ->with('import_commit_multi_url' , $this->import_commit_multi_url )

            ->with('import_upload_cell_url' , $this->import_upload_cell_url )
            ->with('import_upload_cell_url' , $this->import_upload_cell_url )

            ->with('print_template_url', $this->print_template_url)
            ->with('print_template', $this->print_template)
            ->with('print_modal_class', $this->print_modal_class)
            ->with('print_modal_size', $this->print_modal_size)

            ->with('with_workflow', $this->with_workflow)
            ->with('with_timetracking', $this->with_timetracking)
            ->with('with_advanced_search', $this->with_advanced_search)

            ->with('wf_request_doc_id', $this->wf_request_doc_id)
            ->with('wf_request_doc_title', $this->wf_request_doc_title)
            ->with('wf_request_doc_desc', $this->wf_request_doc_desc)

            ->with('extra_view',$this->extra_view)
            ->with('extra_view_params',$this->extra_view_params)
            ->with('extra_query',$this->extra_query)
            ->with('show_actions', $this->show_actions )
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


            ->with('form_view',$this->form_view)
            ->with('form_layout',$this->form_layout)
            ->with('form_type',$this->form_type)
            ->with('viewer_view',$this->viewer_view)
            ->with('viewer_layout',$this->viewer_layout)
            ->with('viewer_type',$this->viewer_type)
            ->with('viewer_icon',$this->viewer_icon)
            ->with('viewer_can_print',$this->viewer_can_print)


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
            ->with('add_form_interval', $this->add_form_interval)

            ->with('edit_methods_view' , $this->edit_methods_view )
            ->with('edit_watch_view' , $this->edit_watch_view )
            ->with('edit_event_view' , $this->edit_event_view )
            ->with('edit_computed_view' , $this->edit_computed_view )
            ->with('edit_icon',$this->edit_icon)

            ->with('view_methods_view' , $this->view_methods_view )
            ->with('view_watch_view' , $this->view_watch_view )
            ->with('view_event_view' , $this->view_event_view )
            ->with('view_computed_view' , $this->view_computed_view)

            ->with('table_methods_view' , $this->table_methods_view )
            ->with('table_watch_view' , $this->table_watch_view )
            ->with('table_event_view' , $this->table_event_view )
            ->with('table_computed_view' , $this->table_computed_view )

            ->with('table_modal_view' , $this->table_modal_view )
            ->with('table_action_view' , $this->table_action_view )
            ->with('table_additional_view' , $this->table_additional_view )
            ->with('table_advanced_search_view' , $this->table_advanced_search_view )

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


        if($request->has('params')){

            if(isset($request->input('params')['queryParams'])){
                //vue-bootstrap4
                $params = $request->input('params')['queryParams'];
                $sorts = $params['sort'];
                $page = (isset($params['page']))?intval($params['page']):1;
                $limit = intval($params['per_page']);
                if(isset($params['filters'])){
                    $query = $params['filters'];
                    $global_query = $params['global_search'];
                }

            }else{
                //vue-tables-2
                $params = $request->input('params');
                if(isset($params['ascending']) && isset($params['orderBy']) ){
                    $order = ($params['ascending'] == 1)?'asc':'desc';
                    $name = isset($params['orderBy'])?$params['orderBy']:'_id';
                    $sorts[] = ['name'=>$name, 'order'=>$order, 'caseSensitive'=>false];
                }
                $limit = intval($params['limit']);
                if(isset($params['query'])){
                    $byColumn = intval($params['byColumn']);
                    if($byColumn == 1){
                        $query = $params['query'];
                    }else{
                        $global_query = $params['query'];
                    }
                }

            }
        }else{
            //vue-good-table
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

        if (isset($sorts)) {
            foreach ($sorts as $sort){
                $data = $data->orderBy($sort['name'], $sort['order']);
            }
        }

        if(!is_null($this->defOrderField)){
            $data = $data->orderBy($this->defOrderField, $this->defOrderDir);
        }

        if($this->with_workflow){
            $data = $data->orderBy('rev', 'desc');
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

        return response()->json($json);
    }

    private function tableExportBs4(Request $request, $respath, $ymlpath)
    {
        set_time_limit(0);
        date_default_timezone_set('Asia/Jakarta');

        $payload = $request->input('params')['payload'];

        $downloadMethod = $request->input('params')['downloadMethod'];
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

        $data = $this->model;

        $colFields =  \App\Helpers\Util::loadResYaml( $ymlpath,$respath )->toColFields();

        $this->col_attributes = \App\Helpers\Util::loadResYaml( $ymlpath,$respath )->toColAttr();


        // add queries

        if (isset($query) && $query) {
            debug('col');
            debug($this->col_attributes);

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

        $downloadPageCount = intval( config('util.download_qty'));

        $fname =  $this->controller_name.'_'.date('d-m-Y-H-m-s',time());

        $downloadMethod = ($totalRecords < $downloadPageCount) ? 'all': $downloadMethod;

        $route = Route::current();

        $export_xls = '';
        $export_csv = '';
        $export_xls_array = [];
        $export_csv_array = [];
        $multiple = false;
        $limit = config('util.download_qty');

        if($downloadMethod == 'chunked'){
            $multiple = true;
            $cnt = ceil($totalRecords / $downloadPageCount);

            for( $t = 0; $t < $cnt; $t++){
                $pnum = str_pad( $t, 2, '0', STR_PAD_LEFT );
                $fpath = 'exports/'.$fname.'_page_'.$pnum;
                $page = $t;
                $eximp = Excel::store(new GenericExport($data, $limit,$page, $headings, $this->timefields, $this->auth_entity), $fpath.'.xlsx','local',\Maatwebsite\Excel\Excel::XLSX);
                $csvimp = Excel::store(new GenericExport($data, $limit,$page, $headings, $this->timefields, $this->auth_entity), $fpath.'.csv', 'local',\Maatwebsite\Excel\Excel::CSV);

                $xls_url = url('api/v1/core/export/xls/'.$fname.'_page_'.$pnum.'.xlsx');
                $csv_url = url('api/v1/core/export/csv/'.$fname.'_page_'.$pnum.'.csv');
                $export_xls_array[] = $xls_url;
                $export_csv_array[] = $csv_url;

                Util::logDownload($xls_url, $fname.'_page_'.$pnum.'.xlsx' );
                Util::logDownload($csv_url, $fname.'_page_'.$pnum.'.csv' );

            }


        }else{
            $limit = intval($totalRecords) + 1;

            $fpath = 'exports/'.$fname.'_page_00';

            $eximp = Excel::store(new GenericExport($data, $limit,$page, $headings, $this->timefields, $this->auth_entity), $fpath.'.xlsx','local',\Maatwebsite\Excel\Excel::XLSX);
            $csvimp = Excel::store(new GenericExport($data, $limit,$page, $headings, $this->timefields, $this->auth_entity), $fpath.'.csv', 'local',\Maatwebsite\Excel\Excel::CSV);

            $export_xls = 'api/v1/core/export/xls/'.$fname.'_page_00'.'.xlsx';
            $export_csv = 'api/v1/core/export/csv/'.$fname.'_page_00'.'.csv';

            $xls_url = url($export_xls);
            $csv_url = url($export_csv);

            Util::logDownload($xls_url, $fname.'_page_00'.'.xlsx' );
            Util::logDownload($csv_url, $fname.'_page_00'.'.csv' );


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

        return response()->json($result, 200);

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
            foreach ($fields as $field) {

                $method = $index ? 'orWhere' : 'where';

                if(is_array($field)){

                    if( $field['datatype'] == 'text' || $field['datatype'] == 'string' || $field['datatype']['vue']['type'] == 'text' || $field['datatype']['vue']['type'] == 'string' ){
                        $q->{$method}($field['name'], 'LIKE', "%{$query}%");
                        debug($field['name'].' LIKE '."%{$query}%");
                    }else{
                        if($field['datatype'] == 'number' || $field['vue']['type'] == 'number'){
                            $query = doubleval($query);
                        }
                        if($field['datatype'] == 'integer' || $field['vue']['type'] == 'integer'){
                            $query = intval($query);
                        }
                        $q->{$method}($field['name'], '=', $query );

                        debug('arr '.$field['name'].' = '.$query);

                    }

                }else{
                    if( $field->datatype == 'text' || $field->datatype == 'string' || $field->vue->type == 'text' || $field->vue->type == 'string' ){
                        $q->{$method}($field->name, 'LIKE', "%{$query}%");

                        debug($field->name.' LIKE '."%{$query}%");
                    }else{
                        if($field->datatype == 'number' || $field->vue->type == 'number'){
                            $query = doubleval($query);
                        }
                        if($field->datatype == 'integer' || $field->vue->type == 'integer'){
                            $query = intval($query);
                        }
                        $q->{$method}($field->name, '=', $query );

                        debug('obj '.$field->name.' = '.$query);

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

        return response()->json( $this->def_param, 200 );

    }

    public function getData($id, $additional_data = null){

        $population = $this->model->find($id)->toArray();

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

        return response()->json($population, 200);

    }


    public function postPrintTemplate(Request $request)
    {
        $key = $request->input('q');

        $data = $request->input('data');

        unset($data['raw_json']);

        $d = new PrintCache();

        $jstr = json_encode($data);

        debug($jstr);

        $jstr = preg_replace('/\$/', '', $jstr);

        debug($jstr);

        $jdata = json_decode($jstr, true);

        debug($jdata);

        $data = $jdata;

        $data = $this->beforeSetPrintData($data, $key);

        $d->content = $data;

        $d->save();

        if( env('PRINT_AS_PDF', false)){
            return response()->json(['result'=>'OK', 'printurl'=>url( 'pdf/'.$key.'/'.$d->_id ) ], 200);
        }else{
            return response()->json(['result'=>'OK', 'printurl'=>url( 'print/'.$key.'/'.$d->_id ) ], 200);
        }
    }

    public function beforeSetPrintData(Array $data, $template)
    {
        info('print_template', [$template]);
        info('print_data', [$data]);
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


        return response()->json(['result'=>'OK', 'data'=>[ 'commited'=>$commited, 'uploaded'=>$importCount, 'totalGroup'=>$totalGroup ] ], 200);

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

}
