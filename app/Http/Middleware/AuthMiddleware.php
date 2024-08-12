<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;
use Closure;

class AuthMiddleware
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
        if (! Auth::guard('api')->check()) {

            if ($request->expectsJson()) {
                return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
            }
    
            return redirect(RouteServiceProvider::LOGIN);
        }

        if (! Auth::guard('api')->user()->hasAnyRole($role)) {
            return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
        }
        
        return $next($request);
    }
}