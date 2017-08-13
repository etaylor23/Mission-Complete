<div class="pane {{ $containerClasses }}">
		<div class="inner-column" counter parent="{{ $parentAttribute }}">
				<div class="panel-main-container">
						<div @if($completeness)
										class="completeness"
									@endif>
								<div id="{{ $pane->mission_slug }}"  class="counter-container">
								</div>
								<div class="end">
									{{ $pane->percent_complete }}
								</div>
								<div class="title">
									<a href="{{ $url }}">
										{{$pane->name}}
									</a>
								</div>
								@if(!is_null($pane->percent_complete))

										<div class="container">
											<div id="percent"></div>
											<svg id="svg-{{ $pane->id }}"></svg>
										</div>

								@elseif(!is_null($pane->done))
										@if($pane->done === 0)
											<div class="container">
													<svg class="cross__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
															<circle class="cross__circle" cx="26" cy="26" r="25" fill="none"/>
															<path class="cross__path cross__path--right" fill="none" d="M16,16 l20,20" />
															<path class="cross__path cross__path--right" fill="none" d="M16,36 l20,-20" />
													</svg>
											</div>
										@else
												<div class="container">
													<div class="trigger"></div>
													<svg version="1.1" id="tick" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
													 viewBox="0 0 37 37" style="enable-background:new 0 0 37 37;" xml:space="preserve">
													<path class="circ path" style="fill:none;stroke:#4D9E69;stroke-width:2;stroke-linejoin:round;stroke-miterlimit:10;" d="
													M30.5,6.5L30.5,6.5c6.6,6.6,6.6,17.4,0,24l0,0c-6.6,6.6-17.4,6.6-24,0l0,0c-6.6-6.6-6.6-17.4,0-24l0,0C13.1-0.2,23.9-0.2,30.5,6.5z"
													/>
													<polyline class="tick path" style="fill:none;stroke:#4D9E69;stroke-width:2;stroke-linejoin:round;stroke-miterlimit:10;" points="
													11.6,20 15.9,24.2 26.4,13.8 "/>
													</svg>
												</div>
										@endif
								@else
											<span class="start">
												<a href="{{ $url }}">
													Start
												</a>
											</span>
								@endif
						</div>
				</div>


				@if($showObjectives)
						<div class="listing-wrapper hidden">
								<ol class="objectives listing">
										@foreach(
											$pane->Objective
												   ->where('done', 1)
													 ->where('next_maintenance_instance_date', '<=', $nextMaintenceInstanceDate) as $objective)
													 @include('partials.objectiveCard',
														 array(
															 'objective' => $objective
													   )
													 )
										@endforeach
								</ol>
						</div>
				@endif

		</div>
</div>
