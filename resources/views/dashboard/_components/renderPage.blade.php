		<li id="page_{{ $page->id }}">
			<div>
				<em class="text-center icon fa fa-bars" aria-hidden="true"></em>
				<span class="page-title">{{ $page->title }}</span>
				<a href="/dashboard/pages/{{ $page->id }}/edit" title="Edit Page" class="pull-right text-center gf-info"><i class="icon fa fa-pencil" aria-hidden="true"></i></a>
				<span class="pull-right page-status"><i class="fa fa-circle fa-1 status-{{ $page->status->id }}" title="{{ $page->status->title }}" aria-hidden="true"></i></span>
				<span class="pull-right page-slug text-muted text-right font-italic">/{{ $page->slug }}&nbsp;</span>
			</div>
			@if ($page->children()->count() > 0)
				<ol>
					@foreach ($page->children as $child)
						@component('dashboard._components.renderPage', ['page' => $child])
						@endcomponent
					@endforeach
				</ol>
			@endif
		</li>
		