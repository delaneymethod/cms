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
	@include('cp._partials.listeners')
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
								<li class="list-inline-item"><a href="/cp/articles/create" title="Add Article" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Article</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle">Slug</th>
								<th class="align-middle">Author</th>
								<th class="align-middle">Published</th>
								<th class="align-middle text-center">Status</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($articles as $article)
								<tr>
									<td class="align-middle">{{ $article->title }}</td>
									<td class="align-middle">{{ $article->slug }}</td>
									<td class="align-middle">{{ $article->user->first_name }} {{ $article->user->last_name }}</td>
									<td class="align-middle">{!! ($article->published_at > date('Y-m-d H:i:s')) ? '<span class="text-info">Due to be published on '.$article->published_at.'</span>' : $article->published_at !!}</td>
									<td class="align-middle status text-center"><i class="fa fa-circle fa-1 status_id-{{ $article->status->id }}" title="{{ $article->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('edit_articles') || $currentUser->hasPermission('delete_articles'))
										<td class="align-middle actions dropdown text-center" id="submenu">
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
@endsection
