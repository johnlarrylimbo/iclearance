<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Collection;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModels();
        $this->configureURL();
        // $this->configureSocialite();

        // $this->registerMacroPaginator();
    }



    /**
     * Summary of configureCommands
     * @return void
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            app()->isProduction()
        );
    }

    /**
     * Summary of configureModel
     * configure the models to be strict
     * @return void
     */
    private function configureModels(): void
    {
        Model::shouldBeStrict();
        Model::unguard();
    }

    /**
     * Summary of configureURL
     * configure the URL to be forced to https when production
     * @return void
     */
    private function configureURL(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }
    }

    /**
     * Summary of registerMacroPaginator
     * Add a `paginate` macro to the Collection class
     * @return void
     */
    // private function registerMacroPaginator(): void
    // {
    //     if (!Collection::hasMacro('paginate')) {
    //         Collection::macro(
    //             'paginate',
    //             function ($perPage = 15, $page = null, $options = []) {
    //                 $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //                 return (new LengthAwarePaginator(
    //                     $this->forPage($page, $perPage),
    //                     $this->count(),
    //                     $perPage,
    //                     $page,
    //                     $options
    //                 ))
    //                     ->withPath('');
    //             }
    //         );
    //     }
    // }
}
