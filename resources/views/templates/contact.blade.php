			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			@if (!empty($page->content))
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						{!! $page->content !!}
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
			@endif
			<div class="row">
				<div class="col-12">
					<div class="row d-flex">
						<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 order-2 order-sm-2 order-md-1 order-lg-1 order-xl-1">
							<form name="contact" id="contact" class="contact" role="form" method="POST" action="/contact">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="first_name" class="control-label">First Name <span class="text-danger">&#42;</span></label>
									<input type="text" name="first_name" id="first_name" class="form-control" placeholder="e.g Joe" value="{{ old('first_name') }}" title="First Name" tabindex="1" autocomplete="off" aria-describedby="helpBlockFirstName" required autofocus>
									@if ($errors->has('first_name'))
										<span id="helpBlockFirstName" class="form-control-feedback form-text gf-red">- {{ $errors->first('first_name') }}</span>
									@endif
								</div>
								<div class="form-group">
									<label for="last_name" class="control-label">Last Name <span class="text-danger">&#42;</span></label>
									<input type="text" name="last_name" id="last_name" class="form-control" placeholder="e.g Bloggs" value="{{ old('last_name') }}" title="Last Name" tabindex="2" autocomplete="off" aria-describedby="helpBlockLastName" required>
									@if ($errors->has('last_name'))
										<span id="helpBlockLastName" class="form-control-feedback form-text gf-red">- {{ $errors->first('last_name') }}</span>
									@endif
								</div>
								<div class="form-group">
									<label for="email" class="control-label">Email Address <span class="text-danger">&#42;</span></label>
									<input type="email" name="email" id="email" class="form-control" placeholder="e.g joe@bloggs.com" value="{{ old('email') }}" title="Email Address" tabindex="3" autocomplete="off" aria-describedby="helpBlockEmail" required>
									@if ($errors->has('email'))
										<span id="helpBlockEmail" class="form-control-feedback form-text gf-red">- {{ $errors->first('email') }}</span>
									@endif
								</div>
								<div class="form-group">
									<label for="telephone" class="control-label">Telephone <span class="text-danger">&#42;</span></label>
									<input type="tel" name="telephone" id="telephone" class="form-control" placeholder="e.g 01224 ..." value="{{ old('telephone') }}" title="Telephone" tabindex="4" autocomplete="off" aria-describedby="helpBlockTelephone" required>
									@if ($errors->has('telephone'))
										<span id="helpBlockTelephone" class="form-control-feedback form-text gf-red">- {{ $errors->first('telephone') }}</span>
									@endif
								</div>
								<div class="form-group">
									<label for="subject" class="control-label">Subject <span class="text-danger">&#42;</span></label>
									<input type="text" name="subject" id="subject" class="form-control" placeholder="e.g Product Enquiry" value="{{ old('subject') }}" title="Subject" tabindex="5" autocomplete="off" aria-describedby="helpBlockSubject" required>
									@if ($errors->has('subject'))
										<span id="helpBlockSubject" class="form-control-feedback form-text gf-red">- {{ $errors->first('subject') }}</span>
									@endif
								</div>
								<div class="form-group">
									<label for="message" class="control-label">Message <span class="text-danger">&#42;</span></label>
									<textarea name="message" id="message" class="form-control" rows="10" placeholder="e.g Details of your message" title="Message" tabindex="6" autocomplete="off" aria-describedby="helpBlockMessage" required>{{ old('message') }}</textarea>
									@if ($errors->has('message'))
										<span id="helpBlockMessage" class="form-control-feedback form-text gf-red">- {{ $errors->first('message') }}</span>
									@endif
								</div>
								<div class="spacer"></div>
								<div class="form-group text-center text-sm-center text-md-left text-lg-left text-xl-left">
									<button type="submit" name="submit" id="submit" class="btn btn-danger" title="Send" tabindex="7">Send</button>
								</div>
							</form>
						</div>
						<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 order-1 order-sm-1 order-md-2 order-lg-2 order-xl-2">
						</div>
					</div>
				</div>
			</div>
			