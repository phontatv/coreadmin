<?php
namespace Phobrv\CoreAdmin\Http\Middleware;

use Auth;
use Closure;

class Lang {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$user = Auth::user();
		if ($user->userMetas) {
			$admin_locale = $user->userMetas->where('key', 'admin_locale')->first();
			$locale = ($admin_locale) ? $admin_locale->value : config('app.locale');
		}
		\App::setLocale(isset($locale) ? $locale : config('app.locale'));
		return $next($request);
	}
}
