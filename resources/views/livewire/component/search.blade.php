<div>
    <form class="d-flex" action="{{ route('shop.index') }}" method="GET">
        <input type="text" name="q" placeholder="Search entire store here ..." id="search-query" wire:model='searchQuery' />
        <button><i class="icon-search"></i></button>
    </form>
</div>
