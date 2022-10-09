<?php

namespace App\Http\Livewire\Console\Products;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Shopper\Framework\Repositories\Ecommerce\ProductRepository;
use Shopper\Framework\Repositories\InventoryRepository;

class Edit extends Component
{
    public Model $product;

    public Collection $inventories;

    public int $inventory;

    public bool $featured = false;

    protected $listeners = ['productHasUpdated'];

    public function mount($product)
    {
        $this->product = $product;
        $this->featured = $product->featured;
        $this->inventories = $inventories = (new InventoryRepository())->get();
        $this->inventory = $inventories->where('is_default', true)->first()->id;
    }

    public function productHasUpdated(int $id)
    {
        $this->product = (new ProductRepository())->getById($id);
    }

    public function render(): View
    {
        return view('shopper::livewire.products.edit', [
            'currency' => shopper_currency(),
        ]);
    }
}
