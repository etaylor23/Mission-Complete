<div class="heading">
		<div class="row">
		<h1 class="elegantshadow column @if(!is_null($headingWidth)){{ $headingWidth }}@endif">{{ $value }}</h1>
		@if(!is_null($showFollowData))
				<div class="follow-details row">
						<div class="column small-12 medium-6 large-6">
								<a href="/follow/following">
										<h2>Following</h2>
										<div class="follow-value">{{ $showFollowData['follow'] }}</div>
								</a>
						</div>
						<div class="column small-12 medium-6 large-6">
								<a href="/follow/followers">
										<h2>Followers</h2>
										<div class="follow-value">{{ $showFollowData['followers'] }}</div>
								</a>
						</div>
				</div>
		@endif
		</div>
</div>
