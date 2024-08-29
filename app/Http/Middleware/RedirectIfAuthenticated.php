<?php



namespace App\Http\Middleware;



use App\Providers\RouteServiceProvider;

use Closure;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;



class RedirectIfAuthenticated

{

    /**

     * Handle an incoming request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next

     * @param  string|null  ...$guards

     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse

     */

    public function handle(Request $request, Closure $next, ...$guards)

    {

        $guards = empty($guards) ? [null] : $guards;



        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
// dd(Auth::guard($guard)->user()->hasRole('user'));
                if(auth()->user()->hasRole(['super admin','tutor','user'])){

                    // dd(RouteServiceProvider::HOME);
                    return redirect(RouteServiceProvider::HOME);

                }else{

                    return redirect()->route('front.index');

                }

                

            }

        }



        return $next($request);

    }

}

