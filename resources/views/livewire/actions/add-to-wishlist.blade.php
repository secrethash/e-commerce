<div>
    @if ($buttonType==='icon')
        <li>
            <a href="#"
                title="Add to Wishlist"
                wire:click.prevent='addToWishlist'>
                <i class="icon-heart" wire:loading.remove></i>
                <div class="spinner-grow spinner-grow-sm" role="status" wire:loading wire:target='addToWishlist'>
                    <span class="visually-hidden">Loading...</span>
                </div>
            </a>
        </li>
    @endif
</div>
