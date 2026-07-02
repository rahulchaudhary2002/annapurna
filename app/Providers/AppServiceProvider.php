<?php

namespace App\Providers;

use App\Helpers\Cms;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('cms', fn () => new Cms());
    }

    public function boot(): void
    {
        // Register CMS blade directive
        Blade::directive('cms', function ($key) {
            return "<?php echo \App\Helpers\Cms::setting($key); ?>";
        });

        // Share global CMS data with all views
        view()->composer('*', function ($view) {
            if (!$view->offsetExists('cms_loaded')) {
                $view->with('cms_loaded', true);
            }
        });
    }
}
