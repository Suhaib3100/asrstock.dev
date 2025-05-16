<div class="searchResult-content-pagi">
    <ul class="zaiStock-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li>
                <a href="#" class="item previous disabled"><i class="fa-solid fa-angle-left"></i></a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="item previous"><i class="fa-solid fa-angle-left"></i></a>
            </li>
        @endif

        {{-- Pagination Links --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><a href="#" class="item disabled">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a href="#" class="item active">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}" class="item">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="item next"><i class="fa-solid fa-angle-right"></i></a>
            </li>
        @else
            <li>
                <a href="#" class="item next disabled"><i class="fa-solid fa-angle-right"></i></a>
            </li>
        @endif
    </ul>

    {{-- Display the range of results --}}
    <p class="fs-md-20 fs-18 fw-500 lh-30 text-primary-dark-text">
        {{__('Results')}}: <span>{{ $paginator->firstItem() }}</span> {{__('to')}} <span>{{ $paginator->lastItem() }}</span> {{__('of')}} <span>{{ $paginator->total() }}</span>
    </p>
</div>
