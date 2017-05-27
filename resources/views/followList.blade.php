@extends('layouts.wrapper')
@section('content')

<div class="main-content">
		<div class="row">
				<div class="column small-12 medium-12 large-12 followers">
						<h1>{{ $title }}</h1>

						@foreach ($following as $key => $follow)
						<h2>
								{{$follow->getAttribute($userLinkType)->name}}
								<a href="/follow/{{$follow->id}}" class="delete-follow">
									<span class="fa fa-remove"></span>
								</a>
						</h2>
						@endforeach
				</div>
		</div>

</div>

<script>
function removeFollower(el) {
	if($('.followers').length > 0) {
			return el.outerHTML = '';
	}
	return;
}


$('.followers').on('click', '.delete-follow', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			context: $(this),
			method: "POST",
			data: {
					"_method":"DELETE",
					"_token":"{{ csrf_token() }}"
			},
		}).done(function(data) {
				console.log(data);
				removeFollower($(this).parent('h2')[0])
		})
})
</script>


@endsection
