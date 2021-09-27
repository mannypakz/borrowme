<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        Schema::defaultStringLength(191);

        if (Schema::hasTable('menus')) {
            $menus = DB::table('menus')->get();
            $menu = count($menus) > 0 ? $menus : null;
            view()->share('menu', $menu);

            $json = json_decode($menu[0]->menu_json);
            $categories = [];
            foreach($json[0] as $j) { // parent
                $categories[$j->name] = [];
                if(count($j->children[0])) {
                    foreach($j->children[0] as $k) { // 1st child
                        $categories[$j->name][$k->name] = [];
                        if(count($k->children[0])) {
                            foreach($k->children[0] as $l) {
                                $categories[$j->name][$k->name][] = $l->name;
                            }
                        }
                    }
                }
            }
            $output = json_encode($categories);
            view()->share('json_obj', $output);
        }

    }
}
