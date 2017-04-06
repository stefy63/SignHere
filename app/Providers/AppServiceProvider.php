<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Support\Helpers;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('menu', function (){

            if($menus = \Auth::user()->getModules()){
                $ret = "";

                foreach($menus as $menu) {
                    $ret .= "<li><a href='".url($menu->short_name)."'><i class='".$menu->icon."'></i>
                            <span class='nav-label'>".__($menu->short_name.".".$menu->short_name)."</span></a></li>";
                }

                return $ret;
            } else {
                return '';
            }
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
