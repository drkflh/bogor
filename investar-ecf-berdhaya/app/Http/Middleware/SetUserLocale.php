<?php

namespace App\Http\Middleware;

use App\Helpers\AuthUtil;
use App\Models\Core\Mongo\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class SetUserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( $request->has('lang')){
            $lang = $request->get('lang');
            if( isset($request->user()->_id)){
                $usr = User::find($request->user()->_id);
                if($usr){
                    $usr->lang = $lang;
                    $usr->save();
                }
            }
        }else{
            $lang = $request->user()->lang ?? env('DEFAULT_LANG');
        }
        App::setLocale( $lang );

        if(isset( $request->user()->_id )){
            $cartSession = $request->user()->cartSession ?? null;
            if(is_null($cartSession)){
                $cartSession = Str::random(16);
                $request->user()->cartSession = $cartSession;
                if( isset($request->user()->_id)){
                    $usr = User::find($request->user()->_id);
                    if($usr){
                        $usr->cartSession = $cartSession;
                        $usr->save();
                    }
                }
            }
        }

        return $next($request);
    }
}
