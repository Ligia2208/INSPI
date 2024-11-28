<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CoreBase\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $count = Menu::count();
        $Menues = Menu::orderBy('orden', 'asc')->where('id','>','0')->where('estado','=','A')->get();

        Schema::defaultstringLength(191);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));
        View::share('menues', $Menues);
    }
}
