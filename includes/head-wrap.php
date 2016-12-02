<section id="page-header" class="clearfix">    
<!-- responsive FlexSlider image slideshow -->

<div class="wrapper">
	<h1 style="margin-bottom:-5px;">
    	Hi <?=ucfirst($_SESSION['roo']['user']['firstname'])?>
        <span class="pull-right account-balance">Account Balance : <i class="fa fa-inr" aria-hidden="true"></i> <span id="balance"><?=$_SESSION['roo']['user']['account_balance']?></span>/-</span>
    </h1>
	 <span style="font-size:12px;font-weight:600;"><?=date("d-M-y h:i:s",strtotime($_SESSION['roo']['user']['lastlogin']));?></span>
    </div>
</section>