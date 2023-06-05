<?php

namespace App\Console\Commands;

use App\Models\Imports\FieldImport;
use App\Models\Imports\GenericImport;
use function Aws\boolean_value;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Yaml\Yaml;

class crudfields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:fields {inputcsv} {--savepath=} {--savefile=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create YML Field Definition file from Excel / CSV';

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
        $inputcsv = $this->argument('inputcsv');
        $savepath = $this->option('savepath');
        $savefile = $this->option('savefile');

        $yml = $this->loadXLS($inputcsv);

        if(isset($savefile) && !is_null($savefile)){

            $cpath = resource_path($savepath);

            if(!is_dir($cpath)){
                mkdir($cpath, 0777, true);
            }

            $path = resource_path($savepath.'/'.$savefile.'.yml');

            print "save to : ".$path."\r\n";

            file_put_contents($path, $yml);
        }else{
            print "filename unspecified, display only\r\n";
        }
    }

    private function loadXLS($file)
    {
        $filepath = resource_path('opt/'.$file);
        print "field def file ".$filepath."\r\n";
        $xarray = Excel::toArray( new FieldImport(), $filepath );

        $struct = config('util.field_structure');

        //print_r($struct);

        $fields = [];
        foreach($xarray as $item){
            foreach($item as  $i){
                $it = [];
                foreach ($i as $k=>$v){
                    $pc = explode( '_', $k );

                    if($k == 'label' && $v == ''){
                        $v = $i['name'];
                    }

                    if(is_null($v) || $v ==  ''){
                        if(isset($struct[$k]['default']) && $struct[$k]['default'] != ''){
                            if( $struct[$k]['default'] == 'false' ){
                                $v = boolean_value('false');
                            }else{
                                $v = $struct[$k]['default'];
                            }
                        }else{
                            $v = 'empty';
                        }
                    }

                    $nested = false;
                    if($v != 'empty'){

                        if($pc[0] == 'search'){
                            $it['search'][$pc[1]] = $v;
                            $nested = true;
                        }
                        if($pc[0] == 'filter'){
                            $it['filter'][$pc[1]] = $v;
                            $nested = true;
                        }
                        if($pc[0] == 'form'){
                            $it['form'][$pc[1]] = $v;
                            $nested = true;
                        }
                        if($pc[0] == 'vue'){
                            $it['vue'][$pc[1]] = $v;
                            $nested = true;
                        }
                        if($pc[0] == 'api'){
                            $it['api'][$pc[1]] = $v;
                            $nested = true;
                        }
                        if($pc[0] == 'view'){
                            $it['view'][$pc[1]] = $v;
                            $nested = true;
                        }

                        if(!$nested){
                            $it[$k] = $v;
                        }
                    }
                }

                $it['form'] = (array) $it['form'];

                $fields[] = $it;
            }
        }

        $yml = Yaml::dump($fields, 6, 4,Yaml::DUMP_OBJECT_AS_MAP);

        $yml = str_replace(["'TRUE'", "'true'"], "true", $yml);
        $yml = str_replace(["'FALSE'","'false'"], "false", $yml);
        $yml = str_replace(["unique_id", "uniqueid"], "uniqueId", $yml);
        $yml = str_replace("'[", "[", $yml);
        $yml = str_replace("]'", "]", $yml);
        $yml = str_replace("'{", "{", $yml);
        $yml = str_replace("}'", "}", $yml);
        //print "YML : \r\n";
        //print $yml;
        return $yml;
    }

}
