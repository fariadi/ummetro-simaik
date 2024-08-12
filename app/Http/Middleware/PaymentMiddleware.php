<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;
use Closure;

class PaymentMiddleware
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
        $secret  = env('API_SIUKH2H_SECRET');
        $nomorPembayaran  = (isset($body['nomor'])) ? $body['nomor']  : uniqid();
        $tanggalTransaksi = (isset($body['tanggalTransaksi']))  ? $body['tanggalTransaksi']  : date('YmdHis');
        $requestChecksum  = (isset($body['checksum']))  ? $body['checksum']  : '';
        
        $checksum  = sha1($nomorPembayaran . $secret . $tanggalTransaksi);

        if ($request->expectsJson()) {
            return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
        }

        if($requestChecksum != $checksum) {
            $log['response'] = [
                'rc'    => 'ERR-SECURE-HASH',
                'msg'   => 'Checksum is invalid'
            ];
            return $this->responseError('ERR-SECURE-HASH', 'Checksum is invalid', 200);
        }

        return $next($request);
    }
}