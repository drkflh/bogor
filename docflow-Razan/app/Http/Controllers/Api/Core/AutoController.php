<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\GeoUtil;
use App\Http\Controllers\Controller;
use App\Models\Core\Mongo\Tag;
use App\Models\Obj\FormTemplate;
use App\Models\Obj\JsonTemplate;
use App\Models\Reference\ExchangeRate;
use Illuminate\Http\Request;

class AutoController extends Controller
{
    protected $provider;
    protected $chain;
    protected $geocoder;

    protected $dumper;

    public function __construct()
    {

    }

    public function getXrate(Request $request)
    {
        $q = $request->get('q');

        $entry = ExchangeRate::where('currencyCode' , '=' ,$q)->first();

        if($entry){
            $xrate = doubleval( $entry->idrValue );
        }else{
            $xrate = 1;
        }

        return response()->json(['result'=>'OK', 'xrate'=>$xrate]);
    }

    public function getTag(Request $request)
    {
        $q = $request->input('q');

        $res = Tag::where('tag','like', '%'.$q.'%')->get()->toArray();

        return response()->json(['result'=>'OK', 'msg'=>'OK', 'data'=>$res ]);

    }

    public function postSaveTag(Request $request)
    {
        $tags = $request->input('tags');
        foreach($tags as $t){
            print_r($t);
            $res = Tag::where('tag','=', $t['text'] )->first();
            if($res){

            }else{
                $nt = new Tag();
                $nt->tag = $t['text'];
                $nt->save();
            }
        }

        return response()->json(['result'=>'OK', 'msg'=>'OK' ]);

    }

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

    public function getSchema(Request $request)
    {
        $key = $request->input('q');

        $schema = FormTemplate::where('key','=', $key)->first();

        //$schema->formContent = '`'.$schema->formContent.'`';

        $schema = $schema->toArray();

        eval("\$schema['formParam'] = ".$schema['formParam'].";");
        eval("\$schema['formModel'] = ".$schema['formModel'].";");
        eval("\$schema['formObjectDefault'] = ".$schema['formObjectDefault'].";");

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
