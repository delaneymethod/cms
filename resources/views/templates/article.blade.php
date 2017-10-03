			<div class="row">
				<div class="col-12 text-center text-sm-left text-md-left text-lg-left text-xl-left">
					<h3>{{ $article->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			@if (!empty($article->content))
				<div class="row">
					<div class="col-12 text-center text-sm-left text-md-left text-lg-left text-xl-left">	
						{!! $article->content !!}
					</div>
				</div>
			@endif
