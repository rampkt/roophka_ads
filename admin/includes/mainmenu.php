<div id="sidebar-left" class="span2" >
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="./dashboard.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>	
                        <? if($_SESSION['roo']['admin_user']['type'] != 3) { ?>
						<li><a href="./users.php"><i class="icon-user"></i><span class="hidden-tablet"> Users</span></a></li>
                        <? } ?>
						<li><a href="./ads.php"><i class="icon-tasks"></i><span class="hidden-tablet"> Ads</span></a></li>
                        <? if($_SESSION['roo']['admin_user']['type'] == 0) { ?>
                        <li><a href="./adminusers.php"><i class="icon-group"></i><span class="hidden-tablet"> Admin Users</span></a></li>
                        <? } ?>
						
						<li>
							<a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Reports</span><span class="label label-important"> 3 </span></a>
							<ul>
								<li><a class="submenu" href="users_report.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> User Reports</span></a></li>
								<li><a class="submenu" href="ads_report.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Ads Reports</span></a></li>
								<li><a class="submenu" href="withdraw_report.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Withdraw Reports</span></a></li>
							</ul>	
						</li>
						
						<li>
						<a href="withdraw_request.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Withdraw Request</span></a>
							
						</li>
						
						<li>
						<a href="manual_transaction.php"><i class="icon-edit"></i><span class="hidden-tablet"> Manual Transaction</span></a>
							
						</li>
						<li>
						<a href="country.php"><i class="icon-dashboard"></i><span class="hidden-tablet"> Location</span></a>
							
						</li>
						<li><a href="settings.php"><i class="icon-star"></i><span class="hidden-tablet"> Setting</span></a></li>
						<li><a href="cms.php"><i class="icon-edit"></i><span class="hidden-tablet"> CMS Pages</span></a></li>
						<!--
						<li><a href="ui.html"><i class="icon-eye-open"></i><span class="hidden-tablet"> UI Features</span></a></li>
						<li><a href="widgets.html"><i class="icon-dashboard"></i><span class="hidden-tablet"> Widgets</span></a></li>
						<li><a href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
						<li><a href="chart.html"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
						<li><a href="typography.html"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
						<li><a href="gallery.html"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
						<li><a href="table.html"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
						<li><a href="calendar.html"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
						<li><a href="file-manager.html"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
						<li><a href="icon.html"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
						<li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li>-->
					</ul>
				</div>
			</div>