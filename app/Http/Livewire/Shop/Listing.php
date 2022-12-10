<?php

namespace App\Http\Livewire\Shop;

use App\Http\Livewire\Common\Notice\CanNotify;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Framework\Models\Shop\Product\Brand as ProductBrand;
use Shopper\Framework\Models\Shop\Product\Category;
// use Shopper\Framework\Models\Shop\Product\Product;
use App\Models\Product;

class Listing extends Component
{

    use WithPagination, CanNotify;

    public $layout = 'x3';

    public string $per_page = '9';

    public string $brands = '';

    public array $selectedBrands;

    public Collection $carBrands;

    public Collection $aftermarketBrands;

    public Collection $categories;

    public $searchQuery;

    protected $paginationTheme = 'bootstrap-5';

    protected string $multiDelimiter = ',';

    /**
     * Selected Category
     *
     * @var \Shopper\Framework\Models\Shop\Product\Category $category
     * */
    public $category;

    protected $queryString = [
        'layout' => ['except' => 'x3'],
        'brands' => ['except' => ''],
        'per_page' => ['except' => '9'],
        'searchQuery' => ['as' => 'q'],
    ];

    public function mount(): void
    {
        $this->categories = Category::enabled()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $this->carBrands = Brand::enabled()
            ->notAftermarket()
            ->orderBy('name')
            ->get();
        $this->aftermarketBrands = Brand::enabled()
            ->aftermarket()
            ->orderBy('name')
            ->get();
        $this->selectedBrands = !blank($this->brands) ? explode($this->multiDelimiter, $this->brands) : [];
    }

    public function changeLayout($layout): void
    {
        if ($layout === 1) {
            $this->layout = 'x1';
        } else {
            $this->layout = 'x3';
        }
        $this->notify('success', 'Layout Updated!', 'Shop List layout has been updated.');
    }

    public function updatedSelectedBrands($value)
    {
        $this->brands = implode($this->multiDelimiter, $this->selectedBrands);
        $this->notify('success', 'Filter Updated!', 'Brand Filter has been updated.');
        // $this->brands = urldecode($this->brands);
    }

    protected static function filterStatic(Component $component)
    {

        if (blank($component->brands) && !$component->category) {
            return Product::publish()->paginate($component->per_page)->withQueryString();
        }

        $brands = !blank($component->brands) ? explode($component->multiDelimiter, $component->brands) : [];

        if ($component->category && $component->category->is_enabled) {
            $products = $component->category->products();
        }

        if (count($brands) >= 1) {
            $brandIds = [];
            foreach ($brands as $brand) {
                $brandIds[] = Brand::whereSlug($brand)->first()?->id;
            }

            if (!isset($products) OR !$products) {
                $products = Product::query();
            }

            $products = $products->whereIn('brand_id', $brandIds);
        }

        return $products->paginate($component->per_page)->withQueryString();
    }

    protected function filter()
    {

        $brands = !blank($this->brands) ?
            explode($this->multiDelimiter, $this->brands) :
            [];

        if ($this->category && $this->category->is_enabled) {
            $products = $this->category->products();
        }

        if (!isset($products) OR !$products) {
            $products = Product::query();
        }

        if (count($brands) >= 1) {
            $brandIds = [];
            foreach ($brands as $brand) {
                $brandIds[] = Brand::whereSlug($brand)->first()?->id;
            }

            $products = $products->whereIn('brand_id', $brandIds);
        }

        if (!blank($this->searchQuery)) {
            $products = $this->searchProducts($products);
        }

        return $products->publish()
            ->paginate($this->per_page)
            ->withQueryString();
    }

    protected function searchProducts($products)
    {
        $q = $this->searchQuery;
        $products = $products->with([
            // 'brand' => function($query) use ($q) {
            //     $query->where('name', 'LIKE', '%' . $q . '%');
            // },
            'attributes' => function($query) use ($q) {
                $query->with(['values' => function($query) use($q) {
                    $query->with(['value' => function($query) use($q) {
                        $query->where('value', 'SIMILAR', '%' . $q . '%');
                    }]);
                }]);
            },
        ])
        ->orWhere('name', 'LIKE', '%' . $q . '%')
        ->orWhere('description', 'LIKE', '%' . $q . '%')
        ->orWhere('sku', 'LIKE', '%' . $q . '%');

        return $products;
    }

    protected function shouldResetFilter(): bool
    {
        if (
            $this->category OR
            !blank($this->brands) OR
            (!blank($this->per_page) && $this->per_page != 9) OR
            $this->layout !== 'x3' OR
            !blank($this->searchQuery)
        ) {
            return true;
        }

        return false;
    }

    // public function paginationView()
    // {
    //     return 'pagination::bootstrap-5';
    // }

    public function render()
    {
        // dd(static::filter($this)->links());
        return view('livewire.shop.listing', [
            'products' => $this->filter(),
            'resetFilter' => $this->shouldResetFilter(),
        ]);
    }
}
