			@if (session('status'))
				<div class="row">
					<div class="col">
						<p id="message" class="message {{ session('status_level') }}">{{ session('status') }}<a href="javascript:void(0);" title="Hide this message" class="pull-right" id="hideMessage"><i class="fa fa-times" aria-hidden="true"></i></a></p>
					</div>
				</div>
				<script>
				window.onload = () => {
					$('#message').trigger('shown');
				};
				</script>
			@endif
			