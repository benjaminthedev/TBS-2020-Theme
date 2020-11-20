;(function ( $, window, document ) {
	'use strict';

	let rangeSliderWidget = document.querySelectorAll('.cz-range-slider');

	for (let i = 0; i < rangeSliderWidget.length; i++) {

		let rangeSlider = rangeSliderWidget[i].querySelector('.cz-range-slider-ui'),
			valueMinInput = rangeSliderWidget[i].querySelector('.cz-range-slider-value-min'),
			valueMaxInput = rangeSliderWidget[i].querySelector('.cz-range-slider-value-max');

		let options = {
			dataStartMin: parseInt(rangeSliderWidget[i].dataset.startMin, 10),
			dataStartMax: parseInt(rangeSliderWidget[i].dataset.startMax, 10),
			dataMin: parseInt(rangeSliderWidget[i].dataset.min, 10),
			dataMax: parseInt(rangeSliderWidget[i].dataset.max, 10),
			dataStep: parseInt(rangeSliderWidget[i].dataset.step, 10),
			currencySymbol: rangeSliderWidget[i].dataset.currencySymbol,
		};

		noUiSlider.create(rangeSlider, {
			start: [options.dataStartMin, options.dataStartMax],
			connect: true,
			step: options.dataStep,
			pips: {mode: 'count', values: 5},
			tooltips: true,
			range: {
				'min': options.dataMin,
				'max': options.dataMax
			},
			format: {
				to: function (value) {
					return options.currencySymbol + parseInt(value, 10);
				},
				from: function (value) {
					return Number(value);
				}
			}
		});

		rangeSlider.noUiSlider.on('update', function(values, handle) {
			let value = values[handle];
			value = value.replace(/\D/g,'');
			if (handle) {
				valueMaxInput.value = Math.round(value);
			} else {
				valueMinInput.value = Math.round(value);
			}
		});

		rangeSlider.noUiSlider.on( 'change', function ( values, handle ) {
			rangeSliderWidget[i].querySelector( 'form' ).submit();
		} );

		valueMinInput.addEventListener('change', function() {
			rangeSlider.noUiSlider.set([this.value, null]);
			rangeSliderWidget[i].querySelector( 'form' ).submit();
		});

		valueMaxInput.addEventListener('change', function() {
			rangeSlider.noUiSlider.set([null, this.value]);
			rangeSliderWidget[i].querySelector( 'form' ).submit();
		});
	}

})( jQuery, window, document );
