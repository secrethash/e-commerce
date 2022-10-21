<?php

namespace App\Http\Livewire\Shop;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Framework\Models\Shop\Product\Brand as ProductBrand;
use Shopper\Framework\Models\Shop\Product\Category;
use Shopper\Framework\Models\Shop\Product\Product;

class Listing extends Component
{

    use WithPagination;

    public $layout = 'x3';

    public string $per_page = '9';

    public string $brands = '';

    public array $selectedBrands;

    public Collection $carBrands;

    public Collection $aftermarketBrands;

    public Collection $categories;

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
    }

    public function updatedSelectedBrands($value)
    {
        $this->brands = implode($this->multiDelimiter, $this->selectedBrands);
        // $this->brands = urldecode($this->brands);
    }

    protected function filter()
    {

        if (blank($this->brands) && !$this->category) {
            return Product::publish()->paginate(9)->withQueryString();
        }

        $brands = !blank($this->brands) ? explode($this->multiDelimiter, $this->brands) : [];

        if ($this->category && $this->category->is_enabled) {
            $products = $this->category->products();
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

        return $products->paginate($this->per_page)->withQueryString();
    }

    protected function shouldResetFilter(): bool
    {
        if (
            $this->category OR
            !blank($this->brands) OR
            (!blank($this->per_page) && $this->per_page != 9) OR
            $this->layout !== 'x3'
        ) {
            return true;
        }

        return false;
    }

    public function render()
    {
        // dd($this->selectedBrands);
        return view('livewire.shop.listing', [
            'products' => $this->filter(),
            'resetFilter' => $this->shouldResetFilter(),
        ]);
    }
}
