@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex-1 flex gap-2 items-center text-black justify-center">
            <span class="relative z-0 inline-flex gap-4 rtl:flex-row-reverse shadow-xs rounded-md">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span
                            class="relative inline-flex text-inherit items-center px-2 py-2 text-sm font-medium bg-mine-400 transition cursor-default rounded-md leading-5"
                            aria-hidden="true">
                            Prev
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="relative inline-flex text-inherit items-center px-2 py-2 text-sm font-medium bg-mine-200 hover:bg-mine-400 transition cursor-default rounded-md leading-5"
                        aria-label="{{ __('pagination.previous') }}">
                        Prev
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span
                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span
                                        class="relative inline-flex text-inherit items-center px-4 py-2 text-sm font-medium bg-mine-400 transition cursor-default rounded-md leading-5">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="relative inline-flex text-inherit items-center px-4 py-2 text-sm font-medium bg-mine-200 hover:bg-mine-400 transition cursor-default rounded-md leading-5"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="relative inline-flex text-inherit items-center px-2 py-2 text-sm font-medium bg-mine-200 hover:bg-mine-400 transition cursor-default rounded-md leading-5"
                        aria-label="{{ __('pagination.next') }}">
                        Next
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span
                            class="relative inline-flex text-inherit items-center px-2 py-2 text-sm font-medium bg-mine-400 transition cursor-default rounded-md leading-5"
                            aria-hidden="true">
                            Next
                        </span>
                    </span>
                @endif
            </span>
        </div>
    </nav>
@endif
