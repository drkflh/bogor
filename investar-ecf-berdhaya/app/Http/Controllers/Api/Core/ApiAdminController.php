<?php
/**
 * Created by Andy Awidarto.
 * User: awidarto
 * Date: 12/12/17
 * Time: 10:11 AM
 */
namespace App\Http\Controllers\Api\Core;

use App\Helpers\APIUtil;
use App\Helpers\AuthUtil;
use App\Helpers\TimeUtil;
use App\Helpers\Util;
use App\Helpers\WorkflowUtil;
use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\AuthorizationStatusLog;
use App\Models\Core\Mongo\Member;
use App\Models\Core\Mongo\Uploaded;
use App\Models\Workflow\ApprovalRequest;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @group Core Classes
 *
 * Base Classes to be extended by other domain implementation classes
 */
class ApiAdminController extends Controller
{

    public $controller_name = '';

    public $model;

    public $sql_connection;

    public $sql_table_name;

    public $def_order_by = 'created_at';
    public $def_order_dir = 'desc';
    public $sql_key = 'NoLelang';

    public $order_unset = ['rawJson'];

    public $res_path = '';
    public $yml_file = '';
    public $entity = '';

    public $auth = null;

    public $use_location = false;
    public $default_lng = 0;
    public $default_lat = 0;

    public $excludeFields = [
        "_id",
        "ajax",
        "handle",
        "deleted",
        "createdAt",
        "updatedAt",
        "updated_at",
        "created_at",
        "ownerId",
        "ownerName"
    ];

    public $pre_process_error = 'Preprocess Error';

    public $entities = [];


    public function  __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        debug($this->controller_name);

        $this->default_lng = doubleval(env('DEFAULT_LNG', 106.82718498459532 ));
        $this->default_lat = doubleval(env('DEFAULT_LAT', -6.175168397297347 ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $this->auth = $request->auth;

        $req_query = $request->toArray();

        $this->default_lng = doubleval(env('DEFAULT_LNG', 106.82718498459532 ));
        $this->default_lat = doubleval(env('DEFAULT_LAT', -6.175168397297347 ));

        /**
         * Pagination Parameters
         * p = page
         * pp = per page
         */
        if($request->has('p')){
            $page = $request->input('p');
        }else{
            $page = 1;
        }

        if($request->has('pp')){
            $page_size = intval($request->input('pp'));
        }else{
            $page_size = config('util.api_page_size');
        }

        $key = $request->input('key');


        $model = $this->model;

        $this->entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiTypeList();

        $searchField = ( $request->has('sf') )?$request->input('sf'): null;
        $searchValue = ( $request->has('sv') )?$request->input('sv'): null;
        $searchOp = ( $request->has('so') )?$request->input('so'): 'eq';

        $searchOp = strtolower($searchOp);

        if(! (is_null($searchField) && is_null($searchValue)) ){
            $prevSearchvalue = $searchValue;
            $searchValue = $this->transformSearchValue($searchValue, $searchField);
            $searchField = $this->transformSearchField($prevSearchvalue, $searchField);

            $req_query['sf'] = $searchField;
            $req_query['sv'] = $searchValue;

            //print_r($this->entities);

            $searchValue = $this->prepareValueType( $searchField, $searchValue);

            //like, for string
            if($searchOp == 'like' || $searchOp == 'likeb' ){ // % sign on left and right
                $model = $model->where($searchField, 'like', '%'.$searchValue.'%');
            }
            if($searchOp == 'likel' ){ // % sign on the left
                $model = $model->where($searchField, 'like', '%'.$searchValue);
            }
            if($searchOp == 'liker' ){ // % sign on the right
                $model = $model->where($searchField, 'like', $searchValue.'%');
            }
            //eq , equal
            if($searchOp == 'eq'){
                $model = $model->where($searchField, '=', $searchValue);
            }
            //ne , not equal
            if($searchOp == 'ne'){
                $model = $model->where($searchField, '!=', $searchValue);
            }
            //gt , greater than
            if($searchOp == 'gt'){
                $model = $model->where($searchField, '>', $searchValue );
            }
            //lt , less than
            if($searchOp == 'lt'){
                $model = $model->where($searchField, '<', $searchValue );
            }
            //gte , greater than or equal
            if($searchOp == 'gte'){
                $model = $model->where($searchField, '>=', $searchValue );
            }
            //lte , less than or equal
            if($searchOp == 'lte'){
                $model = $model->where($searchField, '<=', $searchValue );
            }
        }

        $multiSearch = ( $request->has('ms') )?$request->input('ms'): null;
        $multiEncoding = ( $request->has('me') )?$request->input('me'): 'p';

        /**
         * Multisearch is a very simple implementation of multifield search.
         * for more advanced and complex search or query consider using GraphQL
         * format :
         * field1:op1:t1:val1|field2:op2:t2:val2|field3:op3:t3:val3
         * field : fieldName
         * op : operator => like, eq, ne, gt, gte, le, lte
         * t : type of value => s(tring), i(nt), d(ouble), f(loat)
         * special rule :
         * "like" will always assume that value is string, therefore t is used as wildcard (%) position marker
         * when op = like, t can be b(oth) , l(eft) , or r(ight)
         * will compose the value as '%value%' , '%value', 'value%' respectively
         *
         * $multiEncoding : encoding query string, default => p(lain) , no encoding , or "b" => base64 encoded
         */
        if(!is_null($multiSearch)){
            if($multiEncoding == 'b'){
                $multiSearch = base64_decode($multiSearch);
            }
            $sfs = explode('|', $multiSearch);
            foreach($sfs as $sit){
                $si = explode(':', $sit);
                if(count($si) == 4){
                    $field = $si[0];
                    $op = $si[1];
                    $t = $si[2];
                    $val = $si[3];

                    $val = $this->prepareValueType($field, $val);

                    if($op == 'like'){
                        if($t == 'l'){
                            $val = '%'.$val;
                        }elseif($t == 'r'){
                            $val = $val.'%';
                        }else{
                            $val = '%'.$val.'%';
                        }
                        $model = $model->where($field, 'like', $val);
                    }

                    if($op == 'eq' || $op == 'ne' || $op == 'gt' || $op == 'gte' || $op == 'lt' || $op == 'lte' ){
                        if($t == 's'){
                            $val = strval($val);
                        }
                        if($t == 'i'){
                            $val = intval($val);
                        }
                        if($t == 'd'){
                            $val = doubleval($val);
                        }
                        if($t == 'f'){
                            $val = floatval($val);
                        }
                        $model = $model->where($field, 'like', $val);
                    }

                    if($op == 'eq'){
                        $model = $model->where($field, '=', $val);
                    }

                    if($op == 'ne'){
                        $model = $model->where($field, '!=', $val);
                    }

                    if($op == 'gt'){
                        $model = $model->where($field, '>', $val);
                    }

                    if($op == 'gte'){
                        $model = $model->where($field, '>=', $val);
                    }

                    if($op == 'lt'){
                        $model = $model->where($field, '<', $val);
                    }

                    if($op == 'lte'){
                        $model = $model->where($field, '<=', $val);
                    }

                }
            }

        }

        /**
         * Date range filter parameters
         * df = date field to be filtered
         * ds = date start , yyyy-mm-dd , will be appended with 00:00:00 to denote beginning of day
         * de = date end , yyyy-mm-dd , will be appended with 23:59:59 to denote beginning of day
         */
        $dateField = ( $request->has('df') )?$request->input('df'): null;
        $start = ( $request->has('ds') )?$request->input('ds'): null;
        $until = ( $request->has('de') )?$request->input('de'): null;
        $lf = ( $request->has('lf') )?$request->input('lf'): 'lngLat'; // location field , field yang diquery dengan geo query, harus diindex sebagai 2dsphere
        $lat = ( $request->has('lat') )?$request->input('lat'): null;
        $lng = ( $request->has('lng') )?$request->input('lng'): null;
        $rad = ( $request->has('rad') )?$request->input('rad'): env('DEFAULT_SEARCH_RADIUS', 50 ); // radius pencarian dalam KM

        $rad = intval( $rad ) * intval(env('RADIUS_MULTIPLIER',100));

        if($request->has('df')){
            $dateField = $request->get('df');
        }else{
            $dateField = null;
        }

        if(!is_null($dateField)){
            if($request->has('ds')){
                $start = $request->get('ds');
                try {
                    $start = Carbon::make($start);
                }catch (Exception $exception){
                    debug($exception->getMessage());
                    $start = $until ?? Carbon::now()->startOfDay();
                }
            }else{
                $start = Carbon::now()->startOfDay();
            }

            if($request->has('de')){
                try {
                    $until = Carbon::make($request->get('de'));
                    $uend = Carbon::make($request->get('de'));
                    if($until->equalTo( $uend->startOfDay() )){
                        $until = Carbon::make($request->get('de'))->endOfDay();
                    }
                }catch (Exception $exception){
                    debug($exception->getMessage());
                    $until = $until ?? Carbon::now()->endOfDay();
                }
            }else{
                if($request->has('ds')){
                    $until = Carbon::make( $request->get('ds') )->endOfDay();
                }else{
                    $until = Carbon::now()->endOfDay();
                }
            }

            $model = $model->whereBetween($dateField , [$start, $until]);

            $req_query['ds'] = $start->toDateTimeString();
            $req_query['de'] = $until->toDateTimeString();


        }

        if($this->use_location == true){
            /**
             * lngLat ( or any field used as location ) should be indexed as "2dsphere"
             */
            if(!(is_null($lat) && is_null($lng))){
                $model = $model->where(
                    $lf,
                    'near',
                    [
                        '$geometry'=>[
                            'type'=>'Point',
                            'coordinates'=>[ doubleval($lng), doubleval( $lat) ]
                        ],
                        '$maxDistance'=>doubleval($rad)
                    ]
                );
            }else{
                $lng = $this->default_lng;
                $lat = $this->default_lat;

                $model = $model->where(
                    $lf,
                    'near',
                    [
                        '$geometry'=>[
                            'type'=>'Point',
                            'coordinates'=>[ doubleval($lng), doubleval( $lat) ]
                        ],
                        '$maxDistance'=>doubleval($rad)
                    ]
                );

            }

        }

        $model = $this->additionalQuery($model, $request);

        if($request->has('of')){
            $def_order_by = $request->get('of') ?? 'updated_at';
        }else{
            $def_order_by = 'updated_at';
        }

        if($request->has('od')){
            $def_order_dir = $request->get('od') ?? 'desc';
        }else{
            $def_order_dir = 'desc';
        }

        $model = $model->orderBy($def_order_by, $def_order_dir);

        $total_records = $model->count();

        $total_page = ceil( $total_records / $page_size);

        if($page == 'all'){
            $orders = $model->get();
            $page = 1;
        }else{
            $orders = $model->skip( ($page - 1) * $page_size )->take($page_size)->get();
        }

        $qlog = DB::getQueryLog();

        $orders = $orders->toArray();

        $this->entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiEntity('list');

        $orders = $this->prepareOutputArray($orders, 'list');

        $headers = array('X-Page' => $page, 'X-Total-Pages'=> $total_page, 'X-Total-Records'=>$total_records );

        try{
            $url = Route::current()->uri();

            $resp = [
                'result'=>'OK',
                'data'=>[
                    'page'=>($page == 'all')?$page: intval($page),
                    'totalPage'=>$total_page,
                    'totalRecord'=>$total_records,
                    'data'=>$orders
                ]
            ];

            APIUtil::log( $url, $request->method() ,$request->toArray(), $resp, $this->auth );
        }catch (\Exception $exception){

        }

        if(!$request->has('debug')){
            $qlog = null;
        }

        return response()->json(
            [
                'result'=>'OK',
                'data'=>[
                    'page'=>($page == 'all')?$page: intval($page),
                    'totalPage'=>$total_page,
                    'totalRecord'=>$total_records,
                    'data'=>$orders,
                    'query'=>$req_query,
                    'qlog'=>$qlog
                ]
            ],
            200,
            $headers
        );
    }

    public function prepareValidator($entity){
        $va = [];
        foreach ($entity as $ek=>$ev )
        {
            if($ev['validator'] != ''){
                $va[ $ev['name'] ] = $ev['validator'];
            }
        }

        return $va;
    }

    public function prepareValueType($field, $value)
    {
        if(isset($this->entities[$field])){
            $type = $this->entities[$field]['type'];
        }else{
            $type = 'string';
        }

        if($type == 'string'){
            return strval($value);
        }
        if($type == 'integer' || $type == 'int'){
            return intval($value);
        }
        if($type == 'double'){
            return doubleval($value);
        }
        if($type == 'float'){
            return floatval($value);
        }
        if($type == 'boolean' || $type == 'bool'){
            return boolval($value) == 1 ? true : false;
        }
    }

    public function prepareOutputArray(array $outputs, $mode = 'all')
    {
        for($i = 0; $i < count($outputs); $i++){
            $outputs[$i] = $this->prepareOutput( $outputs[$i] , $mode );
        }
        return $outputs;
    }

    public function prepareOutput($on, $mode = 'all')
    {
//        $entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiEntity($mode);
        $entities = $this->entities;

        $or = [];

        if(isset($on['_id'])){
            $or['extId'] = $on['_id'] ?? '';
        }else{
            $or['extId'] = $on['extId'] ?? '';
        }

        //$or['tz'] = $on['tz'] ?? '';

        foreach($entities as $ek=>$ev ){

            try{

                if( isset($on[$ek]) ){
                    //print $ek."=".$on[$ek]."\r\n";
                    if($ev['nullable'] && is_null($ev['default']) ){
                        $or[$ek] = $on[$ek] ?? $ev['default'] ;
                    }else{
                        $or[$ek] = $on[$ek] ?? '-' ;
                    }
                }else{
                    if($ev['nullable']){
                        $or[$ek] = $ev['default'];
                    }else{
                        $or[$ek] = $ev['default'] ?? '-';
                    }
                }

                if(is_string($or[$ek])){
                    $or[$ek] = trim($or[$ek]);
                }

                if($ev['type'] == 'string'){

                    $or[$ek] = $or[$ek] ?? '';
                    $or[$ek] = strval($or[$ek]);
                }

                if($ev['type'] == 'boolean'){

                    $or[$ek] = $or[$ek] ?? 0;
                    $or[$ek] = boolval($or[$ek]);

                    $or[$ek] = $or[$ek] ? true: false;

                }

                if($ev['type'] == 'datetime'){
                    try{
                        if($or[$ek] instanceof \MongoDB\BSON\UTCDateTime){
                            $dt = Carbon::make( $or[$ek]->toDateTime() );
                            if( !is_null($dt) ){
                                $or[$ek] = $dt->format('Y-m-d h:i:s' );
                            }
                        }else{
                            $dt = Carbon::make( $or[$ek] );
                            if( !is_null($dt) ){
                                $or[$ek] = $dt->format('Y-m-d h:i:s' );
                            }
                        }
                    }catch(\Exception $exception){

                    }
                }
                if($ev['type'] == 'date'){
                    //$or[$ek] = date( env('DATE_API_FORMAT', strtotime($or[$ek]) ) );

                    try{
                        if($or[$ek] instanceof \MongoDB\BSON\UTCDateTime){
                            $dt = Carbon::make( $or[$ek]->toDateTime() );
                            if( !is_null($dt) ){
                                $or[$ek] = $dt->format('Y-m-d' );
                            }
                        }else{
                            $dt = Carbon::make( $or[$ek] );
                            if( !is_null($dt) ){
                                $or[$ek] = $dt->format('Y-m-d' );
                            }
                        }
                    }catch(\Exception $exception){

                    }
                }
                if($ev['type'] == 'time'){
                    //$or[$ek] = date( env('DATE_API_FORMAT', strtotime($or[$ek]) ) );
                    try{
                        if($or[$ek] instanceof \MongoDB\BSON\UTCDateTime){
                            $dt = Carbon::make( $or[$ek]->toDateTime() );
                            if( !is_null($dt) ){
                                $or[$ek] = $dt->format(env('TIME_API_FORMAT', 'H:i:s') );
                            }
                        }else{
                            $dt = Carbon::make( $or[$ek] );
                            if( !is_null($dt) ){
                                $or[$ek] = $dt->format(env('TIME_API_FORMAT', 'H:i:s') );
                            }
                        }
                    }catch(\Exception $exception){

                    }
                }
                if( strtolower($ev['type']) == 'imagearray'){
                    $pics = [];
                    if(is_array($or[$ek])){

                        foreach($or[$ek] as $p){
                            if(isset($p['url']) && isset($p['base'])){
                                $pics[] = $p['base'].$p['url'] ;
                            }
                        }
                    }
                    if(is_string( $or[$ek] )){
                        $pics[] = $or[$ek];
                    }

                    $or[$ek] = $pics;
                }
                if( strtolower($ev['type']) == 'image'){
                    $pic = '';
                    if(is_array($or[$ek])){

                        foreach($or[$ek] as $p){
                            if(isset($p['url']) && isset($p['base'])){
                                $pic = $p['base'].$p['url'] ;
                            }
                        }
                    }
                    if(is_string( $or[$ek] )){
                        $pic = $or[$ek];
                    }

                    $or[$ek] = $pic;
                }
                if( strtolower($ev['type']) == 'imageobjectarray'){
                    $pics = [];
                    if(is_array($or[$ek])){

                        foreach($or[$ek] as $p){
                            if(isset($p['url']) && isset($p['base'])){
                                $pics[] = [
                                    'url'=>$p['base'].$p['url'],
                                    'meta'=>$p
                                ];
                            }
                        }
                    }
                    if(is_string( $or[$ek] )){
                        $pics[] = [
                            'url'=>$or[$ek],
                            'meta'=>[ 'url'=>$or[$ek] ]
                        ];
                    }

                    $or[$ek] = $pics;
                }
                if( strtolower($ev['type']) == 'imageobject'){
                    $pic = '';
                    if(is_array($or[$ek])){

                        foreach($or[$ek] as $p){
                            if(isset($p['url']) && isset($p['base'])){
                                $pic = [
                                    'url'=>$p['base'].$p['url'],
                                    'meta'=>$p
                                ];
                            }
                        }
                    }
                    if(is_string( $or[$ek] )){
                        $pic = [
                            'url'=>$or[$ek],
                            'meta'=>[ 'url'=>$or[$ek] ]
                        ];
                    }

                    $or[$ek] = $pic;
                }

                if( strtolower($ev['type']) == 'array'){
                    $va = is_array($ev['default'])? $ev['default'] : [];
                    if(is_array($or[$ek])){
                        $va = $or[$ek];
                    }
                    if(is_string( $or[$ek] )){
                        if( trim($or[$ek]) != ''){
                            $va = [ trim($or[$ek]) ];
                        }
                    }

                    $or[$ek] = $va;

                }

                if($ev['transform'] && $ev['transform'] != ''){

                    $tx = explode(':', $ev['transform']);
                    if($tx[0] == 'rename'){
                        $or[$tx[1]] = $or[$ek];
                        unset($or[$ek]);
                    }
                    if($tx[0] == 'copy'){
                        $or[$tx[1]] = $or[$ek];
                    }
                    if($tx[0] == 'function'){
                        $or[$ek] = $this->{$tx[1]}($or[$ek]);
                    }
                }


                //print $ek."=".$or[$ek]."\r\n";

            }catch (\Exception $exception){

            }

        }

        $or['tz'] = $or['tz'] ?? env('DEFAULT_TIME_ZONE', 'UTC');

        $or = $this->beforeOutput($or); //add additional process to data object item before output

        unset($or['_id']);
        unset($or['raw_json']);

        return $or;
    }

    public function transformSearchField($val, $field)
    {
        return $field;
    }
    public function transformSearchValue($val, $field)
    {
        return $val;
    }

    public function additionalQuery($model, Request $request){
        return $model;
    }

    public function addFindObjectQuery($model, Request $request){
        return $model;
    }

    public function beforeOutput(Array $data){
        return $data;
    }

    public function preProcess($object){

        return true;
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

    public function getSchema(Request $request)
    {
        $obj = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toObjectSchema();

        foreach ($this->excludeFields as $ex){
            unset($obj[$ex]);
        }

        try{
            $url = Route::current()->uri();

            $resp = [
                'result'=>'OK',
                'message'=>$this->entity.' Object Schema',
                'data'=>$obj
            ];

            APIUtil::log( $url, $request->method() ,$request->toArray(), $resp, $this->auth );
        }catch (\Exception $exception){

        }

        return response()->json(
            [
                'result'=>'OK',
                'message'=>$this->entity.' Object Schema',
                'data'=>$obj
            ],
            200
        );
    }

    /**
     * Add new Member
     *
     * @queryParam app string App bundle Id to identify which application creates new member
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(Request $request)
    {
        $this->auth = $request->auth;

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        date_default_timezone_set( env('DEFAULT_TIME_ZONE', 'UTC'));

        $object = null;

        if($request->getContentType() == 'json'){

            $object = $request->getContent();

            if(is_string($object)){
                if($object = json_decode($object, true)){

                    if(!$this->preProcess($object)){
                        $retVal = array("result" => "ERR", "message" => $this->pre_process_error);
                        return response()->json($retVal, 415);
                    }

                }else{
                    $retVal = array("result" => "ERR", "message" => "Invalid JSON structure");
                    return response()->json($retVal, 415);
                }
            }
        }else{
            $retVal = array("result" => "ERR", "message" => "Request for create requires JSON content type in body");
            return response()->json($retVal, 415);
        }

        $this->entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiEntity('create');

        $entities = $this->entities;

        unset($entities['_id']);

        $validator = $this->prepareValidator($this->entities);

        if(env('SKIP_API_VALIDATION', true)){

        }else{
            $validate = Validator::make( $object , $validator );

            if($validate->fails()){
                //print_r($validate->getMessageBag()->toArray());
                $dt = $validate->getMessageBag()->toArray();
                $retVal = array("result" => "ERR", "message" => "Data validation failed","data"=>$dt);
                return response()->json($retVal, 415);

            }
        }

        $objectmodel = clone $this->model;

        $object = $this->beforeSave($object);

        if(isset($object['tz'])){
            if(str_starts_with($object['tz'], '+') || str_starts_with($object['tz'], '-') ){
                $ltz = CarbonTimeZone::create($object['tz']);
                $object['tz'] = $ltz->toRegionName(null, false);
            }
            date_default_timezone_set($object['tz']);
            $objectmodel->tz = $object['tz'];
        }else{
            $objectmodel->tz = date_default_timezone_get();
        }

        foreach($entities as $ek=>$ev ){
            $def = '';
            if($ev['type'] == 'int' || $ev['type'] == 'integer' ){
                $def = intval($ev['default']);
            }
            if($ev['type'] == 'double' ){
                $def = doubleval($ev['default']);
            }
            if($ev['type'] == 'float' ){
                $def = floatval($ev['default']);
            }

            if($ev['type'] == 'boolean' ){
                $def = boolval($ev['default']);
                $def = $def ? true : false;
            }

            try{
                if( isset($object[$ek]) ){
                    if($ev['nullable']){
                        $objectmodel->{$ek} = $object[$ek];
                        if($ev['type'] == 'datetime' || $ev['type'] == 'date' || $ev['type'] == 'time'){
                            $localDate = $object[$ek] ?? Carbon::now($object['tz']);
                            if(!is_null($localDate)){
                                $objectmodel->{$ek.'_local'} = [
                                    'datetime'=>Carbon::make($localDate)->toDateTimeString(),
                                    'tz'=>$object['tz']
                                ];
                                $dutc = Carbon::make($localDate)->setTimezone('UTC')->getPreciseTimestamp(3);
                                $objectmodel->{$ek.'_utc'} = new \MongoDB\BSON\UTCDateTime($dutc) ;
                            }
                        }
                    }else{
                        $objectmodel->{$ek} = $object[$ek] ?? $def;
                        if($ev['type'] == 'datetime' || $ev['type'] == 'date' || $ev['type'] == 'time'){
                            $localDate = $object[$ek] ?? Carbon::now($object['tz']);
                            if(!is_null($localDate)){
                                $objectmodel->{$ek.'_local'} = [
                                    'datetime'=>Carbon::make($localDate)->toDateTimeString(),
                                    'tz'=>$object['tz']
                                ];
                                $dutc = Carbon::make($localDate)->setTimezone('UTC')->getPreciseTimestamp(3);
                                $objectmodel->{$ek.'_utc'} = new \MongoDB\BSON\UTCDateTime($dutc) ;
                            }
                        }
                    }
                }else{
                    if($ev['nullable']){
                        $objectmodel->{$ek} = $def;
                    }else{
                        $objectmodel->{$ek} = $def ?? '';
                    }
                }
            }catch (\Exception $exception){
//                $retVal = array("result" => "ERR", "message" => 'PROCESS: '.$exception->getMessage());
//                return response()->json($retVal, 415);
            }
        }

        if(isset($objectmodel->handle) && $objectmodel->handle != ''){

        }else{
            $objectmodel->handle = Str::random(12);
        }

        $objectmodel->lastUpdate = Carbon::createFromTimestamp(time());
        $objectmodel->createdDate = Carbon::createFromTimestamp(time());

        if($request->auth){
            $owner = $request->auth;
            $objectmodel->ownerName = $owner->name;
            $objectmodel->ownerId = $owner->_id;
        }

        $retVal = [];
        $status = 404;


        try{
            $objectmodel->save();

            $objectmodel = $this->afterSave($objectmodel);

            $objectmodel = TimeUtil::createTime($objectmodel, $object['tz']);

            $objectmodel->extId = $objectmodel->_id;

            $objectmodel->domainNs = env('APP_NAMESPACE', '');

            $objectmodel->save();

            $dataArray = $objectmodel->toArray();

            $dataArray = $this->prepareOutput($dataArray, 'create');

            $dataArray['extId'] = $objectmodel->extId ;

            unset($dataArray['_id']);

            $retVal = array("result" => "OK", "message" => $this->entity." added" , 'data'=>$dataArray );

            $status = 200;
        }catch (\Exception $exception){
            $retVal = array("result" => "ERR", "message" => 'SAVE : '.$exception->getMessage() , 'data'=>false);
            $status = 417;
        }

        try{
            $url = Route::current()->uri();
            APIUtil::log( $url, $request->method() ,$request->toArray(), $retVal, $this->auth );
        }catch (\Exception $exception){

        }

        return response()->json($retVal, $status);
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBatch(Request $request)
    {
        //print $this->entity;
        $this->auth = $request->auth;

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        if(!$request->getContentType() == 'json'){
            $retVal = array("result" => "ERR", "message" => "Request for create requires JSON content type in body");
            return response()->json($retVal, 415);
        }

        $objectArray = $request->getContent();
        $objectArrayTest = json_decode($objectArray);

        if( !(gettype( $objectArrayTest ) == 'array') ){
            $retVal = array("result" => "ERR", "message" => "Expecting JSON array, JSON object detected");
            return response()->json($retVal, 415);
        }

        $objectArray = json_decode($objectArray, true);

        $entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiEntity('create');
        unset($entities['_id']);
        $retRes = [];
        $index = 0;
        $errCount = 0;
        foreach($objectArray as $object){

            $objectmodel = clone $this->model;

            foreach($entities as $ek=>$ev ){
                try{
                    if( isset($object[$ek]) ){
                        $objectmodel->{$ek} = $object[$ek];
                    }else{
                        $objectmodel->{$ek} = null;
                    }
                }catch (\Exception $exception){
                    $errCount++;
                    $retRes[] = [ 'index'=>$index, 'result'=>'ERR', 'message'=>$exception->getMessage(), 'data'=>$object ];
                }
            }


            if($request->auth){
                $owner = $request->auth;
                $objectmodel->ownerName = $owner->name;
                $objectmodel->ownerId = $owner->_id;
            }

            $objectmodel->handle = $objectmodel->handle ?? Str::random(12);
            $objectmodel->lastUpdate = Carbon::createFromTimestamp(time());
            $objectmodel->createdDate = Carbon::createFromTimestamp(time());
            $objectmodel = $this->beforeSave($objectmodel);

            try{
                $objectmodel->save();

                $now = Carbon::now()->toDateTimeString();

                $objectmodel = $this->afterSave($objectmodel);

                $objectmodel->createdAt = $now;
                $objectmodel->updatedAt = $now;
                $objectmodel->createdDate = $now;
                $objectmodel->lastUpdate = $now;

                $objectmodel->extId = $objectmodel->_id;

                $objectmodel->save();

                $dataArray = $objectmodel->toArray();
                unset($dataArray['_id']);
                unset($dataArray['raw_json']);

                $retRes[] = [ 'index'=>$index, 'result'=>'OK', 'message'=>$this->entity.' added', 'data'=>$dataArray ];
            }catch (\Exception $exception){
                $errCount++;
                $retRes[] = [ 'index'=>$index, 'result'=>'ERR', 'message'=>$exception->getMessage(), 'data'=>$objectmodel ];
            }

            $index++;
        }

        $retVal = [];
        $status = 404;
        if($errCount == count($objectArray)){
            $retVal = ['result'=>'ERR', 'message'=>'Failed to add '.Str::plural( $this->entity ) , 'data'=>$retRes];
            $status = 417;
        }
        if( $errCount > 0 && $errCount < count($objectArray) ){
            $retVal = ['result'=>'ERR', 'message'=>'Saving '.Str::plural( $this->entity ).' partially succesful' , 'data'=>$retRes];
            $status = 206;
        }
        if($errCount == 0 ){
            $retVal = ['result'=>'OK', 'message'=>'Success adding '.Str::plural( $this->entity ) , 'data'=>$retRes];
            $status = 200;
        }

        try{
            $url = Route::current()->uri();
            APIUtil::log( $url, $request->method() ,$request->toArray(), $retVal, $this->auth );
        }catch (\Exception $exception){

        }

        return response()->json($retVal, $status);

    }


    public function beforeUpdate($data)
    {
        return $data;
    }

    public function afterUpdate($data)
    {
        return $data;
    }


    /**
     * Update object data
     *
     * @method PUT
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUpdate($id,Request $request)
    {
        $this->auth = $request->auth;

        $appname = ($request->has('app'))?$request->input('app'):'app.name';
        $findBy = ($request->has('by'))?$request->input('by'):'_id';

        date_default_timezone_set( env('DEFAULT_TIME_ZONE', 'Asia/Jakarta'));

        $object = null;

        if($request->getContentType() == 'json'){
            $object = $request->getContent();
            if(is_string($object)){
                if($object = json_decode($object, true)){

                }else{
                    $retVal = array("result" => "ERR", "message" => "Invalid JSON structure");
                    return response()->json($retVal, 415);
                }
            }
        }else{
            $retVal = array("result" => "ERR", "message" => "Request for create requires JSON content type in body");
            return response()->json($retVal, 415);
        }

        $this->entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiEntity('all');

        $entities = $this->entities;

        unset($entities['_id']);

        $validator = $this->prepareValidator($entities);

        if(env('SKIP_API_VALIDATION', true)){

        }else{
            $validate = Validator::make( $object , $validator );

            if($validate->fails()){
                //print_r($validate->getMessageBag()->toArray());
                $dt = $validate->getMessageBag()->toArray();
                $retVal = array("result" => "ERR", "message" => "Data validation failed","data"=>$dt);
                return response()->json($retVal, 415);

            }
        }

        $objectmodel = $this->getObjectToUpdate($id, $this->model, $findBy);

        if($objectmodel == false || is_null($objectmodel) || empty($objectmodel) ){
            $retVal = array("result" => "ERR", "message" => $this->entity.' not found' );
            return response()->json($retVal, 200);
        }

        if(isset($object['tz'])){
            if(str_starts_with($object['tz'], '+') || str_starts_with($object['tz'], '-') ){
                $ltz = CarbonTimeZone::create($object['tz']);
                $object['tz'] = $ltz->toRegionName(null, false);
            }
            date_default_timezone_set($object['tz']);
            $objectmodel->tz = $object['tz'];
        }else{
            $object['tz'] = env('DEFAULT_TIME_ZONE','UTC');
            $objectmodel->tz = date_default_timezone_get();
        }

        $object = $this->beforeUpdate($object);

        foreach ($object as $ok=>$ov){
            if( isset($entities[$ok]) ){
                $ev = $entities[$ok];
                $objectmodel->{$ok} = $object[$ok];
                if($ev['type'] == 'datetime' || $ev['type'] == 'date' || $ev['type'] == 'time'){
                    $localDate = $object[$ok] ?? Carbon::now($object['tz']);
                    if(!is_null($localDate)){
                        $objectmodel->{$ok.'_local'} = [
                            'datetime'=>Carbon::make($localDate)->toDateTimeString(),
                            'tz'=>$object['tz']
                        ];
                        $dutc = Carbon::make($localDate)->setTimezone('UTC')->getPreciseTimestamp(3);
                        $objectmodel->{$ok.'_utc'} = new \MongoDB\BSON\UTCDateTime($dutc) ;
                    }
                }
            }
        }

        $objectmodel->lastUpdate = Carbon::createFromTimestamp(time());

        $retVal = [];
        $status = 404;

        try{
            $objectmodel->save();

            $objectmodel = $this->afterUpdate($objectmodel);

            $objectmodel = TimeUtil::updateTime($objectmodel, $object['tz']);

            $objectmodel->extId = $objectmodel->_id;

            $objectmodel->save();

            $dataArray = $objectmodel->toArray();

            $dataArray = $this->prepareOutput($dataArray, 'all');

            $dataArray['extId'] = $objectmodel->extId ;
            unset($dataArray['_id']);
            unset($dataArray['raw_json']);
            $retVal = array("result" => "OK", "message" => $this->entity." updated" , 'data'=>$dataArray );
            $status = 200;
        }catch (\Exception $exception){
            $retVal = array("result" => "ERR", "message" => 'Save: '.$exception->getMessage() , 'data'=>null);
            $status = 417;
        }

        try{
            $url = $request->route()->uri();
            APIUtil::log( $url, $request->method() ,$request->toArray(), $retVal , $this->auth);
        }catch (\Exception $exception){

        }

        return response()->json($retVal, $status);
    }

    /**
     * Update data query hook
     *
     * @param $id
     * @param $model
     * @return false
     *
     * Hook to get object using custom query
     * Default behavior is to get object by database _id using find() function
     *
     */
    public function getObjectToUpdate($id, $model, $findBy = 'id')
    {

        if($findBy == '_id' || $findBy == 'id' || $findBy == 'extId'  ){
            $object = $this->model->find($id);
        }else{
            $object = $this->model->where( $findBy, '=', $id)->first();
        }

        if( $object ){
            return $object;
        }else{
            return false;
        }
    }

    /**
     * Update data query hook
     *
     * @param $id
     * @param $model
     * @return false
     *
     * Hook to get object using custom query
     * Default behavior is to get object by database _id using find() function
     *
     */
    public function getObjectOrNew($id, $model, $findBy = 'id')
    {
        if($obj = $model->find($id)){
            return $obj;
        }else{
            $newObj = clone $model;
            unset($newObj->_id);
            return  $newObj;
        }
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putBatch(Request $request)
    {
        //print $this->entity;
        $appname = ($request->has('app'))?$request->input('app'):'app.name';
        $findBy = ($request->has('by'))?$request->input('by'):'_id';


        if(!$request->getContentType() == 'json'){
            $retVal = array("result" => "ERR", "message" => "Request for create requires JSON content type in body");
            return response()->json($retVal, 415);
        }

        $objectArray = $request->getContent();
        $objectArrayTest = json_decode($objectArray);

        if( !(gettype( $objectArrayTest ) == 'array') ){
            $retVal = array("result" => "ERR", "message" => "Expecting JSON array, JSON object detected");
            return response()->json($retVal, 415);
        }

        $objectArray = json_decode($objectArray, true);

        $entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiEntity('edit');
        unset($entities['_id']);
        $retRes = [];
        $index = 0;
        $errCount = 0;
        foreach($objectArray as $object){

            if(isset( $object['_id'] )){
                $objectmodel = $this->getObjectToUpdate( $object['_id'], $this->model, $findBy );
            }else{
                $objectmodel = clone $this->model;
            }

            foreach($entities as $ek=>$ev ){
                try{
                    $objectmodel->{$ek} = $object[$ek];
                }catch (\Exception $exception){
                    $errCount++;
                    $retRes[] = [ 'index'=>$index, 'result'=>'ERR', 'message'=>$exception->getMessage(), 'data'=>$object ];
                }
            }

            $objectmodel->handle = $objectmodel->handle ?? Str::random(12);
            $objectmodel->lastUpdate = Carbon::createFromTimestamp(time());
            if(!isset($objectmodel->_id)){
                $objectmodel->createdDate = Carbon::createFromTimestamp(time());
            }
            $objectmodel = $this->beforeSave($objectmodel);

            try{
                $objectmodel->save();

                $now = Carbon::now()->toDateTimeString();

                $objectmodel = $this->afterSave($objectmodel);

                $objectmodel->updatedAt = $now;
                $objectmodel->lastUpdate = $now;

                $objectmodel->extId = $objectmodel->_id;

                $objectmodel->save();

                $dataArray = $objectmodel->toArray();
                unset($dataArray['_id']);
                unset($dataArray['raw_json']);

                $retRes[] = [ 'index'=>$index, 'result'=>'OK', 'message'=>$this->entity.' added', 'data'=>$dataArray ];
            }catch (\Exception $exception){
                $errCount++;
                $retRes[] = [ 'index'=>$index, 'result'=>'ERR', 'message'=>$exception->getMessage(), 'data'=>$objectmodel ];
            }

            $index++;
        }

        $retVal = [];
        $status = 404;
        if($errCount == count($objectArray)){
            $retVal = ['result'=>'ERR', 'message'=>'Failed to upsert '.Str::plural( $this->entity ) , 'data'=>$retRes];
            $status = 417;
        }
        if( $errCount > 0 && $errCount < count($objectArray) ){
            $retVal = ['result'=>'ERR', 'message'=>'Saving '.Str::plural( $this->entity ).' partially succesful' , 'data'=>$retRes];
            $status = 206;
        }
        if($errCount == 0 ){
            $retVal = ['result'=>'OK', 'message'=>'Success upserting '.Str::plural( $this->entity ) , 'data'=>$retRes];
            $status = 200;
        }

        try{
            $url = Route::current()->uri();
            APIUtil::log( $url, $request->method() ,$request->toArray(), $retVal, $this->auth );
        }catch (\Exception $exception){

        }

        return response()->json($retVal, $status);

    }

    /**
     * Update object data
     *
     * @method PUT
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUpdateStatus($id,Request $request)
    {
        $this->auth = $request->auth;

        $appname = ($request->has('app'))?$request->input('app'):'app.name';
        $findBy = ($request->has('by'))?$request->input('by'):'_id';

        date_default_timezone_set( env('DEFAULT_TIME_ZONE', 'UTC'));

        $object = null;

        if($request->getContentType() == 'json'){
            $object = $request->getContent();
            if(is_string($object)){
                if($object = json_decode($object, true)){

                }else{
                    $retVal = array("result" => "ERR", "message" => "Invalid JSON structure");
                    return response()->json($retVal, 415);
                }
            }
        }else{
            $retVal = array("result" => "ERR", "message" => "Request for create requires JSON content type in body");
            return response()->json($retVal, 415);
        }

        $this->entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiEntity('all');

        $entities = $this->entities;

        unset($entities['_id']);

        $validator = $this->prepareValidator($entities);

        if(env('SKIP_API_VALIDATION', true)){

        }else{
            $validate = Validator::make( $object , $validator );

            if($validate->fails()){
                //print_r($validate->getMessageBag()->toArray());
                $dt = $validate->getMessageBag()->toArray();
                $retVal = array("result" => "ERR", "message" => "Data validation failed","data"=>$dt);
                return response()->json($retVal, 415);

            }
        }

        $objectmodel = $this->getObjectToUpdate($id, $this->model, $findBy);

        if($objectmodel == false || is_null($objectmodel) || empty($objectmodel) ){
            $retVal = array("result" => "ERR", "message" => $this->entity.' not found' );
            return response()->json($retVal, 200);
        }

        if(isset($object['tz'])){
            if(str_starts_with($object['tz'], '+') || str_starts_with($object['tz'], '-') ){
                $ltz = CarbonTimeZone::create($object['tz']);
                $object['tz'] = $ltz->toRegionName(null, false);
            }
            date_default_timezone_set($object['tz']);
            $objectmodel->tz = $object['tz'];
        }else{
            $object['tz'] = env('DEFAULT_TIME_ZONE','UTC');
            $objectmodel->tz = date_default_timezone_get();
        }

        $object = $this->beforeUpdate($object);

        foreach ($object as $ok=>$ov){
            if( isset($entities[$ok]) ){
                $ev = $entities[$ok];
                $objectmodel->{$ok} = $object[$ok];
                if($ev['type'] == 'datetime' || $ev['type'] == 'date' || $ev['type'] == 'time'){
                    $localDate = $object[$ok] ?? Carbon::now($object['tz']);
                    if(!is_null($localDate)){
                        $objectmodel->{$ok.'_local'} = [
                            'datetime'=>Carbon::make($localDate)->toDateTimeString(),
                            'tz'=>$object['tz']
                        ];
                        $dutc = Carbon::make($localDate)->setTimezone('UTC')->getPreciseTimestamp(3);
                        $objectmodel->{$ok.'_utc'} = new \MongoDB\BSON\UTCDateTime($dutc) ;
                    }
                }
            }
        }

        $objectmodel->lastUpdate = Carbon::createFromTimestamp(time());

        $retVal = [];
        $status = 404;

        try{
            $objectmodel->save();

            $objectmodel = $this->afterUpdate($objectmodel);

            $objectmodel = TimeUtil::updateTime($objectmodel, $object['tz']);

            $objectmodel->extId = $objectmodel->_id;

            $objectmodel->save();

            $dataArray = $objectmodel->toArray();
            $dataArray = $this->prepareOutput($dataArray, 'all');
            $dataArray['extId'] = $objectmodel->extId ;
            unset($dataArray['_id']);
            unset($dataArray['raw_json']);
            $retVal = array("result" => "OK", "message" => $this->entity." updated" , 'data'=>$dataArray );
            $status = 200;
        }catch (\Exception $exception){
            $retVal = array("result" => "ERR", "message" => 'Save: '.$exception->getMessage() , 'data'=>null);
            $status = 417;
        }

        try{
            $url = $request->route()->uri();
            APIUtil::log( $url, $request->method() ,$request->toArray(), $retVal , $this->auth);
        }catch (\Exception $exception){

        }

        return response()->json($retVal, $status);
    }


    /**
     * Display the specified member.
     *
     * @method GET
     * @urlParam id string required Database record ID / NIK / Mobile Number of specified Member
     * @authenticated
     *
     * @response status=200 scenario=success
     * {
     *       "result": "OK",
     *       "data": {
     *       "_id": "5fe9f3ca85ba2a77dc6af002",
     *       "name": "Joko Susilo",
     *       "email": "js@susi.com",
     *       "countryCode": "62",
     *       "mobile": "81254645564",
     *       "gender": "L",
     *       "nik": "3701285785785747847",
     *       "bpjs": "876543221",
     *       "address": "Karang Tengah",
     *       "lat": "-6.08687567865",
     *       "lng": "11.8678968",
     *       "city": "Jakarta Barat",
     *       "province": "DKI Jakarta",
     *       "zip": "11640",
     *       "handle": "8RKTbXxRqZzn",
     *       "pushId": "235342765484657896478",
     *       "lastUpdate": "2020-12-28T15:03:38.000000Z",
     *       "createdDate": "2020-12-28T15:03:38.000000Z",
     *       "roleId": "5a5ea1aca39f503e6f4c6716",
     *       "updated_at": "2020-12-28T15:03:38.258000Z",
     *       "created_at": "2020-12-28T15:03:38.258000Z"
     *       },
     *       "message": "Member found"
     *  }
     *
     * @response status=404 scenario="Member not found" {
     *      "result": "ERR,
     *      "message": "Member not found"
     * }
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
//        if($id == 'schema'){
//            $this->getSchema();
//        }

        $findBy = ($request->has('by'))?$request->input('by'):'_id';

        $model = $this->addFindObjectQuery($this->model, $request);

        if($findBy == '_id' || $findBy == 'id' || $findBy == 'extId'  ){
            $object = $this->model->find($id);
        }else{
            $object = $this->model->where( $findBy, '=', $id)->first();
        }

        $this->entities = APIUtil::loadResYaml($this->yml_file, $this->res_path)->toApiEntity('view');

        if($object){
            $object->extId = $object->_id;
            $extId = $object->_id;
            unset($object->raw_json);
            unset($object->_id);

            $object = $this->prepareOutput($object->toArray(), 'view');

            //$object['extId'] = $extId;

            $retVal = array("result" => "OK", 'data'=>$object,  "message" => $this->entity." found");

            try{
                $url = Route::current()->uri();
                APIUtil::log( $url, $request->method() ,$request->toArray(), $retVal, $this->auth );
            }catch (\Exception $exception){

            }

            return response()->json($retVal, 200);
        }else{
            $retVal = array("result" => "ERR", "message" => $this->entity." not found", 'data'=>null);

            try{
                $url = Route::current()->uri();
                APIUtil::log( $url, $request->method() ,$request->toArray(), $retVal, $this->auth );
            }catch (\Exception $exception){

            }

            return response()->json($retVal, 404);
        }

        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function underscoreToCamelCase( $string, $first_char_caps = false)
    {

        $strings = explode('_', $string);

        if(count($strings) > 1){
            for($i = 0; $i < count($strings);$i++){
                if($i == 0){
                    if($first_char_caps == true){
                        $strings[$i] = ucwords($strings[$i]);
                    }
                }else{
                    $strings[$i] = ucwords($strings[$i]);
                }
            }

            return implode('', $strings);
        }else{
            return $string;
        }

    }

    public function isExists($model , $field, $value)
    {
        $cnt = $model->where($field, '=', $value)->count();
        return $cnt > 0;
    }

    public function imageList($field,$val, $data ){

        $images = Uploaded::where($field,'=', $val )->get();

        $imagelist = $images->toArray();

        return $imagelist;

    }

    //Approval Functions
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

    public function approvalItemQuery($model , Request $request){

        return $model;
    }

    public function approvalItemTransform($items)
    {
        return $items;
    }

    public function postFetchApprovalItems(Request $request)
    {
        $model = $this->model;

        $model = $this->approvalItemQuery( $model , $request);

        if(empty($this->approval_item_fields)){
            $items = $model->get();
        }else{
            $items = $model->get($this->approval_item_fields);
        }
        if($items){
            $items = $this->approvalItemTransform($items->toArray());

            return response()->json( [
                'result'=>'OK',
                'data'=> $items,
                'message'=> count($items).' Items to Approve'
            ], 200 );
        }else{
            return response()->json( [
                'result'=>'ERR',
                'data'=> null,
                'message'=> 'Error finding items'
            ], 401 );
        }
    }

    public function getSpecimen($type = 'signature')
    {
        if( $type == 'signature'){
            return Auth::user()->signatureSpecimen ?? '';
        }else{
            return Auth::user()->initialSpecimen ?? '';
        }
    }

    public function processApprovalData($data, $request){

        return $data;
    }

    public function postApprovalCommit(Request $request, $data = null)
    {
        $this->auth = $request->auth;

        $in = $request->all();

        $item = $this->model->find( $request->get('extId') );
        if($item){
            $item = $item->toArray();
            $item['decideAs'] =
            $in['selectedApprovalItems'] = [ $item ];
        }else{
            $in['selectedApprovalItems'] = [];
        }
        //      "ns": "doc",
        //      "handle": "og2v5",
        //      "mode": "Create",
        //      "ts": 1665049246.016,
        //      "extraData": {},
        //      "auth": "103700",

        $data = $in;
        $auth = $request->get('pinAuth');
        $tz = $request->get('tz');


        //check PIN & login
        if($this->auth){
            if(!isset( $this->auth->pin)){
                return response()->json( [
                    'result'=>'ERR',
                    'data'=> null,
                    'message'=>'PIN not set'
                ], 200 );
            }

            //print $auth.' '.$this->auth->pin.' '.Hash::check($auth, $this->auth->pin);

            if( Hash::check($auth, $this->auth->pin) ){

                $logdata = $data ?? [];
                $logdata['doc'] = $data['doc'] ?? [];

                $logdata['postDoc'] = $this->processApprovalData($data ,$request);

                $logdata['decisionList'] = $logdata['postDoc']['decisionList'] ?? [];

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
                        'message'=>'Failed to Commit Decision'
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


}
