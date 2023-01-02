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
    const PAGE_TYPE = 'dynamic-pages';
    const CATEGORY_TYPE = 'category-link';
    const BRAND_TYPE = 'car-brands-link';
    const AFTERMARKET_TYPE = 'aftermarket-brands-link';

    /**
     * Main Menu
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    public static function main(): Menu
    {
        $mainMenu = FilamentNavigation::get('main-menu');

        $menu = Menu::new()
            ->addClass('menu-content');
        foreach ($mainMenu->items as $item) {
            $item = new Fluent($item);

            $link = static::createLink($item, Html::raw('<i class="ion-ios-arrow-down"></i>')->render());

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
        return $menu;
    }

    /**
     * Main Menu for Mobile Devices
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    public static function mainMobile(): Menu
    {
        $mainMenu = FilamentNavigation::get('main-menu');

        $menu = Menu::new();
            // ->addClass('menu-content');
        foreach ($mainMenu->items as $item) {
            $item = new Fluent($item);

            $link = static::createLink($item);

            if($item->children) {
                $menu->submenu(
                    $link,
                    Menu::build($item->children, function(Menu $menu, $child) {
                        $child = new Fluent($child);
                        $menu->add(static::createLink($child), $child->label);
                    })->addClass('sub-menu')
                );
            } else {
                $menu->add($link);
            }
        }
        return $menu;
    }

    /**
     * Footer Menu
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    public static function footer(bool $additional = false): Menu
    {
        $mainMenu = FilamentNavigation::get(
            ($additional) ? 'footer-custom-links-add' : 'footer-custom-links'
        );

        $menu = Menu::new()
            ->addClass('align-items-center');

        foreach ($mainMenu->items as $item) {
            $item = new Fluent($item);

            $link = static::createLink($item);

            $menu->add($link);
        }
        return $menu;
    }

    /**
     * Footer Horizontal Menu
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    public static function footer_horizontal(): Menu
    {
        $mainMenu = FilamentNavigation::get('footer-horizontal');

        $menu = Menu::new();

        foreach ($mainMenu->items as $item) {
            $item = new Fluent($item);

            $link = static::createLink($item);

            $menu->add($link);
        }
        return $menu;
    }

    /**
     * Create a Menu link Item
     *
     * @param \Illuminate\Support\Fluent $item
     * @param string $parentIcon
     * @return \Spatie\Menu\Item
     */
    protected static function createLink($item, $parentIcon = ''): Item
    {
        $link = null;
        $icon = $item->children ? $parentIcon : '';

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
        elseif ($item->type === static::PAGE_TYPE) {
            $link = Link::toRoute(
                'pages',
                "{$item->label} " . $icon,
                $item->data['dynamic_pages']
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
