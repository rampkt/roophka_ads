<?php 

 $code="<option value=''>Select Operator</option>";
			$qry = $db->query("SELECT * FROM roo_mobile_operator where status='0' order by operator_name asc");
			$count=$db->num_rows($qry);
			$i=1;
			
			if($count>0)
			{
			while($row = $db->fetch_array($qry))
			{
				
				if(isset($_SESSION['recharge_operator']) && ($_SESSION['recharge_operator']==$row['operator_shortname'])){ $select ='selected'; }else{$select="";}
			
			$code.="<option value='".$row['operator_shortname']."' ".$select."> ".$row['operator_name']."</option>";
			 
			$i++;
			}
			//echo $code;
			}

	$circle="<option value=''>Select Circle</option>";
			$qry1 = $db->query("SELECT * FROM roo_operator_circle where status='0' order by circle_name asc");
			$count1=$db->num_rows($qry1);
			$ii=1;
			
			if($count1>0)
			{
			while($row1 = $db->fetch_array($qry1))
			{
				
				if(isset($_SESSION['recharge_circle']) && ($_SESSION['recharge_circle']==$row1['circle_code'])){ $select ='selected'; }else{$select="";}
			
			$circle.="<option value='".$row1['circle_code']."' ".$select."> ".$row1['circle_name']."</option>";
			 
			$ii++;
			}
			//echo $code;
			}	

$qry_scroll = $db->query("SELECT * FROM roo_cms WHERE id='1'");
			$row_scroll = $db->fetch_array($qry_scroll);			
			
?>

<div class="container-fluid">
    <div class="row header-top">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-10 wrapper">
            <div class="col-md-2">
            	<div class="info-desc">
                	<span class="info-email"><i class="fa fa-envelope" aria-hidden="true"></i>info@roophka.com</span>
                    <!--<span class="info-phone"><i class="fa fa-phone"></i>044 42840257</span>-->
                </div>
            </div>
			<div class="col-md-8">
			<div class="info-desc" ><marquee style="margin-bottom:-10px;" onmouseover="this.stop();" onmouseout="this.start();"><?=$row_scroll['scrolling_content']?></marquee></div>
			</div>
            <div class="col-md-2 top-right" align="right">
            	<!--<a href="#" ><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></i></a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></i></a>-->
				<span class='st_facebook'></span>
<span class='st_twitter' ></span>
<span class='st_linkedin' ></span>
<span class='st_pinterest' ></span>
<span class='st_googleplus' ></span>

				
            </div>
        </div>
        <div class="col-md-1">&nbsp;</div>
		<div class="clearfix"></div>
    </div>
    
    <div class="row header-logo">
    	<div class="col-md-1">&nbsp;</div>
        <div class="col-md-10 wrapper">
            <div class="logo-wrapper">		
                <div class="main-logo">
                    <a href="./">
                        <!-- Main logo -->
                        <img src="<?=HTTP_PATH?>assets/img/roophka-logo.png" alt="Roopha" title="Roopha" class="normal-logo" />
                    </a>
                </div>
            </div>
            
            <div class="gen-menu-header">
                <div class="gen-menu">
                    <a href="https://www.roophka.com/" class="item"><img src="<?=HTTP_PATH?>assets/img/bn.png"></a>
                    <a href="#" class="item"><img src="<?=HTTP_PATH?>assets/img/bn-3.png"></a>
                    <a href="https://www.roophka.com/" class="item"><img src="<?=HTTP_PATH?>assets/img/bn-2.png"></a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-1">&nbsp;</div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container-fluid">
    <div class="row header-nav">
        <header class="wrapper clearfix">
            <!-- main navigation -->
            <nav id="topnav" role="navigation">
              <div class="menu-toggle">Menu</div>  
              <ul class="srt-menu" id="menu-main-navigation">
                  <li <? if($pagename == 'home') { ?>class="current"<? } ?>><a href="./">Home</a></li>
				  
				   <? if(!isset($_SESSION['roo']['user'])) { ?>
				  
				   <li <? if($pagename == 'recharge') { ?>class="current"<? } ?>><a href="javascript:void(0);" onclick="rechargepopup('showme');">Recharge </a>
				   <ul id="showme" class="rc-form" style="display:none;">
				   <li>
				    <div>
    	<form action='recharge_proceed.php' name="recharge" method="get" >
         <input type="hidden" name="action" value="recharge">
            <div style="text-align:left;padding:20px">
              <!-- MObile NUmber -->
              <div>
              <div style="padding-bottom:.5rem">Mobile Number</div>
            
              <div style="padding-bottom:20px">  
			  <input type="text" id="mobile" name="mobile" class="rc-input numberOnly"  onkeypress="findoperatorvalue(this.value)" onkeyup="findcirclevalue(this.value)" placeholder="Enter Numeric values" Autocomplete="OFF" required />
			  </div>
           </div>
		   <div>
              <!-- Opertaor -->
              <div style="padding-bottom:.5rem">Opearator</div>
             <div style="padding-bottom:20px" >
               <select name="operator" id="operator" class="rc-input" required> 
                <?php echo $code; ?>				
               </select> 
            </div>
			</div>
			
			 <div>
              <!-- Circle -->
              <div style="padding-bottom:.5rem">Circle</div>
             <div style="padding-bottom:20px" >
               <select name="circle" id="circle" class="rc-input" required> 
                <?php echo $circle; ?>				
               </select> 
            </div>
			</div>
			
			
			  <div>
			  <!-- Amount -->
              <div style="padding-bottom:.5rem">Amount</div>
            
              <div >  
			  <input type="text" id="amount" name="amount" class="rc-input numberOnly" placeholder="Enter Amount" required /></div>
           </div>
			
			
			</div>
			
           <div class="clearfix"></div>
			
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button type="submit" name="submit" value="proceed" class="btn btn-success">Proceed</button>
              </div>
            </div>
			
        </form>
    <!-- #end content area -->
      
				   </div>
				   
				   </li>
				  
				   </ul>
				   
				   </li>
				   <?php } else { ?>
				    <li <? if($pagename == 'recharge') { ?>class="current"<? } ?>><a href="./recharge_proceed.php?view=order">Recharge</a></li>
				   <?php } ?>
				  
                  <li <? if($pagename == 'viewads') { ?>class="current"<? } ?>><a href="./viewadslist.php">View ads</a></li>
                  <? if(!isset($_SESSION['roo']['user'])) { ?>
                  <li <? if($pagename == 'login') { ?>class="current"<? } ?>><a href="./login.php">Login</a></li>
                  <li <? if($pagename == 'register') { ?>class="current"<? } ?>><a href="./register.php">Register</a></li>
                  <? } else { ?>
                  <li <? if($pagename == 'dashboard') { ?>class="current"<? } ?>><a href="./dashboard.php">Dashboard</a></li>
                  <li <? if($pagename == 'myprofile') { ?>class="current"<? } ?>><a href="./myprofile.php">My Profile</a></li>
                  <li><a href="./logout.php">Logout</a></li>
                  <? } ?>
				   <li <? if($pagename == 'contact') { ?>class="current"<? } ?>><a href="./contactus.php">Contact Us</a></li>
              </ul> 
              <div class="clearfix"></div>    
            </nav><!-- end main navigation -->
            <div class="clearfix"></div>
        </header>
    </div>
</div>

<script>

function rechargepopup(id) 
{
    var e = document.getElementById(id);
    if (e.style.display == 'block' || e.style.display=='')
    {
        e.style.display = 'none';
    }
    else 
    {
        e.style.display = 'block';
    }
}
function findoperatorvalue(val) {
//	alert("sri");
	var params = { action : '_findoperator',mobile:val}
	$.ajax({
		url:"operator.php",
		type:'POST',
		dataType:"TEXT",
		data:params,
		success: function(result) {
		
			//alert(result);
			if(result.error) {
				
			} else {
			$('#operator').html(result);
			}
		}
	});
}
</script>
<script>
function findcirclevalue(val) {
	//alert("devi");
	var params = { action : '_findcircle',mobile:val}
	$.ajax({
		url:"operator.php",
		type:'POST',
		dataType:"TEXT",
		data:params,
		success: function(result) {
		
			//alert(result);
			if(result.error) {
				
			} else {
			$('#circle').html(result);
			findoperatorplans('TUP');
			}
		}
	});
}
 
</script>

<style>
.table
{
	font-size:13px;
}

#alertamt
{
	color: red;
    font-size: 12px;
    width: 290px;
    position: absolute;
   
}
.rc-input
{
height:30px;
border:1px solid #ccc; 
border-radius:5px;
width:100%;
color:#55595c;
font-size:14px;
}
.btn-success
{
	padding:5px 10px;
	margin-bottom:10px;
}
.rc-form
{
	position:absolute !important;
	z-index:100;
	background-color:#FFF;
	width:300px;
	
}
input.rc-input
{
	padding-left:5px;
	
}
.rc-formshow
{
	display:block !important;
}
.rc-formhide
{
	display:none !important;
}
</style>

