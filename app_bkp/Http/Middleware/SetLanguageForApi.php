<?php
namespace App\Http\Middleware;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Support\Facades\Session;

class SetLanguageForApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        \Debugbar::disable();

        if($locale = $request->get('lang'))
        {
            $languages = \Modules\Language\Models\Language::getActive();
            $localeCodes = Arr::pluck($languages,'locale');
            if(in_array($locale,$localeCodes)){
                app()->setLocale($locale);
            }else{
                app()->setLocale(setting_item('site_locale'));
            }
        }
        if ($currency = $request->get('_currency')) {
            Session::put('bc_current_currency', $currency);
        }
        return $next($request);
    }
}
