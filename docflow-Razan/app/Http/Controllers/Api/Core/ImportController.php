<?php
namespace App\Http\Controllers\Api\Core;

use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\Uploaded;

use App\Helpers\Prefs;

use App\Models\Imports\GenericImport;
use App\Models\Imports\GenericMultiSheetImport;
use App\Models\Imports\Importsession;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Config;

use Auth;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\HeadingRowImport;
use Spatie\SimpleExcel\SimpleExcelReader;
use View;
use Input;
use Image;
use Mongomodel;
use DB;
use HTML;
use Excel;
use Validator;

class ImportController extends Controller {
    public $controller_name = '';
    public $apprealm = 'HALORIDES';

    public $userenv = 'MONGO';

    public $usermodel;

    public function  __construct()
    {
        //$this->model = "Member";
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );

    }

    /**
     * @hideFromAPIDocumentation
     * import excel subsystem
     * upload form endpoint & processor
     * imported files decoded and stored in import temp collection
     * with unique upload session
     * */

    public function postUploadImport(Request $request)
    {
        set_time_limit(0);

        ini_set('memory_limit','2048M');

        date_default_timezone_set('Asia/Jakarta');

        $file = $request->file('inputfile');

        $import_back_url = $request->input('controller');

        $headindex = $request->input('headindex');

        $firstdata = $request->input('firstdata');

        $datalimit = $request->input('limitdata');

        $importkey = (!is_null($this->importkey))?$request->input('importkey'):$this->importkey;

        $aux_form_data = $this->processImportAuxForm();

        $rstring = str_random(15);

        $destinationPath = realpath('storage/upload').'/'.$rstring;

        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $filename = str_replace(config('kickstart.invalidchars'), '-', $filename);

        $uploadSuccess = $file->move($destinationPath, $filename);

        $fileitems = array();

        if($uploadSuccess){

            $xlsfile = realpath('storage/upload').'/'.$rstring.'/'.$filename;

            $headings = (new HeadingRowImport($headindex) )->toArray($xlsfile);

            $xarray = Excel::toArray( new GenericImport($this->heads, $rstring, $headindex ), $xlsfile );

            foreach($xarray as $sheet=>$data){

                $sessobj = new Importsession();
                $sessobj->heads = $headings[$sheet][0];
                $sessobj->sheet = $sheet;
                $sessobj->isHead = 1;
                $sessobj->sessId = $rstring;
                $sessobj->save();

                foreach ($data as $row){

                    $sessobj = new Importsession();

                    $emptycheck = [];

                    foreach ($row as $k=>$v){
                        $sessobj->{ $k } = $this->prepImportItem($k,$v);
                        $emptycheck[] = $v;
                    }

                    if( empty( $emptycheck ) ){

                    }else{

                        if(count($aux_form_data) > 0){
                            foreach($aux_form_data as $ak=>$av){

                                if(trim($ak) != ''){
                                    $sessobj->{ $ak } = $this->prepImportItem($ak,$av);
                                    $rowtemp[$ak] = $av;
                                }
                            }
                        }

                        $sessobj->sheet = $sheet;
                        $sessobj->isHead = 0;
                        $sessobj->sessId = $rstring;

                        $sessobj->save();

                    }

                    $emptycheck = [];

                }



            }


            return response()->json(['result'=>'OK', 'importid'=>$importid ]);

        }

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSource(Request $request)
    {
        $limit = $request->get('perPage');
        $page = $request->get('page');

        $importid = $request->get('importid');
        if($importid == ''){
            $importid = '1234567890';
        }

        debug($importid);

        if($page == 'all'){
            $res = Importsession::where('importid', '=', $importid)
                ->orderBy('created_at','desc')
                ->get();

            $pageCount = $res->count();

            $result = $res->toArray();

            foreach ($result as $r){
                unset($r['_id']);
                unset($r['created_at']);
                unset($r['updated_at']);
                unset($r['importid']);
                $data[] = $r;
            }

        }else{
            $page = $page - 1;
            $skip = $page * $limit;
            $res = Importsession::where('importid', '=', $importid)
                ->orderBy('created_at','desc')
                ->skip($skip)
                ->take($limit)
                ->get();
            $pageCount = $res->count();

            $data = $res->toArray();

        }


        return response()->json([
                'result'=>'OK',
                'data'=> $data,
                'count'=>$pageCount,
                'total'=>count($data)
            ]
        );
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpload(Request $request)
    {
        $key = ($request->has('key'))?$request->input('key'):'app.key';

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $handle = ($request->has('handle'))?$request->input('handle'):'handle';

        $ns = ($request->has('ns'))?$request->input('ns'):'handle';

        $mode = ($request->has('m'))?$request->input('m'):'single';

        $aux = ($request->has('aux'))?$request->input('aux'): false;

        $aux = json_decode($aux, true);

        $auxOverrides = ($request->has('auxOverrides'))?$request->input('auxOverrides'): [];

        if(is_string($auxOverrides)){
            $auxOverrides = explode(',', $auxOverrides);
        }

        $importid = ($request->has('importid'))?$request->input('importid'):'importid';

        $headindex = 1;

        //TODO : change import using box / spatie
        $filename = $request->get('filename');
        //?? Util::alphaNumericRandom(12).'.xlsx';

        $filepath = 'imports';

        $file_content = request()->file('file');

        //$storage_driver = env('STORAGE_DRIVER', 'local');
        $storage_driver = 'local';

//        $res = Storage::disk($storage_driver)
//            ->put($filepath, $file_content );

        $path = Storage::disk($storage_driver)->putFileAs($filepath, $file_content, $filename );

        //dd(storage_path('app/'.$path) );

        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->setShouldFormatDates(true);
        $reader->open( storage_path('app/'.$path) );
        foreach ($reader->getSheetIterator() as $sheet) {
            // only read data from 3rd sheet
            foreach ($sheet->getRowIterator() as $row) {
                $cellValues = array_map(function($cell) {
                    return $cell->getValue();
                }, $row->getCells());
                //print_r($cellValues);
                // do something with the row
            }
        }

        $reader->close();
        //END TODO : change import using box / spatie

        //$url = Storage::disk($storage_driver)->url( $filepath );

        $xarray = Excel::import( new GenericImport($importid,  $headindex,'insert', '_id', $aux, $auxOverrides ), request()->file('file') );

        $upts = Carbon::now();

        $result = array('status'=>'OK', 'timestamp'=>time(), 'importid'=>$importid ,'mode'=>$mode ) ;

        return response()->json($result);
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function postUploadMultiSheet(Request $request)
    {

        $filename = ($request->has('filename'))?$request->input('filename'):'filename.xlsx';

        $mode = ($request->has('m'))?$request->input('m'):'single';

        $importid = ($request->has('importid'))?$request->input('importid'):'importid';

        $headindex = 1;

        $rstring = Util::randomstring(8, 'alpha');

        $filename = str_replace(' ', '_', $filename);

        $file_path = 'uploads/'.$rstring.'/'.$filename;

        $file_content = request()->file('file')->getContent();

        debug($file_content);

        $res = Storage::disk(env('STORAGE_DRIVER', 'local'))
            ->put($file_path, $file_content );

        if( $res ){

            debug( 'public '.public_path($file_path) );
            debug( 'storage '.storage_path('app/'.$file_path) );

            $xpath = storage_path('app/'.$file_path);

            $rows = SimpleExcelReader::create( $xpath )->getRows();

            //$reader = SimpleExcelReader::create( $xpath )->getReader();

            $reader = ReaderEntityFactory::createReaderFromFile($xpath);

            $reader->open($xpath);

            foreach ($reader->getSheetIterator() as $sheet) {
                debug( 'sheet', $sheet->getName() );
                foreach ($sheet->getRowIterator() as $row) {
                    // do stuff with the row
                    debug( 'row', $row );
                    foreach ($row->getCells() as $cell){
                        debug( 'val', $cell->getValue() );
                    }

                }
            }


            $rows->each(function(array $rowProperties) {
                info( 'excelrows',$rowProperties );
                // in the first pass $rowProperties will contain
                // ['email' => 'john@example.com', 'first_name' => 'john']
            });

        }

        $xarray = Excel::import( new GenericMultiSheetImport($importid,  $headindex ), request()->file('file') );

        debug($xarray);

        $upts = Carbon::now();

        $result = array('status'=>'OK', 'timestamp'=>time(), 'importid'=>$importid ,'mode'=>$mode ) ;

        return response()->json($result);
    }


    public function postLoadData(Request $request)
    {

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
