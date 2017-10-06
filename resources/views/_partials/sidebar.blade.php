				@if (!empty($page) && $page->children->count() > 0)
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 text-center text-sm-center text-md-right text-lg-right text-xl-right order-1 order-sm-1 order-md-2 order-lg-2 order-xl-2">
						<div class="row">
							<div class="col-12">
								<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
								<h4>Related Pages</h4>
								<div class="spacer"></div>
								<ul class="list-unstyled">
									@foreach ($page->children as $child)
										<li><a href="{{ $child->url }}" title="{{ $child->title }}">{{ $child->title }}</a></li>
									@endforeach
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					</div>
				@endif
				@if (!empty($article) && $article->article_categories->count() > 0)
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 text-center text-sm-center text-md-right text-lg-right text-xl-right order-1 order-sm-1 order-md-2 order-lg-2 order-xl-2">
						<div class="row">
							<div class="col-12">
								<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
								<h4>Browse by Category</h4>
								<div class="spacer"></div>
								<ul class="list-unstyled">
									@foreach ($article->article_categories as $articleCategory)
										<li><a href="/articles/category/{{ $articleCategory->slug }}" title="{{ $articleCategory->title }}">{{ $articleCategory->title }}</a></li>
									@endforeach
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					</div>
				@endif
				