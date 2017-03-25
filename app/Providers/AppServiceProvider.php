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

            if($menus = Helpers::getMenu()){
                $ret = "";

                foreach($menus as $menu) {
                    $submenus=Helpers::getSubMenu($menu->short_name);
                    if($submenus) {
                        $ret .= "<li>
                                <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-th-large'></i>";
                        $ret .= "<span class='nav-label'>".__('menu.'.$menu->short_name)."<span class='caret'></span></span></a>
                                <ul class='dropdown-menu animated fadeInRight m-t-xs'>       
                                       <li><a href='".url($menu->short_name)."'><i class='fa fa-th-large'></i>".__('menu.'.$menu->short_name)."</a>";

                        foreach($submenus as $submenu) {
                            $ret .= "<li><a href='".url($submenu)."' ><i class='fa fa-th-large'></i>".__('menu.' . $submenu)."</a></li>";
                        }
                        $ret .= "</ul></li>";
                    } else {
                        $ret .= "<li><a href='".url($menu->short_name)."'><i class='fa fa-th-large'></i><span class='nav-label'>".__('menu.'.$menu->short_name)."</span></a></li>";
                    }
                }
                $ret .= "<li>
                        <a href='".route('logout')."' class='text-critical'onClick=\"return confirm('".__('menu.confirmLogout')."')\"><i class='fa fa-th-large'></i><span class='nav-label'>".__('menu.logout')."</span></a>
                        </li>
                        </ul></nav>";

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
