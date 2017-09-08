			<h1>{{ $page->title }}</h1>
			
			{!! $page->content !!}
			
			<ul>
				@foreach ($articles as $article)
					@if ($article->isPublished())
						<li><a href="{{ $article->url }}" title="{{ $article->title }}">{{ $article->title }}</a></li>	
					@endif
				@endforeach
			</ul>
			