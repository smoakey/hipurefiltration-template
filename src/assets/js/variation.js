import _ from 'lodash';

const $ = jQuery;

$(document).ready(init);

function init() {
	var noVariationsTemplate = $('.no-variations-availability-template');
	$('.woocommerce-variation').after('<span class="hipure-variations"></span>');
	var dataMap = noVariationsTemplate.data('map');

	// dont hack for products with variations
	if (!noVariationsTemplate.length) {
		return;
	}

	// when we have selected all attributes show availability
    $('.variations_form').on('change', 'select', function () {
    	var attrs = $('.variations_form').serializeArray().filter(function(control) {
    		return control.name.substr(0,10) == 'attribute_';
    	});

    	var filledAttrs = attrs.filter(function(control) {
    		return control.value != '';
    	});

    	if (attrs.length == filledAttrs.length) {
    		var filledAttrValues = attrs.map(function(control) {
    			var key = control.name.substr(10);
    			return _.get(dataMap[key], control.value, control.value);
    		});

    		var html = noVariationsTemplate
    			.html()
    			.replace(/product_sku=([^"]*)/, 'product_sku=$1' + filledAttrValues.join(''));

    		$('.hipure-variations').html(html);
    	}
    });
}