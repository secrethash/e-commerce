<?php

namespace App\Http\Livewire\Shop;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Framework\Models\Shop\Product\Category;
use Shopper\Framework\Models\Shop\Product\Product;

class Listing extends Component
{

    use WithPagination;

    public $layout = 'x3';

    public string $brands = '';

    public Collection $categories;

    public $category;

    protected $queryString = [
        'layout' => ['except' => 'x3'],
        'brands' => ['except' => ''],
    ];

    public function mount(): void
    {
        $this->categories = Category::enabled()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }

    public function changeLayout($layout): void
    {
        if ($layout === 1) {
            $this->layout = 'x1';
        } else {
            $this->layout = 'x3';
        }
    }

    protected function filter()
    {

        if (blank($this->brands) && !$this->category) {
            return Product::publish()->paginate(9)->withQueryString();
        }

        $products = new Collection;
        $categoryProducts = new Collection;
        $brands = !blank($this->brands) ? explode(',', $this->brands) : [];

        if ($this->category && $this->category->is_enabled) {
            $categoryProducts = $this->category->products()->paginate(9)->withQueryString();
        }

        if (count($brands) >= 1) {
            foreach ($brands as $value) {
                $brand = Brand::findBySlug($value);
                if ($brand) {
                    $categoryProducts->each(function($item) use($products, $brand) {
                        if ($brand->is($item->brand)) {
                            $products->push($item);
                        }
                    });
                }
            }
        } else {
            $products = $categoryProducts;
        }

        return $products;
    }

    public function render()
    {
        // dd($this->category->is_enabled);
        return view('livewire.shop.listing', [
            'products' => $this->filter(),
        ]);
    }
}
