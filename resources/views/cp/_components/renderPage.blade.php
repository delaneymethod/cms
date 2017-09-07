		<li id="page_{{ $page->id }}">
			<div>
				<em class="text-center icon fa fa-bars" aria-hidden="true"></em>
				<span class="page-title">{{ $page->title }}{!! $page->hide_from_nav == 1 ? '&nbsp;<i class="text-muted-lighter">(Hidden from Nav)</i>' : '' !!}</span>
				@if ($currentUser->hasPermission('edit_pages'))
					<a href="/cp/pages/{{ $page->id }}/edit/{{ $page->template_id }}" title="Edit Page" class="pull-right text-center gf-info"><i class="icon fa fa-pencil" aria-hidden="true"></i></a>
				@endif
				<span class="pull-right page-status"><i class="fa fa-circle fa-1 status_id-{{ $page->status->id }}" title="{{ $page->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></span>
			</div>
			@if ($page->children()->count() > 0)
				<ol>
					@foreach ($page->children as $child)
						@component ('cp._components.renderPage', [
							'page' => $child, 
							'currentUser' => $currentUser
						])
						@endcomponent
					@endforeach
				</ol>
			@endif
		</li>
		