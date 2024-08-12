<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;
use Closure;

class PesertaMiddleware
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
        if (!Auth::check() && !Auth::guard('peserta')->check()) {
            if ($request->expectsJson()) {
                return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
            }
    
            return redirect(RouteServiceProvider::LOGIN);
        }

        if (Auth::check()) {
            //return $this->responseError($role, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
            if (Auth::user()->hasAnyRole($role)) {
                return $next($request);
            }
        }

        
        if (!Auth::guard('peserta')->check()) {
            if ($request->expectsJson()) {
                return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
            }
            return redirect(RouteServiceProvider::LOGIN);
        }
        
        /*
        if (! Auth::guard('mahasiswa')->user()->hasAnyRole($role)) {
            abort(401, 'This action is unauthorized.');
        }
        */
        
        return $next($request);
    }
}