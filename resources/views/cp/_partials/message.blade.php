				@if ($currentUser->isLocationSuspended())
					<div class="row">
						<div class="col-12">
							<p class="message danger"><i class="icon fa fa-exclamation-triangle" aria-hidden="true"></i>Your office location is suspended.</p>
						</div>
					</div>
				@endif
				@impersonating
					<div class="row">
						<div class="col-12">
							<p class="message impersonate font-weight-normal"><i class="icon fa fa-exclamation-triangle" aria-hidden="true"></i>You are currently impersonating as <strong>{{ $currentUser->first_name }} {{ $currentUser->last_name }}</strong>. <a href="{{ route('impersonate.leave') }}" title="Leave impersonation" class="impersonation">Go back to your own account</a>.</p>
						</div>
					</div>
				@endImpersonating
				@if (session('status'))
					<div class="row">
						<div class="col-12">
							<p id="message" class="message {{ session('status_level') }}">{{ session('status') }}<a href="javascript:void(0);" title="Hide this message" rel="nofollow" class="pull-right" id="hideMessage"><i class="fa fa-times" aria-hidden="true"></i></a></p>
						</div><!-- /.col -->
					</div><!-- /.row -->
				@endif
				