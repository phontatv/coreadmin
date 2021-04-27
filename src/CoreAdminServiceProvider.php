<?php

namespace Phobrv\CoreAdmin;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CoreAdminServiceProvider extends ServiceProvider {

	public function boot(): void{

		Gate::before(function ($user, $ability) {
			return $user->hasRole('SuperAdmin') ? true : null;
		});

		view()->composer(
			'phobrv::*',
			'Phobrv\CoreAdmin\ViewComposers\AdminComposer'
		);

		$this->loadRepositories();
		$this->migrations();
		$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'phobrv');
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'phobrv');
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
		$this->loadRoutesFrom(__DIR__ . '/routes.php');

		if ($this->app->runningInConsole()) {
			$this->bootForConsole();
		}

	}

	public function register(): void{
		$this->app->singleton(\Phobrv\CoreAdmin\ViewComposers\AdminComposer::class);
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
			__DIR__ . '/../config/option.php' => config_path('option.php'),
			__DIR__ . '/../config/sidebar.php' => config_path('sidebar.php'),
		], 'coreadmin.config');

		// Publishing assets.
		$this->publishes([
			__DIR__ . '/../resources/assets/' => public_path('vendor/phobrv'),
		], 'coreadmin.assets');
		// Publishing the translation files.
		$this->publishes([
			__DIR__ . '/../resources/lang' => resource_path('lang'),
		], 'coreadmin.lang');

		// Publishing the views.
		// $this->publishes([
		// 	__DIR__ . '/../resources/views' => base_path('resources/views/vendor/phobrv'),
		// ], 'coreadmin.views');

		// Registering package commands.
		// $this->commands([]);
	}

	public function migrations() {
		$this->loadMigrationsFrom(__DIR__ . '/database/migrations');
		$this->publishes([
			__DIR__ . '/database/migrations/' => database_path('migrations'),
		], 'coreadmin.migrations');
	}

	public function defineMiddleware() {
		app('router')->aliasMiddleware('lang', \Phobrv\CoreAdmin\Http\Middleware\Lang::class);
	}

	protected function loadRepositories() {
		$this->app->bind(
			\Phobrv\CoreAdmin\Repositories\UserRepository::class,
			\Phobrv\CoreAdmin\Repositories\UserRepositoryEloquent::class
		);
		$this->app->bind(
			\Phobrv\CoreAdmin\Repositories\TermRepository::class,
			\Phobrv\CoreAdmin\Repositories\TermRepositoryEloquent::class
		);
		$this->app->bind(
			\Phobrv\CoreAdmin\Repositories\PostRepository::class,
			\Phobrv\CoreAdmin\Repositories\PostRepositoryEloquent::class
		);
		$this->app->bind(
			\Phobrv\CoreAdmin\Repositories\OptionRepository::class,
			\Phobrv\CoreAdmin\Repositories\OptionRepositoryEloquent::class
		);
		$this->app->bind(
			\Phobrv\CoreAdmin\Repositories\ReceiveDataRepository::class,
			\Phobrv\CoreAdmin\Repositories\ReceiveDataRepositoryEloquent::class
		);
		$this->app->bind(
			\Phobrv\CoreAdmin\Repositories\CommentRepository::class,
			\Phobrv\CoreAdmin\Repositories\CommentRepositoryEloquent::class
		);
		// $this->app->bind(
		// 	\Phobrv\CoreAdmin\Repositories\CrawlerDataRepository::class,
		// 	\Phobrv\CoreAdmin\Repositories\CrawlerDataRepositoryEloquent::class
		// );
		// $this->app->bind(
		// 	\Phobrv\CoreAdmin\Repositories\CrawlerProfileRepository::class,
		// 	\Phobrv\CoreAdmin\Repositories\CrawlerProfileRepositoryEloquent::class
		// );
	}
}
