<?php

namespace Phobrv\CoreAdmin;

use Illuminate\Support\ServiceProvider;

class CoreAdminServiceProvider extends ServiceProvider {

	public function boot(): void{
		$this->loadRepositories();
		$this->migrations();
		// $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'phobrv');
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'phobrv');
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
		$this->loadRoutesFrom(__DIR__ . '/routes.php');

		if ($this->app->runningInConsole()) {
			$this->bootForConsole();
		}

	}

	public function register(): void{
		$this->mergeConfigFrom(__DIR__ . '/../config/coreadmin.php', 'coreadmin');
		$this->mergeConfigFrom(__DIR__ . '/../config/sidebar.php', 'sidebar');

		$this->defineMiddleware();

		$this->app->singleton('coreadmin', function ($app) {
			return new CoreAdmin;
		});
	}

	public function provides() {
		return ['coreadmin'];
	}

	protected function bootForConsole(): void{
		// Publishing the configuration file.
		$this->publishes([
			__DIR__ . '/../config/coreadmin.php' => config_path('coreadmin.php'),
		], 'coreadmin.config');
		$this->publishes([
			__DIR__ . '/../config/sidebar.php' => config_path('sidebar.php'),
		], 'coreadmin.config');

		// Publishing the views.
		// $this->publishes([
		// 	__DIR__ . '/../resources/views' => base_path('resources/views/vendor/phobrv'),
		// ], 'coreadmin.views');

		// Publishing assets.
		// echo __DIR__ . '/../resources/assets/';
		$this->publishes([
			__DIR__ . '/../resources/assets/' => public_path('vendor/phobrv'),
		], 'coreadmin.views');

		// Publishing the translation files.
		// $this->publishes([
		// __DIR__.'/../resources/lang' => resource_path('lang/vendor/phobrv'),
		// ], 'coreadmin.views');

		// Registering package commands.
		// $this->commands([]);
	}

	public function migrations() {
		$this->loadMigrationsFrom(__DIR__ . '/database/migrations');
		// $this->publishes([
		// 	__DIR__ . '/database/migrations/' => database_path('migrations'),
		// ], $this->packageName . '-migrations');
	}

	public function defineMiddleware() {
		app('router')->aliasMiddleware('lang', \Phobrv\CoreAdmin\Http\Middleware\Lang::class);
	}

	protected function loadRepositories() {
		$this->app->bind(
			\Phobrv\CoreAdmin\Repositories\UserRepository::class,
			\Phobrv\CoreAdmin\Repositories\UserRepositoryEloquent::class
		);
	}
}
