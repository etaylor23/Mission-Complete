<li class="alert @if($objective->next_maintenance_instance_date < $nextMaintenceInstanceDate) overdue @endif">
		<div class="card">
				<div class="card-inner">
						<div class="summary">
								{!! Form::open(['method' => 'PUT', 'action' => ['DashboardController@maintenanceComplete', $objective->objective_slug], 'class'=>'row maintenance-complete-form']) !!}
										{!! Form::submit('&#xf058;', ['class' => 'awesome double maintenance-complete']) !!}
								{!! Form::close() !!}
								<div class="objective-title">
										<a href="/campaign/{{$objective->Mission->Campaign->slug}}/mission/{{$objective->Mission->mission_slug}}/objective/{{$objective->objective_slug}}">{{$objective->name}}</a>
										<div class="fa-exclamation-circle fa"></div>
								</div>
								<div class="plan">
										{{ date("l d F Y", strtotime($objective->next_maintenance_instance_date)) }}
								</div>

						</div>
				</div>
		</div>
</li>
