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
@endpush

@section('content')
		<div class="row wrapper">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} main">
				@include('cp._partials.message')
				@if ($messages->count() > 0)
                	@foreach ($messages as $message)
                    	<div class="row">
							<div class="col">
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
						<div class="col">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/assets/upload" title="Upload Assets" class="btn btn-outline-success"><i class="fa fa-upload" aria-hidden="true"></i>Upload Assets</a></li>
								@if ($zipEnabled)
									<li class="list-inline-item"><a href="/cp/assets?zip={{ $zipDownloadPath }}" title="Download Assets" class="btn btn-outline-secondary"><i class="fa fa-download" aria-hidden="true"></i>Download Assets</a></li>
								@endif
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<ul class="breadcrumbs list-unstyled list-inline">
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
						@foreach ($assets as $name => $meta)
							<div class="col-sm-3 col-md-3 col-lg-2 asset text-center">
								@if (!empty($meta->media))
									@if (starts_with($meta->media->mime_type, 'image'))	
										<a href="javascript:void(0);" title="{{ $meta->media->name }}" class="image asset-opener" style="background-image: url('{{ $meta->media->getUrl("grid") }}');" data-toggle="modal" data-target=".asset-{{ $meta->media->id }}-modal-lg">
											<span>{{ $name }}</span>
										</a>
									@else
										<a href="javascript:void(0);" title="{{ $meta->media->name }}" class="asset-opener" data-toggle="modal" data-target=".asset-{{ $meta->media->id }}-modal-lg">
											<i class="fa {{ $meta->icon_class }} fa-5x" aria-hidden="true"></i>
											<span>{{ $name }}</span>
										</a>
									@endif
									<div class="modal fade asset-{{ $meta->media->id }}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="assetModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="assetModalLabel">{{ $meta->media->name }}</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												</div>
												<div class="modal-body">
													<div class="row">
														<div class="col-7 text-center">
															@if (file_exists($meta->media->getPath('modal')))
																<a href="{{ $meta->media->getUrl() }}" title="{{ $meta->media->name }}" target="_blank"><img src="{{ $meta->media->getUrl('modal') }}" width="100%" class="align-top text-center" alt="{{ $meta->media->name }}"></a>
															@else
																<p>&nbsp;</p>
																<p><i class="fa {{ $meta->icon_class }} fa-5x align-middle" aria-hidden="true"></i><br><br>No Preview Available</p>
															@endif
														</div>
														<div class="col-5 text-left">
															<form>
																<div class="form-group">
																	<label class="d-block">File Uploaded: <strong>{{ $meta->mod_time }}</strong></label>
																</div>
																<div class="form-group">
																	<label for="file_url">File URL:</label>
																	<input type="text" class="form-control" value="{{ config('app.url') }}{{ $meta->media->getUrl() }}" id="file_url" readonly>
																</div>
																<div class="form-group">
																	<label>File type: <strong>{{ $meta->media->mime_type }}</strong></label>
																</div>
																<div class="form-group">
																	<label>File size: <strong>{{ $meta->media->human_readable_size }}</strong></label>
																</div>
																@if ($meta->media->width && $meta->media->height)
																	<div class="form-group">
																		<label>Dimensions: <strong>{{ $meta->media->width }} x {{ $meta->media->height }}</strong></label>
																	</div>
																@endif
															</form>	
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<a href="/cp/assets/{{ $meta->media->model_id }}/delete" title="Delete" class="btn btn-danger">Delete</a>
													<a href="/cp/assets/{{ $meta->media->model_id }}/move" title="Move" class="btn btn-info">Move</a>
													<button type="button" class="float-right btn btn-secondary" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								@else
									<a href="{{ $meta->url_path }}" title="{{ $name }}" class="asset-opener">
										<i class="fa {{ $meta->icon_class }} fa-5x" aria-hidden="true"></i>
										<span>{{ $name }}</span>
									</a>
								@endif
							</div>
						@endforeach
					</div>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
