<?php

namespace Phobrv\CoreAdmin;

use Illuminate\Support\ServiceProvider;

class CoreAdminServiceProvider extends ServiceProvider {

	public function boot(): void{
		$this->loadRepositories();
		// $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'phobrv');
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'phobrv');
		// $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
		$this->loadRoutesFrom(__DIR__ . '/routes.php');
		// Publishing is only necessary when using the CLI.
		if ($this->app->runningInConsole()) {
			$this->bootForConsole();
		}

	}

	public function register(): void{
		$this->mergeConfigFrom(__DIR__ . '/../config/coreadmin.php', 'coreadmin');

		// Register the service the package provides.
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

		// Publishing the views.
		/*$this->publishes([
		__DIR__.'/../resources/views' => base_path('resources/views/vendor/phobrv'),
		], 'coreadmin.views');*/

		// Publishing assets.
		/*$this->publishes([
		__DIR__.'/../resources/assets' => public_path('vendor/phobrv'),
		], 'coreadmin.views');*/

		// Publishing the translation files.
		/*$this->publishes([
		__DIR__.'/../resources/lang' => resource_path('lang/vendor/phobrv'),
		], 'coreadmin.views');*/

		// Registering package commands.
		// $this->commands([]);
	}

	protected function loadRepositories() {
		$this->app->bind(
			\Phobrv\CoreAdmin\Repositories\UserRepository::class,
			\Phobrv\CoreAdmin\Repositories\UserRepositoryEloquent::class
		);
	}
}
