<?php
include_once("../config/config.php");
is_admin_login();
include("./functions/ads.php");
$ads = new ads();
if(isset($_REQUEST['action']) AND $_REQUEST['action'] == 'edit') {
	$ads->getAd($_REQUEST['id']);
} else {
	$ads->getsession();
}

if(isset($_REQUEST['action']) AND $_REQUEST['action'] == '_add_ads') {
	//print_r($_REQUEST);
	
	$ads->addtype = $db->escape_string($_REQUEST['addtype']);
	$ads->adname = $db->escape_string($_REQUEST['adname']);
	$ads->adclicks = $db->escape_string($_REQUEST['adclicks']);
	$ads->adamount = $db->escape_string($_REQUEST['adamount']);
	$ads->adduration = $db->escape_string($_REQUEST['adduration']);
	if($ads->addtype == 'text') {
		$ads->addtitle = $db->escape_string($_REQUEST['addtitle']);
		$ads->addcontent = encodehtml($_REQUEST['addcontent']);
	} else {
		$ads->file = $_FILES['upload'];
	}
	$ads->id = ((isset($_REQUEST['addid'])) ? $_REQUEST['addid'] : '');
	
	$emptycheck = $ads->emptycheck();
	if($emptycheck === false) {
		if($ads->id > 0) {
			redirect(HTTP_PATH . 'admin/ads_add.php?action=edit&error=empty&id='.$ads->id);
		} else {
			redirect(HTTP_PATH . 'admin/ads_add.php?error=empty');
		}
	}
	
	$save = $ads->save();
	if($save === false) {
		if($ads->id > 0) {
			redirect(HTTP_PATH . 'admin/ads_add.php?action=edit&error=failed&id='.$ads->id);
		} else {
			redirect(HTTP_PATH . 'admin/ads_add.php?error=failed');
		}
	}
	
	redirect(HTTP_PATH . 'admin/ads.php?success=1');
	
}

$ads->adamount = ($ads->adamount == '') ? '0.20' : $ads->adamount;
$ads->adduration = ($ads->adduration == '') ? '20' : $ads->adduration;
$ads->addcontent = ($ads->addcontent == '') ? '' : decodehtml($ads->addcontent);

$text = true;
$banner = true;
$video = true;

if($ads->id > 0) {
	echo $ads->addtype;
	if($ads->addtype == 'text') {
		$banner = $video = false;
	} elseif($ads->addtype == 'image') {
		$text = $video = false;
	} elseif($ads->addtype == 'video') {
		$banner = $text = false;
	} /*else {
		
	}*/
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include('./includes/head.php'); ?>
    <style type="text/css">
	.form-horizontal .form-actions { margin: 0 0 -20px 0; }
	.tab-menu.nav-tabs > li > a {
		color:#FFF;
	}
	.tab-menu.nav-tabs > li > a:hover {
		color:#555;
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
			
			<? include('./includes/breadcrumb.php'); ?>
			
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
						<h2><i class="halflings-icon white th"></i><span class="break"></span>Adding New Advertisement</h2>
					</div>
					<div class="box-content">
						<ul class="nav tab-menu nav-tabs" id="myTab">
							<li class="active <? echo (($text === false) ? 'hide' : ''); ?>"><a href="#textadd">Text Ad</a></li>
							<li class="<? echo (($banner === false) ? 'hide' : ''); ?>"><a href="#bannerad">Banner Ad</a></li>
							<li class="<? echo (($video === false) ? 'hide' : ''); ?>"><a href="#videoad">Video Ad</a></li>
						</ul>
						 
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active <? echo (($text === false) ? 'hide' : ''); ?>" id="textadd">
								<form class="form-horizontal" method="post">
                                <input type="hidden" name="action" value="_add_ads" />
                                <input type="hidden" name="addtype" value="text" />
                                <? if($ads->id != '') { ?>
                                	<input type="hidden" name="addid" value="<?=$ads->id?>" />
                                <? } ?>
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="adname">Name </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="adname" name="adname" value="<?=$ads->adname?>" />
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label" for="adclicks">Total click</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge numberOnly" id="adclicks" name="adclicks" maxlength="5" value="<?=$ads->adclicks?>" />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="adamount">Earn amount</label>
                                      <div class="controls">
                                        <input type="number" class="input-xlarge" id="adamount" name="adamount" value="<?=$ads->adamount?>" step="0.01" min="0" max="100" />
                                      </div>
                                    </div>
        
                                    <div class="control-group">
                                      <label class="control-label" for="adduration">View duration</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge numberOnly" id="adduration" name="adduration" maxlength="5" value="<?=$ads->adduration?>" />
                                        <p class="help-block">Calculate in seconds</p>
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="addtitle">Ad Title</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="addtitle" name="addtitle" value="<?=$ads->addtitle?>" />
                                      </div>
                                    </div>
                                              
                                    <div class="control-group ">
                                      <label class="control-label" for="addcontent">Ad Content</label>
                                      <div class="controls">
                                        <textarea class="cleditor" id="addcontent" rows="3" name="addcontent"><?=$ads->addcontent?></textarea>
                                      </div>
                                    </div>
                                    <div class="form-actions">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                      <button type="reset" class="btn">Cancel</button>
                                    </div>
                                  </fieldset>
                                </form>
							</div>
                            
                            
							<div class="tab-pane <? echo (($banner === false) ? 'hide' : ''); ?>" id="bannerad">
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_add_ads" />
                                <input type="hidden" name="addtype" value="image" />
                                <? if($ads->id != '') { ?>
                                	<input type="hidden" name="addid" value="<?=$ads->id?>" />
                                <? } ?>
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="adname">Name </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="adname" name="adname" value="<?=$ads->adname?>" />
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label" for="adclicks">Total click</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge numberOnly" id="adclicks" name="adclicks" maxlength="5" value="<?=$ads->adclicks?>" />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="adamount">Earn amount</label>
                                      <div class="controls">
                                        <input type="number" class="input-xlarge" id="adamount" name="adamount" value="<?=$ads->adamount?>" step="0.01" min="0" max="100" />
                                      </div>
                                    </div>
        
                                    <div class="control-group">
                                      <label class="control-label" for="adduration">View duration</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge numberOnly" id="adduration" name="adduration" maxlength="5" value="<?=$ads->adduration?>" />
                                        <p class="help-block">Calculate in seconds</p>
                                      </div>
                                    </div>
                                       
                                    <div class="control-group ">
                                      <label class="control-label" for="banner">Upload banner</label>
                                      <div class="controls">
                                        <input type="file" name="upload" id="banner" />
                                        <p class="help-block">jpg, png, gif</p>
                                      </div>
                                    </div>
                                    <div class="form-actions">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                      <button type="reset" class="btn">Cancel</button>
                                    </div>
                                  </fieldset>
                                </form>
							</div>
                            
                            
							<div class="tab-pane <? echo (($video === false) ? 'hide' : ''); ?>" id="videoad">
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="_add_ads" />
                                <input type="hidden" name="addtype" value="video" />
                                <? if($ads->id != '') { ?>
                                	<input type="hidden" name="addid" value="<?=$ads->id?>" />
                                <? } ?>
                                  <fieldset>
                                    <div class="control-group">
                                      <label class="control-label" for="adname">Name </label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge" id="adname" name="adname" value="<?=$ads->adname?>" />
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label" for="adclicks">Total click</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge numberOnly" id="adclicks" name="adclicks" maxlength="5" value="<?=$ads->adclicks?>" />
                                      </div>
                                    </div>
                                    
                                    <div class="control-group">
                                      <label class="control-label" for="adamount">Earn amount</label>
                                      <div class="controls">
                                        <input type="number" class="input-xlarge" id="adamount" name="adamount" value="<?=$ads->adamount?>" step="0.01" min="0" max="100" />
                                      </div>
                                    </div>
        
                                    <div class="control-group">
                                      <label class="control-label" for="adduration">View duration</label>
                                      <div class="controls">
                                        <input type="text" class="input-xlarge numberOnly" id="adduration" name="adduration" maxlength="5" value="<?=$ads->adduration?>" />
                                        <p class="help-block">Calculate in seconds</p>
                                      </div>
                                    </div>
                                      
                                    <div class="control-group">
                                      <label class="control-label" for="banner">Upload video</label>
                                      <div class="controls">
                                        <input type="file" name="upload" id="banner" />
                                        <p class="help-block">mp4</p>
                                      </div>
                                    </div>
                                    <div class="form-actions">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                      <button type="reset" class="btn">Cancel</button>
                                    </div>
                                  </fieldset>
                                </form>
							</div>
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