<?php
include_once("../config/config.php");
$login = check_admin_login();
if($login === true) {
	redirect(HTTP_PATH . 'admin/dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Admin | <?=$setting['title']?></title>
	<meta name="description" content="<?=$setting['description']?>">
	<meta name="author" content="<?=$setting['sitename']?>">
	<meta name="keyword" content="<?=$setting['keyword']?>">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
    <link id="base-style-responsive" href="../assets/css/parsley.css" rel="stylesheet">
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
			<style type="text/css">
			body { background: url(img/bg-login.jpg) !important; }
			.logo-wrap { position:relative; }
			.logo-text { bottom: 0;
    position: absolute;
    margin-bottom: 1px;
    font-size: 16px;
    text-decoration: underline;
    font-weight: 700;
    color: #15326a; }
			.error-containers { margin-top: -20px;
    padding: 0 20px;
	color: #b36a5b; }
			.login-error {
				padding: 0 20px;
				margin-top:10px;
			}
			.login-error .alert {
				margin-bottom:0;
			}
		</style>
		
		
		
</head>

<body>
		<div class="container-fluid-full">
		<div class="row-fluid">
					
			<div class="row-fluid">
				<div class="login-box">
					<div class="icons">
                    	<span class="pull-left logo-wrap">
                    		<img src="../assets/img/common/roophka-logo.png" width="100" /> <span class="logo-text">Admin</span>
                        </span>
						<a href="../"><i class="halflings-icon home"></i></a>
						<!--<a href="#"><i class="halflings-icon cog"></i></a>-->
                        <div class="clearfix"></div>
					</div>
					<h2>Login to your account</h2>
					<form class="form-horizontal" action="login.php" method="post" data-parsley-validate="">
                    	<input type="hidden" name="action" value="dologin" />
						<fieldset>
							
							<div class="input-prepend" title="Username">
								<span class="add-on"><i class="halflings-icon user"></i></span>
								<input class="input-large span10" name="username" id="username" type="text" placeholder="type username" required data-parsley-errors-container="#username-error" />
							</div>
                            <div id="username-error" class="error-containers"></div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password">
								<span class="add-on"><i class="halflings-icon lock"></i></span>
								<input class="input-large span10" name="password" id="password" type="password" placeholder="type password" required data-parsley-errors-container="#password-error" />
							</div>
                            <div id="password-error" class="error-containers"></div>
							<div class="clearfix"></div>
							
							<label class="remember" for="remember"><input type="checkbox" id="remember" />Remember me</label>

							<div class="button-login">	
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
							<div class="clearfix"></div>
                            
                            <?php if(isset($_REQUEST['logout'])) { ?>
                            <div class="login-error">
                            	<div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <i class="halflings-icon ok"></i> Logged out successfully!!!.
                                </div>
                            </div>
                            <? } ?>
                            
                            <?php if(isset($_REQUEST['error'])) { ?>
                            <div class="login-error">
                            	<?php if($_REQUEST['error'] == 1) { ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>!!!</strong> username and password shouldn't empty.
                                </div>
                                <?php } elseif($_REQUEST['error'] == 2) { ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Login failed!</strong> username or password mismatch.
                                </div>
                                <?php } elseif($_REQUEST['error'] == 3) { ?>
                                <div class="alert alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>!!!</strong> your login has been blocked, Contact admin.
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </fieldset>
					</form>
					
				</div><!--/span-->
			</div><!--/row-->
			

	</div><!--/.fluid-container-->
	
		</div><!--/fluid-row-->
	    
        
	<!-- start: JavaScript-->

		<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="js/jquery.ui.touch-punch.js"></script>
	
		<script src="js/modernizr.js"></script>
	
		<script src="js/bootstrap.min.js"></script>
	
		<script src="js/jquery.cookie.js"></script>
        
        <script src="../assets/js/parsley.min.js"></script>
	
		<script src="js/jquery.uniform.min.js"></script>
		
		<script src="js/jquery.cleditor.min.js"></script>

		<script src="js/custom.js"></script>
	<!-- end: JavaScript-->
	
</body>
</html>
