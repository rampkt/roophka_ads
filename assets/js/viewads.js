// JavaScript Document

function getNextAd() {
	$('.overlay').fadeIn();
	var params = { action : '_getAds' }
	$.ajax({
		url:"user_ajax.php",
		type:'POST',
		dataType:"JSON",
		data:params,
		success: function(result) {
			$('.overlay').fadeOut();
			console.log(result);
		}
	});
}

function submitAd() {
	//$('.overlay').fadeIn();
	var params = { action : '_submitAd', adid : adsid }
	$.ajax({
		url:"user_ajax.php",
		type:'POST',
		dataType:"JSON",
		data:params,
		success: function(result) {
			//$('.overlay').fadeOut();
			console.log(result);
			if(result.error) {
				
			} else {
				$('.timer-wrap .timer').slideUp();
				$('.timer-wrap .loader').slideUp();
				$('.timer-wrap .continue').slideDown();
				$('.account-balance span').html(result.account_balance);
			}
		}
	});
}

/**
 * Countdown timer coding
 */
var count, pausecount;
var counter;
var adviewstatus;

function pauseTimer()
{
	clearInterval(counter);
}

function resetTimer()
{
    count = 0;
    clearInterval(counter);  
}

function timer(){
	count=count-1;
	if (count <= 0){
		$('#countdown').removeClass('running');
		$('#countdown').addClass('end');
		clearInterval(counter);
		document.getElementById("countdown").innerHTML='Done!!!';
		$('.timer-wrap .loader').slideDown();
		submitAd();
		return;  
	}
	document.getElementById("countdown").innerHTML=count + " secs.";
}

function countDownTimer(cnt) {
	resetTimer();
	count = cnt;
	counter=setInterval(timer, 1000);
	$('#countdown').addClass('running');
}

function timerInit() {
	if(adstype == 'video') {
		$("video").on('play',function(){
			//alert('play');
			if($('#countdown').hasClass('running') === true) {
				//alert('resume');
				countDownTimer(pausecount);
			} else if($('#countdown').hasClass('end') === false) {
				//alert('init');
				var duration = parseInt(this.duration);
				adscount = ((duration < adscount) ? duration : adscount);
				countDownTimer(adscount);
			}
		});
		$("video").on('pause',function(){
			if(this.currentTime < this.duration) {
				//alert('pause' + count);
				pausecount = count;
				resetTimer();
			} else {
				//alert('video end');
			}
		});
	} else if(adscount > 0) {
		countDownTimer(adscount);
	}
}
function adPause() {
	if($('#countdown').hasClass('running') === true) {
		if(adstype == 'video') {
			$('video').get(0).pause();
		} else {
			//alert(count);
			pausecount = count;
			resetTimer();
		}
	}
}
function adPlay() {
	if($('#countdown').hasClass('running') === true) {
		if(adstype == 'video') {
			$('video').get(0).play();
		} else {
			countDownTimer(pausecount);
		}
	}
}
$(window).on("blur focus", function(e) {
    var prevType = $(this).data("prevType");
	
    if (prevType != e.type) {   //  reduce double fire issues
        switch (e.type) {
            case "blur":
                // do work
				adPause();
                break;
            case "focus":
                // do work
				adPlay();
                break;
        }
    }

    $(this).data("prevType", e.type);
});

$(document).ready(function(e) {
    timerInit();
});