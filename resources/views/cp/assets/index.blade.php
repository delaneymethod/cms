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
				@include('cp._partials.pageTitle')
				@if ($currentUser->hasPermission('upload_assets'))
					<div class="row">
						<div class="col">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/assets/upload" title="Upload Assets" class="btn btn-outline-success"><i class="fa fa-upload" aria-hidden="true"></i>Upload Assets</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">
					<div class="row assets">
						@foreach ($assets as $asset)
							<div class="col-sm-3 col-md-3 col-lg-2">
								<a href="{{ $asset->getUrl() }}" title="{{ $asset->filename }}" class="asset" style="margin-bottom: 0px;" data-toggle="modal" data-target=".asset-{{ $asset->id }}-modal-lg">
									@if (starts_with($asset->mime_type, 'image'))
										<img src="{{ $asset->getUrl() }}" width="100%" height="100%" alt="{{ $asset->filename }}">
									@else
										PDF
									@endif
								</a>
								<div class="modal fade asset-{{ $asset->id }}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="assetModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="assetModalLabel">{{ $asset->filename }}</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-7 text-center">
														<a href="{{ $asset->getUrl() }}" title="{{ $asset->filename }}" target="_blank"><img src="{{ $asset->getUrl() }}" width="100%" class="align-top text-center" alt="{{ $asset->filename }}"></a>
													</div>
													<div class="col-5 text-left">
														<form>
															<div class="form-group">
																<label class="d-block">Uploaded on: <strong>{{ $asset->created_at }}</strong></label>
															</div>
															<div class="form-group">
																<label for="file_url">File URL:</label>
																<input type="text" class="form-control" value="{{ $asset->getUrl() }}" id="file_url" readonly>
															</div>
															<div class="form-group">
																<label>File type: <strong>{{ $asset->mime_type }}</strong></label>
															</div>
															<div class="form-group">
																<label>File size: <strong>{{ $asset->filesize }}</strong></label>
															</div>
															<div class="form-group">
																<label>Dimensions: <strong>400 x 200</strong></label>
															</div>
														</form>	
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<a href="/assets/{{ $asset->id }}/delete" title="Delete" class="btn btn-danger">Delete</a>
												<a href="/assets/{{ $asset->id }}/move" title="Move" class="btn btn-info">Move</a>
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
