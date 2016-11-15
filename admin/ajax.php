<?php
include_once("../config/config.php");
$output = array('error' => true, 'msg' => 'Something went wrong, please try again...', 'html' => '');
$login = check_admin_login();
if($login === true) {
	if(isset($_REQUEST['cmd'])) {
		if($_REQUEST['cmd'] == '_getAccount' AND $_REQUEST['user'] > 0) {
			include("./functions/users.php");
			$users = new users();
			$accounts = $users->getUserBanks($_REQUEST['user']);
			$html = '<table class="table table-bordered table-striped table-condensed">
						  <thead>
							  <tr>
								  <th>Sno</th>
								  <th>Account Name</th>
								  <th>Account Number</th>
								  <th>Bank</th>
								  <th>Branch</th>
								  <th>IFSC Code</th>
								  <th>Status</th>
							  </tr>
						  </thead>   
						  <tbody>';
			if(!empty($accounts)) {
				$sno = 1;
				foreach($accounts as $acc) {
					$html .= '<tr>
								  <td>'.$sno.'</td>
								  <td>'.$acc['ac_name'].'</td>
								  <td>'.$acc['number'].'</td>
								  <td>'.$acc['bank'].'</td>
								  <td>'.$acc['branch'].'</td>
								  <td>'.$acc['ifsc'].'</td>
								  <td>'.(($acc['status'] == 0) ? '<span class="label label-success">Active</span>' : '<span class="label">Inactive</span>').'</td>
							  </tr>';
					$sno++;
				}
			} else {
				$html .= '<tr><td colspan="6" style="text-align:center;" class="text-error">No User available to show....</td></tr>';
			}
			$html .= '</tbody></table>';
			$output['error'] = false;
			$output['html'] = $html;
			$output['msg'] = "Success";
		}
	}
}
echo json_encode($output);
?>