						<div class="row">
							@php ($columnsLeft = 12)
							@if (!empty($article->section1Image))
								@php ($columnsLeft = 9)
							@endif
							@if (!empty($article->section1Image))
								<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
									<a href="{{ $article->url }}" title="{{ $article->title }}"><img src="{{ $article->section1Image }}" alt="{{ $article->title }}" class="lazyload img-fluid"></a>
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
										<p>Published by <a href="/articles/author/{{ $article->user->slug }}" title="">{{ $article->user->first_name }} {{ $article->user->last_name }}</a> on {{ date('jS F Y', strtotime($article->published_at)) }}</p>
										<p>{!! $article->section1Excerpt !!}</p>
										<p><a href="{{ $article->url }}" title="Read Full Article" class="btn btn-danger btn-sm">Read Full Article</a></p>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="spacer very-tall"></div>
							</div>
						</div>
						