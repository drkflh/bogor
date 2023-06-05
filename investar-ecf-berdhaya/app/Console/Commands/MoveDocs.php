<?php

namespace App\Console\Commands;

use App\Helpers\App\DmsUtil;
use App\Models\Dms\Doc;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MoveDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dms:move  {--in=} {--bucket=} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Moving DMS Local Files to Online Storage';

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
     * @return int
     */
    public function handle()
    {
        $in = $this->option('in');
        $bucket = $this->option('bucket');

        $fd = env('STORAGE_DRIVER') == 's3' ? 's3_' : '';

        $buckets = config('app.'.$fd.'buckets.names');

        $src = Storage::disk('local')->files($in);

        if(isset($buckets[$bucket]) ){
            $storage_driver = $buckets[$bucket];
        }

        $dest = Storage::disk($storage_driver)->allDirectories();

        foreach ($src as $file){
            echo $file."\r\n";
            $callcode = preg_replace('/\.pdf|\.docx|\.xlsx|\.doc|\.xls/mi', '', $file );
            $name = explode('/', $callcode );
            $name = array_pop($name);
            echo $callcode."\r\n";
            echo $name."\r\n";

            $output = storage_path('temp/'.$name.'.pdf');
            $source = storage_path('app/'.$file);
            DmsUtil::embedQR( $source, $output, $name );

            $doc = Doc::where('FCallCode','=', $name )->first();
            if($doc){

            }
        }

        print_r($src);

        print_r( $dest );

        return 0;
    }
}
