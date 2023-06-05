<?php
namespace App\Http\Controllers\Api\Core;

use App\Helpers\App\DmsUtil;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\Uploaded;

use App\Helpers\Prefs;

use Carbon\Carbon;
use Config;

use Auth;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MongoDB\BSON\ObjectId;
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
class UploadapiController extends Controller {
    public $controller_name = '';
    public $apprealm = 'HALORIDES';

    public $userenv = 'MONGO';

    public $usermodel;

    public function  __construct()
    {
        //$this->model = "Member";
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->apprealm = env('MENU_SET', 'HALORIDES');

        $this->userenv = env('USER_MODEL', 'MONGO');

        if( $this->userenv == 'SQL'){
            $this->usermodel = new \App\Models\Core\Mysql\User();
        }else{
            $this->usermodel = new \App\Models\Core\Mongo\User();
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
        Util::ajaxDebug();

        $fd = env('STORAGE_DRIVER') == 's3' ? 's3_' : '';

        $buckets = config('app.'.$fd.'buckets.names');

        $key = ($request->has('key'))?$request->input('key'):'app.key';

        $appname = ($request->has('app'))?$request->input('app'):'app.name';

        $handle = ($request->has('handle'))?$request->input('handle'):'handle';

        $handle = ($handle=="handle")?Str::random(12):$handle;

        $bucket = ($request->has('bucket'))?$request->input('bucket'):'docs';

        $ns = ($request->has('ns'))?$request->input('ns'):'handle';

        $type = ($request->has('t'))?$request->input('t'):'images';

        $mode = ($request->has('m'))?$request->input('m'):'single';

        $dir = ($request->has('dir'))?$request->input('dir'):false;

        $filename = ($request->has('filename'))?$request->input('filename'):false;

        $noHandle = $request->input('nohandle') ?? false;

        $noHandle = (is_bool($noHandle))? $noHandle : (  (is_string($noHandle) && $noHandle == 'true' ) ? true : false ) ;

        $qr = $request->input('qr') ?? false;

        $qr = (is_bool($qr))? $qr : (  (is_string($qr) && $qr == 'true' ) ? true : false ) ;

        $rawUpload = $request->input('rawupload') ?? false;

        $asArray = $request->input('ra') ?? false;

        $caption = $request->input('caption') ?? '';

        $rawUpload = (is_bool($rawUpload))? $rawUpload : ( (is_string($rawUpload) && $rawUpload == 'true' ) ? true : false );

        $totalFiles = count($_FILES);

        $files = [];

        $urls = [];

        foreach($_FILES as $k=>$v){

            $qr_string = $filename;
            $has_qr = false;
            $embed_result = null;

            $v['name'] = Util::validChars($v['name']);
            $filetype = $this->getFileType($v['type']);

            $storage_driver = env('STORAGE_DRIVER', 'local');

            if(isset($buckets[$bucket]) && ( $storage_driver == 'minio' || $storage_driver == 's3') ){
                $storage_driver = $buckets[$bucket];
            }

            $filepath = '';
            if($rawUpload){
                $dir = env('DOC_TEMP_ROOT', 'temp');
                $filename = $v['name'];
                $filepath = $filename;
                if($storage_driver == 'local'){
                    $filepath = $dir.'/'.$filename;
                }
            }else{
                if($noHandle){
                    $dir = env('DOC_UPLOAD_STORAGE_ROOT', 'public/documents');

                    $filepath = $filename.'.'.$filetype;
                    if($storage_driver == 'local'){
                        $filepath = $dir.'/'.$filename.'.'.$filetype;
                        $filename = $filename.'.'.$filetype;
                    }
                    debug('fn2 '.$filename);
                }else{
                    $filename = $v['name'];
                    $filepath = $handle.'/'.$filename;
                    if($storage_driver == 'local'){
                        $filepath = 'public/'.$filetype.'/'.$handle.'/'.$filename;
                    }
                }
            }

            $content = file_get_contents($v['tmp_name']);

            if($qr){
                try {
                    $in = storage_path('temp/in_'.$filename );
                    file_put_contents( $in, $content );
                    $out = storage_path('temp/out_'.$filename );

                    $eres = DmsUtil::embedQR($in, $out, $qr_string);

                    if($eres['status']){
                        $content = file_get_contents($out);
                        $has_qr = true;
                        unlink($out);
                    }
                    $embed_result = $eres;
                    unlink($in);
                }catch (Exception $exception){
                    debug($exception);
                }
            }

            $res = Storage::disk($storage_driver)
                ->put($filepath, $content );

            $url = Storage::disk( $storage_driver )->url( $filepath );

            $upts = Carbon::now();

            $base = ( $storage_driver == 'local')?url('/'):'';

            $meta = $v;

            $thumbnail = $this->getThumbnail( $filetype);

            $files[] = [
                'url'=> $url,
                'type'=>$type ,
                'filename'=>$filename,
                'filepath'=>$filepath,
                'caption'=>$caption,
                'thumbnail'=>'/'.$thumbnail,
                'filetype'=>$filetype,
                'isUploaded'=>1,
                'uploadedAt'=>$upts,
                'upTs'=>$upts->timestamp,
                'handle'=>$handle,
                'ns'=>$ns,
                'base'=>$base,
                'store'=> $storage_driver,
                'bucket'=> $bucket,
                'has_qr'=> $has_qr,
                'embed_result'=> $embed_result,
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

        $urls = [];
        $files = [];
        $uploaded = [];

        if($mode == 'multi'){
            $dbf = Uploaded::where('handle','=', $handle )
                ->where('ns','=', $ns)
                ->where('deleted','=',0)
                ->orderBy('created_at', 'desc')
                ->get();

            if($dbf && $handle != ''){
                $files = $dbf->toArray();

                foreach($dbf->toArray() as $fu){
                    $fu['lock'] = false; // TODO : set file lock according to user access, all unlocked for now
                    $uploaded[] = $fu;
                    if(isset($fu['url']) && isset($fu['base'])){
                        $urls[] = $fu['base'].$fu['url'] ;
                    }
                }
            }
        }else{
            $dbf = Uploaded::where('handle','=', $handle )
                ->where('ns','=', $ns)
                ->where('deleted','=',0)
                ->orderBy('created_at', 'desc')
                ->first();
            $uploaded = $dbf->toArray();
            $uploaded['lock'] = false; // TODO : set file lock according to user access, all unlocked for now

            if(isset($uploaded['url']) && isset($uploaded['base'])){
                if($asArray){
                    $urls[] = $uploaded['base'].$uploaded['url'] ;
                }else{
                    $urls = $uploaded['base'].$uploaded['url'] ;
                }
            }
        }

        $result = [
                'result'=>'OK',
                'message'=>'Upload success',
                'data'=>[
                    'timestamp'=>time(),
                    'mode'=>$mode ,
                    'count'=>$totalFiles,
                    'upload'=>$uploaded ,
                    'urls'=>$urls,
                    'files'=>$files
                ]
            ] ;

        return response()->json($result);
    }

    public function postFormFile(Request $request)
    {
        Util::ajaxDebug();

        $fd = env('STORAGE_DRIVER') == 's3' ? 's3_' : '';

        $buckets = config('app.'.$fd.'buckets.names');

        $handle = ($request->has('handle'))?$request->input('handle'):'handle';

        $handle = ($handle=="handle")?Str::random(12):$handle;

        $ns = ($request->has('ns'))?$request->input('ns'):'handle';

        $bucket = ($request->has('bucket'))?$request->input('bucket'):'docs';

        $type = ($request->has('t'))?$request->input('t'):'images';

        $mode = ($request->has('m'))?$request->input('m'):'single';

        $dir = ($request->has('dir'))?$request->input('dir'):false;

        //$filename = ($request->has('filename'))? $request->input('filename'):$ns.time();
        $filename = $request->input('filename');

        $noHandle = $request->input('nohandle') ?? false;

        $noHandle = (is_bool($noHandle))? $noHandle : (  (is_string($noHandle) && $noHandle == 'true' ) ? true : false ) ;

        $qr = $request->input('qr') ?? false;

        $qr = (is_bool($qr))? $qr : (  (is_string($qr) && $qr == 'true' ) ? true : false ) ;

        $rawUpload = $request->input('rawupload') ?? false;

        $rawUpload = (is_bool($rawUpload))? $rawUpload : ( (is_string($rawUpload) && $rawUpload == 'true' ) ? true : false );

        $asArray = $request->input('ra') ?? false;

        $caption = $request->input('caption') ?? '';

        $totalFiles = 1;

        $enc_file = $request->input('file');

        $urls = [];

        $has_qr = false;

        $embed_result = null;

        if(strpos( $enc_file, 'base64' )){
            $enc_file = explode(';base64,', $enc_file);
            $file_type = $enc_file[0];
            $filetype = $this->getFileType($file_type);
            $file_content = base64_decode( $enc_file[1] );
        }

        $filename = $request->has('filename') && $request->has('filename')  != ''?  $request->input('filename'):$ns.time().$this->imageExt($file_type);

        $storage_driver = env('STORAGE_DRIVER', 'local');

        if(isset($buckets[$bucket]) && ( $storage_driver == 'minio' || $storage_driver == 's3') ){
            $storage_driver = $buckets[$bucket];
        }

        $filepath = '';
        if($rawUpload){
            $dir = env('DOC_TEMP_ROOT', 'temp');
            $filename = $filename;
            $filepath = $filename;
            if($storage_driver == 'local'){
                $filepath = $dir.'/'.$filename;
            }
        }else{
            if($noHandle){
                $dir = env('DOC_UPLOAD_STORAGE_ROOT', 'public/documents');

                $filepath = $filename.'.'.$filetype;
                if($storage_driver == 'local'){
                    $filepath = $dir.'/'.$filename.'.'.$filetype;
                    $filename = $filename.'.'.$filetype;
                }
            }else{
                $filename = $filename;
                $filepath = $handle.'/'.$filename;
                if($storage_driver == 'local'){
                    $filepath = 'public/'.$filetype.'/'.$handle.'/'.$filename;
                }
            }
        }

        $thumbnail = $this->getThumbnail( $file_type);

        if($qr){
            try {
                $in = storage_path('temp/in_'.$filename );
                file_put_contents( $in, $file_content );
                $out = storage_path('temp/out_'.$filename );

                $eres = DmsUtil::embedQR($in, $out, $qr_string);
                if($eres['status']){
                    $file_content = file_get_contents($out);
                    $has_qr = true;
                    unlink($out);
                }
                $embed_result = $eres;
                unlink($in);
            }catch (Exception $exception){
                debug($exception);
            }
        }

        $res = Storage::disk($storage_driver)
            ->put($filepath, $file_content );

        $url = Storage::disk($storage_driver)->url( $filepath );

        $upts = Carbon::now();

        $base = ( $storage_driver == 'local')?url('/'):'';

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
        $fs->filepath = $filepath;
        $fs->caption = $caption;
        $fs->thumbnail = '/'.$thumbnail;
        $fs->filetype = $filetype;
        $fs->isUploaded = 1;
        $fs->uploadedAt = $upts;
        $fs->upTs = $upts->timestamp;
        $fs->handle = $handle;
        $fs->ns = $ns;
        $fs->base = $base;
        $fs->store =  $storage_driver;
        $fs->bucket = $bucket;
        $fs->has_qr = $has_qr;
        $fs->embed_result = $embed_result;
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
                if(isset($fu['url']) && isset($fu['base'])){
                    $urls[] = $fu['base'].$fu['url'] ;
                }
            }
        }else{
            $dbf = Uploaded::where('handle','=', $handle )->where('ns','=', $ns)->where('deleted','=',0)->first();
            $uploaded = $dbf->toArray();
            $uploaded['lock'] = false; // TODO : set file lock according to user access, all unlocked for now

            if(isset($uploaded['url']) && isset($uploaded['base'])){
                if($asArray){
                    $urls[] = $uploaded['base'].$uploaded['url'] ;
                }else{
                    $urls = $uploaded['base'].$uploaded['url'] ;
                }
            }

        }

        $result = [
            'result'=>'OK',
            'message'=>'Upload success',
            'data'=>[
                'timestamp'=>time(),
                'mode'=>$mode ,
                'count'=>$totalFiles,
                'upload'=>$uploaded,
                'files'=>$urls
                //'files'=>$files
            ]
        ] ;

        return response()->json($result);
    }

    public function postCaption(Request $request)
    {
        $file = ($request->has('fileObject'))?$request->input('fileObject'):null;
        $files = ($request->has('fileObjects'))?$request->input('fileObjects'):null;
        $mode = ($request->has('m'))?$request->input('m'):'single';

        $handle = ( !is_null( $file ) && isset($file['handle']) )?$file['handle']:null;
        $ns = ( !is_null( $file ) && isset($file['ns']) )?$file['ns']:null;

        if(!is_null($files)){
            foreach ($files as $fx){
                $obj = Uploaded::find($fx['_id']);
                if($obj){
                    $obj->caption = $fx['caption'];
                    $obj->save();
                }
            }
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
            'message'=>'File update success',
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
        return preg_match('/pdf/i',$mime);
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
