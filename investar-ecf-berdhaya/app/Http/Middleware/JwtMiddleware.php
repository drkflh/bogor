<?php

namespace App\Http\Middleware;

use App\Models\Core\Mongo\TokenBlacklist;
use App\Models\Core\Mongo\User;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $secretKey = file_get_contents( base_path('k/mkey.pem') );

        //$token = $request->get('token');
        $token = str_replace( 'Bearer', '', $request->header('Authorization') );
        $token = trim($token);

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        if($token){
            $tk = TokenBlacklist::where('token','=', $token )->count();
            if($tk > 0){
                return response()->json([
                    'error' => 'Unauthorized token.'
                ], 401);
            }
        }

        try {
            $credentials = JWT::decode($token, $secretKey, ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Error while decoding token.'
            ], 401);
        }

        $request->auth = $credentials->usr;

        return $next($request);
    }
}
