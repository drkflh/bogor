<?php
namespace App\Helpers;

use Illuminate\Http\Request;


use App\Models\Core\PrintCache;

class PrintUtil
{
    public function __construct()
    {

    }

    public static function processPrintTemplate($key, $data)
    {

        unset($data['raw_json']);

        $d = new PrintCache();

        $jstr = json_encode($data);

        debug($jstr);

        $jstr = preg_replace('/\$/', '', $jstr);

        debug($jstr);

        $jdata = json_decode($jstr, true);

        debug($jdata);

        $data = $jdata;

        $d->content = $data;

        $d->save();

        if( env('PRINT_AS_PDF', false)){
            return response()->json(['result'=>'OK', 'printurl'=>url( 'pdf/'.$key.'/'.$d->_id ) ], 200);
        }else{
            return response()->json(['result'=>'OK', 'printurl'=>url( 'print/'.$key.'/'.$d->_id ) ], 200);
        }

    }

}
