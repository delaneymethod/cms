@extends('_layouts.default')

@section('title', 'Assets - '.config('app.name'))
@section('description', 'Assets - '.config('app.name'))
@section('keywords', 'Assets, '.config('app.name'))

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
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@if ($messages->count() > 0)
                	@foreach ($messages as $message)
                    	<div class="row">
							<div class="col-12">
								<p id="system-message" class="message {{ $message->type }}">{!! $message->text !!}<a href="javascript:void(0);" title="Hide this message" class="pull-right" id="hideMessage"><i class="fa fa-times" aria-hidden="true"></i></a></p>
							</div>
						</div>
                    	<script>
						window.onload = () => {
							$('#system-message').trigger('shown');
						};
						</script>
                    @endforeach
				@endif
				@include('cp._partials.pageTitle')
				@if ($currentUser->hasPermission('upload_assets'))
					<div class="row">
						<div class="col-12">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/assets/upload{{ $uploadDirectory }}" title="Upload Assets" class="btn btn-success"><i class="icon fa fa-upload" aria-hidden="true"></i>Upload Assets</a></li>
								@if ($zipEnabled && count($assets) > 0)
									<li class="list-inline-item"><a href="/cp/assets?zip={{ $zipDownloadPath }}" title="Download Assets" class="btn btn-outline-secondary"><i class="icon fa fa-download" aria-hidden="true"></i>Download Assets</a></li>
								@endif
								@if ($deleteFolderEnabled)
									<li class="list-inline-item"><a href="/cp/assets/folder/delete{{ $uploadDirectory }}" title="Delete Folder" class="btn btn-outline-danger"><i class="icon fa fa-folder" aria-hidden="true"></i>Delete Folder</a></li>
								@endif
								<li class="list-inline-item"><a href="/cp/assets/folder/create{{ $uploadDirectory }}" title="Create Folder" class="btn btn-outline-secondary"><i class="icon fa fa-folder" aria-hidden="true"></i>Create Folder</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<ul class="breadcrumbs list-unstyled list-inline">
								<li class="list-inline-item">You are here:</li>
								@foreach ($breadcrumbs as $breadcrumb)
									@if ($breadcrumb != end($breadcrumbs))
										<li class="list-inline-item"><a href="{{ $breadcrumb->url }}" title="{{ $breadcrumb->title }}">{{ $breadcrumb->title }}</a>&nbsp;<span class="divider">/</span></li>
									@else
										<li class="list-inline-item">{{ $breadcrumb->title }}</li>
									@endif
								@endforeach
							</ul>
						</div>
					</div>
					<div class="row assets">
						@if (count($assets) > 0)
							@foreach ($assets as $filename => $meta)
								<div class="col-12 col-sm-3 col-md-3 col-lg-2 col-xl-2 asset text-center">
									@if (!empty($meta->mime_type))
										@if (starts_with($meta->mime_type, 'image'))	
											<a href="javascript:void(0);" title="{{ $filename }}" class="image asset-opener" style="background-image: url('{{ $meta->url_path }}');" data-toggle="modal" data-target=".asset-{{ $meta->id }}-modal-lg">
												<span>{{ $filename }}</span>
											</a>
										@else
											<a href="javascript:void(0);" title="{{ $filename }}" class="asset-opener" data-toggle="modal" data-target=".asset-{{ $meta->id }}-modal-lg">
												<i class="fa {{ $meta->icon_class }} fa-5x" aria-hidden="true"></i>
												<span>{{ $filename }}</span>
											</a>
										@endif
										<div class="modal fade asset-{{ $meta->id }}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="assetModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="assetModalLabel">{{ $filename }}</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 text-center">
																@if (file_exists($meta->file_path))
																	@if (!starts_with($meta->mime_type, 'image'))
																		<p>&nbsp;</p>
																		<p><a href="{{ $meta->url_path }}" title="{{ $filename }}" target="_blank"><i class="fa {{ $meta->icon_class }} fa-5x align-middle" aria-hidden="true"></i><br><br>No Preview Available</a></p>
																	@else
																		<a href="{{ $meta->url_path }}" title="{{ $filename }}" target="_blank"><img src="{{ $meta->url_path }}" width="100%" class="align-top text-center" alt="{{ $filename }}"></a>
																	@endif
																@else
																	<p>&nbsp;</p>
																	<p><a href="{{ $meta->url_path }}" title="{{ $filename }}" target="_blank"><i class="fa {{ $meta->icon_class }} fa-5x align-middle" aria-hidden="true"></i><br><br>No Preview Available</a></p>
																@endif
															</div>
															<div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 text-left">
																<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
																<form>
																	<div class="form-group">
																		<label class="d-block">File Uploaded: <strong>{{ $meta->mod_time }}</strong></label>
																	</div>
																	<div class="form-group">
																		<label for="file_url">File URL:</label>
																		<div class="input-group">
																			<input type="text" class="form-control bg-transparent" value="{{ $meta->url_path }}" id="file_url" readonly>
																			<span class="input-group-addon"><a href="javascript:void(0);" title="Copy File URL to clipboard" data-clipboard data-clipboard-target="#file_url"><i class="fa fa-clipboard" id="clipboard-tooltip" title="Copied!" aria-hidden="true"></i></a></span>
																		</div>
																	</div>
																	<div class="form-group">
																		<label>File type: <strong>{{ $meta->mime_type }}</strong></label>
																	</div>
																	<div class="form-group">
																		<label>File size: <strong>{{ $meta->file_size }}</strong></label>
																	</div>
																	@if ($meta->width && $meta->height)
																		<div class="form-group">
																			<label>Dimensions: <strong>{{ $meta->width }} x {{ $meta->height }}</strong></label>
																		</div>
																	@endif
																</form>	
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<div class="container-fluid">
															<div class="row d-flex h-100 justify-content-start">
																<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center text-sm-center text-md-center text-lg-right text-xl-right align-self-center">
																	<a href="/cp/assets/{{ $meta->id }}/delete{{ $uploadDirectory }}" title="Delete" class="btn btn-outline-danger">Delete</a>
																	<a href="/cp/assets/{{ $meta->id }}/move{{ $uploadDirectory }}" title="Move" class="btn btn-outline-info">Move</a>
																	<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									@else
										<a href="{{ $meta->url_path }}" title="{{ $filename }}" class="asset-opener">
											<i class="fa {{ $meta->icon_class }} fa-5x" aria-hidden="true"></i>
											<span>{{ $filename }}</span>
										</a>
									@endif
								</div>
							@endforeach
						@else
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
								<p>&nbsp;</p>
								<h4><i class="fa fa-folder-o fa-5x" aria-hidden="true"></i><br>Empty folder</h4>
								<p>&nbsp;</p>
								<p>You may upload new assets into this folder by clicking Upload Assets button above.</p>
								<p>&nbsp;</p>
								<p>&nbsp;</p>
								<p>&nbsp;</p>
							</div>
						@endif
					</div>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
