<div>
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : ($this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1))
        <nav class="d-flex justify-items-center justify-content-between">
            <div class="d-flex justify-content-between flex-fill d-sm-none">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">@lang('pagination.previous')</span>
                        </li>
                    @else
                        <li class="page-item">
                            <button class="page-link"
                                dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled"
                                rel="prev" aria-label="@lang('pagination.previous')">
                                <span wire:loading.remove wire:target='previousPage'>@lang('pagination.previous')</span>
                                <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target='previousPage'>
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <button type="button"
                                dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled" rel="next"
                                aria-label="@lang('pagination.next')">
                                <span wire:loading.remove wire:target='nextPage'>@lang('pagination.next')</span>
                                <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target='nextPage'>
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">@lang('pagination.next')</span>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                <div>
                    <p class="small text-muted">
                        {!! __('Showing') !!}
                        <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                        {!! __('of') !!}
                        <span class="fw-semibold">{{ $paginator->total() }}</span>
                        {!! __('results') !!}
                    </p>
                </div>

                <div>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                <span class="page-link" aria-hidden="true">&lsaquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <button type="button" class="page-link"
                                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    wire:loading.attr="disabled" rel="prev"
                                    aria-label="@lang('pagination.previous')">
                                    <span wire:loading.remove wire:target='previousPage'>&lsaquo;</span>
                                    <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target='previousPage'>
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </button>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="page-item disabled" aria-disabled="true"><span
                                        class="page-link">{{ $element }}</span></li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="page-item active"
                                            wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}"
                                            aria-current="page">
                                            <span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"
                                            wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}">
                                            <button type="button" class="page-link"
                                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">
                                                <span wire:loading.remove wire:target='gotoPage'>{{ $page }}</span>
                                                <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target='gotoPage'>
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </button>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <li class="page-item">
                                <button class="page-link" type="button"
                                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                    wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                    wire:loading.attr="disabled"
                                    aria-label="@lang('pagination.next')">
                                    <span wire:loading.remove wire:target='nextPage'>&rsaquo;</span>
                                    <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target='nextPage'>
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </button>
                            </li>
                        @else
                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                <span class="page-link" aria-hidden="true">&rsaquo;</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    @endif
</div>
