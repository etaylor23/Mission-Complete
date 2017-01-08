@if ($breadcrumbs)
    <nav aria-label="You are here:" role="navigation">
      <ul class="breadcrumbs">
        @foreach ($breadcrumbs as $breadcrumb)
    			@if ($breadcrumb->url && !$breadcrumb->last)
    				<li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
    			@else
            <li>
              <span class="show-for-sr">Current: </span> {{ $breadcrumb->title }}
            </li>
    			@endif
    		@endforeach
      </ul>
    </nav>
@endif
