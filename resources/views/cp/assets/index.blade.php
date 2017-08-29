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
								<p id="system-message" class="message {{ $message['type'] }}">{!! $message['text'] !!}<a href="javascript:void(0);" title="Hide this message" class="pull-right" id="hideMessage"><i class="fa fa-times" aria-hidden="true"></i></a></p>
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
										<li class="list-inline-item"><a href="{{ $breadcrumb['link'] }}" title="{{ $breadcrumb['text'] }}">{{ $breadcrumb['text'] }}</a>&nbsp;<span class="divider">/</span></li>
									@else
										<li class="list-inline-item">{{ $breadcrumb['text'] }}</li>
									@endif
								@endforeach
							</ul>
						</div>
					</div>
					<div class="row assets">
						@foreach ($assets as $asset => $fileInfo)
							<div class="col-sm-3 col-md-3 col-lg-2 asset" data-name="{{ $asset }}" data-href="{{ $fileInfo['url_path'] }}">
								
								@if ($fileInfo['icon_class'] == 'fa-file-text')
									<a href="{{ $fileInfo['url_path'] }}" title="{{ $asset }}" data-name="{{ $asset }}" data-toggle="modal" data-target=".asset-{{ $asset }}-modal-lg"><img src="{{ $fileInfo['url_path'] }}" width="100%" height="100%" alt="{{ $asset }}"></a>
								@elseif ($fileInfo['icon_class'] == 'fa-picture-o')
									<a href="{{ $fileInfo['url_path'] }}" title="{{ $asset }}" data-name="{{ $asset }}" data-toggle="modal" data-target=".asset-{{ $asset }}-modal-lg"><img src="{{ $fileInfo['url_path'] }}" width="100%" height="100%" alt="{{ $asset }}"></a>
								@elseif ($fileInfo['icon_class'] == 'fa-folder')
									<a href="{{ $fileInfo['url_path'] }}" title="{{ $asset }}" data-name="{{ $asset }}">{{ $asset }}</a>
								@elseif ($fileInfo['icon_class'] == 'fa-level-up')
									<a href="{{ $fileInfo['url_path'] }}" title="{{ $asset }}" data-name="{{ $asset }}">{{ $asset }}</a>
								@endif
								
								<div class="modal fade asset-{{ $asset }}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="assetModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="assetModalLabel">{{ $asset }}</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-7 text-center">
														<a href="{{ $fileInfo['url_path'] }}" title="{{ $asset }}" target="_blank"><img src="{{ $fileInfo['url_path'] }}" width="100%" class="align-top text-center" alt="{{ $asset }}"></a>
													</div>
													<div class="col-5 text-left">
														<form>
															<div class="form-group">
																<label class="d-block">File Uploaded: <strong></strong></label>
															</div>
															<div class="form-group">
																<label for="file_url">File URL:</label>
																<input type="text" class="form-control" value="{{ config('app.url') }}{{ $fileInfo['url_path'] }}" id="file_url" readonly>
															</div>
															<div class="form-group">
																<label>File type: <strong></strong></label>
															</div>
															<div class="form-group">
																<label>File size: <strong></strong></label>
															</div>
														</form>	
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<a href="/cp/assets/{{ $asset }}/delete" title="Delete" class="btn btn-danger">Delete</a>
												<a href="/cp/assets/{{ $asset }}/move" title="Move" class="btn btn-info">Move</a>
												<button type="button" class="float-right btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								
								
							</div>
						@endforeach
					</div>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
