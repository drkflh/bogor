<?php


namespace App\Helpers\App;


use App\Models\Dms\Doc;
use App\Models\Core\Mongo\Uploaded;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FileUtil
{
    protected $sourceDir = '';

    protected $mode = 'copy';

    public function scanDir($dir, $mode = 'copy')
    {
        $this->sourcedir = $dir;

        $this->mode = $mode ?? 'copy';

        $path = realpath($this->sourcedir);

        if($path && is_dir($path)){

            $files = array_diff(scandir($path), array('.', '..'));

            $filecount = count($files);

            $chunk = 100;

            $loopcnt = ceil($filecount/$chunk);


            for($i = 0; $i < $loopcnt; $i++){
                $offset = $i * $chunk;
                $offchunk = $offset + $chunk;

                for($j = $offset ; $j < $offchunk ; $j++ ){
                    if(isset($files[$j])){
                        if(!is_dir($files[$j])){
                            $callcode = str_replace('.pdf', '', $files[$j]);
                            $this->linkFile($callcode, $files[$j], $path , $this->mode);
                        }
                    }
                }
            }

        }
    }

    public function linkFile($callcode, $file, $srcpath, $mode ){

        $doc = Doc::where('FCallCode','=', $callcode)->first();

        if($doc){
            $m = $this->moveFile($callcode, $file, $srcpath, $mode);
            $doc->FileUrl = $m['FileUrl'];
            $doc->DocBase = $m['DocBase'];
            $doc->DocPath = $m['DocPath'];
            $doc->save();
            return true;
        }else{
            return false;
        }
    }

    public function linkCloudFile($callcode, $srcBucket, $src, $destBucket, $dest, $addQR = false ){

        $doc = Doc::where('FCallCode','=', $callcode)->first();

        if($doc){
            $m = $this->moveCloudFile($callcode, $srcBucket, $src, $destBucket, $dest, $addQR);
            $doc->FileUrl = $m['FileUrl'];
            $doc->DocBase = $m['DocBase'];
            $doc->DocPath = $m['DocPath'];
            $doc->save();
            return [
                'url' => $m['FileUrl'],
                'base' => $m['DocBase'],
                'filepath' => $m['DocPath']
            ];
        }else{
            return false;
        }
    }

    public function moveCloudFile($callcode, $srcBucket, $src, $destBucket, $dest, $addQR)
    {
        $fd = env('STORAGE_DRIVER') == 's3' ? 's3_' : '';

        $buckets = config('app.'.$fd.'buckets.names');

        $source_driver = $buckets[$srcBucket];
        $dest_driver = $buckets[$destBucket];

        $source = Storage::disk($source_driver)
            ->get($src);

        $has_qr = false;
        $embed_result = null;

        if($addQR){
            $file_content = $source;
            $filename = $callcode;
            $qr_string = $callcode;
            try {
                $in = storage_path('temp/in_'.$filename );
                file_put_contents( $in, $file_content );
                $out = storage_path('temp/out_'.$filename );

                $eres = DmsUtil::embedQR($in, $out, $qr_string);

                if($eres['status']){
                    $source = file_get_contents($out);
                    $has_qr = true;
                    unlink($out);
                }
                $embed_result = $eres;
                unlink($in);
            }catch (Exception $exception){
                debug($exception);
            }
        }

        $destination = Storage::disk($dest_driver)
            ->put($dest, $source );

        $srcUrl = Storage::disk( $source_driver )->url( $src );

        $url = Storage::disk( $dest_driver )->url( $dest );
        $filepath =  Storage::disk( $dest_driver )->path( $dest );
        $filename = $dest;
        $filetype = 'pdf' ;
        $thumbnail = $this->getThumbnail( $filetype);
        $upts = Carbon::now();
        $base = ( env('STORAGE_DRIVER', 'local') == 'local')?url('/'):'';

        $up = Uploaded::where('handle','=', $callcode)->first();

        if($up){
            //uploaded record already existed
            $up->url =  $url;
            $up->has_qr = $has_qr;
            $up->embed_result = $embed_result;
            $up->save();
        }else{
            $up = new Uploaded();

            $ns = 'document';

            $meta = new \ArrayObject();

            $up->url =  $url;
            $up->type = $filetype ;
            $up->filename = $filename;
            $up->filepath = $filepath;
            $up->thumbnail = $thumbnail;
            $up->filetype = $filetype;
            $up->isUploaded = 1;
            $up->has_qr = $has_qr;
            $up->embed_result = $embed_result;
            $up->uploadedAt = $upts;
            $up->upTs = $upts->timestamp;
            $up->handle = $callcode;
            $up->ns = $ns;
            $up->base = $base;
            $up->store =  env('STORAGE_DRIVER', 'local');
            $up->deleted = 0;
            $up->meta = $meta;
            $up->bucket = $destBucket;
            $up->save();
        }

        $fileObject = $up->toArray() ?? [];

        Storage::disk( $source_driver )->delete($src);

        return [
            'FileUrl'=>$url,
            'DocBase'=>$base,
            'DocPath'=>$filepath,
            'SrcUrl'=>$srcUrl,
            'SrcPath'=>$src,
            'FileObject'=>$fileObject
        ];
    }

    public function embedQRCloudFile($callcode, $srcBucket, $src, $destBucket, $dest, $addQR)
    {
        $buckets = config('app.buckets.names');
        $source_driver = $buckets[$srcBucket];
        $dest_driver = $buckets[$destBucket];

        $source = Storage::disk($source_driver)
            ->get($src);

        $has_qr = false;
        $embed_result = null;

        $file_content = $source;
        $filename = $callcode;
        $qr_string = $callcode;
        try {
            $in = storage_path('temp/in_'.$filename );
            file_put_contents( $in, $file_content );
            $out = storage_path('temp/out_'.$filename );
            $eres = DmsUtil::embedQR($in, $out, $qr_string);

            if($eres['status']){
                $source = file_get_contents($out);
                $has_qr = true;
                unlink($out);
            }

            $embed_result = $eres;

            unlink($in);
        }catch (Exception $exception){
            debug($exception);
        }

        $destination = Storage::disk($dest_driver)
            ->put($dest, $source );

        $srcUrl = Storage::disk( $source_driver )->url( $src );

        $url = Storage::disk( $dest_driver )->url( $dest );
        $filepath =  Storage::disk( $dest_driver )->path( $dest );
        $filename = $dest;
        $filetype = 'pdf' ;
        $thumbnail = $this->getThumbnail( $filetype);
        $upts = Carbon::now();
        $base = ( env('STORAGE_DRIVER', 'local') == 'local')?url('/'):'';

        $up = Uploaded::where('handle','=', $callcode)->first();

        if($up){
            //uploaded record already existed
            $up->has_qr = $has_qr;
            $up->embed_result = $embed_result;
            $up->save();
        }else{
            $up = new Uploaded();

            $ns = 'document';

            $meta = new \ArrayObject();

            $up->url =  $url;
            $up->type = $filetype ;
            $up->filename = $filename;
            $up->filepath = $filepath;
            $up->thumbnail = $thumbnail;
            $up->filetype = $filetype;
            $up->isUploaded = 1;
            $up->has_qr = $has_qr;
            $up->embed_result = $embed_result;
            $up->uploadedAt = $upts;
            $up->upTs = $upts->timestamp;
            $up->handle = $callcode;
            $up->ns = $ns;
            $up->base = $base;
            $up->store =  env('STORAGE_DRIVER', 'local');
            $up->deleted = 0;
            $up->meta = $meta;
            $up->bucket = $destBucket;
            $up->save();
        }

        $fileObject = $up->toArray() ?? [];

        return [
            'FileUrl'=>$url,
            'DocBase'=>$base,
            'DocPath'=>$filepath,
            'SrcUrl'=>$srcUrl,
            'SrcPath'=>$src,
            'FileObject'=>$fileObject
        ];
    }

    protected function moveFile( $callcode, $filename , $srcpath, $mode ){
//        "FileUrl" : "http://127.0.0.1:8000/storage/documents/F-BK-05-03-C217059-0820-01.pdf",
//        "DocBase" : "http://127.0.0.1:8000",
//        "DocPath" : "/storage/documents/F-BK-05-03-C217059-0820-01.pdf",

        $dir = env('DOC_STORAGE_ROOT', 'documents');

        $fname = $callcode.'.pdf';

        $docpath = $dir.'/'.$fname;

        $filepath = 'public/'.$dir.'/'.$fname;

        $content = file_get_contents( $srcpath.'/'.$filename );

        $res = Storage::disk(env('STORAGE_DRIVER', 'local'))->put($filepath, $content );

        $url = Storage::disk( env('STORAGE_DRIVER', 'local') )->url( $filepath );

        $upts = Carbon::now();

        $base = ( env('STORAGE_DRIVER', 'local') == 'local')?url('/'):'';

        $filetype = 'pdf' ;

        $thumbnail = $this->getThumbnail( $filetype);

        if($res){
            if($mode == 'move'){
                unlink($srcpath.'/'.$filename);
            }
        }

        $up = Uploaded::where('handle','=', $callcode)->first();

        if($up){
            //uploaded record already existed
        }else{
            $up = new Uploaded();

            $ns = 'document';

            $meta = new \ArrayObject();

            $up->url =  $url;
            $up->type = $filetype ;
            $up->filename = $filename;
            $up->thumbnail = $thumbnail;
            $up->filetype = $filetype;
            $up->isUploaded = 1;
            $up->uploadedAt = $upts;
            $up->upTs = $upts->timestamp;
            $up->handle = $callcode;
            $up->ns = $ns;
            $up->base = $base;
            $up->store =  env('STORAGE_DRIVER', 'local');
            $up->deleted = 0;
            $up->meta = $meta;
            $up->save();
        }

        return [
            'FileUrl'=>$base.'/'.$docpath,
            'DocBase'=>$base,
            'DocPath'=>$docpath
        ];
    }

    private function getThumbnail($type , $file = null)
    {
        return 'images/types/'.$type.'.png';
    }

}
