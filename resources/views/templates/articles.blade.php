			{{--
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }} @if (!empty($articleCategory))<small class="text-muted">{{ $articleCategory->title }}</small>@endif</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			--}}
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
				<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 text-center text-sm-center text-md-left text-lg-left text-xl-left order-2 order-sm-2 order-md-2 order-lg-1 order-xl-1">
					@if ($articles->count() > 0)
						<div class="row">
							@foreach ($articles as $article)
								<div class="col-12">
									<div class="row">
										@php ($columnsLeft = 12)
										@if (!empty($article->section1Image))
											@php ($columnsLeft = 9)
										@endif
										@if (!empty($article->section1Image))
											<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
												<img src="{{ $article->section1Image }}" alt="{{ $article->title }}" class="img-fluid">
												<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
											</div>	
										@endif
										<div class="col-12 col-sm-12 col-md-{{ $columnsLeft }} col-lg-{{ $columnsLeft }} col-xl-{{ $columnsLeft }}">
											<div class="row">
												<div class="col-12">
													<h4><a href="{{ $article->url }}" title="{{ $article->title }}">{{ $article->title }}</a></h4>
												</div>
												<div class="col-12">
													<div class="spacer"></div>
													<p>{!! $article->section1Excerpt !!}</p>
													<p><a href="{{ $article->url }}" title="Read full article">Read full article.</a></p>
												</div>	
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<div class="spacer tall"></div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					@endif
				</div>
				@include('_partials.sidebar')			
			</div>
			