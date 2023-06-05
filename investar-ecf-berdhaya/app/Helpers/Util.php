<?php
namespace App\Helpers;

use App\Models\Core\Mongo\ActionLog;
use App\Models\Core\Mongo\ApprovalStatusLog;
use App\Models\Core\Mongo\ChangeStatusLog;
use App\Models\Core\Mongo\Sequence;
use App\Models\Obj\FormTemplate;
use App\Models\Obj\JsonTemplate;
use App\Models\Obj\ViewTemplate;
use App\Models\Workflow\FileDownload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class Util {

    public static $yml;
    public static $ymlfile = "";
    public static $addDataModel = [];

    public static function ajaxDebug(){
        if(env('APP_AJAX_DEBUG', false)){
            config()->set('app.debug', true);
        }
    }

    public static function log($actor, $url, $method ,$req, $resp, $authItem = '', $itemId = '')
    {
        $actionlog = new ActionLog();
        $actionlog->actor = $actor;
        $actionlog->actorId = $actor['_id'] ?? 'Anonymous';
        $actionlog->actorName = $actor['name'] ?? 'Anonymous';
        $actionlog->method = $method;
        $actionlog->url = $url;
        $actionlog->request_data = $req;
        $actionlog->response_data = $resp;

        $actionlog->authItem = $authItem;
        $actionlog->item = $itemId;

        $actionlog = TimeUtil::createTime($actionlog, env('DEFAULT_TIME_ZONE'));

        $actionlog->save();
    }

    public static function statuslog($actor, $data, $entity, $authItem = '', $itemId = '')
    {

        $changelog = new ChangeStatusLog();
        $changelog->actor = $actor;
        $changelog->actorId = $actor['_id'];
        $changelog->actorName = $actor['name'];
        $changelog->changeBy = $data['changeBy'];
        $changelog->changeDate = $data['changeDate'];
        $changelog->changeRemarks = $data['changeRemarks'];
        $changelog->changeStatusTo = $data['changeStatusTo'];
        $changelog->changeStatusToOptions = $data['changeStatusToOptions'];
        $changelog->currentStatus = $data['currentStatus'];

        $changelog->authItem = $authItem;
        $changelog->item = $itemId;
        $changelog->entity = $entity;

        $changelog = TimeUtil::createTime($changelog, env('DEFAULT_TIME_ZONE'));

        $changelog->save();
    }

    public static function approvallog($next, $prev, $itemId, $entity, $authItem = '')
    {

        $changelog = new ApprovalStatusLog();
        $approveAs = $next['approveAs'] ?? 'Reviewer';

        if(AuthUtil::isAdmin()){
            $approveAs = $approveAs . ' ( ADMIN )';
        }

        $changelog->actorId = $next['approverId'];
        $changelog->actorName = $next['approverName'];

        $changelog->approveAs = $approveAs;

        $changelog->sign = $next['authorizationSign'];
        $changelog->initial = $next['initialSign'];
        $changelog->changeRemarks = $next['note'];
        $changelog->changeTo = $next['decision'];
        $changelog->nextState = $next;
        $changelog->prevState = $prev;
        $changelog->itemId = $itemId;
        $changelog->entity = $entity;
        $changelog->authEntity = $authItem;

        $changelog = TimeUtil::createTime($changelog, env('DEFAULT_TIME_ZONE'));

        $changelog->save();
    }

    public static function getSequence($entity, $padded = true)
    {

        $sequencer = new Sequence();
        if( is_null($entity) && $entity != ''){
            return false;
        }else{
            $seq = $sequencer->getNewId($entity);
            return ($padded)? str_pad($seq, env('NUM_PAD', 5), '0', STR_PAD_LEFT ) : $seq;
        }

    }


    public static function sumOfKey($arr, $key)
    {
        $sum  = 0;
        foreach($arr as $r){
            $sum += floatval($r[$key]);
        }
        return $sum;
    }

    public static function makeSlug($str){

        $slug = preg_replace( '/^\s+|\s+$|\s+(?=\s)/', '', $str );
        $slug = preg_replace( '/[^\w\s]/i', '', $slug );
        $slug = implode( '-', explode( ' ', $slug ));
        $slug = strtolower($slug);
        return $slug;
    }

    /**
     * @param int $length length or randomized string
     * @param string $type default to numeric, may be set to alpha or alphanumeric
     * @return false|string
     */

    public static function randomstring($length = 5, $type = 'numeric'){
        $a = '';
        if($type == 'numeric') {
            for ($i = 0; $i < $length; $i++) {
                $a .= mt_rand(0, 9);
            }
        }elseif($type == 'alpha'){
            $a = self::alphaRandom($length);
        }elseif($type == 'alphanumeric'){
            $a = self::alphaNumericRandom($length);
        }else{
            $a = Str::random($length);
        }

        return $a;
    }

    public static function alphaRandom($length = 16)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public static function alphaNumericRandom($length = 16)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public static function validChars($string){
        return str_replace(["\\"," ", "\\t", "\\r","\\n"], "_", $string);
    }

    public static function makeApiRoute($controller, $controller_class){
        Route::get('/'.$controller, $controller_class.'@getIndex')->middleware('jwt');
        Route::get('/'.$controller.'/list/{filter?}', $controller_class.'@getList')->middleware('jwt');
        Route::post('/'.$controller.'/batch', $controller_class.'@postBatch')->middleware('jwt');
        Route::post('/'.$controller, $controller_class.'@postAdd')->middleware('jwt');
        Route::put('/'.$controller.'/batch', $controller_class.'@putBatch')->middleware('jwt');
        Route::put('/'.$controller.'/{id}', $controller_class.'@putUpdate')->middleware('jwt');
        Route::get('/'.$controller.'/schema', $controller_class.'@getSchema')->middleware('jwt');
        Route::get('/'.$controller.'/{id}', $controller_class.'@show')->middleware('jwt');

        Route::post('/'.$controller.'/approval/item', $controller_class.'@postFetchApprovalItems')->middleware('jwt');
        Route::post('/'.$controller.'/approval/param', $controller_class.'@postApprovalParam')->middleware('jwt');
        Route::post('/'.$controller.'/approval/request', $controller_class.'@postApprovalRequest')->middleware('jwt');
        Route::post('/'.$controller.'/approval/commit', $controller_class.'@postApprovalCommit')->middleware('jwt');

    }

    public static function makeOpenApiRoute($controller, $controller_class){
        Route::get('/'.$controller, $controller_class.'@getIndex');
        Route::get('/'.$controller.'/list/{filter?}', $controller_class.'@getList');
        Route::post('/'.$controller.'/batch', $controller_class.'@postBatch');
        Route::post('/'.$controller, $controller_class.'@postAdd');
        Route::put('/'.$controller.'/batch', $controller_class.'@putBatch');
        Route::put('/'.$controller.'/{id}', $controller_class.'@putUpdate');
        Route::get('/'.$controller.'/schema', $controller_class.'@getSchema');
        Route::get('/'.$controller.'/{id}', $controller_class.'@show');
    }

    public static function makeRoute($controller, $controller_class){

//        Route::get('/'.$controller.'/list/{filter?}', $controller_class.'@getList');
        Route::get('/'.$controller, $controller_class.'@getIndex');
        Route::post('/'.$controller, $controller_class.'@postIndex');
        Route::get('/'.$controller.'/list/{keyword0}/{keyword1?}/{keyword2?}', $controller_class.'@getList');
        Route::post('/'.$controller.'/list/{keyword0}/{keyword1?}/{keyword2?}', $controller_class.'@postList');
        Route::get('/'.$controller.'/add/{keyword0?}/{keyword1?}/{keyword2?}', $controller_class.'@getAdd');
        Route::get('/'.$controller.'/edit/{id}/{keyword0?}/{keyword1?}/{keyword2?}', $controller_class.'@getEdit');
        Route::get('/'.$controller.'/step/{step?}/{id?}/{keyword0?}/{keyword1?}/{keyword2?}', $controller_class.'@getStep');
        Route::get('/'.$controller.'/revise/{id}/{keyword0?}/{keyword1?}/{keyword2?}', $controller_class.'@getRevise');
        Route::get('/'.$controller.'/view/{id}/{keyword0?}/{keyword1?}/{keyword2?}', $controller_class.'@getView');
        Route::get('/'.$controller.'/pdf/{id}/{keyword0?}/{keyword1?}/{keyword2?}', $controller_class.'@getPdf');
        Route::get('/'.$controller.'/html/{id}/{keyword0?}/{keyword1?}/{keyword2?}', $controller_class.'@getHtml');
//        Route::get('/'.$controller.'/import', $controller_class.'@getImport');
//        Route::post('/'.$controller.'/uploadimport', $controller_class.'@postUploadimport');
//        Route::get('/'.$controller.'/commit/{sessid}', $controller_class.'@getCommit');
        Route::post('/'.$controller.'/commit', $controller_class.'@postCommit');

        Route::get('/'.$controller.'/param', $controller_class.'@getParam');
        Route::post('/'.$controller.'/param', $controller_class.'@getParam');
        Route::get('/'.$controller.'/data/{id}', $controller_class.'@getData');
        Route::post('/'.$controller.'/data/{id}', $controller_class.'@getData');
        Route::post('/'.$controller.'/del', $controller_class.'@postDel');
        Route::post('/'.$controller.'/clone', $controller_class.'@postClone');
        Route::post('/'.$controller.'/admin/set-approval', $controller_class.'@postSetApprovalStatus');
        Route::post('/'.$controller.'/admin/reset-rev', $controller_class.'@postResetRevLock');

        Route::post('/'.$controller.'/add', $controller_class.'@postAdd');
        Route::post('/'.$controller.'/autosave', $controller_class.'@postAutosave');
        Route::post('/'.$controller.'/relay/{id}', $controller_class.'@postRelay');
        Route::post('/'.$controller.'/edit/{id}', $controller_class.'@postEdit');
        Route::post('/'.$controller.'/print-template', $controller_class.'@postPrintTemplate');
        Route::post('/'.$controller.'/print-xls', $controller_class.'@postPrintXls');
        Route::post('/'.$controller.'/dl-summary', $controller_class.'@postDlSummary');
        Route::post('/'.$controller.'/dlxl', $controller_class.'@postDlxl');
        Route::get('/'.$controller.'/dl/{filename}', $controller_class.'@getDl');
        Route::get('/'.$controller.'/csv/{filename}', $controller_class.'@getCsv');
        Route::post('/'.$controller.'/auto', $controller_class.'@getAuto');
        Route::get('/'.$controller.'/auto', $controller_class.'@getAuto');
        Route::post('/'.$controller.'/seq', $controller_class.'@postAutoSequence');

        Route::post('/'.$controller.'/validate', $controller_class.'@postEmailUnique');

        Route::post('/'.$controller.'/approval/item', $controller_class.'@postFetchApprovalItems');
        Route::post('/'.$controller.'/approval/param', $controller_class.'@postApprovalParam');
        Route::post('/'.$controller.'/approval/request', $controller_class.'@postApprovalRequest');
        Route::post('/'.$controller.'/approval/commit', $controller_class.'@postApprovalCommit');

    }

    public static function clearYaml()
    {
        self::$ymlfile = '';
        return new self;
    }


    public static function getFormTemplates($tag = null){
        if(is_null($tag)){
            $sc = FormTemplate::orderBy('name', 'asc')->get()->toArray();
        }else{
            $sc = FormTemplate::where('tags', 'like', '%'.$tag.'%')->orderBy('name', 'asc')->get()->toArray();
        }

        $res = [];
        foreach( $sc as $s ){
            $res[] = [ 'text'=>$s['name'], 'value'=>strval($s['key']) ];
        }

        return $res;
    }


    public static function loadResYaml($filename = 'fields', $base_path = null, $additive = false){
        if(is_null($base_path)){
            self::$yml = false;
        }else{
            $path = resource_path($base_path).'/'.$filename.'.yml';

            try{
                $ymlfile = file_get_contents( $path );
                if($additive){
                    if(self::$ymlfile == ""){
                        self::$ymlfile = $ymlfile;
                    }else{
                        self::$ymlfile .= "\r\n".$ymlfile;
                    }
                }else{
                    self::$ymlfile = $ymlfile;
                }
                self::$yml = Yaml::parse(self::$ymlfile);
            }catch (\Exception $exception){
                print $exception->getMessage();
                self::$yml = false;
            }
            return new self;
        }
    }

    public function toArray(){
        return self::$yml;
    }

    public function addData($data){
        self::$addDataModel = $data;
        return new self;
    }

    public function toTemplateHeader()
    {
        $heads = [];

        if( self::$yml ){
            foreach( self::$yml as $k=>$v){
                $can_import = $v['im'] ?? true;
                if( $can_import && isset($v['name']) && $v['name'] != '' && !(in_array( $v['name'] ,config('util.template_exclude') ) ) ){
                    $label = $v['label'] ??  $v['name'];
                    $heads[$v['name']] = $label;
                }
            }
        }

        return $heads;

    }

    public function toTemplateColumns()
    {
        $cols = [];

        if( self::$yml ){
            foreach( self::$yml as $k=>$v){
                $can_import = $v['im'] ?? true;
                if( $can_import && isset($v['name']) && $v['name'] != '' && !(in_array( $v['name'] ,config('util.template_exclude') ) ) ){
                    $cols[] = [
                        'title'=> $v['name'],
                        'dataIndex'=> $v['name'],
                        'key'=> $v['name'],
                        'width'=> ($v['width'] ?? ''),
                    ];
                }
            }
        }

        return $cols;

    }

    public function toHeads()
    {
        $heads = [];

        if( self::$yml ){
            foreach( self::$yml as $k=>$v){
                if( isset($v['column']) && $v['column'] == true ){
                    $heads[] = [$k, [
                        'search'=>(isset($v['search'])?$v['search']:false),
                        'sort'=>(isset($v['sort'])?$v['sort']:false ),
                        'show'=>(isset($v['show'])?$v['show']:false),
                    ] ];
                }
            }
        }

        return $heads;
    }

    public function toFields()
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k=>$v){
                if( isset($v['column']) && $v['column'] == true ){
                    $fields[] = [$v['field'], [
                        'kind'=>(isset($v['kind'])?$v['kind']:'text'),
                        'query'=>(isset($v['query'])?$v['query']:'like' ),
                        'pos'=>(isset($v['pos'])?$v['pos']:'both'),
                        'show'=>(isset($v['show'])?$v['show']:true),
                        'callback'=>(isset($v['callback'])?$v['callback']:false),
                        'attr'=>(isset($v['attr'])?$v['attr']:[]),
                    ] ];
                }
            }
        }

        return $fields;
    }

    public function toVueType()
    {

        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( ( isset($k['form']['model']) ) ){

                    $vtype = $k['vue']['type'] ?? 'text';
                    $vdefault = $k['vue']['default'] ?? '';
                    if($vtype == 'object'){
                        $vdefault = new \ArrayObject();
                    }
                    if($vtype == 'array'){
                        $vdefault = [];
                    }

                    $fields[$k['form']['model']] = ['type'=>$vtype, 'default'=>$vdefault];
                }
            }
        }

        return $fields;
    }

    public function toColumnFields($encoded = true, $show_action = true, $add_filler = true, $exclude = null)
    {
        $fields = [];

        $dateOutFormat = 'dd MMM yyyy';
        $dateInputFormat = 'yyyy-MM-dd HH:mm:ss';

        $exclude = $exclude ?? [];

        if( self::$yml ){
            foreach( self::$yml['table'] as $k){
                if( isset($k['name']) && ( isset($k['show']) && $k['show'] == true ) && !in_array( $k['name'] , $exclude)  ){
                    //bootstrap4 table
                    $k['field'] = $k['name'];
                    $k['column_classes'] = isset($k['column_classes'])?$k['column_classes']:'';
                    $k['datatype'] = isset($k['datatype'])?$k['datatype']:'text';

                    //ant-vue-table
                    $k['title'] = __($k['label']);
                    $k['dataIndex'] = $k['name'];
                    $k['key'] = $k['name'];
                    $k['ellipsis'] = $k['ellipsis'] ?? false;
                    $k['scopedSlots'] = ['customRender'=>  $k['name'] ] ;
                    $k['width'] = $k['width'] ?? '';
                    $k['fixed'] = $k['fixed'] ?? false;
                    $k['className'] = $k['column_classes'];

                    //goodtable
                    $k['label'] = __($k['label']);
                    $k['sortable'] = $k['sort'];
                    $k['tdClass'] = $k['column_classes'];
                    if($k['datatype'] == 'date' || $k['datatype'] == 'datetime' || $k['datatype'] == 'dateutc')
                    {
                        $k['type'] =  'date';
                        $k['dateOutputFormat'] = $dateOutFormat;
                        $k['dateInputFormat'] = $dateInputFormat;
                    }
                    // show / hide action column
                    if($k['field'] == '_id'){
                        if($show_action){
                            $fields[] = $k;
                        }
                    }else{
                        $fields[] = $k;
                    }
                }
            }
        }

        // show / hide filler column
        if($add_filler){
            $fields[] = [
                'field'=>'filler',
                'column_classes'=>'',
                'title'=>'',
                'key'=>'filler',
                'sortable'=>false,
                'sort'=>false
            ];
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }


    public function toColFields($encoded = true, $show_action = true, $add_filler = true, $exclude = null)
    {
        $fields = [];

        $dateOutFormat = 'dd MMM yyyy';
        $dateInputFormat = 'yyyy-MM-dd HH:mm:ss';

        $exclude = $exclude ?? [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['name']) && ( isset($k['show']) && $k['show'] == true ) && !in_array( $k['name'] , $exclude) ){
                    //bootstrap4 table
                    $k['field'] = $k['name'];
                    $k['column_classes'] = isset($k['column_classes'])?$k['column_classes']:'';
                    $k['datatype'] = isset($k['datatype'])?$k['datatype']:'text';
                    //ant-vue-table
                    $k['title'] = __($k['label']);
                    $k['dataIndex'] = $k['name'];
                    $k['key'] = $k['name'];
                    $k['ellipsis'] = $k['ellipsis'] ?? false;
                    $k['scopedSlots'] = ['customRender'=>  $k['name'] ] ;
                    $k['width'] = $k['width'] ?? '';
                    $k['fixed'] = $k['fixed'] ?? false;
                    $k['className'] = $k['column_classes'];

                    //goodtable
                    $k['label'] = __($k['label']);
                    $k['sortable'] = $k['sort'];
                    $k['tdClass'] = $k['column_classes'];
                    if($k['datatype'] == 'date' || $k['datatype'] == 'datetime' || $k['datatype'] == 'dateutc')
                    {
                        $k['type'] =  'date';
                        $k['dateOutputFormat'] = $dateOutFormat;
                        $k['dateInputFormat'] = $dateInputFormat;
                    }

                    if($k['field'] == '_id'){
                        if($show_action){
                            $fields[] = $k;
                        }
                    }else{
                        $fields[] = $k;
                    }

                }
            }
        }
        // show / hide filler column
        if($add_filler){
            $fields[] = [
                'field'=>'filler',
                'column_classes'=>'',
                'title'=>'',
                'key'=>'filler',
                'sortable'=>false,
                'sort'=>false
            ];
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }

    public function toColHeads($encoded = true, $keyval = false)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['label']) && ( isset($k['show']) && $k['show'] == true ) ){
                    $fields[] = $k;
                }
            }
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }


    public function toColFieldFiltered($encoded = true)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['name']) && ( isset($k['show']) && $k['show'] == true ) ){
                    if( !in_array($k['name'], config('util.sys_fields'))){
                        if( isset($k['filter']['visible']) && $k['filter']['visible'] == true){
                            $fields[] = $k['name'];
                        }
                    }
                }
            }
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }

    public function toColFieldSearchable($encoded = true)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['name']) ){
                    if( !in_array($k['name'], config('util.sys_fields'))){
                        if($k['search']['visible'] == true){
                            $fields[] = $k;
                        }
                    }
                }
            }
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }

    public function toColumnFieldSearchable($encoded = true)
    {
        $fields = [];

        if( self::$yml ){
            info('searchyml', self::$yml);
            foreach( self::$yml['table'] as $k){
                info('searchitem', $k);
                if( isset($k['name']) ){
                    if( !in_array($k['name'], config('util.sys_fields'))){
                        if($k['search'] == true){
                            $fields[] = $k;
                        }
                    }
                }
            }
        }

        info('searchfields', $fields);

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }

    public function toColFieldSortable($encoded = true)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['name']) && ( isset($k['show']) && $k['show'] == true ) ){
                    if( !in_array($k['name'], config('util.sys_fields'))){
                        if($k['sort'] == true){
                            $fields[] = $k['name'];
                        }
                    }
                }
            }
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }

    public function toExportHeads($encoded = true)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['name']) ){
                    if( !in_array($k['name'], config('util.sys_fields'))){
                        $fields[] = $k['name'];
                    }
                }
            }
        }

        return $fields;

    }

    public function toExportHeadings($encoded = true)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml['vue'] as $k){
                $can_import = $k['im'] ?? true;
                if( isset($k['model']) ){
                    if( $can_import && !in_array($k['model'], config('util.sys_fields'))){
                        $fields[] = $k['model'];
                    }
                }
            }
        }

        return $fields;

    }

    public function toPrintExportHeadings($encoded = true)
    {
        $fields = [];

        if( self::$yml && isset( self::$yml['print'] )){
            foreach( self::$yml['print'] as $k){
                if( isset($k['model']) ){
                    if( !in_array($k['model'], config('util.sys_fields'))){
                        $fields[] = $k['model'];
                    }
                }
            }
        }

        return $fields;

    }


    public function toColFieldName($encoded = true)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['name']) && ( isset($k['show']) && $k['show'] == true ) ){
                    if( !in_array($k['name'], config('util.sys_fields'))){
                        $fields[] = $k['name'];
                    }
                }
            }
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }


    public function toColLabel($encoded = true, $keyval = true)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['label']) && ( isset($k['show']) && $k['show'] == true ) ){
                    if( !in_array($k['name'], config('util.sys_fields'))) {
                        if($keyval){
                            $fields[$k['name']] = __($k['label']);
                        }else{
                            $fields[] = __($k['label']);
                        }
                    }
                }
            }
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }

    public function toColumnLabel($encoded = true, $keyval = true)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml['table'] as $k){
                if( isset($k['label']) && ( isset($k['show']) && $k['show'] == true ) ){
                    if( !in_array($k['name'], config('util.sys_fields'))) {
                        if($keyval){
                            $fields[$k['name']] = __($k['label']);
                        }else{
                            $fields[] = __($k['label']);
                        }
                    }
                }
            }
        }

        if($encoded){
            return json_encode($fields);
        }else{
            return $fields;
        }
    }

    public function toDateField($encoded = false)
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['label']) && ( isset($k['show']) && $k['show'] == true ) ){
                    if( !in_array($k['form']['type'], config('util.sys_datefields'))) {
                        $fields[] = __($k['label']);
                    }
                }
            }
        }

        return $fields;
    }



    public function toColAttr()
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k){
                if( isset($k['name']) && ( isset($k['show']) && $k['show'] == true ) ){
                    $fields[ $k['name'] ]['type'] = $k['datatype']??'string';
                    $fields[ $k['name'] ]['label'] = __($k['label'])??'Action';
                    $fields[ $k['name'] ]['callback'] = $k['callback']??'onAction';
                }
            }
        }

        return $fields;
    }


    public function toJson()
    {
        if( self::$yml ){
            return json_encode(self::$yml);
        }else{
            return json_encode([]);
        }
    }

    public static function setMenuArray($menuArray){
        self::$yml = $menuArray;
        return new self;
    }

    public static function appendMenuArray($menuArray){
        if( is_array(self::$yml) ){
            self::$yml = array_merge( self::$yml , $menuArray );
        }
        return new self;
    }

    public function toMenu($section,$item, $subparent ,$subitem, $subtag = null, $grandtag = null)
    {
        if(Auth::check()){
            $roleEntity = AuthUtil::loadRoleEntity(Auth::user()->roleId);
            $roleId = Auth::user()->roleId;
        }else{
            $roleEntity = null;
            $roleId = null;
        }

        if( self::$yml ){
            $menu = self::$yml;
            $menustring = '';
            $menuarray = [];
            $next = true;
            foreach($menu as $m){
                if(isset($m['auth'])){
                    if( !is_null( $roleEntity) && $roleEntity->can('read', $m['auth'] , $roleId)){
                        $menuarray[] = sprintf($section, __($m['title']));
                        $next = true;
                    }else{
                        $next = false;
                    }
                }else{
                    $menuarray[] = sprintf($section, __($m['title']));
                    $next = true;
                }
                if(isset( $m['children'] ) && $next ){
                    if(is_array($m['children'])){
                        if(isset($m['children']['call'])){
                            $m_children = eval( 'return '.$m['children']['call'].';' );
                            if($m_children){
                                $m['children'] = $m_children;
                            }
                        }
                        foreach ($m['children'] as $c){
                            $submenustring = '';
                            $haschildren = false;
                            if(isset($c['children'])  && $next  ){
                                $submenu = [];
                                $submenu[] = $subtag ?? '<ul class="submenu">';

                                if(is_array($c['children'])){
                                    if(isset($c['children']['call'])){
                                        $c_children = eval( 'return '.$c['children']['call'].';' );
                                        if($c_children){
                                            $c['children'] = $c_children;
                                        }
                                    }
                                    foreach($c['children'] as $sm){
                                        debug(['sm',$sm]);
                                        if(isset($sm['children'])  && $next  ){

                                            $gc = $this->composeChildren($sm['children'], $subitem ,$grandtag, $roleId, $roleEntity);

                                            $gcmenustring = implode("\r\n", $gc);

                                            $badge = $sm['badge'] ?? '';


                                            if(isset( $sm['auth'] ) && !is_null($roleEntity) ){
                                                if($roleEntity->can('read', $sm['auth'] , $roleId)){
                                                    $submenu[] = sprintf($subparent, $icon , __($sm['title']) , $gcmenustring, $badge, $badge );
                                                }
                                            }else{
                                                $submenu[] = sprintf($subparent, $icon ,__($sm['title']) , $gcmenustring, $badge, $badge );
                                            }

                                        }else{
                                            if( isset($sm['click'])){
                                                $surl = '@click="'.$sm['click'].'"';
                                            }else{
                                                $surl = (isset($sm['url']))?url($sm['url']):'#';
                                                $surl = 'href="'.$surl.'"';

                                            }
                                            $badge = $sm['badge'] ?? '';

                                            //$surl = (isset($sm['url']))?url($sm['url']):'';
                                            if(isset( $sm['auth'] ) && !is_null($roleEntity)){
                                                info("MENU CHILDREN 01 HAS AUTH",$sm);

                                                if($roleEntity->can('read', $sm['auth'] , $roleId)){
                                                    if(isset($sm['title'])){
                                                        $submenu[] = sprintf($subitem, $surl, __($sm['title']), $badge, $badge );
                                                    }
                                                }
                                            }else{
                                                if(isset($sm['title'])){
                                                    $submenu[] = sprintf($subitem, $surl, __($sm['title']), $badge, $badge );
                                                }
                                            }


                                        }
                                    }
                                }
                                $submenu[] = '</ul>';
                                $submenustring = implode("\r\n", $submenu);
                                $haschildren = true;

                            }
                            if( isset($c['click'])){
                                $url = '@click="'.$c['click'].'"';
                            }else{
                                $url = (isset($c['url']))?url($c['url']):'#';
                                $url = 'href="'.$url.'"';
                            }
                            $icon = (isset($c['icon']))?$c['icon']:'';
                            $title = (isset($c['title']))?$c['title']:'No Title';
                            $title = __($title);

                            $badge = $c['badge'] ?? '';

                            if($haschildren){

                                if(isset($c['id']) && $c['id'] != ''){
                                    $randId = $c['id'];
                                }else{
                                    $randId = self::randomstring(5, 'alpha');
                                }
                                $subparentx = str_replace('{{id}}', $randId, $subparent );

                                if(isset($c['auth'])){
                                    if(Auth::check() && $roleEntity->can('read', $c['auth'] , $roleId)){
                                        $menuarray[] = sprintf($subparentx, $icon , $title , $submenustring , $badge, $badge);
                                    }
                                }else{
                                    $menuarray[] = sprintf($subparentx, $icon , $title , $submenustring , $badge, $badge);
                                }

                            }else{
                                if(isset($c['auth'])){
                                    if(Auth::check() && $roleEntity->can('read', $c['auth'] , $roleId)){
                                        $menuarray[] = sprintf($item, $url, $icon , $title, $badge, $badge );
                                    }
                                }else{
                                    $menuarray[] = sprintf($item, $url, $icon , $title, $badge, $badge );
                                }
                            }
                        }
                    }
                }
            }
            //print_r($menuarray);
            $menustring = implode("\r\n", $menuarray );
            return $menustring;
        }else{
            return sprintf($section, 'No Menu' );
        }
    }

    public function composeChildren($children , $subitem ,$listtag, $roleId, $roleEntity)
    {
        debug('MENU CHILDREN');
        debug( $children );

        $gc = [];
        $gc[] = $listtag;
        foreach ($children as $ch){
            $target = isset($ch['target']) && $ch['target'] != '' ? ' target="'.$ch['target'].'"' :'';
            if( isset($ch['click'])){
                $surl = '@click="'.$ch['click'].'"';
            }else{
                $surl = (isset($ch['url']))?url($ch['url']):'#';
                $surl = 'href="'.$surl.'"'.$target;
            }
            $badge = $ch['badge'] ?? '';

            //$surl = (isset($ch['url']))?url($ch['url']):'';

            if(isset( $ch['auth'] ) && !is_null($roleEntity)){
                if($roleEntity->can('read', $ch['auth'] , $roleId)){
                    $gc[] = sprintf($subitem, $surl, __($ch['title']), $badge, $badge );
                }
            }else{
                $gc[] = sprintf($subitem, $surl, __($ch['title']), $badge, $badge );
            }


        }
        $gc[] = '</ul>';

        return $gc;
    }

    public static function toSelectOptions($model, $simplearray = false, $labelfield = null, $key = '_id')
    {
        $opts = $model->get()->toArray();

        if($simplearray){
            $sa = [];
            foreach ($opts as $s){
                $label = '';
                if( is_array( $labelfield ) ){
                    $lbl = [];
                    foreach($labelfield as $f){
                        $lbl[] = $s[$f]?? '';
                    }
                    $label = implode(' ', $lbl);
                }else{
                    if(!is_null($labelfield)){
                        $label = $s[$labelfield]??$s[$labelfield];
                    }
                }
                $sa[] = ['value'=>$s[$key] , 'text'=> __($label)];
            }
            $opts = $sa;
        }

        return $opts;
    }

    public function toExportFields()
    {
        $fields = [];

        if( self::$yml ){
            foreach( self::$yml as $k=>$v){
                if( isset($v['kind']) && $v['kind']  == 'placeholder' ){
                    $fields[$k] = false;
                }else{
                    $fields[$k] = $v;
                }
            }
        }

        return $fields;
    }

    public function formByName($name, $is_create = true)
    {
        $formfield = null;

        if( self::$yml ){

            foreach( self::$yml as $k=>$v){
                if($k == $name){
                    $formfield = self::composeFormField($k, $v, $is_create);
                }
            }
        }

        return $formfield;

    }

    public function toFormPage($mode , $column = 1, $is_create = true)
    {
        $forms = [];

        if( self::$yml ){

            foreach( self::$yml as $v){
                if(isset($v['form'])){
                    if(isset($v['form']['col']) && $v['form']['col'] == $column ){
                        if( $mode == 'edit' && (isset($v['form']['edit']) && $v['form']['edit']) || $mode == 'create' && (isset($v['form']['create']) && $v['form']['create']) ){
                            $forms[] = self::composeFormField($v['label'], $v, $is_create);
                        }
                    }
                }
            }
        }
        return $forms;
    }

    public function toForm($column = 1, $row = 1 ,$mode = 'page')
    {
        $forms = [];

        if( self::$yml ){

            foreach( self::$yml as $v){
                if(isset($v['form'])){
                    if(isset($v['form']['row']) && $v['form']['row'] == $row ){
                        if(isset($v['form']['col']) && $v['form']['col'] == $column ){
                            if( (isset($v['form']['edit']) && $v['form']['edit']) || (isset($v['form']['create']) && $v['form']['create']) ){
                                $forms[] = self::composeFormField($v['label'], $v);
                            }
                        }
                    }

                }
            }
        }
        return $forms;
    }

    public function toFormWithKey($keyfield = 'name', $is_create = true)
    {
        $forms = [];

        if( self::$yml ){

            foreach( self::$yml as $v){
                if(isset($v['form'])){
                    if((isset($v['form']['edit']) && $v['form']['edit']) || (isset($v['form']['create']) && $v['form']['create']) ){
                        $forms[ $v[$keyfield] ] = self::composeFormField($v['label'], $v, $is_create);
                    }
                }
            }
        }
        return $forms;
    }

    public function toFormElementWithKey($keyfield = 'name', $is_create = true, $model_prefix = '')
    {
        $forms = [];

        if( self::$yml ){
            if(isset(self::$yml['form'])){
                foreach( self::$yml['form'] as $v){
                    if((isset($v['edit']) && $v['edit']) || (isset($v['create']) && $v['create']) ){
                        $forms[ $v[$keyfield] ] = self::composeFormElement($v['label'], $v, $is_create, $model_prefix);
                    }
                }
            }
        }
        return $forms;
    }


    public function formWithLayout($formObject){

        $forms = [];
        if( self::$yml ){
            foreach( self::$yml as $obj){
                $row = [];
                foreach($obj as $k=>$v){
                    if($k == 'row'){
                        $row[] = '<div class="row">';
                        foreach($v as $vk=>$vl){
                            $width = 12 / count($v);
                            $width = floor($width);
                            foreach ($vl as $c => $f){
                                $col = [];
                                if( preg_match('/^col/', $c) ){
                                    if(preg_match('/^col_/', $c)){
                                        $width = str_replace('col_', '', $c);
                                    }
                                    $col[] = '<div class="col-lg-'.$width.' col-md-'.$width.' col-sm-12" >';
                                    if(is_array($f)){
                                        foreach( $f as $fobj ){
                                            foreach($fobj as $fk=>$fv){
                                                if($fk == 'field'){
                                                    if(isset($formObject[$fv])){
                                                        $col[] = $formObject[$fv]."\r\n";
                                                    }
                                                }
                                                if($fk == 'row'){
                                                    $col[] = '<div class="row">';
                                                    foreach($fv as $cobj){
                                                        $width = 12 / count($fv);
                                                        $width = floor($width);
                                                        foreach($cobj as $cfk=>$cfv){
                                                            foreach($cfv as $fko=>$flo){
                                                                if(preg_match('/^col_/', $cfk)){
                                                                    $width = str_replace('col_', '', $cfk);
                                                                }

                                                                $col[] = '<div class="col-lg-'.$width.' col-md-'.$width.' col-sm-12">';
                                                                foreach ($flo as $flk=>$flv){
                                                                    if(isset($formObject[$flv])){
                                                                        $col[] = $formObject[$flv]."\r\n";
                                                                    }
                                                                }
                                                                $col[] = '</div>';
                                                            }
                                                        }
                                                    }
                                                    $col[] = '</div>';
                                                }
                                            }
                                        }
                                    }
                                    $col[] = '</div>';
                                }
                            }
                            $row = array_merge($row, $col);
                        }
                        $row[] = '</div>';
                        $forms = array_merge($forms, $row);
                    }
                }
            }
        }

        return $forms;

    }

    public static function formElementWithBladeLayout($bladeview ,$formObject, $is_create, $auxdata = null, $id = null){
        if(!is_null($auxdata) && is_array($auxdata)){
            $formObject = array_merge( $formObject, $auxdata );
        }
        $formObject['_isCreate'] = $is_create;
        $formObject['itemId'] = $id;
        debug($formObject);
        return view($bladeview, $formObject )->render();
    }

    public static function formWithBladeLayout($bladeview ,$formObject, $is_create, $auxdata = null, $id = null){
        if(!is_null($auxdata) && is_array($auxdata)){
            $formObject = array_merge( $formObject, $auxdata );
        }
        $formObject['_isCreate'] = $is_create;
        $formObject['itemId'] = $id;
        debug($formObject);
        return view($bladeview, $formObject )->render();

    }


    public function toFormOption()
    {
        $formopts = [];

        if( self::$yml ){

            foreach( self::$yml as $v){
                if(isset($v['form'])){
                    if((isset($v['form']['edit']) && $v['form']['edit']) || (isset($v['form']['create']) && $v['form']['create']) ){
                        if($v['form']['type'] == 'simpleselect' || $v['form']['type'] == 'localselect'){
                            if(isset($v['form']['options'])){
                                $formopts[ $v['form']['model'].'Options' ] = $v['form']['options'];
                            }
                        }
                        if($v['form']['type'] == 'simpletableinput' || $v['form']['type'] == 'simpletable'){
                            if(isset($v['form']['fields'])){
                                $formopts[ $v['form']['model'].'Fields' ] = $v['form']['fields'];
                            }
                        }
                        if($v['form']['type'] == 'simplelistinput' || $v['form']['type'] == 'simpletable'){
                            if(isset($v['form']['fields'])){
                                $formopts[ $v['form']['model'].'Fields' ] = $v['form']['fields'];
                            }
                        }
                    }
                }
            }
        }
        return $formopts;
    }

    public static function makeDataModel($k, $val, $datatype = 'text', $vuetype = 'text', $default = null)
    {
        $v = [];
        $v['name'] = $k;
        $v['datatype'] = $datatype;
        $v['vue']['visible'] = true;
        $v['vue']['type'] = $vuetype;
        $v['vue']['default'] = $default ?? $val;

        return $v;
    }

    public function composeFormElement($k, $v, $is_create = true, $model_prefix = '')
    {

        $model = ( !isset($v['model']) || is_null($v['model']))? $v['name'] : $v['model'];

        $options = [];
        if(isset($v['options'])){
            $opt = $v['options'];
            if(isset($opt['call'])){
                $options = (isset($opt['call']))? $this->buffeval($opt['call'], $opt['param'], $v['kind'] ) :$default;
            }else{
                if(is_array($opt)){
                    $options = $opt;
                }else{
                    $options = [''=>'Select '.$k];
                }
            }

        }

        $default = isset($v['default'])?$v['default']:'';

        $field = '';

        if( strtoupper($v['edit']) == true && $is_create == false) {
            $field = $this->getFormElement( $v['type'], $k, $v, $v['name'], $model, $model_prefix );
        }

        if( strtoupper($v['create']) == true && $is_create){
            $field = $this->getFormElement( $v['type'], $k, $v, $v['name'], $model, $model_prefix );
        }

        if( strtoupper($v['edit']) == 'RO' && $is_create == false) {
            $field = $this->getFormElement('readonly', $k, $v, $v['name'], $model, $model_prefix);
        }

        if( strtoupper($v['create']) == 'RO' && $is_create){
            $field = $this->getFormElement( 'readonly', $k, $v, $v['name'], $model, $model_prefix );
        }

        if( strtoupper($v['edit']) == 'VO' && $is_create == false  ){
            $field = $this->getViewElement( $v['type'], $k, $v, $v['name'], $model, $model_prefix );
        }

        if( strtoupper($v['create']) == 'VO' && $is_create ){
            $field = $this->getViewElement( $v['type'], $k, $v, $v['name'], $model, $model_prefix );
        }

        return $field;
    }

    public function composeFormField($k, $v, $is_create = true)
    {

        $model = ( !isset($v['form']['model']) || is_null($v['form']['model']))? $v['name'] : $v['form']['model'];

        $options = [];
        if(isset($v['form']['options'])){
            $opt = $v['form']['options'];
            if(isset($opt['call'])){
                $options = (isset($opt['call']))? $this->buffeval($opt['call'], $opt['param'], $v['kind'] ) :$default;
            }else{
                if(is_array($opt)){
                    $options = $opt;
                }else{
                    $options = [''=>'Select '.$k];
                }
            }

        }

        $default = isset($v['form']['default'])?$v['form']['default']:'';

        if( strtoupper($v['form']['edit']) == 'RO' && !$is_create) {
            $field = $this->getFormElement('readonly', $k, $v, $v['name'], $model);
        }elseif( strtoupper($v['form']['create']) == 'RO' && $is_create){
            $field = $this->getFormElement( 'readonly', $k, $v, $v['name'], $model );
        }else{
            if( (strtoupper($v['form']['edit']) == 'VO' && !$is_create ) || ( strtoupper($v['form']['create']) == 'VO' && $is_create  ) ){
                $field = $this->getViewElement( $v['form']['type'], $k, $v, $v['name'], $model );
            }else{
                $field = $this->getFormElement( $v['form']['type'], $k, $v, $v['name'], $model );
            }
        }

        return $field;
    }

    public function getFormElement($element, $k, $v, $name = '', $model = '', $model_prefix = '')
    {
        $view = 'form.component.'.$element;
        if(isset($v['form'])){
            $v = $v['form'];
        }
        if( view()->exists( $view ) ){
            if( $model_prefix != ''){
                $model = $model_prefix.'.'.$model;
            }
            $field = view($view, ['label'=>$k, 'form'=>$v, 'name'=>$name, 'model'=>$model  ] )->render();
            return $field;
        }else{
            return '';
        }
    }

    public static function staticFormElement($element, $k, $v, $name = '', $model = '')
    {
        $view = 'form.component.'.$element;
        if(isset($v['form'])){
            $v = $v['form'];
        }
        if( view()->exists( $view ) ){
            $field = view($view, ['label'=>$k, 'form'=>$v, 'name'=>$name, 'model'=>$model  ] )->render();
            return $field;
        }else{
            return '';
        }
    }

    public function toViewElement($column = 1, $row = 1 ,$mode = 'page')
    {
        $forms = [];

        if( self::$yml ){

            foreach( self::$yml as $v){
                if(isset($v['form'])){
                    if(isset($v['form']['row']) && $v['form']['row'] == $row ){
                        if(isset($v['form']['col']) && $v['form']['col'] == $column ){
                            if( (isset($v['form']['edit']) && $v['form']['edit']) || (isset($v['form']['create']) && $v['form']['create']) ){
                                $forms[] = self::composeViewField($v['label'], $v);
                            }
                        }
                    }

                }
            }
        }
        return $forms;
    }

    public function getViewField($element, $k, $v, $name = '', $model = '')
    {
        $view = 'viewer.component.'.$element;

        if( view()->exists( $view ) ){
            $field = view($view, ['label'=>$k, 'form'=>$v['form'], 'name'=>$name, 'model'=>$model  ] )->render();
            return $field;
        }else{
            $view = 'viewer.component.text';
            $field = view($view, ['label'=>$k, 'form'=>$v['form'], 'name'=>$name, 'model'=>$model  ] )->render();
            return $field;
        }
    }

    public function composeViewField($k, $v)
    {

        $model = ( !isset($v['form']['model']) || is_null($v['form']['model']))? $v['name'] : $v['form']['model'];

        $vtype = $v['form']['type'];
        if(isset($v['view']['type'])){
            $vtype = $v['view']['type'];
        }

        $vlabel = $k;
        if(isset($v['view']['label'])){
            $vlabel = $v['view']['label'];
        }


        $field = $this->getViewField( $vtype , $vlabel, $v, $v['name'], $model );

        return $field;
    }

    public function getViewElement($element, $k, $v, $name = '', $model = '')
    {
        info('View Neo', $v);
        $view = 'viewer.component.'.$element;

        $form = isset($v['form']) ? $v['form']: $v;

        if( view()->exists( $view ) ){
            $field = view($view, ['label'=>$k, 'form'=>$form, 'name'=>$name, 'model'=>$model  ] )->render();
            return $field;
        }else{
            $view = 'viewer.component.text';
            $field = view($view, ['label'=>$k, 'form'=>$form, 'name'=>$name, 'model'=>$model  ] )->render();
            return $field;
        }
    }

    public function composeViewElement($k, $v)
    {

        $model = ( !isset($v['model']) || is_null($v['model']))? $v['name'] : $v['model'];

        $vtype = $v['type'];
        if(isset($v['type'])){
            $vtype = $v['type'];
        }

        $vlabel = $k;
        if(isset($v['label'])){
            $vlabel = $v['label'];
        }


        $field = $this->getViewElement( $vtype , $vlabel, $v, $v['name'], $model );

        return $field;
    }

    public function toViewWithKey($keyfield = 'name')
    {
        $forms = [];

        if( self::$yml ){
            foreach( self::$yml as $v){
                info('View Element',$v);
                if(isset($v['view'])){
                    //if((isset($v['form']['edit']) && $v['form']['edit']) || (isset($v['form']['create']) && $v['form']['create']) ){
                        $forms[ $v[$keyfield] ] = self::composeViewField($v['label'], $v);
                    //}
                }
            }
        }
        return $forms;
    }

    public function toViewElementWithKey($keyfield = 'name')
    {
        $forms = [];

        if( self::$yml ){
            if(isset(self::$yml['view'])){
                foreach( self::$yml['view'] as $v){
                    $forms[ $v[$keyfield] ] = self::composeViewElement($v['label'], $v);
                }
            }
        }
        return $forms;
    }

    public function viewWithLayout($formObject){

        $forms = [];
        if( self::$yml ){
            foreach( self::$yml as $obj){
                $row = [];
                foreach($obj as $k=>$v){
                    if($k == 'row'){
                        $row[] = '<div class="row">';
                        foreach($v as $vk=>$vl){
                            $width = 12 / count($v);
                            $width = floor($width);
                            foreach ($vl as $c => $f){
                                $col = [];
                                if( preg_match('/^col/', $c) ){
                                    if(preg_match('/^col_/', $c)){
                                        $width = str_replace('col_', '', $c);
                                    }
                                    $col[] = '<div class="col-lg-'.$width.' col-md-'.$width.' col-sm-12" >';
                                    if(is_array($f)){
                                        foreach( $f as $fobj ){
                                            foreach($fobj as $fk=>$fv){
                                                if($fk == 'field'){
                                                    if(isset($formObject[$fv])){
                                                        $col[] = $formObject[$fv]."\r\n";
                                                    }
                                                }
                                                if($fk == 'row'){
                                                    $col[] = '<div class="row">';
                                                    foreach($fv as $cobj){
                                                        $width = 12 / count($fv);
                                                        $width = floor($width);
                                                        foreach($cobj as $cfk=>$cfv){
                                                            foreach($cfv as $fko=>$flo){
                                                                if(preg_match('/^col_/', $cfk)){
                                                                    $width = str_replace('col_', '', $cfk);
                                                                }

                                                                $col[] = '<div class="col-lg-'.$width.' col-md-'.$width.' col-sm-12">';
                                                                foreach ($flo as $flk=>$flv){
                                                                    if(isset($formObject[$flv])){
                                                                        $col[] = $formObject[$flv]."\r\n";
                                                                    }
                                                                }
                                                                $col[] = '</div>';
                                                            }
                                                        }
                                                    }
                                                    $col[] = '</div>';
                                                }
                                            }
                                        }
                                    }
                                    $col[] = '</div>';
                                }
                            }
                            $row = array_merge($row, $col);
                        }
                        $row[] = '</div>';
                        $forms = array_merge($forms, $row);
                    }
                }
            }
        }

        return $forms;

    }

    public function toVueDataList($prefix = '', $separator = ':', $valprefix = '', $terminator = ',', $stripLastComma = false){
        $fields = [];
        if(isset(self::$yml['vue'])){
            foreach( self::$yml['vue'] as $v){

                $default = $v['default'];

                if($v['type'] == 'object'){
                    if( $default == '' || $default == '{}' ){
                        $default = '{}';
                    }else{
                        $default = json_encode($v['default']);
                    }
                }

                if($v['type'] == 'array'){
                    if(empty($default)){
                        $default = '[]';
                    }else{
                        $default = json_encode($v['default']);
                    }
                }

                if($v['type'] == 'string'){
                    if( $default == ''){
                        $default = "''";
                    }else{
                        $default = "'".$default."'";
                    }
                }

                if(
                    $v['type'] == 'int'
                    || $v['type'] == 'integer'
                    || $v['type'] == 'double'
                    || $v['type'] == 'float'
                ){
                    if( $default == ''){
                        $default = 0;
                    }else{
                        $default = doubleval($default);
                    }
                }

                if(
                    $v['type'] == 'boolean'
                ){
                    if( $default == true){
                        $default = 'true';
                    }else{
                        $default = 'false';
                    }
                }

                if($valprefix == 'this.'){
                    $default = $v['model'];
                }

                if( strpos($v['model'], "(" ) || $v['type'] == 'function' ){

                }else{
                    $fields[] = sprintf("\t%s%s %s %s%s %s", $prefix, $v['model'], $separator, $valprefix ,$default, $terminator);
                }
            }
        }

        if($stripLastComma){
            $fields[ count($fields) - 1 ] = str_replace( ',','', $fields[ count($fields) - 1 ]  );
        }

        return $fields;
    }

    public function toVueDataModel($modelset = 'default')
    {

        $vmodel = self::$addDataModel;

        $ymd = [];
        foreach( self::$yml as $v){
            if(isset($v['name'])){
                $ymd[$v['name']] = $v;
            }
        }

        if(empty($vmodel)){
            $vmodel = $ymd;
        }else{
            $vmodel = array_merge( $ymd, $vmodel );
        }

        $fields = [];

        foreach($vmodel as $k=>$v){
            $default = "''";

            if($modelset == 'default' || $modelset == 'clear' || $modelset == 'plain' ){
                if(isset($v['name'])){
                    //$fields[] = $prefix.$v['name'].$equ.$default.$suffix;
                    $plainobject = '';
                    if( isset($v['vue']['type']) ){

                        if(isset($v['vue']['default']) && $v['vue']['type'] == 'array' ){
                            if( is_array($v['vue']['default']) && !empty($v['vue']['default'])){
                                $default = json_encode($v['vue']['default']);
                                $plainobject = $v['vue']['default'];
                            }else{
                                $default = json_encode([]);
                                $plainobject = [];
                            }
                        }

                        if(isset($v['vue']['default']) && $v['vue']['type'] == 'object' ){
                            //print_r($v['vue']['default']);
                            //die();
                            if( is_array($v['vue']['default']) && !empty($v['vue']['default'])){
                                $default = json_encode($v['vue']['default']);
                                $plainobject = $v['vue']['default'];
                            }else{
                                $default = json_encode(new \ArrayObject());
                                $plainobject = new \ArrayObject();
                            }
                        }

                        //$default = ($v['vue']['type'] == 'array')?json_encode([]): $default;
                        //$default = ($v['vue']['type'] == 'object')? json_encode(new \ArrayObject()) : $default;
                    }

                    if($modelset == 'default'){
                        $fields[] = sprintf("\t%s:%s,", $v['name'], $default );
                    }elseif($modelset == 'clear'){
                        $fields[] = sprintf("\tthis.%s = %s;", $v['name'], $default );
                    }else{
                        $fields[] = $plainobject;
                    }

                }
            }

            if($modelset == 'objectfield'){
                $fields[] = sprintf("\t%s: this.%s,", $v['name'], $v['name'] );
            }

            if($modelset == 'load'){
                $fields[] = sprintf("\tthis.%s = data.%s ;", $v['name'], $v['name'] );
            }

            if($modelset == 'return'){
                $fields[] = sprintf("\t{ %s: this.%s },", $v['name'], $v['name'] );
            }

        }


        return $fields;
    }

    public static function inflateYmlForm($yml_file,$res_path, $form_layout ,$is_create = true, $model_prefix = '')
    {
        if(strpos($yml_file,'_controller') === false){
            $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormWithKey('name', $is_create);
            $form_page = \App\Helpers\Util::formWithBladeLayout($form_layout,$form_fields, $is_create) ;
        }else{
            $form_fields = \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toFormElementWithKey('name', $is_create, $model_prefix);
            $form_page = \App\Helpers\Util::formElementWithBladeLayout($form_layout,$form_fields, $is_create) ;
        }

        return $form_page;
    }

    public static function inflateVueModel()
    {

    }

    public static function templateJson($field, $val){
        $tmp = false;
        if($field == 'id'){
            $tmp = JsonTemplate::find($val);
        }else{
            $tmp = JsonTemplate::where($field, '=', $val)->first();
        }
        if($tmp){
            return $tmp->content;
        }else{
            return new \ArrayObject();
        }
    }

    public static function templateForm($field, $val){
        $tmp = false;
        if($field == 'id'){
            $tmp = FormTemplate::find($val);
        }else{
            $tmp = FormTemplate::where($field, '=', $val)->first();
        }
        if($tmp){
            return $tmp->content;
        }else{
            return '``';
        }
    }

    public static function templateView($field, $val){
        $tmp = false;
        if($field == 'id'){
            $tmp = ViewTemplate::find($val);
        }else{
            $tmp = ViewTemplate::where($field, '=', $val)->first();
        }
        if($tmp){
            return $tmp->content;
        }else{
            return '``';
        }
    }

    private function buffeval($code, $param, $kind)
    {
        $xs = call_user_func($code, $param);
        if($kind == 'text'){
            if(is_array($xs)){
                return $xs;
            }else{
                return "'$xs'";
            }
        }else{
            return $xs;
        }
    }

    public static function sa($str){
        $current = Route::currentRouteAction();
        if(stripos($current, $str )){
            return 'active';
        }else{
            return '';
        }
    }

    public static function logDownload($url, $desc)
    {
        $fd = new FileDownload();
        $fd->handle = Util::randomstring();
        $fd->tz = date_default_timezone_get();
        $fd->downloadUrl = $url;
        $fd->downloadDescription = $desc;
        $fd->isActive = true;
        $fd->ownerId = Auth::user()->_id;
        $fd->ownerName = Auth::user()->name;
        $fd->save();

    }

    public static function composeDynaFormSection($formCode)
    {
        $sections = DcsUtil::getQuestionSection($formCode);

        $form = self::composeDynaForm($formCode);

        $tabs = [];

        $section_idx = 1;

        foreach ($sections as $section){

            $cx = self::composeDynaForm($formCode, $section_idx , $section['formSectionName']);


            $tabs[] = '<b-tab title="'.$section['formSectionName'].'" class="mr-1"  ><h6 class="p-3">'.( $section['formSectionDescription'] ?? '' ).'</h6>'.$cx['template'].'</b-tab>';

            $section_idx++;
        }

        $template = '<b-tabs >'.implode('', $tabs).'</b-tabs>';

        $form['template'] = $template;

        return $form;

    }

    public static function composeDynaForm($formCode, $section_idx = 0 , $section = false)
    {
        $questions = DcsUtil::getQuestions($formCode, $section);
        $tmpl = [];
        $index = 1;
        $model = [];
        $objDef = [];
        $params = [];

        $params['handle'] = Str::random(12);

        $uploadurl = 'api/v1/core/upload';
        $params['uploadurl'] = $uploadurl;
        $params['show_list'] = 'true';

        foreach ($questions as $q){
            $label = $q['question'];
            $mdl = 'question'.strval($section_idx).$index;
            $el['model'] = 'value.'.$mdl;
            $el['name'] = 'question'.strval($section_idx).$index;
            $el['type'] = $q['questionType'];
            $el['edit'] = false;
            $el['create'] = true;
            $el['inline'] = false;
            $opt = [];

            $model[$mdl] = isset($q['defaultAnswer']) && $q['defaultAnswer'] != '' ? $q['defaultAnswer'] : ' ';
            $objDef[$mdl] = isset($q['defaultAnswer']) && $q['defaultAnswer'] != '' ? $q['defaultAnswer'] : ' ';
            if($el['type'] == 'checkboxselect'){
                $model[$mdl] = isset($q['defaultAnswer']) && $q['defaultAnswer'] != '' ? $q['defaultAnswer'] : ' ';
                $objDef[$mdl] = isset($q['defaultAnswer']) && $q['defaultAnswer'] != '' ? $q['defaultAnswer'] : ' ';
            }
            if($el['type'] == 'radioselect'){
                $model[$mdl] = isset($q['defaultAnswer']) && $q['defaultAnswer'] != '' ? $q['defaultAnswer'] : ' ';
                $objDef[$mdl] = isset($q['defaultAnswer']) && $q['defaultAnswer'] != '' ? $q['defaultAnswer'] : ' ';
            }
            if($el['type'] == 'number'){
                $el['class'] = 'text-150';
                $model[$mdl] = isset($q['defaultAnswer']) && $q['defaultAnswer'] != '' ? doubleval($q['defaultAnswer']) : 0;
                $objDef[$mdl] = isset($q['defaultAnswer']) && $q['defaultAnswer'] != '' ? doubleval($q['defaultAnswer']) : 0;
            }

            for( $i = 1; $i < 6; $i++ ){
                if($q['answer'.$i] != ''){
                    $opt[] = [ 'value'=>$q['answer'.$i], 'text'=>$q['answer'.$i] ];
                }
            }

            $model[$mdl.'Options'] = $opt;
            $elq = Util::staticFormElement( $el['type'], $label, $el );

            if($q['useRemark']){
                $rmType = $q['remarkType'] ?? 'textarea';
                $rmLabel = $q['remarkLabel'] ?? 'Remark';

                $rmdl = 'remark'.strval($section_idx).$index;
                $el['model'] = 'value.'.$rmdl;
                $el['name'] = 'remark'.strval($section_idx).$index;
                $el['handle'] = 'params.handle';
                $el['uploadurl'] = $uploadurl;
                $el['show_list'] = 'params.show_list';
                $model[$rmdl] = $q['defaultAnswer'] ?? '';
                $objDef[$rmdl] = $q['defaultAnswer'] ?? '';

                $rem = Util::staticFormElement( $rmType, $rmLabel, $el );

                $elq = '<div class="row"><div  class="col-md-7 col-sm-12" >'.$elq.'</div><div class="col-md-5 col-sm-12">'.$rem.'</div></div>';
            }

            $tmpl[] = '<div class="row"><div class="col-1 text-50 text-center text-top pt-4" >'.$index.'</div><div class="col-11 text-left text-top">'.$elq.'</div></div>' ;

            $index++;
        }

        $template = '<div>'.implode('', $tmpl).'</div>';

        $model['handle'] = Str::random(8);

        return [
            'template'=>$template,
            'model'=>$model,
            'default'=>$objDef,
            'params'=>$params
        ];
    }



}
