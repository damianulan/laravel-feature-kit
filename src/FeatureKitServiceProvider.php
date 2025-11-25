<?php

namespace FeatureKit;

use FeatureKit\Console\Commands\ClearCache;
use FeatureKit\Console\Generators\FeatureMakeCommand;
use FeatureKit\Repositories\BaseRepository;
use FeatureKit\Repositories\JsonFeatureRepository;
use FeatureKit\Repositories\DatabaseFeatureRepository;
use Illuminate\Support\Facades\Blade;
use FeatureKit\Features;
use Illuminate\Support\ServiceProvider;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
class FeatureKitServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/featurekit.php', 'featurekit');

        $this->app->bind('FeatureRepository', function (): BaseRepository{
            return match(config('featurekit.connection')){
                'json' => new JsonFeatureRepository(),
                default => new DatabaseFeatureRepository()
            };
        });

        $this->app->singleton(Features::class);
    }

    /**
     * When this method is apply we have all laravel providers and methods available
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'featurekit');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/featurekit'),
        ], 'featurekit-langs');

        $this->publishes([
            __DIR__ . '/../config/featurekit.php' => config_path('featurekit.php'),
        ], 'featurekit-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/featurekit'),
        ], 'featurekit-views');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_features_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_features_table.php'),
        ], 'featurekit-migrations');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_features_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_features_table.php'),
            __DIR__ . '/../config/featurekit.php' => config_path('featurekit.php'),
        ], 'featurekit');

        $this->commands([
            FeatureMakeCommand::class,
            ClearCache::class
        ]);

        $this->registerBladeDirectives();
        MacroFactory::load();
        app(Features::class);
    }

    public function registerBladeDirectives(): void
    {
        Blade::directive('feature', function ($key): bool {
            return feature($key);
        });
    }
}
