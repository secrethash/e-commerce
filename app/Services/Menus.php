<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Shopper\Framework\Models\Shop\Product\Category;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class Menus {

    /**
     * Main Menu
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    public static function main(): Menu
    {
        $categories = Category::enabled()->get()->all();
        $carBrands = Brand::enabled()->notAftermarket()->get()->all();
        $aftermarket = Brand::enabled()->aftermarket()->get()->all();

        return Menu::new()
            ->addClass('menu-content')
            ->route('home', 'Home')
            ->submenu(
                Link::to('#', 'Category ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
                Menu::build($categories, function(Menu $menu, Category $category) {
                    $menu->route('shop.category', $category->name, $category->slug);
                })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
            )
            ->submenu(
                Link::to('#', 'Car Brands ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
                Menu::build($carBrands, function(Menu $menu, Brand $brand) {
                    $menu->route('shop.index', $brand->name, ['brands' => $brand->slug]);
                })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
            )
            ->submenu(
                Link::to('#', 'Aftermarket Brands ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
                Menu::build($aftermarket, function(Menu $menu, Brand $brand) {
                    $menu->route('shop.index', $brand->name, ['brands' => $brand->slug]);
                })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
            )
            ->add(Link::toRoute(
                'shop.index',
                'New Arrivals',
                ['new-arrivals' => 1]
            ))
            ->link('#', 'Offer Products')
            ->link('#', 'About')
            ->link('#', 'Contact');
    }

    /**
     * Main Menu for Mobile Devices
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    public static function mainMobile(): Menu
    {
        $categories = Category::enabled()->get()->all();
        $carBrands = Brand::enabled()->notAftermarket()->get()->all();
        $aftermarket = Brand::enabled()->aftermarket()->get()->all();

        return Menu::new()
            // ->addClass('menu-content')
            ->route('home', 'Home')
            ->submenu(
                Link::to('#', 'Category'),
                Menu::build($categories, function(Menu $menu, Category $category) {
                    $menu->route('shop.category', $category->name, $category->slug);
                })
                // ->addParentClass('menu-dropdown')
                ->addClass('sub-menu')
            )
            ->submenu(
                Link::to('#', 'Car Brands'),
                Menu::build($carBrands, function(Menu $menu, Brand $brand) {
                    $menu->route('shop.index', $brand->name, ['brands' => $brand->slug]);
                })
                // ->addParentClass('menu-dropdown')
                ->addClass('sub-menu')
            )
            ->submenu(
                Link::to('#', 'Aftermarket Brands'),
                Menu::build($aftermarket, function(Menu $menu, Brand $brand) {
                    $menu->route('shop.index', $brand->name, ['brands' => $brand->slug]);
                })
                // ->addParentClass('menu-dropdown')
                ->addClass('sub-menu')
            )
            ->add(Link::toRoute(
                'shop.index',
                'New Arrivals',
                ['new-arrivals' => 1]
            ))
            ->link('#', 'Offer Products')
            ->link('#', 'About')
            ->link('#', 'Contact');
    }

    public static function categories(): Menu
    {
        $categories = Category::enabled()->whereNull('parent_id')->limit(10)->get()->all();
        $itemIndex = 1;
        return Menu::build($categories, function(Menu $menu, Category $category) use($itemIndex) {
            $children = Category::where('parent_id', $category->id)->get();
            if ($children->count() >= 1) {
                $menu->submenu(
                    Link::to('#', $category->name . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
                    Menu::build($children->all(), function(Menu $menu, $child) use($itemIndex) {
                        $menu->route(
                            'shop.category',
                            $child->name,
                            $child->slug
                        );
                    })->addClass("category-mega-menu category-mega-menu-{$itemIndex}")
                    ->addParentClass("menu-item-has-children menu-item-has-children-{$itemIndex}")
                );
            } else {
                $menu->route(
                    'shop.category',
                    $category->name,
                    $category->slug
                );
            }
            $itemIndex++;
        });
    }
}
