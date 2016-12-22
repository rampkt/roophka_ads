<?php
include_once("../config/config.php");
$output = array('error' => true, 'msg' => 'Something went wrong, please try again...', 'html' => '','count'=>'','ids'=>'');
$login = check_admin_login();
if($login === true) {
	if(isset($_REQUEST['cmd'])) {
		
		
		
		if($_REQUEST['cmd'] == '_gettemplate' AND $_REQUEST['temp'] > 0) {
			include("./functions/bulkemail.php");
			$bulkemail = new bulkemail();
			$preview = $bulkemail->templateedit($_REQUEST['temp']);
			$html = $preview['template_content'];
			$output['error'] = false;
			$output['html'] = $html;
			$output['msg'] = "Success";
		}
		if($_REQUEST['cmd'] == '_getemailexternal' AND $_REQUEST['temp']!="") {
			include("./functions/bulkemail.php");
			$bulkemail = new bulkemail();
			$tmpfile=HTTP_PATH . "admin/csv/".$_REQUEST['temp'];
		
			//Import uploaded file to Database
            $handle = fopen($tmpfile, "r");
			
			$i=0;
			$a=1;
			$html="";
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$html.=$a.". ".$data[0]."<br>";
			$i++;
			$a++;}
			
			
			
			$output['error'] = false;
			$output['html'] = $html;
			$output['count']=$i;
			$output['msg'] = "Success";
		}
		
		
		
		if($_REQUEST['cmd'] == '_getemails' AND $_REQUEST['temp'] > 0) {
			include("./functions/bulkemail.php");
			$bulkemail = new bulkemail();
			$id=implode(", ", $_REQUEST['temp']);
		
			$email = $bulkemail->emailsvalue($id);
			$count=$bulkemail->emailscount($id);
			$ids=$bulkemail->emailids($id);
			
			$html = $email;
			$output['error'] = false;
			$output['html'] = $html;
			$output['msg'] = "Success";
			$output['count']=$count;
			$output['ids']=$ids;
		}
		
		if($_REQUEST['cmd'] == '_getemailids' AND $_REQUEST['temp'] > 0) {
			include("./functions/bulkemail.php");
			$bulkemail = new bulkemail();
			$ids=explode(",", $_REQUEST['ids']);
			
			if($_REQUEST['select']=='true')
			{
			$eids=$_REQUEST['temp'];	
			}
			else
			{
			$eids="";	
			}	
			
			
			foreach($ids as $eid)
			{
				if($_REQUEST['temp']!=$eid)
				{
					if($eids=="")
					{
						$eids.=$eid;
					}
					else
					{
						$eids.=",".$eid;
					}
				}
			}
			
			//$html = $email;
			$output['error'] = false;
			$output['msg'] = "Success";
			$output['ids']=$eids;
		}
		
		
	}
}
echo json_encode($output);
?>