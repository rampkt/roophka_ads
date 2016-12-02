<?php
include_once("./config/config.php");


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
            $qryCount = $this->db->query($query);
		    $rowCount = $this->db->fetch_array($qryCount);
			
			
			$totalviews=$rowCount['cnt'];
			
			$date=date('Y-m-d');
			
			$query2 = "SELECT COUNT(t.adid) AS cnt FROM roo_transaction AS t WHERE (date_added='$date' and adid='$id')"; 
            $qryCount2 = $this->db->query($query2);
		    $rowCount2 = $this->db->fetch_array($qryCount2);
			
			$todayviews=$rowCount2['cnt'];
			
			
			$query3 = "SELECT email,firstname FROM roo_users WHERE (id='$userid')"; 
            $qryCount3 = $this->db->query($query3);
		    $rowCount3 = $this->db->fetch_array($qryCount3);
			
			
			
			$to = array($rowCount3['email']);
			$from = 'info@roophka.com';
			$subject = "Ad report from roophka.com";
			$message = '<div style="width:600px;">
			Dear '.$rowCount3['firstname'].'<br>
			<p>Welcome to ROOPHKA.COM</p>
			<p>Your ads details are following</p>
			<br>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right"><h4>Adname : </h4> </td>
					<td>'.$adname.'</td>
				</tr>
				
				<tr>
					<td align="right"><h4>Ad Title : </h4> </td>
					<td>'.$addtitle.'</td>
				</tr>
				
				<tr>
					<td align="right"><h4>Watch count : </h4> </td>
					<td>'.$adwatch.'</td>
				</tr>
				
				<tr>
					<td align="right"><h4>Clicks Remain : </h4> </td>
					<td>'.$adclicks.'</td>
				</tr>
				
				<tr>
					<td align="right"><h4>Ad Duration : </h4> </td>
					<td>'.$adduration.'</td>
				</tr>
				
				<tr>
					<td align="right"><h4>Amount : </h4> </td>
					<td>'.$adamount.'</td>
				</tr>
				
				<tr>
					<td align="right"><h4>Status : </h4> </td>
					<td>'.$status.'</td>
				</tr>
				
				<tr>
					<td align="right"><h4>Total view count : </h4> </td>
					<td>'.$totalviews.'</td>
				</tr>
				
				<tr>
					<td align="right"><h4>Today view count : </h4> </td>
					<td>'.$todayviews.'</td>
				</tr>
				
			</table>
			<br>
			Thanks & regards,<br>
			<a href="roophka.com">roophka.com</a>
			</div>';
			
			$mailler->sendmail($to, $from, $subject, $message);
			
$i++;
}	
	


?>