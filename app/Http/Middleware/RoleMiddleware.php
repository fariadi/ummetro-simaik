<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Closure;

class RoleMiddleware
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
        if (!Auth::check()) {

            if ($request->expectsJson()) {
                return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
            }
    
            return redirect(RouteServiceProvider::LOGIN);
        }

        if (! Auth::user()->hasAnyRole($role)) {
            abort(401, 'This action is unauthorized.');
        }
        
        return $next($request);
    }
}