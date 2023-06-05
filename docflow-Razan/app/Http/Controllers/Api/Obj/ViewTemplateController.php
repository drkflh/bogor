<?php
/**
 * Created by Andy Awidarto.
 * User: awidarto
 * Date: 12/12/17
 * Time: 10:11 AM
 */
namespace App\Http\Controllers\Api\Obj;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Obj\ViewTemplate;
use App\Models\Core\Mongo\Uploaded;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ViewTemplateController extends Controller

{

    public $controller_name = '';

    public $model;

    public $sql_connection;

    public $sql_table_name;

    public $def_order_by = 'created_at';
    public $def_order_dir = 'desc';
    public $sql_key = 'NoLelang';

    public $order_unset = [];


    public function  __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new ViewTemplate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex(Request $request)
    {
        if($request->has('p')){
            $page = $request->input('p');
        }else{
            $page = null;
        }

        $key = $request->input('key');

        $start = ( $request->has('date') )?$request->input('date'): null;
        $until = ( $request->has('until') )?$request->input('until'): null;

        if(is_null($start)){
            $start = Carbon::now()->startOfDay();
        }else{
            $st = new Carbon($start);
            $start = $st->startOfDay();
        }

        if(is_null($until)){
            if(is_null($start)){
                $until = Carbon::now()->endOfDay();
            }else{
                $ut = new Carbon($start);
                $until = $ut->endOfDay();
            }
        }else{
            $ut = new Carbon($until);
            $until = $ut->endOfDay();
        }

        $page_size = config('util.api_page_size');

        $model = new ViewTemplate();

        //$model = $model->whereBetween('created_at', [ $start, $until ]  )
        //            ->orderBy('created_at','desc');


        $this->def_order_by = 'created_at';
        $this->def_order_dir = 'desc';

        $total_records = $model->count();

        $total_page = ceil( $total_records / $page_size);

        if(is_null($page)){
            $orders = $model->get();
        }else{
            $orders = $model->skip( ($page - 1) * $page_size )->take($page_size)->get();
        }

        $total_billing = 0;
        $total_delivery = 0;
        $total_cod = 0;

        $norders = array();

        for($n = 0; $n < count($orders);$n++){
            $or = new \stdClass();

            foreach( $orders[$n]->toArray() as $k=>$v ){
                $nk = $this->underscoreToCamelCase($k);
                if(in_array($nk, $this->order_unset)){

                }else{
                    if(!preg_match('/^editor./', $k)){
                        $or->{$nk} = (is_null($v))?'':$v;
                    }
                }
            }

            $or->extId = $or->Id;

            unset($or->Id);
            unset($or->id);

            $orders[$n] = $or;

        }


        $headers = array('X-Page' => $page, 'X-Total-Pages'=> $total_page, 'X-Total-Records'=>$total_records );

        return response()->json(
            $orders,
            200,
            $headers
        );
    }

    public function postAdd(Request $request)
    {
        $report = $request->input();

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $reportmodel = clone $this->model;

        $idPicId = null;

        foreach ($report as $k=>$v){
            $reportmodel->{$k} = $v;
        }

        if(isset($reportmodel->handle) && $reportmodel->handle != ''){

        }else{
            $reportmodel->handle = Str::random(12);
        }

        $reportmodel->lastUpdate = Carbon::createFromTimestamp(time());
        $reportmodel->createdDate = Carbon::createFromTimestamp(time());

        $retVal = array("status" => "ERR", "message" => "Nothing To Do");

        try{
            $reportmodel->save();
            $retVal = array("status" => "OK", "message" => "Report added");
        }catch (\Exception $exception){
            $retVal = array("status" => "ERR", "message" => $exception->getMessage());
        }

        return response()->json($retVal);
    }

    public function postBatch(Request $request)
    {

        $key = $request->input('key');

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $json = $request->input();

        $batch = $request->input('batch');

        $result = array();

        foreach( $json as $j){

            if(is_array($j)){

                $exp = ViewTemplate::where('extId','=', $j['extId'] )->first();

                if($exp){

                }else{
                    $exp = new Report();
                }

                foreach ($j as $k=>$v) {
                    $exp->{$k} = $v;
                }

                $exp->appname = $appname;
                $exp->mtimestamp = time();
                $exp->uploaded = 1;

                $r = $exp->save();

                if( $r ){
                    $result[] = array('status'=>'OK', 'timestamp'=>time(), 'message'=>$j['extId'] );
                }else{
                    $result[] = array('status'=>'NOK', 'timestamp'=>time(), 'message'=>'insertion failed' );
                }


            }


        }

        return response()->json($result);
    }


    public function putUpdate($id, Request $request)
    {

        $key = $request->input('key');

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $json = $request->input();

        $result = array();

        $j = $json;

        if(is_array($j)){

            $exp = ViewTemplate::where('extId','=', $id )->first();



            if($exp){
                //$exp = new ViewTemplate();

                foreach ($j as $k=>$v) {
                    $exp->{$k} = $v;
                }

                $exp->updated_at = Carbon::createFromTimestamp(time());
                $exp->lastUpdate = Carbon::createFromTimestamp(time());

                $r = $exp->save();

                if( $r ){
                    $result = array('status'=>'OK', 'timestamp'=>time(), 'message'=>$j['extId'] );
                }else{
                    $result = array('status'=>'NOK', 'timestamp'=>time(), 'message'=>'insertion failed' );
                }

            }else{

                $result = array('status'=>'NOK', 'timestamp'=>time(), 'message'=>'object not found' );

            }


        }

        return response()->json($result);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        $in = $request->input();
        if(isset($in['key']) && $in['key'] != ''){
            print $in['key'];
        }else{
            print 'no key';
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

    public function imageList($field,$val, $data ){

        $images = Uploaded::where($field,'=', $val )->get();

        $imagelist = $images->toArray();

        return $imagelist;

    }

}
