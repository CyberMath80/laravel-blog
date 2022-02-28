@if($paginator->hasPages())
                    <nav>
                        <ul class="pagination"> {{-- Previous Page Link --}}
@if($paginator->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')"><span class="page-link" aria-hidden="true">&lsaquo;</span></li>
@else
                            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a></li>@endif
                            @foreach($elements as $element){{-- Pagination Elements --}}{{-- "Three Dots" Separator --}}@if(is_string($element))<li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>@php echo "\n\t\t\t\t\t\t\t";@endphp@endif
@if(is_array($element)){{-- Array Of Links --}}@foreach($element as $page => $url)
@if($page == $paginator->currentPage())<li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>@php echo "\n\t\t\t\t\t\t\t";@endphp@endif
@endforeach
@endif
@endforeach
@if($paginator->hasMorePages()){{-- Next Page Link --}}<li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a></li>
    @else<li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')"><span class="page-link" aria-hidden="true">&rsaquo;</span></li>
@endif
@if($paginator->currentPage() == $paginator->lastPage())@php echo "\t";@endphp@endif
                    </ul>
                    </nav>@endif
