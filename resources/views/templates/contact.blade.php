			{{--
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			--}}
			@for ($i = 1; $i <= 10; $i++)
				@component('_components.page.content', [
					'field' => 'section'.$i.'Content',
					'page' => $page
				])
				@endcomponent
			@endfor
			<div class="row d-flex">
				<div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 order-3 order-sm-3 order-md-2 order-lg-1 order-xl-1 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<div class="spacer"></div>
					<h4>Contact Us</h4>
					<h5 class="text-danger">Customer Care</h5>
					<p>For all sales orders, quotes or general enquiries: <a href="tel:+441224772777" title="Call us" class="telephone-number d-block d-sm-block d-md-inline-block d-lg-inline-block d-xl-inline-block">&#43;44 (0) 1224 772 777</a></p>
					<p><a href="mailto:connect@grampianfasteners.com" title="Email us" class="email-address">connect@grampianfasteners.com</a></p>
				</div>
				<div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 order-1 order-sm-1 order-md-1 order-lg-2 order-xl-2 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<div class="spacer"></div>
					<h4>Postal Address</h4>
					<h5 class="text-danger">Grampian Fasteners</h5>
					<p>Grampian House,<br>Pitmedden Road,<br>Dyce, Aberdeen,<br>AB21 0DP,<br>Scotland,<br>United Kingdom.</p>
					<div class="spacer d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
				</div>
				<div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 order-2 order-sm-2 order-md-3 order-lg-3 order-xl-3 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<div class="spacer d-none d-sm-block d-md-none d-lg-block d-xl-block"></div>
					<h4>Opening Times</h4>
					<h5 class="text-danger">Monday to Friday</h5>
					<p>07:00 - 17:00.</p>
					<h5 class="text-danger">Saturday &amp; Sunday</h5>
					<p>Closed.</p>
				</div>
				<div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 order-4 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<div class="spacer d-block d-sm-block d-md-none d-lg-block d-xl-block"></div>
					<h4>Credit Account</h4>
					<p>Applying for a Grampian Fasteners Credit Account is quick and easy&nbsp;to&nbsp;do.</p>
					<p><a href="http://www.grampianfasteners.com/files/ed7dc2d1-b20f-4c16-87a1-9fe35fd8fa32/Credit_Account_Request_-_Grampian_Fasteners_v3.2.pdf" title="Find our more">Find out more.</a></p>
				</div>
			</div>	
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="row d-flex">
						<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 order-2 order-sm-2 order-md-2 order-lg-1 order-xl-1">
							<div class="row">
								<div class="col-12 spacer"></div>
							</div>
							<div class="row">
								<div class="col-12 bg-lighter-grey">	
									<div class="spacer"></div>
									<h4 class="text-center text-sm-center text-md-left text-lg-left text-xl-left">Enquiry Form</h4>
									<div class="spacer"></div>
									<form name="contactForm" id="contactForm" class="contactForm" role="form" method="POST" action="/contact">
										{{ csrf_field() }}
										<div class="form-group">
											<label for="first_name" class="control-label">First Name <span class="text-danger">&#42;</span></label>
											<input type="text" name="first_name" id="first_name" class="form-control" placeholder="e.g Joe" value="{{ old('first_name') }}" title="First Name" tabindex="1" autocomplete="off" aria-describedby="helpBlockFirstName" required autofocus>
											@if ($errors->has('first_name'))
												<span id="helpBlockFirstName" class="form-control-feedback form-text gf-red">- {{ $errors->first('first_name') }}</span>
											@endif
										</div>
										<div class="spacer"></div>
										<div class="form-group">
											<label for="last_name" class="control-label">Last Name <span class="text-danger">&#42;</span></label>
											<input type="text" name="last_name" id="last_name" class="form-control" placeholder="e.g Bloggs" value="{{ old('last_name') }}" title="Last Name" tabindex="2" autocomplete="off" aria-describedby="helpBlockLastName" required>
											@if ($errors->has('last_name'))
												<span id="helpBlockLastName" class="form-control-feedback form-text gf-red">- {{ $errors->first('last_name') }}</span>
											@endif
										</div>
										<div class="spacer"></div>
										<div class="form-group">
											<label for="email" class="control-label">Email Address <span class="text-danger">&#42;</span></label>
											<input type="email" name="email" id="email" class="form-control" placeholder="e.g joe@bloggs.com" value="{{ old('email') }}" title="Email Address" tabindex="3" autocomplete="off" aria-describedby="helpBlockEmail" required>
											@if ($errors->has('email'))
												<span id="helpBlockEmail" class="form-control-feedback form-text gf-red">- {{ $errors->first('email') }}</span>
											@endif
											<span id="did-you-mean" class="form-control-feedback form-text gf-red">- Did you mean <a href="javascript:void(0);" title="Click to fix your mistake." rel="nofollow"></a>?</span>
										</div>
										<div class="spacer"></div>
										<div class="form-group">
											<label for="telephone" class="control-label">Telephone <span class="text-danger">&#42;</span></label>
											<input type="tel" name="telephone" id="telephone" class="form-control" placeholder="e.g 01224 &hellip;" value="{{ old('telephone') }}" title="Telephone" tabindex="4" autocomplete="off" aria-describedby="helpBlockTelephone" required>
											@if ($errors->has('telephone'))
												<span id="helpBlockTelephone" class="form-control-feedback form-text gf-red">- {{ $errors->first('telephone') }}</span>
											@endif
										</div>
										<div class="spacer"></div>
										<div class="form-group">
											<label for="subject" class="control-label">Subject <span class="text-danger">&#42;</span></label>
											<input type="text" name="subject" id="subject" class="form-control" placeholder="e.g Product Enquiry, General Enquiry, E-Procurement Enquiry" value="{{ old('subject') }}" title="Subject" tabindex="5" autocomplete="off" aria-describedby="helpBlockSubject" required>
											@if ($errors->has('subject'))
												<span id="helpBlockSubject" class="form-control-feedback form-text gf-red">- {{ $errors->first('subject') }}</span>
											@endif
										</div>
										<div class="spacer"></div>
										<div class="form-group">
											<label for="message" class="control-label">Message <span class="text-danger">&#42;</span></label>
											<textarea name="message" id="message" class="form-control" rows="10" placeholder="e.g Details of your message" title="Message" tabindex="6" autocomplete="off" aria-describedby="helpBlockMessage" required>{{ old('message') }}</textarea>
											@if ($errors->has('message'))
												<span id="helpBlockMessage" class="form-control-feedback form-text gf-red">- {{ $errors->first('message') }}</span>
											@endif
										</div>
										<div class="spacer"></div>
										<div class="form-group">
											<div class="g-recaptcha" data-sitekey="{{ config('services.google.recaptcha.key') }}"></div>
										</div>
										<div class="spacer"></div>
										<div class="form-group text-center text-sm-center text-md-left text-lg-left text-xl-left">
											<button type="submit" name="submit_contact" id="submit_contact" class="btn btn-danger" title="Send Enquiry" tabindex="7">Send Enquiry</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 ml-auto order-1 order-sm-1 order-md-1 order-lg-2 order-xl-2">
							<div class="row">
								<div class="col-12 spacer"></div>
							</div>
							<div class="row">
								<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
									<div class="spacer"></div>
									<h4>Other Contacts</h4>
									<div class="spacer"></div>
								</div>
								<div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
									<h5 class="text-danger">International &amp; Projects</h5>
									<p>For all international orders or quotes: <a href="tel:+441224727467" title="Call us" class="telephone-number d-block d-sm-block d-md-block d-lg-inline-block d-xl-inline-block">&#43;44 (0) 1224 727 467</a></p>
									<p><a href="mailto:paul.cunningham@grampianfasteners.com" title="Email us" class="email-address">paul.cunningham<br>@grampianfasteners.com</a></p>
									<div class="spacer"></div>
								</div>
								<div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
									<h5 class="text-danger">Purchasing</h5>
									<p>For all supplier enquiries: <a href="tel:+441224727465" title="Call us" class="telephone-number d-block d-sm-block d-md-block d-lg-inline-block d-xl-inline-block">&#43;44 (0) 1224 727 465</a></p>
									<p><a href="mailto:purchasing@grampianfasteners.com" title="Email us" class="email-address">purchasing@grampianfasteners.com</a></p>
									<div class="spacer"></div>
								</div>
								<div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
									<h5 class="text-danger">Accounts</h5>
									<p>For all accounts enquiries: <a href="tel:+441224727478" title="Call us" class="telephone-number d-block d-sm-block d-md-block d-lg-inline-block d-xl-inline-block">&#43;44 (0) 1224 727 478</a></p>
									<p><a href="mailto:accounts@grampianfasteners.com" title="Email us" class="email-address">accounts@grampianfasteners.com</a></p>
									<div class="spacer"></div>
								</div>
								<div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
									<h5 class="text-danger">Trade Shop</h5>
									<p>To browse our product range: <a href="tel:+441224727464" title="Call us" class="telephone-number d-block d-sm-block d-md-block d-lg-inline-block d-xl-inline-block">&#43;44 (0) 1224 727 464</a></p>
									<p><a href="mailto:tradeshop@grampianfasteners.com" title="Email us" class="email-address">tradeshop@grampianfasteners.com</a></p>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="spacer tall"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row map-padding">
						<div class="col-12">
							<div class="spacer very-tall"></div>
						</div>
					</div>		
					<div class="row map-info">
						<div class="col-12">
							<div class="spacer"></div>
						</div>
						<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<h4>How To Find Us</h4>
						</div>
						<div class="col-12">
							<div class="spacer"></div>
						</div>
					</div>		
				</div>
			</div>
		</div>
		<div class="container-fluid map" style="margin-bottom: -40px;background-image: url('/');"></div>
		<div class="container">		
			