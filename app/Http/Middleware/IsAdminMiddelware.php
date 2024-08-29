<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\V1\DashboardController;

class IsAdminMiddelware
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
        // if(!auth()->check() || !auth()->user->role){
        //     abort(403);
        // }
        if (auth()->check() && auth()->user()->role == 2) {
            $permission = Permission::Where('sub_admin_id', auth()->user()->id)->first();
            $actionRoute = Route::currentRouteName();
            $routeName = Str::after(Str::replace('.', '_', $actionRoute), 'admin_v1_');
            if (Str::endsWith($routeName, 'list')) {
                $routeName = Str::replace('list', 'view', $routeName);
            }
            if ($permission->$routeName) {
                return $next($request);
            }else{
                return redirect('home');
            }
        }
        return $next($request);
    }
}
