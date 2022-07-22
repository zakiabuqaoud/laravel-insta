<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator as ValidationValidator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('app_name', config('app.name'));

        Validator::extend('content', function($attribute, $value, $parameters, $validator) {
            foreach ($parameters as $word) {
                if (strpos($value, $word) !== false) {
                    $validator->errors()->add($attribute, 'You can not use theses words: ' . implode(', ', $parameters));
                    return false;
                }
            }
            return true;
        }, 'Some words are not allowed');

        Paginator::defaultView('vendor.pagination.bootstrap-4');
        Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4');
    }
}
