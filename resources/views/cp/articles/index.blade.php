@extends('_layouts.default')

@section('title', 'Articles - '.config('app.name'))
@section('description', 'Articles - '.config('app.name'))
@section('keywords', 'Articles, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
@endpush

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				@if ($currentUser->hasPermission('create_articles'))
					<div class="row">
						<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/articles/create" title="Add Article" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Article</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<div class="spacer"></div>
					<table id="datatable" class="table table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle no-sort">&nbsp;</th>
								<th class="align-middle">Title</th>
								<th class="align-middle d-none d-sm-none d-md-none d-lg-table-cell d-xl-table-cell">Author</th>
								<th class="align-middle d-none d-sm-none d-md-table-cell d-lg-table-cell d-xl-table-cell">Published</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($articles as $article)
								<tr>
									<td class="align-middle status text-center"><i class="fa fa-circle fa-1 status_id-{{ $article->status->id }}" title="{{ $article->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									<td class="align-middle">{{ $article->title }}</td>
									<td class="align-middle d-none d-sm-none d-md-none d-lg-table-cell d-xl-table-cell">{{ $article->user->first_name }} {{ $article->user->last_name }}</td>
									<td class="align-middle d-none d-sm-none d-md-table-cell d-lg-table-cell d-xl-table-cell">{{ $article->published_at }}</td>
									@if ($currentUser->hasPermission('edit_articles') || $currentUser->hasPermission('delete_articles'))
										<td class="align-middle actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Article Actions" rel="nofollow" class="dropdown-toggle needsclick" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-item gf-default"><a href="{{ $article->url }}" title="Preview {{ $article->title }}" target="_blank"><i class="icon fa fa-eye" aria-hidden="true"></i>Preview Article</a></li>
												@if ($currentUser->hasPermission('edit_articles'))
													<li class="dropdown-item gf-info"><a href="/cp/articles/{{ $article->id }}/edit" title="Edit Article"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Article</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_articles'))
													<li class="dropdown-item gf-danger"><a href="/cp/articles/{{ $article->id }}/delete" title="Delete Article"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Article</a></li>
												@endif
											</ul>
										</td>
									@else
										<td class="align-middle">&nbsp;</td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
