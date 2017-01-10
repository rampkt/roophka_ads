function checkamount(useramt)
  {
	var enteramt=document.recharge_proceed.amount.value;
	
	var eamt=parseInt(enteramt);
	
	var fullamt=parseInt(useramt);
	
	//alert(eamt+"<br>"+fullamt);
	//return false;
	 var smat=$('#spl_rechr').val();
	 if(smat==0)
	 {
	 if(fullamt<30)
	 {
		 $('#alertamt').html("If must be to reach Rs.30 in your account balance. After that only you can proceed recharge");
		 document.recharge_proceed.amount.value="";
		  //$('#amount').css('outline-color','red')
		  document.recharge_proceed.amount.focus();
		 return false;
	 }
	
	  if(eamt>fullamt)
	  {
		  $('#alertamt').html("Please enter below "+useramt+" rupees");
		  document.recharge_proceed.amount.value="";
		  //$('#amount').css('outline-color','red')
		  document.recharge_proceed.amount.focus();
		  return false;
		  
	  }  
	 }
	  
  }
  
  function pickval(amt)
  {
	  
	  document.recharge_proceed.amount.value=amt;
	  
  }
  
  $( document ).ready(function() {
   // console.log( "ready!" );
   var mobileval=document.recharge_proceed.mobile.value;
	var opval=document.recharge_proceed.operator.value;
	var circleval=document.recharge_proceed.circle.value;
	
	//alert(mobileval+''+opval+''+circleval);
	if((mobileval!="")&&(opval!="")&&(circleval!="")){
		findoperatorplans('TUP');
	}
});
  
  
function findoperatorplans(val) {
	
	var htmlval=$('#topupplans'+val).html();
	if(htmlval=='<br>Enter 10 digit mobile number in given form on the left to view plans.')
	{
	//	alert(htmlval);
	
	
	
	//alert("devi");
	var mobileval=document.recharge_proceed.mobile.value;
	var opval=document.recharge_proceed.operator.value;
	var circleval=document.recharge_proceed.circle.value;
	
	//alert(mobileval+''+opval+''+circleval);
	if((mobileval!="")&&(opval!="")&&(circleval!="")){
		
		$('#topupplans'+val).html('<img src="./assets/images/loader.gif" />');
		
	var params = { action : '_findplans',circle:circleval,operator:opval,mobile:mobileval,type:val}
	$.ajax({
		url:"operatorplans.php",
		type:'POST',
		dataType:"text",
		data:params,
		success: function(result) {
		
			//alert(result);
			if(result.error) {
				
			} else {
			$('#topupplans'+val).html(result);
			}
		}
	});
	}
}
}
 