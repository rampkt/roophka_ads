<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/ads.php");
$ads = new ads();
if(isset($_REQUEST['action']) AND $_REQUEST['action'] == 'details') {
	$currentAd=$ads->getAd($_REQUEST['id']);
} else {
	$ads->getsession();
}

$ads->adamount = ($ads->adamount == '') ? '0.20' : $ads->adamount;
$ads->adduration = ($ads->adduration == '') ? '20' : $ads->adduration;
$ads->addcontent = ($ads->addcontent == '') ? '' : decodehtml($ads->addcontent);

$text = true;
$banner = true;
$video = true;
$scroll=true;
if($ads->id > 0) {
	//echo $ads->addtype;
	if($ads->addtype == 'text') {
		$banner = $video =$scroll = false;
	} elseif($ads->addtype == 'image') {
		$text = $video =$scroll= false;
	} elseif($ads->addtype == 'scroll') {
		$text = $video =$banner= false;
	}elseif($ads->addtype == 'video') {
		$banner = $text =$scroll= false;
	} /*else {
		
	}*/
}

$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
list($adslist, $pagination)= $ads->getAllAdsviews($_REQUEST['id'],$page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	.totalcsshead
	{
		
		    background-color: #DDE;
    padding-top: 20px;
    margin-bottom: 20px;
    border-radius: 50px;
	}
	.form-horizontal .form-actions { margin: 0 0 -20px 0; }
	.tab-menu.nav-tabs > li > a {
		color:#FFF;
	}
	.tab-menu.nav-tabs > li > a:hover {
		color:#555;
	}
	.videoad { text-align:left; margin-left:20px;}
.videoad video, .imagead img{  max-width: 100%; width:450px; }
.spaccss
{
	margin-left:25px;
	line-height:30px;
}
 .breadcrumb a 
	{
		color:#08c !important;
	}

	</style>
	<link rel="stylesheet" href="./css/w3.css">
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
					<a href="dashboard.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				
				<li>
					<a href="ads.php">Ads</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li>Details</li>
			</ul>
			
			
            <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'empty') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong> All field should be filled.
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
            <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'failed') { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong> Insert failed, Please contact developer regarding this issue.
            </div>
            <div class="clearfix"></div>
            <? } ?>
            
            
            <!--<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Oh snap!</strong> Change a few things up and try submitting again.
            </div>
            <div class="clearfix"></div>-->
            
            <div class="row-fluid">
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Ad Details</h2>
					</div>
					<div class="col-md-12">
					<h2 style="margin:20px;"><?=$ads->adname?> (<?=$ads->addtype?>)</h2>
					</div>
					
					 <div class="col-md-12">
                         <div class="col-md-6 pull-left">
						 <div style="width:400px;margin-left:20px;"><img src="../uploads/ads/<?=$ads->filehash?>.attach" /></div>
    	                 <?=$ads->adhtml?>
   
                           </div>
	                     <div class="col-md-6 pull-left">
						 <table class="spaccss">
						 <tr>
						 <td colspan='2'><h2>Ad Specification</h2></td>
						 </tr>
						 <tr>
						 <td>Watch Count : </td>
						 <td> <?=$ads->adwatch?></td>
						 </tr>
						 <tr>
						 <td>Clicks Remain : </td>
						 <td> <?=$ads->adclicks?></td>
						 </tr>
						 <tr>
						 <td>Ad duration : </td>
						 <td> <?=$ads->adduration?> seconds</td>
						 </tr>
						 <tr>
						 <td>Click amount : </td>
						 <td> &#8377; <?=$ads->adamount?></td>
						 </tr>
						 <tr>
						 <td>Date Added : </td>
						 <td> <?=$ads->addate?></td>
						 </tr>
						 <tr>
						 <td>Ad status : </td>
						 <td>
						 <? if($ads->adstatus == 0) { ?>
										<span class="label label-success">Active</span>
                                        <? } else { ?>
                                        <span class="label">Inactive</span>
                                        <? } ?>
						 </td>
						 </tr>
						 
						 
						 </table>
						 
						 </div>
	
	                     <div class="clearfix">&nbsp;</div>
					</div>
					<hr style="border-bottom:2px solid #CCC;"/>
					<div class="col-md-12" style="margin:20px;">
					<h2>Ad View Details Progress</h2>
					</div><br>
					<? if(!empty($adslist)) { ?>
					<div class="col-md-12 totalcsshead">
					
					
					<div class="col-md-3 pull-left" style="width:15%;margin-left:20px;"><strong>Total</strong></div>
					<div class="col-md-7 pull-left" style="width:70%">
					<div class="w3-progress-container w3-light-grey w3-round-large">
    <div class="w3-progressbar w3-blue w3-round-large" style="width:100%">
      <div class="w3-center w3-text-white">100%</div>
    </div>
  </div><br></div>
  <div class="col-md-2 pull-left" style="width:10%;margin-left:30px;">
  <label class="btn btn-small btn-error"><?=$ads->totalvcount?> </label>
  </div>
  <div class="clearfix"></div>
  </div>
					<?php } ?>			
					
					
					<? if(empty($adslist)) { ?>
                                <div class="col-md-12 text-center"><font color="red">No records to show</font></div>
                                <? } else { 
									$sno = 1;
									foreach($adslist as $ad) {
					
					?>
					<div class="col-md-12">
					<div class="col-md-3 pull-left" style="width:15%;margin-left:20px;"><?php echo $ad['visitor_area']; ?></div>
					<div class="col-md-9 pull-left" style="width:70%">
					<div class="w3-progress-container w3-light-grey w3-round-large">
    <div class="w3-progressbar w3-blue w3-round-large" style="width:<?=$ad['avg'];?>%">
      <div class="w3-center w3-text-white"><?=$ad['avg'];?>%</div>
    </div>
  </div><br/></div>
  
  <div class="col-md-2 pull-left" style="width:10%;margin-left:30px;">
  <label class="btn btn-small btn-error"> <?=$ad['cnt'];?> </label>
  </div>
  <div class="clearfix"></div></div>
                  <?php
				 }
								}?>
					
				
						 <div class="pagination pagination-centered">
						  <ul>
                          	<?=$pagination?>
						  </ul>
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
	<script type="text/javascript">
	var tabtype = '<?=$ads->addtype?>';
	var edit_id = '<?=$ads->id?>';
	$(document).ready(function(e) {
        if(tabtype == 'video') {
			$('.nav-tabs a[href="#videoad"]').tab('show');
		} else if(tabtype == 'image') {
			$('.nav-tabs a[href="#bannerad"]').tab('show');
		}
    });
	</script>
</body>
</html>