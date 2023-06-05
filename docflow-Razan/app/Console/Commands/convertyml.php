<?php

namespace App\Console\Commands;

use App\Helpers\Util;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class convertyml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:yml {--in=} {--file=} {--out=} {--ns=} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert old style YML to newer version';

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

        $filename = $filename ?? 'fields';

        print "input : ".$in."\r\n";
        print "filename : ".$filename."\r\n";

        $inyml = Util::loadResYaml($filename, $in, false);

        $inarray = $inyml->toArray();

        $dbfield = [];
        $table = [];
        $form = [];
        $vue = [];
        $view = [];
        $api = [];

        foreach ($inarray as $el){

            if($el['name'] != 'filler'){
                unset($el['form']['row']);
                unset($el['form']['col']);

                $frm['label'] = $el['label'] ?? '';
                $frm['name'] = $el['name'];
                $frm['create'] = $el['form']['create'];
                $frm['edit'] = $el['form']['edit'];
                $frm['type'] = $el['form']['type'];
                $frm['model'] = $el['form']['model'];
                $frm['placeholder'] = $el['form']['placeholder'] ?? $frm['label'];
                $frm['default'] = $el['form']['default'] ?? '';
                $frm['validator'] = $el['form']['validator'] ?? '';
                $frm['column_classes'] = $el['form']['column_classes'] ?? 'text-left text-100';

                foreach($el['form'] as $k=>$v){
                    if(!array_key_exists($k, $frm)){
                        $frm[$k] = $v;
                    }
                }
                // this sequece of action is just for yml cosmetics
                unset($frm['param']);
                unset($frm['attr']);
                unset($frm['options']);

                $frm['param'] = $el['form']['options'] ?? '';
                $frm['attr'] = $el['form']['attr'] ?? '{}';

                $form[] = $frm;

                $vutype = $el['vue']['type'] == 'text' ? 'string': $el['vue']['type'];
                $vu['model'] = $el['form']['model'];
                $vu['visible'] = $el['vue']['visible'] ?? true;
                $vu['type'] = $vutype ?? 'string';
                $vu['default'] = $el['vue']['default'] ?? '';

                $vue[] = $vu;

                $vi['label'] = $el['view']['label'] ?? $el['label'] ;
                $vi['name'] = $el['name'];
                $vi['model'] = $el['view']['model'] ?? $el['name'] ;
                $vi['visible'] = $el['view']['visible'] ?? true;
                $vi['type'] = $el['view']['type'] ?? 'text';
                $vi['default'] = $el['view']['default'] ?? '';
                $vi['model'] = $el['view']['model'] ?? $el['form']['model'] ;

                $view[] = $vi;

                $api = $el['api'];

                unset($el['form']);
                unset($el['vue']);
                unset($el['view']);
                unset($el['api']);

                $tbl['label'] = $el['label'] ?? '';
                $tbl['name'] = $el['name'] ?? '';
                $tbl['show'] = $el['show'] ?? false;
                $tbl['search'] = $el['search']['visible'] ?? false;
                $tbl['sort'] = $el['sort'] ?? false;
                $tbl['filter'] = $el['filter']['visible'] ?? false;
                $tbl['datatype'] = $el['datatype'] ?? '';
                $tbl['row_text_alignment'] = $el['row_text_alignment'];
                $tbl['column_classes'] = $el['column_classes'] ?? '';
                $tbl['thClass'] = $el['thClass'] ?? '';

                if($el['name'] == '_id'){
                    $tbl['uniqueId'] = true;
                    $tbl['column_classes'] = 'col_action';
                }else{
                    unset( $tbl['uniqueId'] );
                }

                $table[] = $tbl;

                $el['api'] = $api;

                $pt = config('util.preset_type');
                if( isset( $pt[$el['name']] )){
                    $type = $pt[$el['name']];
                }else{
                    $type = $vu['type'];
                }

                $db['name'] = $el['name'];
                $db['type'] =  $type;
                $db['default'] = null;
                $db['nullable'] = true;
                $db['api']['show'] = $api['visible'] ?? true;
                $db['api']['create'] = true;
                $db['api']['edit'] = true;
                $db['api']['view'] = true;
                $db['api']['validator'] = '';
                $db['api']['default'] = $vu['default'];
                $db['api']['transform'] = false;
                $db['api']['type'] = $vu['type'];

                $dbfield[] = $db;

            }else{

                unset($el['form']);
                unset($el['vue']);
                unset($el['view']);
                unset($el['api']);

                $el['search'] = $el['search']['visible'];
                $el['filter'] = $el['filter']['visible'];

                $table[] = $el;

            }


        }

        $controller = [
            'table'=>$table,
            'form'=>$form,
            'vue'=>$vue,
            'view'=>$view,
        ];

        print $this->toYMLString($dbfield);
        print "\r\n";
        print $this->toYMLString($controller);

        $res_model_path = resource_path('model');

        $res_controller_path = resource_path('model/controllers');

        $cxpath = resource_path('models/controllers').'/'.strtolower($ns);

        if(!is_dir($cxpath)){
            mkdir($cxpath, 0777, true);
        }

        $controller_save_path = resource_path('models/controllers').'/'.strtolower($ns).'/'.strtolower($out.'_controller.yml');
        $dbfield_save_path = resource_path('models').'/'.strtolower($out.'.yml');

        print "\r\n";
        print "saving controller YML";
        print "\r\n";
        print $controller_save_path;
        $controller_yml = $this->toYMLString($controller);
        file_put_contents($controller_save_path, $controller_yml);
        print "\r\n";
        print "saving db model YML";
        print "\r\n";
        print $dbfield_save_path;
        $dbfield_yml = $this->toYMLString($dbfield);
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
