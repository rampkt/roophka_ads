// JavaScript Document

/*window.parsley.addValidator('dobvalidate', {
  validateString: function(value, requirement) {
    alert(requirement);
	return false;
	//return value.split('').reverse().join('') === value;
  },
  messages: {
    en: 'Give valide D O B.'
  }
});*/

function getCity(sid, cid, cls, req, callback, attribute) {
	var params = { cmd:'_getCity', state:sid, city:cid, class:cls, required:req, attr:attribute };
	$('.overlay').fadeIn();
	$.ajax({
		url:"user_ajax.php",
		type:"POST",
		dataType:"JSON",
		data:params,
		success: function(data) {
			$('.overlay').fadeOut();
			if(data.error) {
				alert(data.msg);
			} else {
				$('#city_container').html(data.html);
				callback();
			}
		}
	});
}

$(document).ready(function(e) {
    
	//Hide loader
	$('.overlay').fadeOut();
	
	// For number only allowed validation
	$(".numberOnly").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	
	// Home page slider video
	$('.slidervideo').click(function(){ this.play(); }).mouseleave(function(e) { this.pause(); });
	
});