@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="hidden sm:flex items-center gap-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 text-sm font-medium text-white bg-slate-700 border border-slate-700 rounded-lg">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Next
            </a>
        @else
            <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                Next
            </span>
        @endif
    </nav>
@endif
