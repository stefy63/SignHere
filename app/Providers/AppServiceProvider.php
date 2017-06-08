<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Support\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if(env('APP_ENV') !== 'local')
        {
            $url->forceSchema('https');
        }


        Validator::extend('sign_format', function($attribute, $value, $parameters, $validator) {
            $tplLine = explode("\n",$value);
            $ret = true;
            foreach ($tplLine as $line) {
                if(!preg_match_all('/(\d+)\|(\d+)\|(\d+)\|[OM]\|*/s',$line)) {
                    $ret = false;
                }
            }
            return $ret;
        });
        Validator::extend('question_format', function($attribute, $value, $parameters, $validator) {
            $tplLine = explode("\n",$value);
            $ret = true;
            foreach ($tplLine as $line) {
                if($line != "" && !preg_match_all('/(\d+)\|(\d+)\|(\d+)\|(\d+)\|(\d+)\|.*/',$line)) {
                    $ret = false;
                }
            }
            return $ret;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //
    }
}
