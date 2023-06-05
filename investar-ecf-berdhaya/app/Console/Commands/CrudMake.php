<?php

namespace App\Console\Commands;

use App\Helpers\GenUtil;
use App\Models\Imports\ApiFieldImport;
use App\Models\Obj\AclObject;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Yaml\Yaml;

class CrudMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * example : php5 artisan api:make Incoming --model=Trip --dpath=trip/incoming --ns=Trips --route=incoming --routefile=app/trips
     */
    protected $signature = 'crud:make {controller} {--model=} {--dpath=} {--ns=} {--route=} {--routefile=} {--fieldcsv=} {--ymlpath=} {--ymlfile=} {--skipmodel} {--skipapi} {--skipmodelyml}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Model, API End Point and Front End CRUD';

    protected $num_field = 0;

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

        $skipapi = $this->option('skipapi');
        $skipmodel = $this->option('skipmodel');
        $skipmodelyml = $this->option('skipmodelyml');

        if($skipapi){
            print "Skipping API Controller \r\n";
        }else{
            $this->controller($controller, $model, $datapath ,$ns, $route, $routefile, $savepath ,$savefile);
        }
        if($skipmodel){
            print "Skipping Model \r\n";
        }else{
            $this->model($model, $ns);
        }

        if(!is_null($inputcsv)){
            $yml = $this->fieldDefinition( $inputcsv, $savepath, $savefile, $skipmodelyml, $ns );
            if($yml){
                foreach($yml['controllers'] as $cn=>$cd){

                    print "CRUD target name ".$cn."\r\n";

                    if(strpos($cn, "/") === false){

                    }else{
                        $cx = explode("/", $cn);
                        $cn = array_pop($cx);
                        $ns = implode("/", $cx);
                    }

                    print "CRUD target namespace ".$ns."\r\n";
                    print "CRUD target controller name ".$cn."\r\n";

                    $savefile = strtolower( $cn.'_controller' );
                    $savepath = $savepath.'/controllers';
                    $this->appController($cn, $model, $datapath ,$ns, $route, $routefile, $savepath ,$savefile, $cd);
                }
            }
        }
    }

    protected function controller($controller, $model, $datapath ,$ns, $route,$routefile, $savepath ,$savefile){
        $nsb = str_replace("/", "\\", $ns);
        $viewpath = str_replace('/','.', $datapath);

        $ymlpath = strtolower($savepath.'/db/'.$ns);

        $models = Str::plural($model);

        print "Controller namespace: ".$nsb."\r\n";

        $controllerTemplate = str_replace([
            '{{nameSpace}}',
            '{{controllerName}}',
            '{{dataSrcPath}}',
            '{{dataSrcPathDot}}',
            '{{modelName}}',
            '{{modelNamePlural}}',
            '{{modelNameSingular}}',
            '{{resourcePath}}',
            '{{ymlFile}}'
        ],
            [
                $nsb,
                $controller,
                $datapath,
                $viewpath,
                $model,
                strtolower($models),
                strtolower($model),
                strtolower($ymlpath),
                strtolower($savefile)
            ],
            $this->getStub('ApiController')
        );

        $cpath = app_path("/Http/Controllers/Api/".$ns);

        if(!is_dir($cpath)){
            mkdir($cpath, 0777, true);
        }

        $controllerName = $controller.'Controller.php';
        $controllerPath = "/Http/Controllers/Api/".$ns."/".$controllerName;
        file_put_contents(app_path($controllerPath), $controllerTemplate);

        $this->apiRoute($controller, $route, $routefile, $nsb );

    }

    protected function appController($controller, $model, $datapath ,$ns, $route,$routefile, $savepath ,$savefile, $yml){

        $nsb = str_replace("/", "\\", $ns);
        $viewpath = str_replace('/','.', $ns."/".$controller);
        $viewpath = strtolower($viewpath);
        $ymlpath = strtolower($savepath.'/'.$ns);

        $models = Str::plural($model);

        //$entity = strtolower($controller);

        $entity = preg_split('/(?=[A-Z])/',$controller);

        $entity = ucwords(  trim( implode( ' ', $entity ) )  );

        $authentity = strtolower( str_replace( ' ', '-' , $entity ) );

        $this->registerAcl( $authentity, $entity );

        print "CRUD Controller namespace: ".$nsb."\r\n";

        if($this->num_field > 6 ){
            $as_page = 'true';
            $add_filler = 'false';
        }else{
            $as_page = 'false';
            $add_filler = 'true';
        }

        $controllerTemplate = str_replace([
            '{{nameSpace}}',
            '{{controllerName}}',
            '{{entity}}',
            '{{authEntity}}',
            '{{dataSrcPath}}',
            '{{viewBasePath}}',
            '{{modelName}}',
            '{{modelNamePlural}}',
            '{{modelNameSingular}}',
            '{{ymlResourcePath}}',
            '{{ymlFile}}',
            '{{asPage}}',
            '{{addFiller}}'
        ],
            [
                $nsb,
                $controller,
                $entity,
                $authentity,
                $datapath,
                $viewpath,
                $model,
                strtolower($models),
                strtolower($model),
                $ymlpath,
                strtolower($savefile),
                $as_page,
                $add_filler
            ],
            $this->getStub('Controller')
        );

        $cpath = app_path("/Http/Controllers/".$ns);

        if(!is_dir($cpath)){
            mkdir($cpath, 0777, true);
        }

        $controllerName = $controller.'Controller.php';
        $controllerPath = "/Http/Controllers/".$ns."/".$controllerName;
        file_put_contents(app_path($controllerPath), $controllerTemplate);

        $this->appRoute($controller, $route, $routefile, $nsb );

        $viewPath = strtolower("views/".$ns."/".$controller);

        $this->appResources($viewPath, $yml);

    }

    protected function appResources($viewPath, $yml)
    {
        $yml = Yaml::parse($yml);
        $cpath = resource_path($viewPath);

        if(!is_dir($cpath)){
            mkdir($cpath, 0777, true);
        }
        print "Copy resource files :\r\n";
        $stubfiles = $this->getResourceStub();
        foreach ($stubfiles as $sf){
            print resource_path('views/stubs/'.$sf).'=>'.$cpath.'/'.$sf."\r\n";
            if(file_exists ( $cpath.'/'.$sf )){
                $content = file_get_contents($cpath.'/'.$sf);
            }else{
                $content = '';
            }

            if($sf == 'form_layout.blade.php'){
                $content = GenUtil::compileForm($yml, $content);
                print "Compiling form layout :\r\n";
                file_put_contents($cpath.'/'.$sf, "<div>\r\n".$content."\r\n</div>");
            }elseif($sf == 'view_layout.blade.php'){
                $content = GenUtil::compileViewForm($yml, $content);
                file_put_contents($cpath.'/'.$sf, "<div>\r\n".$content."\r\n</div>");
            }else{
                copy(resource_path('views/stubs/'.$sf), $cpath.'/'.$sf);
            }
        }
        //file_put_contents(app_path($controllerPath), $controllerTemplate);
    }

    protected function model($model, $ns){
        $nsb = str_replace("/", "\\", $ns);

        print "Model namespace: ".$nsb."\r\n";

        $modelTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{nameSpace}}'
            ],
            [
                $model,
                strtolower(Str::plural($model)),
                $nsb
            ],
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

    protected function apiRoute($controllerName, $route, $routefile, $namespace){
        $path =  base_path('routes/api/'.$routefile.'.php');
        $namespace = str_replace("/", "\\", $namespace);

        print "Route namespace: ".$namespace."\r\n";

        $str = sprintf( "\t"."\App\Helpers\Util::makeApiRoute('%s', 'Api\%s\%sController');"."\r\n",$route, $namespace, $controllerName );

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

    protected function appRoute($controllerName, $route, $routefile, $namespace){
        $path =  base_path('routes/app/'.$routefile.'.php');
        $namespace = str_replace("/", "\\", $namespace);

        print "CRUD Route namespace: ".$namespace."\r\n";

        $route_template = "\t"."\App\Helpers\Util::makeRoute('{{route}}', '{{nameSpace}}\{{controllerName}}Controller');"."\r\n";
        $str = str_replace([
                '{{route}}',
                '{{nameSpace}}',
                '{{controllerName}}'
            ],
            [
                $route,
                $namespace,
                $controllerName
            ],
            $route_template
        );

        if(!file_exists($path)){
            touch($path);
        }

        if(file_exists($path)){
            print "CRUD Route entry : ".$str."\r\n";
            print "Opening APP route file : ".$path."\r\n";
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

    protected function fieldDefinition($csv , $savepath, $savefile, $skipmodelyml, $ns)
    {
        if(isset($savefile) && !is_null($savefile)){

            $yml = $this->loadXLS($csv);

            $cpath = resource_path($savepath);

            if(!is_dir($cpath)){
                mkdir($cpath, 0777, true);
                $ctrlpath = resource_path($savepath.'/controllers');
                if(!is_dir($ctrlpath)){
                    mkdir($ctrlpath, 0777, true);
                }
            }

            // db & api model path
            $dbpath = resource_path($savepath.'/db/'.strtolower($ns));

            if(!is_dir($dbpath)){
                mkdir($dbpath, 0777, true);
            }

//            $path = resource_path($dbpath.'/'.$savefile.'.yml');

            $path = $dbpath.'/'.$savefile.'.yml';

            if($skipmodelyml){
                print "Skipping DB Model YML \r\n";
            }else{
                file_put_contents($path, $yml['model']);
            }

            foreach ($yml['controllers'] as $fk=>$fc){

                if(strpos($fk, "/") === false){
                    $path = resource_path($savepath.'/controllers/'.$savefile );

                    $savefile = strtolower($fk).'_'.'controller.yml';
                    print "Controller save to : ".$path."\r\n";
                    file_put_contents($path, $fc);

                }else{
                    $fx = explode("/", $fk);
                    $fk = array_pop($fx);
                    $fx = implode("/", $fx);
                    $cxpath = resource_path($savepath.'/controllers/'.strtolower($fx));

                    if(!is_dir($cxpath)){
                        mkdir($cxpath, 0777, true);
                    }

                    $savefile = strtolower($fk).'_'.'controller.yml';

                    $path = $cxpath.'/'.$savefile;

                    print "Controller save to : ".$path."\r\n";
                    file_put_contents($path, $fc);

                }


            }

            return $yml;

        }else{
            print "filename unspecified, display only\r\n";
            return false;
        }
    }

    protected function getStub($type){
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function getResourceStub(){
        $stubdir = resource_path('views/stubs');
        $stubs = [];
        if ($handle = opendir($stubdir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $stubs[] = $entry;
                }
            }
            closedir($handle);
        }
        return $stubs;
    }

    private function loadXLS($file)
    {
        $filepath = resource_path('opt/'.$file);

        print "Model definition YML ".$filepath."\r\n";

        $xarray = Excel::toArray( new ApiFieldImport(), $filepath );

        $struct = config('util.api_field_structure');

        //print_r($struct);
        //print_r($xarray);

        $fields = [];
        foreach($xarray as $item){
            $appc = [];
            $fc = 0;
            foreach($item as  $i){
                $it = [];
                foreach ($i as $k=>$v){
                    $pc = explode( '_', $k );

                    $vx = $v;
                    $v = $this->defaultVal($struct, $k, $v);

                    $nested = false;

                    if($pc[0] == 'api'){
                        $it['api'][$pc[1]] = $v;
                        $nested = true;
                    }

                    if(count($pc) == 3){
                        $ctr = $pc[0];
                        $ent = $pc[1];
                        $key = $pc[2];
                        if( !isset( $appc[ $ctr ] ) ){
                            $appc[ $ctr ] = [];
                        }

                        if(!isset( $appc[$ctr][$ent]) ){
                            $appc[$ctr][$ent] = [];
                        }
                        $ky = $ent.'_'.$key;
                        $v = $this->defaultVal($struct, $ky, $vx);

                        $appc[$ctr][$ent][$fc][$key] = $v;

                        $nested = true;
                    }

                    if(!$nested){
                        $it[$k] = $v;
                    }

                    unset($it['doc']);
                }
                $fc++;
                $fields[] = $it;
            }
        }

        $myml = Yaml::dump($fields, 6, 4,Yaml::DUMP_OBJECT_AS_MAP);

        $myml = $this->stripYML($myml);

        $controllers = [];
        foreach($appc as $kx=>$yml){
            print 'Compacting YML'."\r\n";
            $yml = $this->compactYML($yml);

            $cyml = Yaml::dump($yml, 6, 4,Yaml::DUMP_OBJECT_AS_MAP);
            $cyml = $this->stripYML($cyml);
            $controllers[$kx] = $cyml;
        }

        //print_r($controllers);

        //print "YML : \r\n";
        //print $ayml;

        return [ 'model'=>$myml, 'controllers'=>$controllers ];
    }

    private function compactYML($yml){
        if(isset($yml['table'])){
            $ctable = [];
            foreach($yml['table'] as $tf){
                if($tf['show'] == "true" || $tf['name'] == '_id'){
                    if($tf['name'] == '_id'){
                        $tf['label'] = 'Action';
                        $tf['show'] = true;
                        $tf['sort'] = false;
                        $tf['uniqueId'] = true;
                        $tf['row_text_alignment'] = 'text-left';
                        $tf['column_classes'] = 'col_action';
                        $tf['thClass'] = 'text-center text-50';
                        $tf['datatype'] = 'text';
                        $ctable[] = $tf;
                    }else{
                        if($tf['name'] != ''){
                            if( isset($tf['datatype']) && $tf['datatype'] != '' ){

                            }
                            $tf['row_text_alignment'] = $tf['row_text_alignment'] ?? 'text-left';
                            $tf['column_classes'] = $tf['column_classes'] ?? 'text-left text-100';
                            $tf['thClass'] = $tf['thClass'] ?? 'text-center text-50';
                            $tf['datatype'] = $tf['datatype'] ?? 'text';
                            $ctable[] = $tf;
                        }
                    }
                }
            }
            $yml['table'] = $ctable;
            $this->num_field = count($ctable);
        }

        if(isset($yml['form'])){
            $cform = [];
            foreach($yml['form'] as $tf){
                if($tf['create'] == "true" || $tf['edit'] == "true" || $tf['name'] == '_id'){
                    if($tf['name'] != ''){
                        $cform[] = $tf;
                    }
                }
            }
            $yml['form'] = $cform;
        }

        if(isset($yml['view'])){
            $cview = [];
            foreach($yml['view'] as $tf){
                if($tf['visible'] == "true" || $tf['name'] == '_id'){
                    if($tf['name'] != ''){
                        $cview[] = $tf;
                    }
                }
            }
            $yml['view'] = $cview;
        }

        if(isset($yml['vue'])){
            $cvue = [];
            foreach($yml['vue'] as $tf){
                if($tf['visible'] == "true" || $tf['model'] == '_id'){
                    if($tf['type'] == 'array'){
                        $tf['default'] = $tf['default'] == '' ? '[]' : $tf['default'];
                    }
                    if($tf['type'] == 'object'){
                        $tf['default'] = $tf['default'] == '' ? '{}': $tf['default'];
                    }
                    $tf['im'] =  isset($tf['im'] )?$this->booleanVal( $tf['im'] ): true;
                    $tf['ex'] =  isset($tf['ex'] )?$this->booleanVal( $tf['ex'] ): true;
                    $tf['search'] =  isset($tf['search'] )?$this->booleanVal( $tf['search'] ): true;

                    if($tf['model'] != ''){
                        $cvue[] = $tf;
                    }
                }
            }
            $yml['vue'] = $cvue;
        }

        return $yml;
    }

    private function booleanVal($val){

        $val = $val ?? false;

        if( strtolower($val) == 'yes' || strtolower($val) == 'true' || $val == 1 || $val === true){
            return true;
        }else{
            return false;
        }

    }

    private function stripYML($yml){
        $yml = str_replace(["'[]'"], "[]", $yml);
        $yml = str_replace(["'{}'"], "{}", $yml);
        $yml = str_replace(["'TRUE'", "'true'"], "true", $yml);
        $yml = str_replace(["'FALSE'","'false'"], "false", $yml);
        $yml = str_replace(["unique_id", "uniqueid"], "uniqueId", $yml);
        return $yml;
    }

    private function defaultVal($struct, $k, $v){
        if(isset($struct[$k])){
            if( $struct[$k]['type'] == 'boolean'){
                if(is_null($v) || $v == '' || empty($v) ){
                    if( $struct[$k]['default'] == false || strtolower($struct[$k]['default']) == 'no' ){
                        $v = 'false';
                    }else{
                        $v = 'true';
                    }
                }else{
                    if( strtolower($v) == 'no' || strtolower($v) == 'false' ){
                        $v = 'false';
                    }else{
                        $v = 'true';
                    }
                }
            }
            if( $struct[$k]['type'] == 'string'){
                $v = $v ?? $struct[$k]['default'];
            }

            if( $struct[$k]['type'] == 'array'){
                $v = $v ?? [];
            }

            if( $struct[$k]['type'] == 'object'){
                $v = $v ?? '{}';
            }

            if($k == 'type'){
                $v = $v ?? 'string';
            }

            if( isset($struct[$k]['case']) ){
                if($struct[$k]['case'] == 'lower'){
                    $v = strtolower($v);
                }
                if($struct[$k]['case'] == 'upper'){
                    $v = strtoupper($v);
                }
                if($struct[$k]['case'] == 'capital'){
                    $v = ucfirst($v);
                }
                if($struct[$k]['case'] == 'title'){
                    $v = ucwords($v);
                }
            }

            return $v;
        }

        return null;
    }

    private function registerAcl( $aclKey, $aclName )
    {

        $acl = AclObject::where( 'objectKey', '=', $aclKey )->first();
        if($acl){

        }else{
            $acl = new AclObject();

            $acl->objectName = $aclName ;
            $acl->objectKey = $aclKey ;
            $acl->checkMethod = 'BooleanCheck' ;
            $acl->objectType = 'Boolean' ;
            $acl->formType = 'Checkbox' ;
            $acl->standardCrud = true ;
            $acl->valueArray = null ;
            $acl->lookupTo = 'Config' ;
            $acl->lookupParam = 'acl.crud' ;
            $acl->objectDescription = null ;

            $acl->save();
        }

    }
}
