<?php namespace WebEd\Base\ACL\Http\Middleware;

use \Closure;

class HasPermission
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  array|string $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        if (!$request->user()->hasPermission($permissions)) {
            return redirect()->to(route('admin::error', ['code' => 403]));
        }

        return $next($request);
    }
}
