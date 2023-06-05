<?php

namespace App\Console\Commands;

use App\Helpers\Util;
use App\Models\Dms\Doc;
use App\Models\Core\Mongo\Uploaded;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class scanlink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:scanlink {--dir=} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Scan Directory and Link files to document records\n\r--dir=fullpath of source dir\n\r--mode=copy|move";

    protected $sourceDir = '';

    protected $mode = 'copy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sourcedir = $this->option('dir');

        $this->mode = $this->option('mode')??'copy';

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

    protected function linkFile($callcode, $file, $srcpath, $mode ){

        $doc = Doc::where('FCallCode','=', $callcode)->first();

        if($doc){
            $m = $this->moveFile($callcode, $file, $srcpath, $mode);
            $doc->FileUrl = $m['FileUrl'];
            $doc->DocBase = $m['DocBase'];
            $doc->DocPath = $m['DocPath'];

            $doc->Status = $doc->Status ?? 'Active';

            $doc->save();
            return true;
        }else{
            return false;
        }
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
