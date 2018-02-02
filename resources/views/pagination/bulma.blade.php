@if ($paginator->hasPages())
    <nav class="pagination is-rounded is-medium is-centered mt-2 pb-2">

        <ul class="pagination-list">
            @if ($paginator->onFirstPage())
                <li class="previous disabled"><a disabled>Previous</a></li>
            @else
                <li class="previous"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span class="pagination-ellipsis"><span>{{ $element }}</span></span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><a class="pagination-link">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}" class="pagination-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="next"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
            @else
                <li class="next disabled"><a disabled>Next</a></li>
            @endif
        </ul>
    </nav>
@endif