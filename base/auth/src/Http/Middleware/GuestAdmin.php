<?php namespace WebEd\Base\Auth\Http\Middleware;

use \Closure;

class GuestAdmin
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth($guard)->check()) {
            return redirect()->to(route('admin::pages.index.get'));
        }

        return $next($request);
    }
}
