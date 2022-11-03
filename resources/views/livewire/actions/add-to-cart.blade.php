<div>
    @if($buttonType === 'icon')
        <div class="cart-btn">
            <a href="#"
                class="add-to-cart"
                title="Add to cart"
                wire:click.prevent='addToCart'>
                <i class="icon-shopping-cart" wire:loading.remove></i>
                <div class="spinner-grow spinner-grow-sm" role="status" wire:loading wire:target='addToCart'>
                    <span class="visually-hidden">Loading...</span>
                </div>
            </a>
        </div>
    @elseif($buttonType === 'product')


        <div class="pro-details-quality mt-0px">
            {{-- <div class="cart-plus-minus">
                <input class="cart-plus-minus-box"
                    type="text"
                    name="qtybutton"
                    wire:model.defer='quantity' />
            </div> --}}
            <div class="pro-details-cart btn-hover">
                <a href="#" title="Add to cart"
                    wire:click.prevent='addToCart'>
                    <div class="spinner-grow spinner-grow-sm" role="status" wire:loading wire:target='addToCart'>
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Add To Cart
                </a>
            </div>
        </div>
    @else
        <div class="cart-btn">
            <a href="#"
                class="add-to-curt"
                title="Add to cart"
                wire:click.prevent='addToCart'>
                <div class="spinner-grow spinner-grow-sm" role="status" wire:loading wire:target='addToCart'>
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span>{{ __('Add to cart') }}</span>
            </a>
        </div>
    @endif
</div>
