// JavaScript Document

function editprofile() {
	if($('#profile_edit').parsley().validate()) {
		return true
	} 
	return false;
}

function formReset() {
	$('#profile_edit').parsley().destroy();
	 $('#profile_edit').parsley();
}

$(document).ready(function(e) {
    $('#state').on('change', function() {
		//alert(this.value);
		getCity(this.value, 0, 'width-50', 1, formReset);
	});
});