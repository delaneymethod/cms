			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }} @if (!empty($articleCategory))<small class="text-muted">{{ $articleCategory->title }}</small>@endif</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
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
			<div class="row d-flex">
				<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 text-center text-sm-center text-md-left text-lg-left text-xl-left order-2 order-sm-2 order-md-1 order-lg-1 order-xl-1">
					@if ($articles->count() > 0)
						<ul class="list-unstyled list-inline articles">
							@foreach ($articles as $article)
								@if ($article->isPublished())
									<li class="list-inline-item">
										<a href="{{ $article->url }}" title="{{ $article->title }}">{{ $article->title }}</a>
										<div class="spacer tall"></div>
										{!! $article->excerpt !!}
										<div class="spacer very-tall"></div>
									</li>	
								@endif
							@endforeach
						</ul>
					@endif
				</div>
				@include('_partials.sidebar')			
			</div>
			