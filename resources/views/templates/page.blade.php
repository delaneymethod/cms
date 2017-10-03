			<div class="row">
				<div class="col-12 text-center text-sm-left text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			@if (!empty($page->content))
				<div class="row">
					<div class="col-12 text-center text-sm-left text-md-left text-lg-left text-xl-left">	
						{!! $page->content !!}
					</div>
				</div>
			@endif
			