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
            $menus = Helpers::getMenu();
            $ret = "<p>".ucwords(strtolower(Auth::user()->name))."</p>";
            $ret .= "<ul class='nav navbar-nav'>";
            //$ret .= "<li class='nav-divider'></li>";
            //$ret .= "<li><a href='' class='text-success'>Home</a></li>";
            $ret .= "<li class='nav-divider'></li>";
            foreach($menus as $menu) {
                $submenus=Helpers::getSubMenu($menu->short_name);
                if($submenus) {
                    $ret .= "<li class='dropdown'><a href='#'  class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>".__('menu.'.$menu->short_name)."<span class='caret'></span></a></li>";
                    $ret .= "<ul class='dropdown-menu' role='menu'>";
                    $ret .= "<li><a href='". url($menu->short_name) ."' role='button' aria-expanded='false'>".__('menu.'.$menu->short_name)."</a></li>";
                    foreach($submenus as $submenu) {
                        $ret .= "<li><a href='" . url($submenu) . "' role='button' aria-expanded='false'>" . __('menu.' . $submenu) . "</span></a></li>";
                    }
                    $ret .= "</ul>";
                } else {
                    $ret .= "<li><a href='". url($menu->short_name) ."' role='button' aria-expanded='false'>".__('menu.'.$menu->short_name)."</span></a></li>";
                }
            }
            $ret .= "</ul>";
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
