<?php

namespace App\Http\Livewire\Shop;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
// use Shopper\Framework\Models\Shop\Product\Product as Model;
use App\Models\Product as Model;
use Livewire\Component;

class Product extends Component
{
    public Model $product;

    public Collection $relatedProducts;

    public array $images;
    public array $thumbs;

    public function mount()
    {
        $this->getImages();
        $this->relatedProducts = $this->product->relatedProducts()->limit(10)->get();
    }

    public function getImages()
    {
        $images = $this->product->getMedia('uploads');
        $i = 0;
        foreach ($images as $image) {
            $this->thumbs[$i] = $image->getUrl('thumb200x200');
            $this->images[$i] = $image->getUrl();
            $i++;
        }
    }

    public function render()
    {
        // $this->getImages();
        // dd(
        //     $this->product,
        //     Str::of($this->product->description)->inlineMarkdown(['html_input' => 'strip'])->words(20),
        //     $this->product->attributes->first()->attribute->name,
        //     $this->product->attributes->first()->values,
        //     $this->product->formattedPrice($this->product->old_price_amount)
        // );
        // dd($this->product->categories);
        return view('livewire.shop.product');
    }
}
