			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			@for ($i = 1; $i <= 10; $i++)
				@component('_components.page.content', [
					'page' => $page,
					'field' => 'section'.$i.'Content'
				])
				@endcomponent
			@endfor
			