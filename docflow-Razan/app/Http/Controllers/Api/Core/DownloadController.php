<?php
namespace App\Http\Controllers\Api\Core;

use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\Uploaded;

use App\Helpers\Prefs;

use App\Models\Export\GenericExport;
use App\Models\Export\GenericTemplateExport;
use Carbon\Carbon;
use Config;

use Auth;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use View;
use Input;
use Image;
use Mongomodel;
use DB;
use HTML;
use Excel;
use Validator;

class DownloadController extends Controller {
    public $controller_name = '';
    public $apprealm = 'HALORIDES';

    public $userenv = 'MONGO';

    public $usermodel;

    public function  __construct()
    {
        $controller = (new \ReflectionClass($this))->getShortName();
        $this->controller_name = str_ireplace('controller', '',  $controller);
    }

    /**
     * @hideFromAPIDocumentation
     * @param $name
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getXls($name)
    {
        $headers = array(
            'Content-Type: application/vnd.ms-excel'
        );
        return Storage::disk('local')->download('exports/'.$name, $name, $headers);
    }

    /**
     * @hideFromAPIDocumentation
     * @param $name
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getCsv($name)
    {
        $headers = array(
            'Content-Type: text/csv'
        );
        return Storage::disk('local')->download('exports/'.$name, $name, $headers);
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFile(Request $request)
    {
        $key = ($request->has('key'))?$request->input('key'):'app.key';

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $handle = ($request->has('handle'))?$request->input('handle'):'handle';

        $ns = ($request->has('ns'))?$request->input('ns'):'handle';

        $type = ($request->has('t'))?$request->input('t'):'images';

        $mode = ($request->has('m'))?$request->input('m'):'single';

        $totalFiles = count($_FILES);

        $files = [];

        $urls = [];

        foreach($_FILES as $k=>$v){

            $v['name'] = Util::validChars($v['name']);

            $filepath = 'public/'.$type.'/'.$handle.'/'.$v['name'];

            $content = file_get_contents($v['tmp_name']);

            Storage::disk(env('STORAGE_DRIVER', 'local'))->put($filepath, $content );

            $url = Storage::disk(env('STORAGE_DRIVER', 'local'))->url( $filepath );

            $upts = Carbon::now();

            $base = ( env('STORAGE_DRIVER', 'local') == 'local')?url('/'):'';

            $meta = $v;

            $filetype = $this->getFileType($v['type']);

            $thumbnail = $this->getThumbnail( $filetype);

            $files[] = [
                'url'=> $url,
                'type'=>$type ,
                'filename'=>$v['name'],
                'thumbnail'=>'/'.$thumbnail,
                'filetype'=>$filetype,
                'isUploaded'=>1,
                'uploadedAt'=>$upts,
                'upTs'=>$upts->timestamp,
                'handle'=>$handle,
                'ns'=>$ns,
                'base'=>$base,
                'store'=> env('STORAGE_DRIVER', 'local'),
                'deleted'=> 0,
                'meta'=>$meta
            ];

            $urls[] = $url;
        }

        /*delete all previous files in single mode*/
        if($mode == 'single'){
            $dbf = Uploaded::where('handle','=', $handle )
                ->where('deleted','=',0)->get();
            foreach($dbf as $tb){
                $tb->deleted = 1;
                $tb->save();
            }
        }

        $uploaded = [];

        foreach($files as $f){
            $up = new Uploaded();

            foreach($f as $f=>$v){
                $up->{$f} = $v;
            }

            $up->save();
            $uploaded[] = $up->toArray();
        }

        if($mode == 'multi'){
            $dbf = Uploaded::where('handle','=', $handle )->where('ns','=', $ns)
                ->where('deleted','=',0)->orderBy('created_at', 'desc')
                ->get();
            $uploaded = [];
            foreach($dbf->toArray() as $fu){
                $fu['lock'] = false; // TODO : set file lock according to user access, all unlocked for now
                $uploaded[] = $fu;
            }
        }else{
            $dbf = Uploaded::where('handle','=', $handle )->where('ns','=', $ns)->where('deleted','=',0)->first();
            $uploaded = $dbf->toArray();
            $uploaded['lock'] = false; // TODO : set file lock according to user access, all unlocked for now
        }

        $result = array('status'=>'OK', 'timestamp'=>time(), 'mode'=>$mode ,'count'=>$totalFiles, 'upload'=>$uploaded ,'message'=>$files ) ;

        return response()->json($result);
    }

    public function postXlsTemplate(Request $request)
    {
        $heads = $request->get('headings');
        $items = $request->get('items');
        $includeData = $request->get('includeData');

        $fname =  'tmpl_'.date('d-m-Y-H-m-s',time()).'_';
        $fpath = 'exports/'.$fname;
        $limit = 100;
        $page = 1;

        $data = [];
        $headings = [];
        $row = [];
        foreach($heads as $key=>$lbl){
            if( is_int($key)){
                if( !in_array( $lbl ,config('util.template_exclude') ) ){
                    $headings[] = $lbl;
                    $row[$lbl] = '';
                }
            }else{
                if( !in_array( $key ,config('util.template_exclude') ) ){
                    $headings[] = $key;
                    $row[$key] = '';
                }
            }
        }
        if($includeData){
            $data = $items;
        }else{
            $data[] = $row; // data is single empty row
        }

        $eximp = \Maatwebsite\Excel\Facades\Excel::store(new GenerictemplateExport($data, $limit,$page, $headings), $fpath.'.xlsx','local',\Maatwebsite\Excel\Excel::XLSX);

        $export_xls = 'api/v1/core/export/xls/'.$fname.'.xlsx';

        $result = [
            'result'=>'OK',
            'message'=> 'Template exported',
            'data'=>[
                'filename'=>$fname,
                'urlxls'=>url($export_xls)
            ]
        ];

        return response()->json($result, 200);
    }

    public function postDel(Request $request)
    {
        $files = ($request->has('files'))?$request->input('files'):null;
        $handle = ($request->has('handle'))?$request->input('handle'):null;
        $mode = ($request->has('m'))?$request->input('m'):'single';
        $ns = ($request->has('ns'))?$request->input('ns'):'ns';

        //print_r($files);

        if(!is_null($files)){
//            if(is_array($files)){
//                $ids = [];
//                foreach($files as $f){
//                    $ids[] = $f['_id'];
//                }
//            }else{
                $ids[] = $files['_id'];
//            }
        }

        //print_r($ids);

        //$upf = Uploaded::whereIn('_id', $ids)->where('deleted','=',0)->get();
        $upf = Uploaded::find($files['_id']);
        if($upf){
            //foreach ($upf as $f){
                $upf->deleted = 1;
                $upf->save();
            //}
        }

        $count = 0;

        if($mode == 'multi'){
            $dbf = Uploaded::where('handle','=', $handle )->where('ns','=', $ns)->where('deleted','=', 0)->get();
            $uploaded = $dbf->toArray();
            $count = $dbf->count();
        }else{
            $dbf = Uploaded::where('handle','=', $handle )->where('ns','=', $ns)->where('deleted','=', 0)->first();
            if($dbf){
                $uploaded = $dbf->toArray();
                $count = 1;
            }else{
                $uploaded = new \ArrayObject();
                $count = 0;
            }
        }

        $result = array('status'=>'OK', 'timestamp'=>time(), 'mode'=>'single' ,'count'=>$count, 'upload'=>$uploaded ,'message'=>$files ) ;

        return response()->json($result);

    }

    public function postDrawing(Request $request)
    {
        $post = $request->all();

        $up = new Uploaded();
        $up->dump = $post;
        $up->save();

        return response()->json(
            [
                'status'=>'success',
                'message'=>'success',
                'code'=>0,
                'data'=>[
                    'message'=>'success',
                    'ok'=>true,
                    'status'=>'success'
                ]
            ]
        );

    }

    public function loadDrawing(){
        $pathToFile = public_path(env('DEFAULT_DRAW_IMAGE'));
        $mimetype = mime_content_type($pathToFile);


        $filecontent = file_get_contents($pathToFile);

        $imagedata = base64_encode($filecontent);

        $res = [
            'code'=>0,
            'data'=>[
                "action" => "load",
                "id" => "id123",
                "name" => "name123",
                "token" => "abc123",
                'imageData'=>$imagedata
            ],
            'message'=>'success',
            'status'=>'success'
        ];

//        ob_start();
//        header('Content-Type: '.$mimetype);
//        ob_end_clean();
//        $fp = fopen($pathToFile, 'rb');
//        fpassthru($fp);
//        exit;
//
//        $headers = ['Content-Type' => 'image/jpeg' ];
//        return response()->file($pathToFile, $headers);

        return response()->json($res);
    }

    private function getThumbnail($type , $file = null)
    {
        if($this->getFileType($type) == 'image'){
            return 'images/types/'.$type.'.png';
        }else{
            return 'images/types/'.$type.'.png';
        }
    }

    private function getFileType($type){
        if($this->isImage($type)){
            return 'image';
        }

        if($this->isAudio($type)){
            return 'audio';
        }

        if($this->isVideo($type)){
            return 'video';
        }

        if($this->isPdf($type)){
            return 'pdf';
        }

        return 'document';

    }

    private function isAudio($mime){
        return preg_match('/^audio/',$mime);
    }

    private function isVideo($mime){
        return preg_match('/^video/',$mime);
    }

    private function isImage($mime){
        return preg_match('/^image/',$mime);
    }

    private function isPdf($mime){
        return preg_match('/pdf/',$mime);
    }


}
