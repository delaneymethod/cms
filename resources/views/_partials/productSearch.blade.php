			<div class="row">
				<div class="col-12 text-center">
					<h4>Search {{ $totalProducts }} Products</h4>
					{{--
					<p>Type in your keywords to begin searching&hellip;</p>
					--}}
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
			<div class="row d-flex h-100 justify-content-center">
				<div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-start">
					@include('_partials.search', [
						'placeholder' => 'e.g Hex Setscrew, ISO 4017/DIN 933, Brass',
						'keywords' => $keywords,
						'hideLabel' => true
					])
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
			<div class="row">
				<div class="col-12"><hr></div>
			</div>
			<div class="row">
				<div class="col-12 spacer very-tall"></div>
			</div>
		</div>
		<div class="container">
			