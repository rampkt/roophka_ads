<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/location.php");
$location = new location();
include("./includes/access.php");
$page_name ="Advertise";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }

$start = $location->start;



//echo $date;

list($advertiseList,$pagination) = $location->getAlladvertise(1);
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
				<li>Resumes</li>
			</ul>
			
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Record is deleted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '3') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Record is Approved successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
               
			<div class="row-fluid ">	
				<div class="box span12">
				
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Resume Management</h2>
						<div class="box-icon">
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
                                     <th>Name</th>
                                      <th>email</th>
                                      <th>Address</th>
									  <th>Mobile</th>
									  <th>Date</th>
                                      <th style="width:185px;">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($advertiseList)){
							  ?>
                              <tr><td colspan="9" style="text-align:center;" class="text-error">No Resumes available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($advertiseList as $adv) {
							  ?>
								<tr>
									<td><?=$sno?></td>
                                    <td><?=$adv['contact_person']?></td>
                                    <td><?=$adv['email']?></td>
									<td><?=$adv['address1']?>,<?=$adv['address2']?>,<?=$adv['countryname']?>,<?=$adv['statename']?>,<?=$adv['cityname']?>,<?=$adv['pincode']?></td>
									<td><?=$adv['mobile']?></td>
									
									<td><?=date("d-M-Y h:i:s",strtotime($adv['date_added']))?></td>
									
                                    <td>
                                   
                                        <a href="../uploads/resume/<?=$adv['filename']?>" class="btn btn-small btn-primary"><i class="halflings-icon white ok">&nbsp;</i>Download</a>
                                       
										
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
	
    <!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 </body>
</html>