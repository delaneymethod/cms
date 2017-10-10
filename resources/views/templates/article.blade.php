			{{--
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $article->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			--}}
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<div class="row">
						<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left article-content">	
							<h4>Published by {{ $article->user->first_name }} {{ $article->user->last_name }} on {{ date('jS F Y', strtotime($article->published_at)) }} in {{ implode(', ', $article->article_categories->pluck('title')->toArray()) }}</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					@if (!empty($article->section1Content))
						<div class="row">
							<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left article-content">	
								{!! $article->section1Content !!}
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					@endif
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center text-sm-center text-md-center text-lg-right text-xl-right">
					<div class="row">
						<div class="col-12">
							@if ($article->article_categories->forget(0)->count() > 0)
								<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
								<h4>Article Categories</h4>
								<div class="spacer"></div>
								<ul class="list-unstyled">
									@foreach ($article->article_categories->forget(0) as $articleCategory)
										<li class="d-inline-block d-sm-inline-block d-md-inline-block d-lg-block d-xl-block"><a href="/articles/category/{{ $articleCategory->slug }}" title="{{ $articleCategory->title }}">{{ $articleCategory->title }}</a></li>
										@if (!$loop->last)
											<li class="d-inline-block d-sm-inline-block d-md-inline-block d-lg-none d-xl-none">&nbsp;|&nbsp;</li>
										@endif
									@endforeach
								</ul>
								<div class="spacer tall"></div>
							@endif
						</div>	
						<div class="col-12">
							@if ($articleCategories->count() > 0)
								<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
								<h4>Browse by Category</h4>
								<div class="spacer"></div>
								<ul class="list-unstyled">
									@foreach ($articleCategories as $articleCategory)
										<li class="d-inline-block d-sm-inline-block d-md-inline-block d-lg-block d-xl-block {{ setActive('articles/category/'.$articleCategory->slug) }}"><a href="/articles/category/{{ $articleCategory->slug }}" title="{{ $articleCategory->title }}">{{ $articleCategory->title }}</a></li>
										@if (!$loop->last)
											<li class="d-inline-block d-sm-inline-block d-md-inline-block d-lg-none d-xl-none">&nbsp;|&nbsp;</li>
										@endif
									@endforeach
								</ul>
								<div class="spacer tall"></div>
							@endif
						</div>
						<div class="col-12">
							@if ($articleAuthors->count() > 0)
								<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
								<h4>Articles by Author</h4>
								<div class="spacer"></div>
								<ul class="list-unstyled">
									@foreach ($articleAuthors as $articleAuthor)
										<li class="d-inline-block d-sm-inline-block d-md-inline-block d-lg-block d-xl-block {{ setActive('articles/author/'.$articleAuthor->slug) }}"><a href="/articles/author/{{ $articleAuthor->slug }}" title="{{ $articleAuthor->first_name }} {{ $articleAuthor->last_name }}">{{ $articleAuthor->first_name }} {{ $articleAuthor->last_name }}</a></li>
										@if (!$loop->last)
											<li class="d-inline-block d-sm-inline-block d-md-inline-block d-lg-none d-xl-none">&nbsp;|&nbsp;</li>
										@endif
									@endforeach
								</ul>
							@endif
						</div>
					</div>
				</div>
			</div>
