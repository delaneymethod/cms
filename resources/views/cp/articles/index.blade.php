@extends('_layouts.default')

@section('title', 'Articles - '.config('app.name'))
@section('description', 'Articles - '.config('app.name'))
@section('keywords', 'Articles, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/cp.css') }}">
@endpush

@push('headScripts')
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/cp.js') }}"></script>
@endpush

@section('content')
		<div class="row wrapper">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				@if ($currentUser->hasPermission('create_articles'))
					<div class="row">
						<div class="col">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/articles/create" title="Add Article" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Article</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th>Title</th>
								<th>Slug</th>
								<th>Author</th>
								<th>Published</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($articles as $article)
								<tr>
									<td>{{ $article->title }}</td>
									<td>{{ $article->slug }}</td>
									<td>{{ $article->user->first_name }} {{ $article->user->last_name }}</td>
									<td>{{ $article->published_at }}</td>
									<td class="status text-center"><i class="fa fa-circle fa-1 status_id-{{ $article->status->id }}" title="{{ $article->status->title }}" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('edit_articles') || $currentUser->hasPermission('delete_articles'))
										<td class="actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Article Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_articles'))
													<li class="dropdown-item gf-info"><a href="/cp/articles/{{ $article->id }}/edit" title="Edit Article"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Article</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_articles'))
													<li class="dropdown-item gf-danger"><a href="/cp/articles/{{ $article->id }}/delete" title="Delete Article"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Article</a></li>
												@endif
											</ul>
										</td>
									@else
										<td>&nbsp;</td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
