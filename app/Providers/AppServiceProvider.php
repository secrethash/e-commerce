<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Enums\UsedFor;
use App\Models\Tax;
use App\Services\Menus;
use App\Services\Taxation;
use Beier\FilamentPages\Models\FilamentPage;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use RyanChandler\FilamentNavigation\Facades\FilamentNavigation;
use Shopper\Framework\Models\Shop\Order\OrderStatus;
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

        View::share('customMenu', fn (): Menus => new Menus());
        View::share('taxation', fn (Tax $tax, int $amount): int => Taxation::fromTax($tax, $amount));
        View::share('usedForEnum', fn ($from): UsedFor => UsedFor::from($from));
        View::share('orderStatus', OrderStatus::class);

        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make('manage-store')
                    ->label('Manage Store')
                    ->icon('heroicon-o-adjustments')
                    ->activeIcon('heroicon-s-adjustments')
                    ->url(route('shopper.dashboard'))
                    ->openUrlInNewTab()
                    ->group('extra')
                    ->sort(100),
                NavigationItem::make('view-store')
                    ->label('View Store')
                    ->icon('heroicon-o-shopping-bag')
                    ->activeIcon('heroicon-s-shopping-bag')
                    ->url(route('home'))
                    ->openUrlInNewTab()
                    ->group('extra')
                    ->sort(101),
            ]);
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Manage Store')
                    ->icon('heroicon-o-adjustments')
                    ->url(route('shopper.dashboard'))
                    ->sort(100),
                UserMenuItem::make()
                    ->label('View Store')
                    ->icon('heroicon-o-shopping-bag')
                    ->url(route('home'))
                    ->sort(101),
            ]);

            // Change Theme Colors
            $primaryColor = '#2a1baf'; // For example, put your tenant primary color here
            $secondaryColor = '#BBAA87'; // For example, put your tenant secondary color here

            Filament::pushMeta([
                new HtmlString('<meta name="theme-primary-color" id="theme-primary-color" content="' . $primaryColor . '" />' .
                    '<meta name="theme-secondary-color" id="theme-secondary-color" content="' . $secondaryColor . '" />'),
            ]);
        });

        $this->registerNavigationTypes();

    }

    protected function registerNavigationTypes(): void
    {
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
        FilamentNavigation::addItemType('Dynamic Pages', [
            Select::make('dynamic_pages')
                ->label('Page')
                ->searchable()
                ->options(function () {
                    return FilamentPage::all()->pluck('title', 'slug');
                })
        ]);
    }
}
