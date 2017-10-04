			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }}</h3>
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
			@if ($articles->count() > 0)
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
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
					</div>
				</div>
			@endif
			