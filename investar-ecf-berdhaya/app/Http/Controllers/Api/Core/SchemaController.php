<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\GeoUtil;
use App\Helpers\PrintUtil;
use App\Http\Controllers\Controller;
use App\Models\Core\PrintCache;
use App\Models\Obj\FormTemplate;
use App\Models\Obj\JsonTemplate;
use App\Models\Obj\PrintTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchemaController extends Controller
{
    protected $provider;
    protected $chain;
    protected $geocoder;

    protected $dumper;

    public function __construct()
    {

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCode(Request $request)
    {
        $q = $request->input('q');

        $result = $this->geocoder->geocodeQuery(GeocodeQuery::create($q));


        $dumper = new GeoArray();

        foreach ($result->all() as $g){
            $geojson[] = $dumper->dump($g);
        }

        return response()->json($geojson);

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrintTemplate(Request $request)
    {
        $key = $request->input('q');

        $schema = PrintTemplate::where('slug','=', $key)->first();

        if($schema){
            $template = $schema->body;
        }else{
            $template = file_get_contents(resource_path('views/obj/printtemplate/printtemplate.html'));
        }


        return response()->json(['result'=>'OK', 'template'=>$template ]);

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPrintTemplate(Request $request)
    {
        $key = $request->input('q');

        $data = $request->input('data');

        return PrintUtil::processPrintTemplate($key, $data);
//        $key = $request->input('q');
//
//        $data = $request->input('data');
//
//        unset($data['raw_json']);
//
//        $d = new PrintCache();
//
//        $jstr = json_encode($data);
//
//        debug($jstr);
//
//        $jstr = preg_replace('/\$/', '', $jstr);
//
//        debug($jstr);
//
//        $jdata = json_decode($jstr, true);
//
//        debug($jdata);
//
//        $data = $jdata;
//
//        $d->content = $data;
//
//        $d->save();
//
//        if( env('PRINT_AS_PDF', false)){
//            return response()->json(['result'=>'OK', 'printurl'=>url( 'pdf/'.$key.'/'.$d->_id ) ], 200);
//        }else{
//            return response()->json(['result'=>'OK', 'printurl'=>url( 'print/'.$key.'/'.$d->_id ) ], 200);
//        }

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchema(Request $request)
    {
        $key = $request->input('q');
        $rw = $request->input('replaceWith');

        $schema = FormTemplate::where('key','=', intval($key))
                        ->orWhere('key','=', strval($key))
                        ->first();


        //$schema->formContent = '`'.$schema->formContent.'`';

        $schema = $schema->toArray();

        eval("\$schema['formParam'] = ".$schema['formParam'].";");
        eval("\$schema['formModel'] = ".$schema['formModel'].";");
        eval("\$schema['formObjectDefault'] = ".$schema['formObjectDefault'].";");

        $schema['formModel']['formTitle'] = '';
        $schema['formModel']['formHtml'] = '';
        $schema['formModel']['formKey'] = '';
        $schema['formModel']['formTs'] = 0;

        return response()->json(['result'=>'OK', 'schema'=>$schema ]);

    }


    function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
        $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        //$replacements = "";
        $result = str_replace($escapers, $replacements, $value);
        return $result;
    }

}
