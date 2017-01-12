<aside>
<!--        <h2>Secondary Section menu</h2>-->
            <nav id="secondary-navigation">
                    <ul>
                    	<? if(!isset($_SESSION['roo']['user'])) { ?>
                            <li <? if($subname == 'register') { ?>class="current"<? } ?>><a href="register.php">Register</a></li>
                            <li <? if($subname == 'login') { ?>class="current"<? } ?>><a href="login.php">Login</a></li>
							 
                        <? } else { ?>
                            <li <? if($subname == 'withdraw') { ?>class="current"<? } ?>><a href="witdraw.php">Withdraw</a></li>
							 <li <? if(isset($_REQUEST['view'])&&($_REQUEST['view'] == 'recharge')) { ?>class="current"<? } ?>><a href="recharge_proceed.php?view=recharge">Recharge Now</a></li>
							  <li <?  if(isset($_REQUEST['view'])&&($_REQUEST['view'] == 'order')) { ?>class="current"<? } ?>><a href="recharge_proceed.php?view=order">Recharge Orders</a></li>
							  <li <? if($subname == 'viewads') { ?>class="current"<? } ?>><a href="viewads.php">View All Ads</a></li>
							    <li <? if($subname == 'allads') { ?>class="current"<? } ?>><a href="viewadslist.php">Ads List</a></li>
                            <li <? if($subname == 'transaction') { ?>class="current"<? } ?>><a href="transaction.php">Transaction</a></li>
                            <li <? if($subname == 'password') { ?>class="current"<? } ?>><a href="password.php">Change Password</a></li>
                        <? } ?>
                        <li <? if($subname == 'aboutus') { ?>class="current"<? } ?>><a href="aboutus.php">About Us</a></li>
                        <li <? if($subname == 'how') { ?>class="current"<? } ?>><a href="howitworks.php">How it works</a></li>
						<li <? if($subname == 'advertise') { ?>class="current"<? } ?>><a href="advertise.php">Advertise with us</a></li>
                       <!-- <li <? //if($subname == 'plans') { ?>class="current"<? //} ?>><a href="plans.php">Advertisement Plans</a></li> -->						
						
                    </ul>
             </nav>
      </aside>