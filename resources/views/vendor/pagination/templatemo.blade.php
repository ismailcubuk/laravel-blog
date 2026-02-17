@if ($paginator->hasPages())
<div class="col-lg-12">
    <ul class="page-numbers">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <a href="#"><i class="fa fa-angle-double-left"></i></a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
        @endif


        {{-- Pages --}}
        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="disabled"><a href="#">{{ $element }}</a></li>
            @endif


            @if (is_array($element))
                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <li class="active">
                            <a href="#">{{ $page }}</a>
                        </li>

                    @else

                        <li>
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>

                    @endif

                @endforeach
            @endif

        @endforeach


        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}">
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
        @else
            <li class="disabled">
                <a href="#"><i class="fa fa-angle-double-right"></i></a>
            </li>
        @endif

    </ul>
</div>
@endif
