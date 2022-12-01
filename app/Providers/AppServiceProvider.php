<?php

namespace App\Providers;

use App\Models\Brand;
use App\Services\Menus;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use RyanChandler\FilamentNavigation\Facades\FilamentNavigation;
use Shopper\Framework\Models\Shop\Product\Category;

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
        Paginator::useBootstrapFive();
        Filament::serving(function () {
            // Using Vite
            // Filament::registerViteTheme('resources/css/filament.css');

            // Using Laravel Mix
            // Filament::registerTheme(
            //     mix('css/filament.css'),
            // );

            // ...
            $primaryColor = '#2a1baf'; // For example, put your tenant primary color here
            $secondaryColor = '#BBAA87'; // For example, put your tenant secondary color here

            Filament::pushMeta([
                new HtmlString('<meta name="theme-primary-color" id="theme-primary-color" content="' . $primaryColor . '">' .
                    '<meta name="theme-secondary-color" id="theme-secondary-color" content="' . $secondaryColor . '">'),
            ]);
        });

        FilamentNavigation::addItemType('Category link', [
            Select::make('category_id')
                ->label('Category')
                ->searchable()
                ->options(function () {
                    return Category::pluck('name', 'slug');
                })
        ]);
        FilamentNavigation::addItemType('Car Brands link', [
            Select::make('car_brand_id')
                ->label('Car Brand')
                ->searchable()
                ->options(function () {
                    return Brand::notAftermarket()->pluck('name', 'slug');
                })
        ]);
        FilamentNavigation::addItemType('Aftermarket Brands link', [
            Select::make('aftermarket_brand_id')
                ->label('Aftermarket Brand')
                ->searchable()
                ->options(function () {
                    return Brand::aftermarket()->pluck('name', 'slug');
                })
        ]);
    }
}
