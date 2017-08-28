			<h1>{{ $page->title }}</h1>
			
			{!! $page->content !!}
			
			<ul>
				@foreach ($articles as $article)
					@if ($article->status_id == 4)
						<li><a href="/articles/{{ $article->slug }}" title="{{ $article->title }}">{{ $article->title }}</a></li>	
					@endif
				@endforeach
			</ul>
			