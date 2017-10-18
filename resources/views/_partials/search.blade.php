								<form name="productSearch" id="productSearch" class="productSearch" role="form" method="POST" action="/products/search">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="keywords" class="form-control-label @if ($hideLabel) d-none @endif"><span class="sr-only">Product Search</span></label>
										<div class="input-group">	
											<input type="text" name="keywords" id="keywords" class="form-control" value="{{ old('keywords') ?? $keywords }}" aria-label="{{ $placeholder }}" placeholder="{{ $placeholder }}" tabindex="-1" autocomplete="on">
											<span class="input-group-btn">
												<button type="submit" name="submit_product_search" id="submit_product_search" class="btn btn-outline-danger" title="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
											</span>
										</div>							
									</div>
								</form>
						