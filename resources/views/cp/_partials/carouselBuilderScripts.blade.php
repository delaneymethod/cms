<script async>
'use strict';

let usedCounters = [];

function loadAssetsBrowser(id, counter) {
	$('#' + id + '-browse-modal').on('show.bs.modal', event => {
		const button = $(event.relatedTarget);
		
		const fieldId = button.data('field_id');
		
		const value = button.data('value');
		
		window.CMS.ControlPanel.attachAssetBrowser('#' + id + '-container', fieldId, value);
	});
	
	$('#' + id + '-reset-field').on('click', () => {
		$('#' + id).val('').blur();
		
		$('a[data-target="#' + id + '-browse-modal"]').data('value', '');
	});
	
	usedCounters.push(counter);
}

function loadCarouselBuilder() {
	let x = 1;
	
	$('.add_form_group').on('click', event => {
		event.preventDefault();
		
		x = usedCounters.length + 1;
		
		/**
		 * Because we are creating fields on the fly with incremental IDs, 
		 * when we add a few and then remove some from the middle, e.g 1, 2, 3, 4 and then remove 3, 
		 * and then add a new one again, the IDs become broken so this check finds the missing numbers in a sequence 
		 */
		usedCounters.sort();
		
		for (let i = 1; i < usedCounters.length; i++) {
			if (usedCounters[i] - usedCounters[i - 1] != 1) {
				x = usedCounters[i] - usedCounters[i - 1];
			}
		}

		let slide = '';
		
		slide += '<div class="form-group">' + '\r\n';
		slide += '	<div class="spacer"></div>' + '\r\n';
		slide += '	<div class="spacer"><hr></div>' + '\r\n';
		slide += '	<div class="spacer"></div>' + '\r\n';
		slide += '	<label for="slide_' + x + '_image" class="control-label font-weight-bold">Slide ' + x + ' Image</label>' + '\r\n';
		slide += '	<div class="input-group">' + '\r\n';
		slide += '		<input type="text" name="slide_' + x + '_image" id="slide_' + x + '_image" class="form-control" autocomplete="off" placeholder="" value="{{ old('slide_\' + x + \'_image') }}" tabindex="' + (x + 2) + '" aria-describedby="helpBlockSlideImage' + x + '" />' + '\r\n';
		slide += '		<span class="input-group-btn">' + '\r\n';
		slide += '			<a href="javascript:void(0);" title="Select Asset" rel="nofollow" data-toggle="modal" data-target="#slide_' + x + '_image-browse-modal" data-field_id="slide_' + x + '_image" data-value="{{ old('slide_\' + x + \'_image') }}" class="btn btn-outline-secondary">Select Asset</a>' + '\r\n';
		slide += '			<a href="javascript:void(0);" title="Clear Asset" rel="nofollow" id="slide_' + x + '_image-reset-field" class="btn btn-outline-secondary">Clear Asset</a>' + '\r\n';
		slide += '		</span>' + '\r\n';
		slide += '	</div>' + '\r\n';
		slide += '	<div class="spacer"></div>' + '\r\n';
		slide += '	<label for="slide_' + x + '_content" class="control-label font-weight-bold">Slide ' + x + ' Content</label>' + '\r\n';
		slide += '	<textarea name="slide_' + x + '_content" id="slide_' + x + '_content" class="form-control redactor" autocomplete="off" placeholder="" rows="5" cols="50" tabindex="' + (x + 3) + '" aria-describedby="helpBlockSlideContent' + x + '">{{ old('slide_\' + x + \'_content') }}</textarea>' + '\r\n';
		slide += '	<div class="spacer"></div>' + '\r\n';
		slide += '	<div class="text-right">' + '\r\n';
		slide += '		<a href="javascript:void(0);" title="Remove Slide" rel="nofollow" class="btn btn-outline-warning remove_field" data-counter="' + x + '">Remove Slide ' + x + '</a>' + '\r\n';
		slide += '	</div>' + '\r\n';
		slide += '	<div class="modal fade" id="slide_' + x + '_image-browse-modal" tabindex="-1" role="dialog" aria-labelledby="slide_' + x + '_image-browse-modal-label" aria-hidden="true">' + '\r\n';
		slide += '		<div class="modal-dialog modal-lg modal-xl" role="document">' + '\r\n';
		slide += '			<div class="modal-content">' + '\r\n';
		slide += '				<div class="modal-header">' + '\r\n';
		slide += '					<h5 class="modal-title" id="slide_' + x + '_image-browse-modal-label">Assets</h5>' + '\r\n';
		slide += '				</div>' + '\r\n';
		slide += '				<div class="modal-body">' + '\r\n';
		slide += '					<div class="container-fluid">' + '\r\n';
		slide += '						<div class="row no-gutters">' + '\r\n';
		slide += '							<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 text-left">' + '\r\n';
		slide += '								<div id="slide_' + x + '_image-container"></div>' + '\r\n';
		slide += '							</div>' + '\r\n';
		slide += '							<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 text-center">' + '\r\n';
		slide += '								<div id="slide_' + x + '_image-selected-asset-preview"></div>' + '\r\n';
		slide += '							</div>' + '\r\n';
		slide += '						</div>' + '\r\n';
		slide += '					</div>' + '\r\n';
		slide += '				</div>' + '\r\n';
		slide += '				<div class="modal-footer">' + '\r\n';
		slide += '					<div class="container-fluid">' + '\r\n';
		slide += '						<div class="row d-flex h-100 justify-content-start">' + '\r\n';
		slide += '							<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 align-self-center align-self-sm-center align-self-md-left align-self-lg-left align-self-xl-left">' + '\r\n';
		slide += '								<div class="text-center text-sm-center text-md-left text-lg-left text-xl-left selected-asset" id="slide_' + x + '_image-selected-asset"></div>' + '\r\n';
		slide += '							</div>' + '\r\n';
		slide += '							<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center text-sm-center text-md-center text-lg-right text-xl-right align-self-center">' + '\r\n';
		slide += '								<button type="button" class="btn btn-primary" id="slide_' + x + '_image-select-asset">Insert</button>' + '\r\n';
		slide += '								<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>' + '\r\n';
		slide += '							</div>' + '\r\n';
		slide += '						</div>' + '\r\n';
		slide += '					</div>' + '\r\n';
		slide += '				</div>' + '\r\n';
		slide += '			</div>' + '\r\n';
		slide += '		</div>' + '\r\n';
		slide += '	</div>' + '\r\n';
		slide += '</div>';
		
		$('#wrapper').append(slide);
		
		loadAssetsBrowser('slide_' + x + '_image', x);
		
		window.CMS.ControlPanel.attachRedactor('#slide_' + x + '_content');
	});
	
	$('#wrapper').on('click', '.remove_field', event => {
		event.preventDefault(); 
		
		const counter = $(event.target).data('counter');
		
		const id = $(event.target).parents('.form-group').find('input').attr('id');
		
		window.CMS.ControlPanel.detachAssetBrowser('#' + id + '-container');
		
		window.CMS.ControlPanel.detachRedactor('#' + id);
		
		$(event.target).parents('.form-group').remove();
		
		usedCounters.splice($.inArray(counter, usedCounters), 1);
		
		x = usedCounters.length;
	});
}

if (window.attachEvent) {
	window.attachEvent('onload', () => {
		loadCarouselBuilder();
		
		@if (!empty($carousel->slides))
			@foreach ($carousel->slides as $key => $value)
				@php ($key = $key + 1)
				loadAssetsBrowser('slide_{{ $key }}_image', {{ $key }});
			@endforeach
		@else
			loadAssetsBrowser('slide_1_image', 1);
		@endif
	});
} else if (window.addEventListener) {
	window.addEventListener('load', () => {
		loadCarouselBuilder();
		
		@if (!empty($carousel->slides))
			@foreach ($carousel->slides as $key => $value)
				@php ($key = $key + 1)
				loadAssetsBrowser('slide_{{ $key }}_image', {{ $key }});
			@endforeach
		@else
			loadAssetsBrowser('slide_1_image', 1);
		@endif
	}, false);
} else {
	document.addEventListener('load', () => {
		loadCarouselBuilder();
		
		@if (!empty($carousel->slides))
			@foreach ($carousel->slides as $key => $value)
				@php ($key = $key + 1)
				loadAssetsBrowser('slide_{{ $key }}_image', {{ $key }});
			@endforeach
		@else
			loadAssetsBrowser('slide_1_image', 1);
		@endif
	}, false);
}
</script>
