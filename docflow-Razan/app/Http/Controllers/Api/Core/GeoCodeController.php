<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\GeoUtil;
use App\Http\Controllers\Controller;
use Geocoder\Dumper\GeoArray;
use Geocoder\Dumper\GeoJson;
use Geocoder\Provider\OpenRouteService\OpenRouteService;
use Geocoder\Query\GeocodeQuery;
use Http\Discovery\HttpClientDiscovery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeoCodeController extends Controller
{
    protected $provider;
    protected $chain;
    protected $geocoder;

    protected $dumper;

    public function __construct()
    {

        $httpClient = new \Http\Adapter\Guzzle6\Client();

        $chain = new \Geocoder\Provider\Chain\Chain([
            new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient, null, env('GOOGLE_MAPS_API_KEY')),
            new \Geocoder\Provider\OpenRouteService\OpenRouteService($httpClient, env('OPEN_ROUTE_KEY'))
        ]);

        //$geocoder->registerProvider($chain);
        //$this->provider = new \Geocoder\Provider\OpenRouteService\OpenRouteService($httpClient, env('OPEN_ROUTE_KEY'));

        $this->geocoder = new \Geocoder\StatefulGeocoder($chain, 'en');

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Geocoder\Exception\Exception
     */
    public function getCode(Request $request)
    {
        $q = $request->input('q');

        $result = $this->geocoder->geocodeQuery(GeocodeQuery::create($q));


        $dumper = new GeoArray();

        foreach ($result->all() as $g){
            $geojson[] = $dumper->dump($g);
        }

        $res = [];

        $idx = 0;
        foreach($geojson as $item ){
            $p = [];
            $idx++;
            $p['_id'] = Str::random(10);

            $center = (is_array($item['geometry']['coordinates']) && count($item['geometry']['coordinates']) == 2)? [ 'lng'=>$item['geometry']['coordinates'][0], 'lat'=>$item['geometry']['coordinates'][1] ]:[];

            $p['center'] = $center;
            $p['type'] = $item['geometry']['type'];
            $p['text'] = $item['properties']['streetName']??'No Street';
            $p['place'] = $item['properties']['streetName']??'No Street';
            $p['name'] = $item['properties']['streetName']??'No Street';
            $p['locality'] = $item['properties']['locality']??'No Locality';
            $p['country'] = $item['properties']['country']??'No Country';
            $p['countryCode'] = $item['properties']['countryCode']??'No Country Code';
            $p['bounds'] = $item['bounds']??[];

            $p['full'] = $item;

            $res[] = $p;
        }

        return response()->json([ 'result'=>'OK', 'places'=>$res ]);

    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Geocoder\Exception\Exception
     */
    public function postCode(Request $request)
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
    public function getRev(Request $request)
    {
        $geocoder = new \Geocoder\ProviderAggregator(); // or \Geocoder\TimedGeocoder
        $httpClient  = HttpClientDiscovery::find();

        $geocoder->registerProviders([
            new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient),
            new \Geocoder\Provider\OpenRouteService\OpenRouteService($httpClient, env('OPEN_ROUTE_KEY')),
//            new \Geocoder\Provider\BingMaps\BingMaps($httpClient, '<FAKE_API_KEY>'), // throws InvalidCredentialsException
//            new \Geocoder\Provider\Yandex\Yandex($httpClient),
//            new \Geocoder\Provider\FreeGeoIp\FreeGeoIp($httpClient),
//            new \Geocoder\Provider\Geoip\Geoip(),
        ]);

        try {
            $geotools = new \League\Geotools\Geotools();
            $cache    = new \Cache\Adapter\PHPArray\ArrayCachePool();

            $results  = $geotools->batch($geocoder)->setCache($cache)->geocode([
                'Paris, France',
                'Copenhagen, Denmark',
//                '74.200.247.59',
//                '::ffff:66.147.244.214'
            ])->serie();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $geojson = [];
        $dumper = new \Geocoder\Dumper\GeoArray();
        foreach ($results as $result) {
            // if a provider throws an exception (UnsupportedException, InvalidCredentialsException ...)
            // an custom /Geocoder/Result/Geocoded instance is returned which embedded the name of the provider,
            // the query string and the exception string. It's possible to use dumpers
            // and/or formatters from the Geocoder library.

            $gr = $result->all();
            if(is_array( $gr )){
                foreach ($result->all() as $g){
                    $geojson[] = $dumper->dump($g);
                }
            }

        }

        return response()->json($geojson);

    }

    public function postRev(Request $request)
    {

        $geotools   = new \League\Geotools\Geotools();
        $coordinate = new \League\Geotools\Coordinate\Coordinate('40.446195, -79.948862');
        $converted  = $geotools->convert($coordinate);
// convert to decimal degrees without and with format string
        printf("%s\n", $converted->toDecimalMinutes()); // 40 26.7717N, -79 56.93172W
        printf("%s\n", $converted->toDM('%P%D°%N %p%d°%n')); // 40°26.7717 -79°56.93172
// convert to degrees minutes seconds without and with format string
        printf("%s\n", $converted->toDegreesMinutesSeconds('<p>%P%D:%M:%S, %p%d:%m:%s</p>')); // <p>40:26:46, -79:56:56</p>
        printf("%s\n", $converted->toDMS()); // 40°26′46″N, 79°56′56″W
// convert in the UTM projection (standard format)
        printf("%s\n", $converted->toUniversalTransverseMercator()); // 17T 589138 4477813
        printf("%s\n", $converted->toUTM()); // 17T 589138 4477813 (alias)
    }

    /*
     * @param: algo
     * supported algorithms :
     * flat, haversine, vincenty, greatCircle
     * units :
     * km, mi, ft
     * */
    public function postDistance(Request $request)
    {
        $in = $request->all();
        $from = [ doubleval($in['fromlat']), doubleval($in['fromlng'])  ];
        $to = [ doubleval($in['tolat']), doubleval($in['tolng'])  ];

        $unit = $request->has('unit')?$request->input('unit'): 'km';
        $algo = $request->has('algo')?$request->input('algo'): 'flat';

        $distance = GeoUtil::getDistance($from, $to, $unit, $algo);

        return response()->json(['distance'=>$distance, 'from'=>$from, 'to'=>$to, 'unit'=>$unit, 'algo'=>$algo ]);
    }

}
