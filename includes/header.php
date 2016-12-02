<div class="container-fluid">
    <div class="row header-top">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-10 wrapper">
            <div class="col-md-6">
            	<div class="info-desc">
                	<span class="info-email"><i class="fa fa-envelope" aria-hidden="true"></i>info@roophka.com</span>
                    <!--<span class="info-phone"><i class="fa fa-phone"></i>044 42840257</span>-->
                </div>
            </div>
			
            <div class="col-md-6 top-right" align="right">
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
                    <a href="http://www.roophka.com/" class="item"><img src="<?=HTTP_PATH?>assets/img/bn.png"></a>
                    <a href="#" class="item"><img src="<?=HTTP_PATH?>assets/img/bn-3.png"></a>
                    <a href="http://www.roophka.com/" class="item"><img src="<?=HTTP_PATH?>assets/img/bn-2.png"></a>
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
                  <li <? if($pagename == 'viewads') { ?>class="current"<? } ?>><a href="./viewads.php">View ads</a></li>
                  <? if(!isset($_SESSION['roo']['user'])) { ?>
                  <li <? if($pagename == 'login') { ?>class="current"<? } ?>><a href="./login.php">Login</a></li>
                  <li <? if($pagename == 'register') { ?>class="current"<? } ?>><a href="./register.php">Register</a></li>
                  <? } else { ?>
                  <li <? if($pagename == 'dashboard') { ?>class="current"<? } ?>><a href="./dashboard.php">Dashboard</a></li>
                  <li <? if($pagename == 'myprofile') { ?>class="current"<? } ?>><a href="./myprofile.php">My Profile</a></li>
                  <li><a href="./logout.php">Logout</a></li>
                  <? } ?>
              </ul> 
              <div class="clearfix"></div>    
            </nav><!-- end main navigation -->
            <div class="clearfix"></div>
        </header>
    </div>
</div>



