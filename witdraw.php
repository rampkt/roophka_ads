<?php
include_once("./config/config.php");
/***
 * initial setup
 */
$pagename = 'myprofile';
$subname = 'withdraw';

$login = check_login();
if($login === false) {
	redirect(HTTP_PATH . 'login.php');
}

include("./functions/user.php");
$user = new user;

if(isset($_REQUEST['cmd'])) {
	if($_REQUEST['cmd'] == '_addbank') {
		$data = array();
		$data['user_id'] = 0;
		$data['name'] = $db->escape_string($_REQUEST['name']);
		$data['bank'] = $db->escape_string($_REQUEST['bankname']);
		$data['ac_name'] = $db->escape_string($_REQUEST['accname']);
		$data['number'] = $db->escape_string($_REQUEST['accnumber']);
		$data['branch'] = $db->escape_string($_REQUEST['branch']);
		$data['ifsc'] = $db->escape_string($_REQUEST['ifsc']);
		$result = $user->addBank($data);
		if($result['error']) {
			if($result['msg'] == 'empty')
				redirect(HTTP_PATH . "witdraw.php?error=empty");
			elseif($result['msg'] == 'insert')
				redirect(HTTP_PATH . "witdraw.php?error=insert");
			else
				redirect(HTTP_PATH . "witdraw.php?error=1");
		} else {
			redirect(HTTP_PATH . "witdraw.php?success=1");
		}
	}
	if($_REQUEST['cmd'] == '_addwithdraw') {
		$amount = $_REQUEST['withdraw_amount'];
		if($amount >= 500) {
			$result = $user->addWithdraw($amount);
			if($result['error']) {
				redirect(HTTP_PATH . "witdraw.php?error=withdraw");
			} else {
				redirect(HTTP_PATH . "witdraw.php?success=withdraw");
			}
		} else {
			redirect(HTTP_PATH . "witdraw.php?error=amount");
		}
	}
	redirect(HTTP_PATH . 'witdraw.php');
}

$withdraw = $user->withdraw_status(0);
$accounts = $user->accounts(0);
//print_r($accounts);exit;
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<? include("./includes/head.php"); ?>
<link type="text/css" rel="stylesheet" href="./assets/css/dashboard.css" />
</head>

<body id="home">
  
	<!-- header area -->
	<? include("./includes/header.php"); ?>
    <!-- end header -->
 
 
<? include("./includes/head-wrap.php"); ?>

<!-- main content area -->   
<div id="main" class="wrapper transaction"> 
	
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'empty') { ?>
    <div class="error-msg"><strong>Bank account adding failed!</strong> All fields should be filled...</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'insert') { ?>
    <div class="error-msg"><strong>Bank account adding failed!</strong> Data update issue, Please try again or after some time later.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == '1') { ?>
    <div class="error-msg"><strong>Bank account adding failed!</strong> Some thing went wrong, Please try again later</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'amount') { ?>
    <div class="error-msg"><strong>Withdraw failed!</strong> Withdraw amount should be greater or equal to minimum reqired amount.</div>
    <? } ?>
    
    <? if(isset($_REQUEST['error']) AND $_REQUEST['error'] == 'withdraw') { ?>
    <div class="error-msg"><strong>Withdraw failed!</strong> Some thing went wrong, Please try again later</div>
    <? } ?>
    
    <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == '1') { ?>
    <div class="success-msg"><strong>Update Success!</strong> Your new bank account added successfully....</div>
    <? } ?>
    
    <? if(isset($_REQUEST['success']) AND $_REQUEST['success'] == 'withdraw') { ?>
    <div class="success-msg"><strong>Withdraw Success!</strong> Your request for withdraw proccessed successfully. Admin will validate and complete within 24Hrs.</div>
    <? } ?>
    
    <!-- content area -->    
	<section id="content">
    	
        <div class="grid_4 no-padding">
            <div class="panel panel-primary">
              <div class="panel-heading">Available to withdraw</div>
              <div class="panel-body"><i class="fa fa-inr" aria-hidden="true"></i> <?=$withdraw['withdraw_available']?>/-</div>
            </div>
        </div>
        
        <div class="grid_4 no-padding">
            <div class="panel panel-primary">
              <div class="panel-heading">Withdraw pending</div>
              <div class="panel-body"><i class="fa fa-inr" aria-hidden="true"></i> <?=$withdraw['withdraw_pending']?>/-</div>
            </div>
        </div>
        
        <div class="grid_4 no-padding">
            <div class="panel panel-primary">
              <div class="panel-heading">Total withdrawn</div>
              <div class="panel-body"><i class="fa fa-inr" aria-hidden="true"></i> <?=$withdraw['withdraw_total']?>/-</div>
            </div>
        </div>
        
        <div class="grid_12">
        	<? if($withdraw['withdraw_pending'] <=0) { ?><a href="javascript:void(0);" class="btn btn-link pull-right" data-toggle="modal" data-target="#addBankAccount">Add bank</a><? } ?>
        	<h3>Bank accounts to withdraw</h3>
            
        	<table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Account name</th>
                  <th>Account</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              	<? if(empty($accounts)) { ?>
                <tr><td colspan="5" class="text-danger" align="center">No account details updated, please add account to start withdraw</td>
                <? } else { 
					$i=1;
					foreach($accounts as $data) {
				?>
                <tr>
                  <th scope="row"><?=$i?></th>
                  <td><?=$data['name']?></td>
                  <td><?=$data['number']?></td>
                  <td>
				  	<? if($data['status'] == 0) { ?>
                    	<span class="text-success">Active</span>
                    <? } else { ?>
                    	<span class="text-warning">Inactive</span>
                    <? } ?>
                  </td>
                  <td>
                  <? if($withdraw['withdraw_pending'] <=0) { ?>
                  	<a href="#" class="text-danger" onClick="return confirm('Are you sure you want to delete your bank account?');">Delete</a>
                    
                    <? if($data['status'] == 0) { ?>
                    	<!--<a href="#" class="text-warning">Deactivate</a>-->
                    <? } else { ?>
                    	| <a href="#" class="text-success" onClick="return confirm('By activate this account will deavtivate other active account if you have.\nDo you want to proceed now?');">Activate</a>
                    <? } ?>
                  <? } else { ?>
                  	<span class="text-info">Withdraw in progress</span>
                  <? } ?>
                  </td>
                </tr>
                <? $i++; } } ?>
              </tbody>
            </table>
        </div>
        <? if(!empty($accounts)) { ?>
        <div class="grid_12">
        	<center>
            	<? if($withdraw['withdraw_available'] < 500) { ?>
            		<button class="btn btn-success" title="Minimum balance not met" disabled>WITHDRAW NOW</button>
                    <p class="text-danger">Minimum withdraw amount <i class="fa fa-inr" aria-hidden="true"></i> 500/-</p>
                <? } else { ?>
                	<button class="btn btn-success" data-toggle="modal" data-target="#addWithdraw">WITHDRAW NOW</button>
                <? } ?>
            </center>
        </div>
        <? } ?>
    </section><!-- #end content area -->
      
      
    <!-- sidebar -->    
    <? include("./includes/loginmenu.php"); ?>
    <!-- #end sidebar -->
   
  </div><!-- #end div #main .wrapper -->


<!-- footer area -->    
<? include("./includes/footer.php"); ?>
<!-- #end footer area --> 

<? if($withdraw['withdraw_available'] >= 500) { ?>
<!-- Modal -->
<div id="addWithdraw" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form class="form-horizontal" action='' name="addbank" method="POST" data-parsley-validate="">
    <input type="hidden" name="cmd" value="_addwithdraw" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Withdraw amount</h4>
      </div>
      
      <div class="modal-body">
      <center>
      	<p>Withdraw amount should be greater then <i class="fa fa-inr" aria-hidden="true"></i> 500. And below available amount</p>
        <input type="number" id="withdraw_amount" name="withdraw_amount" placeholder="" min="500" max="<?=$withdraw['withdraw_available']?>" value="500.00" class="form-control width-50" required />
      </center>
      </div>
      
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Withdraw</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<? } ?>

<? if($withdraw['withdraw_pending'] <=0) { ?>
<!-- Modal -->
<div id="addBankAccount" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form class="form-horizontal" action='' name="addbank" method="POST" data-parsley-validate="">
    <input type="hidden" name="cmd" value="_addbank" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add new bank account</h4>
      </div>
      <div class="modal-body">
        <div>
        	
              <fieldset style="border:0;">
                <div class="control-group">
                  <!-- Username -->
                  <label class="control-label"  for="name">Account Name</label>
                  <div class="controls">
                    <input type="text" id="name" name="name" placeholder="" class="form-control input-lg" required />
                  </div>
                </div>
                
                <div class="control-group">
                  <!-- Username -->
                  <label class="control-label"  for="accname">Account Holder Name</label>
                  <div class="controls">
                    <input type="text" id="accname" name="accname" placeholder="" class="form-control input-lg" required />
                  </div>
                </div>
                
                <div class="control-group">
                  <!-- Username -->
                  <label class="control-label"  for="accnumber">Account Number</label>
                  <div class="controls">
                    <input type="text" id="accnumber" name="accnumber" placeholder="" class="form-control input-lg numberOnly" required />
                  </div>
                </div>
                
                <div class="control-group">
                  <!-- Username -->
                  <label class="control-label"  for="bankname">Bank Name</label>
                  <div class="controls">
                    <input type="text" id="bankname" name="bankname" placeholder="" class="form-control input-lg" required />
                  </div>
                </div>
                
                <div class="control-group">
                  <!-- Username -->
                  <label class="control-label"  for="branch">Branch</label>
                  <div class="controls">
                    <input type="text" id="branch" name="branch" placeholder="" class="form-control input-lg" required />
                  </div>
                </div>
                
                <div class="control-group">
                  <!-- Username -->
                  <label class="control-label"  for="ifsc">IFSC Code (optional)</label>
                  <div class="controls">
                    <input type="text" id="ifsc" name="ifsc" placeholder="" class="form-control input-lg" />
                  </div>
                </div>
              </fieldset>
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<? } ?>
<? include("./includes/footerinclude.php"); ?>

<script type="text/javascript" src="./assets/js/withdraw.js"></script>

</body>
</html>