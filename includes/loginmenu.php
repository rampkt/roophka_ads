<aside>
<!--        <h2>Secondary Section menu</h2>-->
            <nav id="secondary-navigation">
                    <ul>
                    	<? if(!isset($_SESSION['roo']['user'])) { ?>
                            <li <? if($subname == 'register') { ?>class="current"<? } ?>><a href="register.php">Register</a></li>
                            <li <? if($subname == 'login') { ?>class="current"<? } ?>><a href="login.php">Login</a></li>
                        <? } else { ?>
                            <li <? if($subname == 'withdraw') { ?>class="current"<? } ?>><a href="witdraw.php">Withdraw</a></li>
                            <li <? if($subname == 'transaction') { ?>class="current"<? } ?>><a href="transaction.php">Transaction</a></li>
                            <li <? if($subname == 'password') { ?>class="current"<? } ?>><a href="password.php">Change Password</a></li>
                        <? } ?>
                        <li <? if($subname == 'aboutus') { ?>class="current"<? } ?>><a href="#">About Us</a></li>
                        <li <? if($subname == 'how') { ?>class="current"<? } ?>><a href="#">How it works</a></li>
                    </ul>
             </nav>
      </aside>