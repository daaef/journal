<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
class SubSubCategoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */

    public function register()
    {
        $this->app->bind('App\Repositories\SubSubCategory\SubSubCategoryContract',
            'App\Repositories\SubSubCategory\EloquentSubSubCategoryRepository');
    }
}
