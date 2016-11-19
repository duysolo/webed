<?php namespace WebEd\Base\ACL\Http\Middleware;

use \Closure;

class HasRole
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  array|string $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!$request->user()->hasRole($roles)) {
            return redirect()->to(route('admin::error', ['code' => 403]));
        }

        return $next($request);
    }
}
