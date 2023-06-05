<?php

namespace App\Console\Commands;

use App\Helpers\Util;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class convertmodel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:model {--in=} {--file=} {--out=} {--ns=} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert controller YML to to data API YML';

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
        $ns = $this->option('ns');
        $in = $this->option('in');
        $out = $this->option('out');

        $filename = $this->option('file');

        $out = $out ?? $filename;


        $filename = strtolower($filename).'_controller';

        $controller_res_path = 'models/controllers'.'/'.strtolower($ns);

        print "outpath : ".$out."\r\n";
        print "path : ".$controller_res_path."\r\n";
        print "input : ".$in."\r\n";
        print "filename : ".$filename."\r\n";

        $existdb = [];
        $existkey = [];
        if(file_exists( resource_path('models/'.strtolower($out).'.yml' ) )){
            $outyml = Util::loadResYaml($out, 'models', false);
            $existdb = $outyml->toArray();
            foreach ($outyml->toArray() as $ex){
                $existkey[] = $ex['name'];
            }
        }

        $inyml = Util::loadResYaml($filename, $controller_res_path, false);

        $inarray = $inyml->toArray();

        $inarray = $inarray['vue'];

        $dbfield = [];
        foreach ($inarray as $el){
            $db['name'] = $el['model'];
            $db['type'] =  $el['type'];
            $db['default'] = null;
            $db['nullable'] = true;
            $db['api']['show'] = $el['visible'] ? true : false;
            $db['api']['create'] = true;
            $db['api']['edit'] = true;
            $db['api']['view'] = true;
            $db['api']['validator'] = '';
            $db['api']['default'] = $el['default'];
            $db['api']['transform'] = false;
            $db['api']['type'] = $el['type'];

            if(!empty($existkey) && !in_array($db['name'], $existkey )){
                $dbfield[] = $db;
            }
        }

        if(!empty($existdb)){
            $dbfield = array_merge( $existdb , $dbfield );
        }

        print $this->toYMLString($dbfield);

        $dbfield_save_path = resource_path('models').'/'.strtolower($out.'.yml');
        $dbfield_yml = $this->toYMLString($dbfield);

        print "\r\n";
        print "saving db model YML";
        print "\r\n";
        print $dbfield_save_path;
        file_put_contents($dbfield_save_path, $dbfield_yml);

        return 0;
    }

    private function toYMLString($yml){

        $cyml = Yaml::dump($yml, 6, 4,Yaml::DUMP_OBJECT_AS_MAP);
        $cyml = $this->stripYML($cyml);

        return $cyml;
    }

    private function stripYML($yml){
        $yml = str_replace(["'[]'"], "[]", $yml);
        $yml = str_replace(["'{}'"], "{}", $yml);
        $yml = str_replace(["'TRUE'", "'true'"], "true", $yml);
        $yml = str_replace(["'FALSE'","'false'"], "false", $yml);
        $yml = str_replace(["unique_id", "uniqueid"], "uniqueId", $yml);
        return $yml;
    }
}
