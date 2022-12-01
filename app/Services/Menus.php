<?php

namespace App\Services;

use App\Models\Brand;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Fluent;
use RyanChandler\FilamentNavigation\Facades\FilamentNavigation;
use Shopper\Framework\Models\Shop\Product\Category;
use Spatie\Menu\Item;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class Menus {

    const LINK_TYPE = 'external-link';
    const ROUTE_TYPE = 'route';
    const CATEGORY_TYPE = 'category-link';
    const BRAND_TYPE = 'car-brands-link';
    const AFTERMARKET_TYPE = 'aftermarket-brands-link';

    /**
     * Main Menu
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    // public static function main(): Menu
    // {
    //     $categories = Category::enabled()->get()->all();
    //     $carBrands = Brand::enabled()->notAftermarket()->get()->all();
    //     $aftermarket = Brand::enabled()->aftermarket()->get()->all();

    //     return Menu::new()
    //         ->addClass('menu-content')
    //         ->route('home', 'Home')
    //         ->submenu(
    //             Link::to('#', 'Category ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
    //             Menu::build($categories, function(Menu $menu, Category $category) {
    //                 $menu->route('shop.category', $category->name, $category->slug);
    //             })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
    //         )
    //         ->submenu(
    //             Link::to('#', 'Car Brands ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
    //             Menu::build($carBrands, function(Menu $menu, Brand $brand) {
    //                 $menu->route('shop.index', $brand->name, ['brands' => $brand->slug]);
    //             })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
    //         )
    //         ->submenu(
    //             Link::to('#', 'Aftermarket Brands ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
    //             Menu::build($aftermarket, function(Menu $menu, Brand $brand) {
    //                 $menu->route('shop.index', $brand->name, ['brands' => $brand->slug]);
    //             })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
    //         )
    //         ->add(Link::toRoute(
    //             'shop.index',
    //             'New Arrivals',
    //             ['new-arrivals' => 1]
    //         ))
    //         ->link('#', 'Offer Products')
    //         ->link('#', 'About')
    //         ->link('#', 'Contact');
    // }
    public static function main(): Menu
    {
        $mainMenu = FilamentNavigation::get('main-menu');

        $menu = Menu::new()
            ->addClass('menu-content');
        foreach ($mainMenu->items as $item) {
            $item = new Fluent($item);

            $link = static::createLink($item);

            if($item->children) {
                $menu->submenu(
                    $link,
                    Menu::build($item->children, function(Menu $menu, $child) {
                        $child = new Fluent($child);
                        $menu->add(static::createLink($child), $child->label);
                    })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
                );
            } else {
                $menu->add($link);
            }
        }
            // ->route('home', 'Home')
            // ->submenu(
            //     Link::to('#', 'Category ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
            //     Menu::build($categories, function(Menu $menu, Category $category) {
            //         $menu->route('shop.category', $category->name, $category->slug);
            //     })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
            // )
            // ->submenu(
            //     Link::to('#', 'Car Brands ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
            //     Menu::build($carBrands, function(Menu $menu, Brand $brand) {
            //         $menu->route('shop.index', $brand->name, ['brands' => $brand->slug]);
            //     })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
            // )
            // ->submenu(
            //     Link::to('#', 'Aftermarket Brands ' . Html::raw('<i class="ion-ios-arrow-down"></i>')->render()),
            //     Menu::build($aftermarket, function(Menu $menu, Brand $brand) {
            //         $menu->route('shop.index', $brand->name, ['brands' => $brand->slug]);
            //     })->addParentClass('menu-dropdown')->addClass('main-sub-menu')
            // )
            // ->add(Link::toRoute(
            //     'shop.index',
            //     'New Arrivals',
            //     ['new-arrivals' => 1]
            // ))
            // ->link('#', 'Offer Products')
            // ->link('#', 'About')
            // ->link('#', 'Contact');
        return $menu;
    }

    protected static function createLink($item): Item
    {
        $link = null;
        $icon = $item->children ? Html::raw('<i class="ion-ios-arrow-down"></i>')->render() : '';

        if ($item->type === static::LINK_TYPE) {
            $link = Link::to(
                $item->data['url'],
                "{$item->label} " . $icon
            );
        }
        elseif ($item->type === static::BRAND_TYPE) {
            $link = Link::toRoute(
                'shop.index',
                "{$item->label} " . $icon,
                [
                    'brands' => $item->data['car_brand_id'],
                ]
            );
        }
        elseif ($item->type === static::AFTERMARKET_TYPE) {
            $link = Link::toRoute(
                'shop.index',
                "{$item->label} " . $icon,
                [
                    'brands' => $item->data['aftermarket_brand_id'],
                ]
            );
        }
        elseif ($item->type === static::CATEGORY_TYPE) {
            $link = Link::toRoute(
                'shop.category',
                "{$item->label} " . $icon,
                [
                    'category' => $item->data['category_id'],
                ]
            );
        } else {
            throw new Exception('Invalid Item Type provided in Dynamic Menu.');
        }

        return $link;
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
