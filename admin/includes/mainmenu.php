<div id="sidebar-left" class="span2" style="overflow-y:scroll;" >
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="./dashboard.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>	
                       <?php  if (in_array("Users", $admin_access)) { ?>
						<li><a href="./users.php"><i class="icon-user"></i><span class="hidden-tablet"> Users</span></a></li>
                       <?php } if (in_array("Ads", $admin_access))
                       { ?>
						<li><a href="./ads.php"><i class="icon-tasks"></i><span class="hidden-tablet"> Ads</span></a></li>
					   <?php } if (in_array("Adminuser", $admin_access))
                       { ?>
                        <li><a href="./adminusers.php"><i class="icon-group"></i><span class="hidden-tablet"> Admin Users</span></a></li>
					   <?php } if (in_array("Reports", $admin_access))
                       { ?>
						<li>
							<a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Reports</span><span class="label label-important"> 3 </span></a>
							<ul>
								<li><a class="submenu" href="users_report.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> User Reports</span></a></li>
								<li><a class="submenu" href="ads_report.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Ads Reports</span></a></li>
								<li><a class="submenu" href="withdraw_report.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Withdraw Reports</span></a></li>
							</ul>	
						</li>
						
						
						<li>
							<a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Plan Details</span><span class="label label-important"> 2 </span></a>
							<ul>
								<li><a class="submenu" href="plancategory.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Plan Category</span></a></li>
								<li><a class="submenu" href="plandetails.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Plan Details</span></a></li>
								
							</ul>	
						</li>
						
					   <?php } if (in_array("Bulkmail", $admin_access)) { ?>
						<li>
							<a class="dropmenu" href="#"><i class="icon-star"></i><span class="hidden-tablet"> Bulk Emails</span><span class="label label-important"> 5 </span></a>
							<ul>
							<li><a class="submenu" href="compose.php"><i class="icon-file-alt"></i><span class="hidden-tablet">Compose</span></a></li>
							<li><a class="submenu" href="sentemails.php"><i class="icon-file-alt"></i><span class="hidden-tablet">Sent Emails</span></a></li>
								<li><a class="submenu" href="emailcategory.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Email Category</span></a></li>
								<li><a class="submenu" href="templates.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Templates</span></a></li>
								<li><a class="submenu" href="emails.php"><i class="icon-file-alt"></i><span class="hidden-tablet">Emails</span></a></li>
							</ul>	
						</li>
					   <?php } if (in_array("Withdraw", $admin_access)) { ?>
						
						<li>
						<a href="withdraw_request.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Withdraw Request</span></a>
							
						</li>
					   <?php }  if (in_array("Manual_Transaction", $admin_access)) { ?>
						<li>
						<a href="manual_transaction.php"><i class="icon-edit"></i><span class="hidden-tablet"> Manual Transaction</span></a>
							
						</li>
					   <?php }  if (in_array("Recharge", $admin_access)) { ?>
						<li>
							<a class="dropmenu" href="#"><i class="icon-list-alt"></i><span class="hidden-tablet"> Recharge</span><span class="label label-important"> 3 </span></a>
							<ul>
								<li><a class="submenu" href="operator_name.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Operator Name</span></a></li>
								<li><a class="submenu" href="operator_circle.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Circle Name</span></a></li>
								<li><a class="submenu" href="recharge_orders.php"><i class="icon-file-alt"></i><span class="hidden-tablet">Orders</span></a></li>
							</ul>	
						</li>
					   <?php }  if (in_array("Location", $admin_access)) { ?>
						
						
						<li>
						<a href="country.php"><i class="icon-dashboard"></i><span class="hidden-tablet"> Location</span></a>
							
						</li>
					   <?php }  if (in_array("Settings", $admin_access)) { ?>
						
						<li><a href="settings.php"><i class="icon-star"></i><span class="hidden-tablet"> Settings</span></a></li>
					   <?php }  if (in_array("CMS", $admin_access)) { ?>
						
						<li><a href="cms.php"><i class="icon-edit"></i><span class="hidden-tablet"> CMS Pages</span></a></li>
					   <?php }  if (in_array("Contact", $admin_access)) { ?>
						
						<li><a href="contactus.php"><i class="icon-folder-open"></i><span class="hidden-tablet"> Contact Us</span></a></li>
						
					   <?php }  if (in_array("Advertise", $admin_access)) { ?>
						<li><a href="advertise.php"><i class="icon-picture"></i><span class="hidden-tablet"> Advertise Request</span></a></li>
					   <?php } ?>
					    <?php if (in_array("Resume", $admin_access)) { ?>
						<li><a href="resume.php"><i class="icon-picture"></i><span class="hidden-tablet"> Resumes</span></a></li>
					   <?php } ?>
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
			
<style>
#sidebar-left::-webkit-scrollbar {
    width: 12px;
}
 
#sidebar-left::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
    border-radius: 10px;
}
 
#sidebar-left::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}
</style>			