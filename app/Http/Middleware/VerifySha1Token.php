<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;
use Closure;

class VerifySha1Token
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        $body = $request->all();
        $secret = env('API_SIUKSHA1_SECRET', 'HJSpcADBgvuyf48n9YC25r0grfXQ0uOKfEwKeEaPZK8lvRFVgqsYy9a3gB7a986T');
        $xToken = ($request->hasHeader('X-Token')) ? $request->header('X-Token') : sha1(uniqid());
        $xApiKey = ($request->hasHeader('X-Api-Key')) ? $request->header('X-Api-Key') : null;

        $checksum  = sha1($secret . $xApiKey);

        if ($request->expectsJson()) {
            return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
        }

        if($xToken != $checksum) {
            $log['response'] = [
                'rc'    => 'ERR-SECURE-HASH',
                'msg'   => 'Checksum is invalid'
            ];
            return $this->responseError('ERR-SECURE-HASH', 'Checksum is invalid', 200);
        }

        return $next($request);
    }
}