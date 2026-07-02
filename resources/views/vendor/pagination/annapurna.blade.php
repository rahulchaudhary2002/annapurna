@if ($paginator->hasPages())
<ul class="blog-pagination-wrap align-center mb-30 mt-30">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <li class="disabled"><span><i class="ti-angle-left"></i></span></li>
    @else
        <li><a href="{{ $paginator->previousPageUrl() }}"><i class="ti-angle-left"></i></a></li>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="disabled"><span>{{ $element }}</span></li>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li><a class="active">{{ $page }}</a></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}"><i class="ti-angle-right"></i></a></li>
    @else
        <li class="disabled"><span><i class="ti-angle-right"></i></span></li>
    @endif

</ul>
@endif
