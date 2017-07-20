				@if (session('status'))
				<div class="row">
					<div class="col">
						<p id="message" class="message {{ session('status_level') }}">{{ session('status') }}</p>
					</div><!-- /.col -->
				</div><!-- /.row -->
				@endif
				