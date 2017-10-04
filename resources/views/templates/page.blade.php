			@php ($columnsLeft = ($page->children->count() > 0) ? 9 : 12)
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row d-flex">
				<div class="col-12 col-sm-12 col-md-{{ $columnsLeft }} col-lg-{{ $columnsLeft }} col-xl-{{ $columnsLeft }} text-center text-sm-center text-md-left text-lg-left text-xl-left order-2 order-sm-2 order-md-1 order-lg-1 order-xl-1">
					@if (!empty($page->content))
						<div class="row">
							<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
								{!! $page->content !!}
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					@endif
				</div>
				@include('_partials.sidebar')
			</div>
			