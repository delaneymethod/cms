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
			@if (!empty($page->section1Content))
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">	
						{!! $page->section1Content !!}
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
							<div class="col-12">
								<h4>All {{ $page->title }} @if (!empty($articleCategory))<small class="text-muted">{{ $articleCategory->title }}</small>@endif</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer"></div>
						</div>
						@foreach ($articles as $article)
							@component('_components.article.content', [
								'article' => $article
							])
							@endcomponent
						@endforeach
					@else
						<div class="row">
							<div class="col-12">
								@if (!empty($articleCategory))
									<h4>{{ $page->title }} <small class="text-muted">{{ $articleCategory->title }}</small></h4>
								@else 
									<h4>All {{ $page->title }}</h4>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer"></div>
						</div>
						<div class="row">
							<div class="col-12">
								<p>No articles were found.</p>
							</div>
						</div>
						@if ($recentArticles->count() > 0)
							<div class="row">
								<div class="col-12 spacer very-tall"></div>
							</div>
							<div class="row">
								<div class="col-12">
									<h5 class="text-danger">Recent Articles</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-12 spacer"></div>
							</div>
							@foreach ($recentArticles as $recentArticle)
								@component('_components.article.content', [
									'article' => $recentArticle
								])
								@endcomponent
							@endforeach
						@endif
					@endif
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center text-sm-center text-md-center text-lg-right text-xl-right order-1 order-sm-1 order-md-1 order-lg-2 order-xl-2">
					@if ($articleCategories->count() > 0)
						<div class="row">
							<div class="col-12">
								<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
								<h4>Articles by Category</h4>
								<div class="spacer"></div>
								<ul class="list-unstyled">
									@foreach ($articleCategories as $articleCategory)
										<li class="d-inline-block d-sm-inline-block d-md-inline-block d-lg-block d-xl-block {{ setActive('articles/category/'.$articleCategory->slug) }}"><a href="/articles/category/{{ $articleCategory->slug }}" title="{{ $articleCategory->title }}">{{ $articleCategory->title }}</a></li>
										@if (!$loop->last)
											<li class="d-inline-block d-sm-inline-block d-md-inline-block d-lg-none d-xl-none">&nbsp;|&nbsp;</li>
										@endif
									@endforeach
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer"></div>
						</div>						
					@endif
					@if ($articleAuthors->count() > 0)
						<div class="row">
							<div class="col-12">
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
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer"></div>
						</div>						
					@endif
				</div>
			</div>
			