						@if (!empty($page->$field))
							<div class="row">
								<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
									{!! $page->$field !!}
								</div>
							</div>
							<div class="row">
								<div class="col-12 spacer tall"></div>
							</div>
						@endif
						