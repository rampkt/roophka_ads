<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/recharge.php");
$recharge = new recharge();
include("./includes/access.php");
$page_name ="Recharge";

if (in_array($page_name, $admin_access))
  {
  //echo "Match found";
  }
else
  {
 header("location:accessdenied.php");
  }

$start = $recharge->start;

if(isset($_REQUEST['action']) AND isset($_REQUEST['id']) AND $_REQUEST['id'] > 0) {
	$operator=$_REQUEST['operator'];
	if($_REQUEST['action'] == 'activate') {
		$recharge->Activate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/operator_name.php?operator=$operator&success=1");
	}
	if($_REQUEST['action'] == 'deactivate') {
		$recharge->Deactivate($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/operator_name.php?operator=$operator&success=2");
	}
	if($_REQUEST['action'] == 'delete') {
		$recharge->Deleteoperator($_REQUEST['id']);
		redirect(HTTP_PATH . "admin/operator_name.php?success=4");
	}


	redirect(HTTP_PATH . "admin/operator_name.php");
}

if(isset($_REQUEST['action'])and ($_REQUEST['action']=="_addoperator")) {
	$recharge->name=$_REQUEST['name'];
	$recharge->short=$_REQUEST['short_name'];
	$recharge->code=$_REQUEST['code'];
	
		$recharge->operatorsave();
		redirect(HTTP_PATH . "admin/operator_name.php?success=3");

}


if(isset($_REQUEST['operator']))
{
	$operator=$_REQUEST['operator'];
	$operator2=$_REQUEST['operator'];
}
else{
$operator="";
$operator2="";
}
//echo $date;

list($operatorList,$pagination) = $recharge->getAlloperator($operator);
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
				<li>Operators</li>
			</ul>
			
			
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Operator is activated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
            <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '2') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Operator is deactivated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '3') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Operator is added successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			 <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '4') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Operator is deleted successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			<? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '5') { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success!</strong> Operator is updated successfully.
            </div>
            <div class="clearfix" style="margin-bottom:20px;"></div>
            <? } ?>
			
                 <a href="javascript:void(0);" onClick="operatoraddfn(1);" class="btn btn-small btn-primary pull-right add-new" style="margin-bottom:10px;">Add new</a>
			<div class="row-fluid ">	
				<div class="box span12">
				
					<div class="box-header">
						<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Operator Management</h2>
						<div class="box-icon">
						<form name="search" action="operator_name.php" method="get">
						<div class="row-fluid" style="height:30px;margin-top:-10px;">
			
			<div class="pull-right"><a href="javascript:void(0);" onclick="usersreportfn();"; class="btn btn-small ">Search</a></div>
			<div class="pull-right"><input type="text" name="operator" id="operator" placeholder="Enter Operator here..." value="<?php echo $operator;?>"></div>
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
                                      <th>Operator Name</th>
                                      <th>Short Name</th>
                                      <th>Operator Code</th>
									  <th>Status</th>
                                      <th style="width:235px;">Action</th>
								  </tr>
							  </thead>   
							  <tbody>
                              <?
							  if(empty($operatorList)){
							  ?>
                              <tr><td colspan="9" style="text-align:center;" class="text-error">No Operator available to show....</td></tr>
                              <?
							  } else {
								  $sno = $start + 1;
								  foreach($operatorList as $operator) {
							  ?>
								<tr>
									<td><?=$sno?></td>
                                    <td ><?=$operator['operator_name']?></td>
                                    <td><?=$operator['operator_shortname']?></td>
                                    <td><?=$operator['operator_code']?></td>
									<td class="center">
                                    	<? if($operator['status'] == 0) { ?>
										<span class="label label-success" style="padding:6px;">Active</span>
                                        <? } elseif($operator['status'] == 1) { ?>
                                        <span class="label" style="padding:6px;">Inactive</span>
                                        <? } ?>
									</td>
                                    <td>
                                    	<? if($operator['status'] == 0) { ?>
                                        <a href="./operator_name.php?action=deactivate&id=<?=$operator['id']?>&operator=<?php echo $operator2;?>" onClick="return confirm('Do you realy want to deactivate this account?');" class="btn btn-small"><i class="halflings-icon white remove"></i>Deactiavte</a>
                                        <? } elseif($operator['status'] == 1) { ?>
                                        <a href="./operator_name.php?action=activate&id=<?=$operator['id']?>&operator=<?php echo $operator2;?>" onClick="return confirm('Do you realy want to activate this account?');" class="btn btn-small btn-success"><i class="halflings-icon white ok">&nbsp;</i>Actiavte</a>
                                        <? } ?>
                                        
										<a href="./operator_name.php?action=delete&id=<?=$operator['id']?>" onClick="return confirm('Do you realy want to delete this account?');" class="btn btn-small btn-primary"><i class="halflings-icon white remove">&nbsp;</i>Delete</a>
										
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
	
    	
		
		
		<div class="modal hide fade" id="operatoradd">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Add New operator</h3>
		</div>
		<div class="modal-body" id="OperatorResult">
			
			<form action="operator_name.php" method="post" name="addoperator">
			<input type="hidden" name="action" value="_addoperator" >
			
			 <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="name">Operator Name </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="name" name="name" required placeholder="Enter Operator name ..." />
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label" for="short_name">Short Name</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge " id="short_name" name="short_name" required placeholder="Enter Short name ..." />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="codde">Operator code</label>
                                      <div class="controls">
                                        <input type="number" class="input-xlarge numberOnly" id="code" name="code" required placeholder="Enter Operator Code ..." />
                                      </div>
                                    </div>
			</fieldset>
			
			
		</div>
		<div class="modal-footer">
		<input type="submit" name="submit" value="Save" class="btn btn-primary" />	<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
		
		</form>
		
	</div>
		
	<!-- start: JavaScript-->
	<? include('./includes/footerinclude.php'); ?>
	<!-- end: JavaScript-->
	
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script>
  
  function usersreportfn()
  {
	  document.search.submit();
  }
  
  
  function operatoraddfn(val)
  {
	  //alert("adad");
	  
	  $('#operatoradd').modal('show');
	  
	  
  }
   function operatoreditfn(val,cid,cname)
  {
	  //alert(cid);
	  if(val==1)
	  {
	  document.getElementById('light1').style.display='block';
	  document.getElementById('fade1').style.display='block';
	  document.getElementById('cnid').value=cid;
	  document.getElementById('operator_nameedit').value=cname;
	  
	  }
	  
	   if(val==2)
	  {
	  document.getElementById('light1').style.display='none';
	  document.getElementById('fade1').style.display='none';
	   document.getElementById('cnid').value="";
	  document.getElementById('operator_nameedit').value="";
	  }
	  
	  
  }
  
  </script>  
  
  
 </body>
</html>