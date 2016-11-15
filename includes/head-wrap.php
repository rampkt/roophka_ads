<section id="page-header" class="clearfix">    
<!-- responsive FlexSlider image slideshow -->

<div class="wrapper">
	<h1>
    	Hi <?=ucfirst($_SESSION['roo']['user']['firstname'])?>
        <span class="pull-right account-balance">Account Balance : <i class="fa fa-inr" aria-hidden="true"></i> <span id="balance"><?=$_SESSION['roo']['user']['account_balance']?></span>/-</span>
    </h1>
    </div>
</section>