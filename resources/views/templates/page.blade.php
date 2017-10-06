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
					@for ($i = 1; $i <= 10; $i++)
						@component('_components.page.content', [
							'page' => $page,
							'field' => 'section'.$i.'Content'
						])
						@endcomponent
					@endfor
				</div>
				@include('_partials.sidebar')
			</div>
			