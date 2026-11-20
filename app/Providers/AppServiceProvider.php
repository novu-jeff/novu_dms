<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\OrganizationSetting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $settings = OrganizationSetting::query()->first();

            $view->with([
                'organizationName' => $settings?->organization_name
                    ?? config('app.name', 'Organization'),

                'organizationLogo' => $settings?->organization_logo,

                'systemName' => $settings?->system_name
                    ?? 'Document Management System',

                'systemLogo' => $settings?->system_logo,
            ]);
        });
    }
}
