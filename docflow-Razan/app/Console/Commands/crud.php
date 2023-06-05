<?php

namespace App\Console\Commands;

use App\Models\Imports\FieldImport;
use function Aws\boolean_value;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Yaml\Yaml;

class crud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * example : php5 artisan crud:make Incoming --model=Trip --dpath=trip/incoming --ns=Trips --route=incoming --routefile=app/trips
     */
    protected $signature = 'app:make {controller} {--model=} {--dpath=} {--ns=} {--route=} {--routefile=}  {--fieldcsv=}  {--ymlpath=}  {--ymlfile=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates CRUD sets';

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
        $controller = $this->argument('controller');
        $model = $this->option('model');
        $ns = $this->option('ns');
        $route = $this->option('route');
        $routefile = $this->option('routefile');
        $datapath = $this->option('dpath');

        $inputcsv = $this->option('fieldcsv');
        $savepath = $this->option('ymlpath');
        $savefile = $this->option('ymlfile');


        $this->controller($controller, $model, $datapath ,$ns, $route, $routefile);
        $this->model($model, $ns);
        $this->tabdef($controller, $ns);

        if(!is_null($inputcsv)){
            $this->fielddef( $inputcsv, $savepath, $savefile );
        }
    }

    protected function controller($controller, $model, $datapath ,$ns, $route,$routefile){
        $nsb = str_replace("\\", "/", $ns);

        $controllerTemplate = str_replace([
                '{{nameSpace}}',
                '{{controllerName}}',
                '{{dataSrcPath}}',
                '{{dataSrcPathDot}}',
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingular}}',
                '{{resourcePath}}'
            ],
            [
                $ns,
                $controller,
                $datapath,
                str_replace('/','.', $datapath),
                $model,
                strtolower(Str::plural($model)),
                strtolower($model),
                strtolower("views/{$nsb}/{$controller}")
            ],
            $this->getStub('Controller')
        );

        $cpath = app_path("/Http/Controllers/{$ns}");

        if(!is_dir($cpath)){
            mkdir($cpath, 0777, true);
        }

        file_put_contents(app_path("/Http/Controllers/{$ns}/{$controller}Controller.php"), $controllerTemplate);

        $this->route($controller, $route, $routefile, $ns );

    }

    protected function model($model, $ns){
        $nsb = str_replace("\\", "/", $ns);
        $modelTemplate = str_replace(
            ['{{modelName}}', '{{modelNamePlural}}', '{{nameSpace}}'],
            [$model, strtolower(Str::plural($model)), $ns ],
            $this->getStub('Model')
        );

        $cpath = app_path("Models/{$ns}");

        if(!is_dir($cpath)){
            mkdir($cpath, 0777, true);
        }

        $model_path = app_path("Models/{$ns}/{$model}.php" );

        if(file_exists($model_path)){
            print "Model already exists, skipping ..."."\r\n";
        }else{
            file_put_contents($model_path, $modelTemplate);
        }
    }

    protected function tabdef($controller, $ns){
        $nsb = str_replace("\\", "/", $ns);

        $controller = strtolower($controller);

        $cpath = resource_path( strtolower("views/{$nsb}/{$controller}") );

        print 'resource path : '.$cpath."\r\n";

        if(!is_dir($cpath)){
            mkdir($cpath, 0777, true);
        }

        file_put_contents(resource_path(strtolower("views/{$nsb}/{$controller}/fields.yml") ), $this->getStub('Fields') );
    }

    protected function route($controllerName, $route, $routefile, $namespace){
        $path =  base_path('routes/'.$routefile.'.php');

        $str = sprintf( "\t"."\App\Helpers\Util::makeRoute('%s', '%s\%sController');"."\r\n",$route, $namespace, $controllerName );

        if(!file_exists($path)){
            touch($path);
        }

        if(file_exists($path)){
            print "Route entry : ".$str."\r\n";
            print "Opening route file : ".$path."\r\n";
            $route_content = file_get_contents($path);
            if( strpos( $route_content, $str ) > 0 ){
                print "Route definition already exists, skipping ...\r\n";
            }else{
                $routefile = fopen($path, "a");
                fwrite($routefile, $str);
                fclose($routefile);
            }
        }

    }

    protected function fielddef( $csv ,$savepath, $savefile)
    {
        if(isset($savefile) && !is_null($savefile)){

            $yml = $this->loadXLS($csv);

            $cpath = resource_path($savepath);

            if(!is_dir($cpath)){
                mkdir($cpath, 0777, true);
            }

            $path = resource_path($savepath.'/'.$savefile.'.yml');

            print "Save to : ".$path."\r\n";

            file_put_contents($path, $yml);
        }else{
            print "filename unspecified, display only\r\n";
        }
    }

    protected function getStub($type){
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    private function loadXLS($file)
    {
        $filepath = resource_path('opt/'.$file);

        print "Model definition YML ".$filepath."\r\n";

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
