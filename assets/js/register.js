// JavaScript Document

function formReset() {
	$('#city_container').append('<p class="help-block">&nbsp;</p>');
	$('#register').parsley().destroy();
	$('#register').parsley();
}

$(document).ready(function(e) {
    $('#state').on('change', function() {
		//alert(this.value);
		getCity(this.value, 0, '', 1, formReset, 'data-parsley-errors-container="#city-error"');
	});
});