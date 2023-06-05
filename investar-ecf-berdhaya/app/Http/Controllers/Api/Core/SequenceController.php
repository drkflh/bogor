<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\App\DmsUtil;
use App\Helpers\GeoUtil;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use Geocoder\Dumper\GeoArray;
use Geocoder\Dumper\GeoJson;
use Geocoder\Provider\OpenRouteService\OpenRouteService;
use Geocoder\Query\GeocodeQuery;
use Http\Discovery\HttpClientDiscovery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SequenceController extends Controller
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
    public function postSequence(Request $request)
    {
        $entity = $request->get('entity');

        if( $request->has('padding') ){
            $padding = $request->get('padding')??env('NUM_PAD', 5);
        }else{
            $padding = env('NUM_PAD', 5);
        }


        $seq = Util::getSequence($entity, false);

        if($seq){
            return response()->json([
                'result'=>'OK',
                'entity'=>$entity,
                'seq'=>$seq,
                'padded'=> str_pad($seq, $padding , '0', STR_PAD_LEFT )
            ]);

        }else{
            return response()->json([
                'result'=>'ERR',
                'msg'=>'NOENTITY'
            ]);
        }

    }

}
