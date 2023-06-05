<?php
namespace App\Http\Controllers\Api\Core;

use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\Uploaded;

use App\Helpers\Prefs;

use App\Models\Workflow\ApprovalLog;
use App\Models\Workflow\ApprovalRequest;
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

/**
 * @group File Upload API
 *
 * APIs for uploading files
 */
class WorkflowController extends Controller {
    public $controller_name = '';

    public function  __construct()
    {
        //$this->model = "Member";
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );


    }

    public function postRequest(Request $request)
    {
        $data = $request->get('data');

        $requestData = $data['requestData'];
        $log = new ApprovalRequest();

        $log->doc = $data['doc'];
        $log->entity = $data['entity'];
        $log->requestObj = $requestData;

        $log->requesterId = $requestData['requesterId'];
        $log->requesterName = $requestData['requesterName'];
        $log->requestNote = $requestData['requestNote'];
        $log->requestApprovers = $requestData['requestApprovers'];
        $log->authorization = $requestData['authorization'];
        $log->authorizationSign = $requestData['authorizationSign'];
        $log->timestamp = time();

        if($log->save()){
            return response()->json([
                'result'=>'OK',
                'message'=>'Request submitted',
                'data'=>$log->toArray()
            ], 200);
        }else{
            return response()->json([
                'result'=>'ERR',
                'message'=>'Failed to submit request',
                'data'=>false
            ], 500);
        }


    }

    public function postCommit(Request $request)
    {
        $data = $request->get('data');

        $decision = $data['decisionData'];
        $log = new ApprovalLog();

        $log->doc = $data['doc'];
        $log->decisionObj = $decision;
        $log->entity = $data['entity'];


        $log->approverId = $decision['approverId'];
        $log->approverName = $decision['approverName'];
        $log->authorization = $decision['authorization'];
        $log->authorizationSign = $decision['authorizationSign'];
        $log->decision = $decision['decision'];
        $log->note = $decision['note'];
        $log->timestamp = time();

        if($log->save()){
            return response()->json([
                'result'=>'OK',
                'message'=>'Decision committed',
                'data'=>$log->toArray()
            ], 200);
        }else{
            return response()->json([
                'result'=>'ERR',
                'message'=>'Failed to commit decision',
                'data'=>false
            ], 500);
        }


    }

    /**
     * File upload endpoint
     * @queryParam t string File type ie : images
     * @queryParam m string Upload mode, single or multiple
     * @queryParam handle string File handle, used to connect db record with file.
     * if nohandle is false, handle will be used for the name of directory name containing the actual file.
     * @queryParam nohandle integer Denotes existence of handle information
     * @queryParam rawupload string
     * @bodyParam files file File to upload
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFile(Request $request)
    {
        $key = ($request->has('key'))?$request->input('key'):'app.key';

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $handle = ($request->has('handle'))?$request->input('handle'):'handle';

        $handle = ($handle=="handle")?Str::random(12):$handle;


        $ns = ($request->has('ns'))?$request->input('ns'):'handle';

        $type = ($request->has('t'))?$request->input('t'):'images';

        $mode = ($request->has('m'))?$request->input('m'):'single';

        $dir = ($request->has('dir'))?$request->input('dir'):false;

        $filename = ($request->has('filename'))?$request->input('filename'):false;

        $noHandle = $request->input('nohandle') ?? false;

        $noHandle = (is_bool($noHandle))? $noHandle : (  (is_string($noHandle) && $noHandle == 'true' ) ? true : false ) ;

        $rawUpload = $request->input('rawupload') ?? false;

        $rawUpload = (is_bool($rawUpload))? $rawUpload : ( (is_string($rawUpload) && $rawUpload == 'true' ) ? true : false );

        $totalFiles = count($_FILES);

        $files = [];

        $urls = [];

        foreach($_FILES as $k=>$v){

            $v['name'] = Util::validChars($v['name']);
            $filetype = $this->getFileType($v['type']);

            if($rawUpload){
                $dir = env('DOC_TEMP_ROOT', 'temp');
                $filename = $v['name'];
                $filepath = $dir.'/'.$filename;
            }else{
                if($noHandle){
                    $dir = env('DOC_UPLOAD_STORAGE_ROOT', 'public/documents');
                    $filepath = $dir.'/'.$filename.'.'.$filetype;
                    $filename = $filename.'.'.$filetype;
                    debug('fn2 '.$filename);
                }else{
                    $filename = $v['name'];
                    $filepath = 'public/'.$filetype.'/'.$handle.'/'.$filename;
                    debug('fn3 '.$filepath);
                }
            }

            $content = file_get_contents($v['tmp_name']);

            $res = Storage::disk(env('STORAGE_DRIVER', 'local'))
                ->put($filepath, $content );

            $url = Storage::disk(env('STORAGE_DRIVER', 'local'))->url( $filepath );

            $upts = Carbon::now();

            $base = ( env('STORAGE_DRIVER', 'local') == 'local')?url('/'):'';

            $meta = $v;


            $thumbnail = $this->getThumbnail( $filetype);

            $files[] = [
                'url'=> $url,
                'type'=>$type ,
                'filename'=>$filename,
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

        $result = [
                'result'=>'OK',
                'message'=>'Upload success',
                'data'=>[
                    'timestamp'=>time(),
                    'mode'=>$mode ,
                    'count'=>$totalFiles,
                    'upload'=>$uploaded ,
                    'files'=>$files
                ]
            ] ;

        return response()->json($result);
    }

    public function postFormFile(Request $request)
    {
        $handle = ($request->has('handle'))?$request->input('handle'):'handle';

        $handle = ($handle=="handle")?Str::random(12):$handle;

        $ns = ($request->has('ns'))?$request->input('ns'):'handle';

        $type = ($request->has('t'))?$request->input('t'):'images';

        $mode = ($request->has('m'))?$request->input('m'):'single';

        $dir = ($request->has('dir'))?$request->input('dir'):false;

        //$filename = ($request->has('filename'))? $request->input('filename'):$ns.time();
        $filename = $request->input('filename');

        $noHandle = $request->input('nohandle') ?? false;

        $noHandle = (is_bool($noHandle))? $noHandle : (  (is_string($noHandle) && $noHandle == 'true' ) ? true : false ) ;

        $rawUpload = $request->input('rawupload') ?? false;

        $rawUpload = (is_bool($rawUpload))? $rawUpload : ( (is_string($rawUpload) && $rawUpload == 'true' ) ? true : false );

        $totalFiles = 1;

        $enc_file = $request->input('file');

        if(strpos( $enc_file, 'base64' )){
            $enc_file = explode(';base64,', $enc_file);
            $file_type = $enc_file[0];
            $filetype = $this->getFileType($file_type);
            $file_content = base64_decode( $enc_file[1] );
        }

        $filename = $request->has('filename') && $request->has('filename')  != ''?  $request->input('filename'):$ns.time().$this->imageExt($file_type);

        if($rawUpload){
            $dir = env('DOC_TEMP_ROOT', 'temp');
            $filename = $filename;
            $filepath = $dir.'/'.$filename;
        }else{
            if($noHandle){
                $dir = env('DOC_UPLOAD_STORAGE_ROOT', 'public/documents');
                $filepath = $dir.'/'.$filename.'.'.$filetype;
                $filename = $filename.'.'.$filetype;
                debug('fn2 '.$filename);
            }else{
                $filename = $filename;
                $filepath = 'public/'.$filetype.'/'.$handle.'/'.$filename;
                debug('fn3 '.$filepath);
            }
        }
        $thumbnail = $this->getThumbnail( $file_type);

        $res = Storage::disk(env('STORAGE_DRIVER', 'local'))
            ->put($filepath, $file_content );

        $url = Storage::disk(env('STORAGE_DRIVER', 'local'))->url( $filepath );

        $upts = Carbon::now();

        $base = ( env('STORAGE_DRIVER', 'local') == 'local')?url('/'):'';

        $meta = null;

        $thumbnail = $this->getThumbnail( $filetype);

        /*delete all previous files in single mode*/
        if($mode == 'single'){
            $dbf = Uploaded::where('handle','=', $handle )
                ->where('deleted','=',0)->get();
            foreach($dbf as $tb){
                $tb->deleted = 1;
                $tb->save();
            }
        }

        $fs = new Uploaded();

        $fs->url =  $url;
        $fs->type = $type ;
        $fs->filename = $filename;
        $fs->thumbnail = '/'.$thumbnail;
        $fs->filetype = $filetype;
        $fs->isUploaded = 1;
        $fs->uploadedAt = $upts;
        $fs->upTs = $upts->timestamp;
        $fs->handle = $handle;
        $fs->ns = $ns;
        $fs->base = $base;
        $fs->store =  env('STORAGE_DRIVER', 'local');
        $fs->deleted =  0;
        $fs->meta = $meta ;

        $fs->save();

        $fso = $fs->toArray();

        unset($fso['raw_json']);

        $files = [ $fso ];

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

        $result = [
            'result'=>'OK',
            'message'=>'Upload success',
            'data'=>[
                'timestamp'=>time(),
                'mode'=>$mode ,
                'count'=>$totalFiles,
                'upload'=>$uploaded,
                'files'=>$files
            ]
        ] ;

        return response()->json($result);
    }

    public function postDel(Request $request)
    {
        $files = ($request->has('files'))?$request->input('files'):null;
        $handle = ($request->has('handle'))?$request->input('handle'):null;
        $mode = ($request->has('m'))?$request->input('m'):'single';
        $ns = ($request->has('ns'))?$request->input('ns'):'ns';

        if(!is_null($files)){
            $ids[] = $files['_id'];
        }

        $upf = Uploaded::find($files['_id']);

        if($upf){
            $upf->deleted = 1;
            $upf->save();
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

        $result = [
            'result'=>'OK',
            'message'=>'Delete file(s) success',
            'data'=>[
                'timestamp'=>time(),
                'mode'=>'single' ,
                'count'=>$count,
                'upload'=>$uploaded ,
                'files'=>$files
            ]
        ] ;

        return response()->json($result);

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

    private function imageExt($type)
    {
        if( preg_match('/png/i', $type) ){
            return '.png';
        }

        if( preg_match('/jpg/i', $type) ){
            return '.jpg';
        }

        if( preg_match('/jpeg/i', $type) ){
            return '.jpeg';
        }

        if( preg_match('/svg/i', $type) ){
            return '.svg';
        }

    }


}
