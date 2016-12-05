<?php
include_once("./config/config.php");

include("./functions/cms.php");

$cms=new cms();

$sql="select * from roo_ads";
$qry=$db->query($sql);
$i=1;
while($row=$db->fetch_array($qry))
{

            $id = $row['id'];
			$userid=$row['userid'];
			$adname = $row['name'];
			$adwatch = $row['watch_count'];
			$adclicks = $row['clicks_remain'];
			$adduration = $row['duration'];
			$addtitle = $row['title'];
			$addcontent = $row['content'];
			$addtype = $row['type'];
			$adamount = $row['amount'];
			$adstatus = $row['status'];
			$addate = $row['date_added'];

			 if($adstatus == 0) { 
					$status="Active";
              } else { 
                    $status="Inactive";
              } 
			  
			$query = "SELECT COUNT(t.adid) AS cnt FROM roo_transaction AS t WHERE (adid='$id')"; 
            $qryCount = $db->query($query);
		    $rowCount = $db->fetch_array($qryCount);
			
			
			$totalviews=$rowCount['cnt'];
			
			$date=date('Y-m-d');
			
			$query2 = "SELECT COUNT(t.adid) AS cnt FROM roo_transaction AS t WHERE (date_added='$date' and adid='$id')"; 
            $qryCount2 = $db->query($query2);
		    $rowCount2 = $db->fetch_array($qryCount2);
			
			$todayviews=$rowCount2['cnt'];
			
			
			$query3 = "SELECT email,username FROM roo_admin_users WHERE (id='$userid')"; 
            $qryCount3 = $db->query($query3);
		    $rowCount3 = $db->fetch_array($qryCount3);
			
			$adminmail=$cms->getsetting('1','email');
			
			$to = array($rowCount3['email']);
			$from = $adminmail;
			$subject = "Ad report from roophka.com";
			$message = '<div style="width:600px;">
			Dear '.$rowCount3['username'].'<br>
			<p>Welcome to ROOPHKA.COM</p>
			<p>Your ads details are following :</p>
			
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right"><strong>Adname : </strong> </td>
					<td>'.$adname.'</td>
				</tr>
				
				<tr>
					<td align="right"><strong>Ad Title : </strong> </td>
					<td>'.$addtitle.'</td>
				</tr>
				
				<tr>
					<td align="right"><strong>Watch count : </strong> </td>
					<td>'.$adwatch.'</td>
				</tr>
				
				<tr>
					<td align="right"><strong>Clicks Remain : </strong> </td>
					<td>'.$adclicks.'</td>
				</tr>
				
				<tr>
					<td align="right"><strong>Ad Duration : </strong> </td>
					<td>'.$adduration.'</td>
				</tr>
				
				<tr>
					<td align="right"><strong>Amount : </strong> </td>
					<td>'.$adamount.'</td>
				</tr>
				
				<tr>
					<td align="right"><strong>Status : </strong> </td>
					<td>'.$status.'</td>
				</tr>
				
				<tr>
					<td align="right"><strong>Total view count : </strong> </td>
					<td>'.$totalviews.'</td>
				</tr>
				
				<tr>
					<td align="right"><strong>Today view count : </strong> </td>
					<td>'.$todayviews.'</td>
				</tr>
				
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			//echo $rowCount3['email']."<br>".$from."<br>".$subject."<br>".$message;
			
			
			$mailler->sendmail($to, $from, $subject, $message);
			
$i++;
}	
	


?>