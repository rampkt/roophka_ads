<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/location.php");
$location = new location();

include("./includes/access.php");
$page_name ="Location";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }


$start = $location->start;

if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	$country=$_REQUEST['country'];
	if($_REQUEST['action'] == 'activate') {
		$location->Activate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/country.php?country=$country&success=1");
	}
	if($_REQUEST['action'] == 'deactivate') {
		$location->Deactivate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/country.php?country=$country&success=2");
	}
	if($_REQUEST['action'] == 'delete') {
		$location->Deletecountry($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/country.php?success=4");
	}


	redirect(HTTP_PATH . "admin/country.php");
}

if(isset($_REQUEST['submit'])and ($_REQUEST['country_name']!="")) {
	$country_name=$_REQUEST['country_name'];
	
		$location->countrysave($country_name);
		redirect(HTTP_PATH . "admin/country.php?success=3");

}
if(isset($_REQUEST['submit'])and ($_REQUEST['country_nameedit']!="")) {
	$country_nameedit=$_REQUEST['country_nameedit'];
	$cnid=$_REQUEST['cnid'];
		$location->countryupdate($cnid,$country_nameedit);
		redirect(HTTP_PATH . "admin/country.php?success=5");

}



if(isset($_REQUEST['country']))
{
	$country=$_REQUEST['country'];
	$country2=$_REQUEST['country'];
}
else{
$country="";
$country2="";
}
//echo $date;

list($countryList,$pagination) = $location->getAllcountry($country);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	.add-search { margin:-15px 0 10px 0;}
    .btn-small{padding:4px 10px;}	
    .breadcrumb a 
	{
		color:#08c !important;
	}
	</style>
</head>

<body>
		<!-- start: Header -->
        <? include('./includes/header.php'); ?>
        <!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid">
				
			<!-- start: Main Menu -->
			<? include('./includes/mainmenu.php'); ?>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			<? //include('./includes/breadcrumb.php'); ?>
            
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="dashoboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Country</li>
			</ul>
			
			
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Country is activated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Country is deactivated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '3') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Country is added successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Country is deleted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '5') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Country is updated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
                 <a href="javascript:void(0);" onClick="countryaddfn(1);" class="btn btn-small btn-primary pull-right add-new" style="margin-bottom:10px;">Add new</a>
			<div class="row-fluid ">	
				<div class="box span12">
				
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Country Management</h2>
						<div class="box-icon">
						<form name="search" action="country.php" method="get">
						<div class="row-fluid" style="height:30px;margin-top:-10px;">
			
			<div class="pull-right"><a href="javascript:void(0);" onclick="usersreportfn();"; class="btn btn-small ">Search</a></div>
			<div class="pull-right"><input type="text" name="country" id="country" placeholder="Enter country here..." value="<?php echo $country;?>"></div>
			 <div class="clearfix" style="margin-bottom:20px;"></div>
			
			</div>
			</form>
							<!--<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
									  <th>Sno</th>
                                      <th>Country</th>
                                      <th>State</th>
                                      <th>City</th>
									  <th>Status</th>
                                      <th style="width:235px;">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($countryList)){
							  ?>
                              <tr><td colspan="9" style="text-align:center;" class="text-error">No Country available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($countryList as $cntry) {
							  ?>
								<tr>
									<td><?=$sno?></td>
                                    <td ><?=$cntry['name']?></td>
                                    <td><span class="label label-success" style="padding:6px;">
									<a href="state.php?id=<?=$cntry['id']?>"><?=$cntry['state']?></a>
									</span></td>
                                    <td><span class="label" style="padding:6px;">
									<?=$cntry['city']?>
									</span></td>
									<td class="center">
                                    	<? if($cntry['status'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Active</span>
                                        <? } elseif($cntry['status'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($cntry['status'] == 0) { ?>
                                        <a href="./country.php?action=deactivate&id=<?=$cntry['id']?>&country=<?php echo $country2;?>" onClick="return confirm('Do you really want to deactivate this account?');" class="btn btn-small"><i class="halflings-icon white remove"></i>Deactiavte</a>
                                        <? } elseif($cntry['status'] == 1) { ?>
                                        <a href="./country.php?action=activate&id=<?=$cntry['id']?>&country=<?php echo $country2;?>" onClick="return confirm('Do you really want to activate this account?');" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i>Actiavte</a>
                                        <? } ?>
                                        
										<a href="./country.php?action=delete&id=<?=$cntry['id']?>" onClick="return confirm('Do you really want to delete this account?');" class="btn btn-small btn-primary"><i class="halflings-icon white ok">&nbsp;</i>Delete</a>
										
										 <a href="javascript:void(0);" onClick="countryeditfn(1,'<?php echo $cntry['id'];?>','<?php echo $cntry['name'];?>');" class="btn btn-small " >Edit</a>
                                    </td>
								</tr>
                              <? $sno++; } } ?>
							  </tbody>
						 </table>  
						 <div class="pagination pagination-centered">
						  <ul>
                          	<?=$pagination?>
						  </ul>
						</div>     
					</div>
				</div><!--/span-->
			</div><!--/row-->
			
       

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	
    <? include('./includes/footer.php'); ?>
	
    	
		<div id="light" class="white_content"> <a href = "javascript:void(0)" onclick = "countryaddfn(2);"><button type="button" class="close" data-dismiss="modal">x</button></a>
		<div style="border-bottom:2px solid #ccc;width100%;margin:5px;"><h2>Add New Country</h2></div>
		<form action="country.php" method="post">
		<div class="row-fluid" style="margin-top:20px;">
		<div class="pull-left" style="margin-right:10px;">Country :</div>
		<div class="pull-left">
		<input type="text" name="country_name" id="country_name"  class="input-xlarge" placeholder="Enter country here..." required>
		</div>
		<div class="clearfix" style="margin-bottom:10px;"></div>
		</div>
		
		<div>
		<input type="submit" name="submit" id="submit" value="submit" style="padding:5px 15px;" class="btn btn-small btn-primary add-new">
		</div>
		
		</form>
		<div></div>
		</div>
		<div id="fade" class="black_overlay"></div>
		
		<div id="light1" class="white_content"> <a href = "javascript:void(0)" onclick = "countryeditfn(2);"><button type="button" class="close" data-dismiss="modal">x</button></a>
		<div style="border-bottom:2px solid #ccc;width100%;margin:5px;"><h2>Add edit Country</h2></div>
		<form action="country.php" method="post">
		<div class="row-fluid" style="margin-top:20px;">
		<div class="pull-left" style="margin-right:10px;">Country :</div>
		<div class="pull-left">
		<input type="text" name="country_nameedit" id="country_nameedit"  class="input-xlarge" placeholder="Enter country here..." required>
		</div>
		<div class="clearfix" style="margin-bottom:10px;"></div>
		</div>
		<input type="hidden" name="cnid" id="cnid">
		<div>
		<input type="submit" name="submit" id="submit" value="submit" style="padding:5px 15px;" class="btn btn-small btn-primary add-new">
		</div>
		
		</form>
		<div></div>
		</div>
		<div id="fade1" class="black_overlay"></div>
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script>
  
  function usersreportfn()
  {
	  document.search.submit();
  }
  function countryaddfn(val)
  {
	  //alert("adad");
	  if(val==1)
	  {
	  document.getElementById('light').style.display='block';
	  document.getElementById('fade').style.display='block';
	  }
	  
	   if(val==2)
	  {
	  document.getElementById('light').style.display='none';
	  document.getElementById('fade').style.display='none';
	  }
	  
	  
  }
   function countryeditfn(val,cid,cname)
  {
	  //alert(cid);
	  if(val==1)
	  {
	  document.getElementById('light1').style.display='block';
	  document.getElementById('fade1').style.display='block';
	  document.getElementById('cnid').value=cid;
	  document.getElementById('country_nameedit').value=cname;
	  
	  }
	  
	   if(val==2)
	  {
	  document.getElementById('light1').style.display='none';
	  document.getElementById('fade1').style.display='none';
	   document.getElementById('cnid').value="";
	  document.getElementById('country_nameedit').value="";
	  }
	  
	  
  }
  
  </script>  
  
  
  <style>
		.black_overlay{
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			top: 25%;
			left: 25%;
			width: 50%;
			height: 25%;
			padding: 16px;
			border: 10px solid #578EBE;
			background-color: white;
			z-index:1002;
			overflow: auto;
			border-radius:10px;
		}
	</style>
</body>
</html>