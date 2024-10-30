<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

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
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['en', 'id'])
                ->labels([
                    'en' => 'English',
                    'id' => 'Indonesian',
                ])
                ->flags([
                    'en' => asset('img/flags/en.png'),
                    'id' => asset('img/flags/id.png'),
                ])
                // ->flagsOnly()
                ->circular()
                ->visible(outsidePanels: true); // also accepts a closure
        });

        Table::$defaultNumberLocale = 'id';
    }
}
