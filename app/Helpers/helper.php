<?php

use App\Models\Banner;
use App\Models\Enums\UsedFor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Shopper\Framework\Models\Shop\Order\Order;
use Shopper\Framework\Models\Shop\Product\Product;

// use NumberFormatter;

if (! function_exists('price_quantity')) {

    function price_quantity(int $cents, int $quantity): int {
        return $cents * $quantity;
    }
}

if (! function_exists('price_quantity_format')) {

    function price_quantity_format(int $price, int $quantity): string {
        return price_formatted(price_quantity($price * 100, $quantity));
    }
}

if (! function_exists('price_formatted')) {

    function price_formatted(int $cents): string {
        $money = new Money($cents, new Currency(shopper_currency()));
        $currencies = new ISOCurrencies();

        $numberFormatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}

if (!function_exists('order_number')) {
    function order_number(int $length = 12, int $regenerated = 0) {
        $min = "";
        $max = "";
        for($i = 0; $i < $length; $i++) {
            $min .= "9";
            $max .= "1";
        }

        $generated = rand((int) $min, (int) $max);

        $find = Order::whereNumber($generated)->first();

        if (!$find) {
            return $generated;
        }

        if ($regenerated > 15) {
            order_number($length+1);
        }

        return order_number($length, $regenerated + 1);
    }
}

if (!function_exists('product_images')) {
    function product_images(Product $product): Fluent {
        $productImages = $product->getMedia('uploads');
        $images = [];
        $hover = null;
        $thumb = null;
        $index = 0;
        foreach ($productImages as $productImage) {
            if ($index === 0) {
                $thumb = $productImage->getUrl('thumb200x200');
            }
            elseif ($index === 1) {
                $hover = $productImage->getUrl('thumb200x200');
            }
            $images[] = $productImage->getUrl();
            $index++;
        }

        return new Fluent([
            'thumb' => $thumb ?? asset('frontend/assets/images/product-image/placeholder-images-image_large.webp'),
            'hover' => $hover,
            'all' => $images,
        ]);
    }
}

if (!function_exists('banners')) {
    function banners(UsedFor $for, bool $queryable = false): Collection|Builder {
        $banners = Banner::whereUsedFor($for);
        if ($queryable) {
            return $banners;
        }
        return $banners->get();
    }
}
if (!function_exists('banner_single')) {
    function banner_single(UsedFor $for, bool $randomize = true, ?Banner $ignore = null): Model {
        $banners = banners($for, true);
        if (!is_null($ignore)) {
            $banners->whereNotIn('id', [$ignore->id]);
        }
        if ($randomize) {
            return $banners->get()->random();
        }
        return $banners->latest()->first();
    }
}
if (!function_exists('banner_exists')) {
    function banner_exists(UsedFor $for, int $quantity = 1): bool {
        $banners = banners($for, true);
        return $banners->count() >= $quantity;
    }
}

if (! function_exists('slugify_model')) {

    /**
     * Creates a URL Friendly Unique Slug (also ignore if necessary)
     * It will also verify if it already exists, & if it does, append Str::random()
     * Example: this-is-a-friendly-slug
     * OR Example: this-is-a-friendly-slug-9rkt6
     *
     * @param \Illuminate\Database\Eloquent\Model|string $model
     * @param string|null $columnOrTitle Database Column for "title" or Title to Slugify
     * @param string|null $ignore Ignore a slug for Regeneration if slug is similar
     * @param string $slugColumn column used to check for duplicates
     * @param bool $regenrate Specifies if regeneration is done
     * @return string
     */
	function slugify_model(
        Model|string $model,
        string $columnOrTitle,
        ?string $ignore = null,
        string $slugColumn = 'slug',
        bool $regenerate = false
    ): string
	{
        $data = ($model instanceof Model) ?
                $model->$columnOrTitle :
                $columnOrTitle;

        (!$model instanceof Model && ($columnOrTitle == null OR $columnOrTitle == '')) ?
            throw(new \Exception('No Title Provided to Slugify')) : null;

        $slug = Str::slug($data);
        $ignore = ($model instanceof Model && $ignore === null) ?
                    $model->$slugColumn : $ignore;

        $slug = ($regenerate && $slug !== $ignore) ?
                $slug . '-' . Str::random(5) :
                $slug;

        $instance = ($model instanceof Model) ?
                    get_class($model) :
                    $model;

        $lookup = ($slug !== $ignore) ?
                    $instance::where($slugColumn, $slug)->first() :
                    false;

		return ($lookup) ?
                slugify_model(
                    $model,
                    $columnOrTitle,
                    $ignore,
                    $slugColumn,
                    regenerate: true
                ) : $slug;
	}
}
