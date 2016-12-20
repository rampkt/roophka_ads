<?php
class ads
{
	private $db = '';
	public $adname = '';
	public $adclicks = '';
	public $adduration = '';
	public $addtitle = '';
	public $addcontent = '';
	public $addtype = '';
	public $adamount = '';
	public $file = array();
	public $id = '';
	
	public $page = 1;
	public $start = 0;
	public $rowLimit = 10;
	
	public function __construct() {
		global $db;
		$this->db = $db;
		
		$this->page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
		if($this->page > 1) {
			$this->start = ($this->page - 1) * $this->rowLimit;
		}
		
	}
	
	public function getsession() {
		
		$this->adname = (isset($_SESSION['roo']['ads']['adname']) ? $_SESSION['roo']['ads']['adname'] : '');
		$this->adclicks = (isset($_SESSION['roo']['ads']['adclicks']) ? $_SESSION['roo']['ads']['adclicks'] : '');
		$this->adduration = (isset($_SESSION['roo']['ads']['adduration']) ? $_SESSION['roo']['ads']['adduration'] : '');
		$this->addtitle = (isset($_SESSION['roo']['ads']['addtitle']) ? $_SESSION['roo']['ads']['addtitle'] : '');
		$this->addcontent = (isset($_SESSION['roo']['ads']['addcontent']) ? $_SESSION['roo']['ads']['addcontent'] : '');
		$this->addtype = (isset($_SESSION['roo']['ads']['addtype']) ? $_SESSION['roo']['ads']['addtype'] : '');
		$this->adamount = (isset($_SESSION['roo']['ads']['adamount']) ? $_SESSION['roo']['ads']['adamount'] : '');
		
	}
	
	public function addsession() {
		
		$_SESSION['roo']['ads'] = array();
		$_SESSION['roo']['ads']['adname'] = $this->adname;
		$_SESSION['roo']['ads']['adclicks'] = $this->adclicks;
		$_SESSION['roo']['ads']['adduration'] = $this->adduration;
		$_SESSION['roo']['ads']['addtitle'] = $this->addtitle;
		$_SESSION['roo']['ads']['addcontent'] = $this->addcontent;
		$_SESSION['roo']['ads']['addtype'] = $this->addtype;
		$_SESSION['roo']['ads']['adamount'] = $this->adamount;
		
	}
	
	public function emptycheck() {
		
		if($this->addtype != '' ) {
			$this->addsession();
			if($this->addtype == 'text' ) {
				if($this->adname == '' || $this->adclicks == '' || $this->adduration == '' || $this->addtitle == '' || $this->addcontent == '' || $this->adamount == '') {
					return false;
				} else {
					return true;
				}
			} else {
				if($this->adname == '' || $this->adclicks == '' || $this->adduration == '' || $this->adamount == '') {
					return false;
				} else {
					return true;
				}
			}
		} 
		return false;
	}
	
	public function getAlladminUsersemail() 
	{
		$field=array();
		
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT u.id, u.email, u.username FROM roo_admin_users AS u WHERE u.status IN (0,1) and u.type!=0  order by u.email asc';
		
		$queryCount = 'SELECT u.id, u.email, u.username FROM roo_admin_users AS u WHERE u.status IN (0,1) and u.type!=0'; 
		
		//echo $query; 
		$qry = $this->db->query($query);
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				
				$field[]=($row['email']);
				
				$result[] = $row;
			}
		}
		//print_r(json_encode($field)); 
		// pagination code
		return $field;
	}
	
	public function getadminuser($email) 
	{
		$query = "SELECT u.id, u.email, u.username FROM roo_admin_users AS u WHERE u.status IN (0,1) and u.type!=0 and u.email='$email' order by u.email asc limit 1";
		
		//echo $query; 
		$qry = $this->db->query($query);
		
		$result= $this->db->fetch_array($qry);
		
		return $result['id'];
	}
	
	
	public function save($id=0) {
		
		$this->emptycheck();
		if($id > 0) {
			
			$result=$this->db->query("UPDATE roo_ads SET title='".$this->addtitle."',content='".$this->addcontent."',name='".$this->adname."',duration='".$this->adduration."',amount='".$this->adamount."',watch_count='".$this->adclicks."',clicks_remain='".$this->adclicks."' where id='".$id."'");
			
			
		} else {
			if($this->addtype == 'text' ) {
				$result = $this->db->query("INSERT INTO roo_ads (userid, isadmin, type, title, content, name, duration, amount, watch_count, clicks_remain, date_added, status) VALUES ('".$_SESSION['roo']['admin_user']['id']."', 1, '".$this->addtype."', '".$this->addtitle."', '".$this->addcontent."', '".$this->adname."', '".$this->adduration."', '".$this->adamount."', '".$this->adclicks."', '".$this->adclicks."', '". DATETIME24H ."', 1)");
				unset($_SESSION['roo']['ads']);
				if($result) { 
					return true;
				} else {
					return false;
				}
			}
             else if($this->addtype == 'scroll' ) {
				 
				 
				$result = $this->db->query("INSERT INTO roo_ads (userid, isadmin, type, title, content, name, duration, amount, watch_count, clicks_remain, date_added, status) VALUES ('".$_SESSION['roo']['admin_user']['id']."', 1, '".$this->addtype."', '".$this->addtitle."', '".$this->addcontent."', '".$this->adname."', '".$this->adduration."', '".$this->adamount."', '".$this->adclicks."', '".$this->adclicks."', '". DATETIME24H ."', 1)");
				unset($_SESSION['roo']['ads']);
				if($result) { 
					return true;
				} else {
					return false;
				}
			}

			else {
				$org_filename = $this->file['name'];
				$extn = pathinfo($org_filename, PATHINFO_EXTENSION);
				
				$path = DOCUMENT_PATH . "uploads/ads/";
				$filehash = randomString(20);
				if($this->addtype == 'video') {
					$filename = $filehash . '.'.$extn;
				} else {
					$filename = $filehash . '.attach';
				}
				$destination = $path . $filename;
				
				$httpPath = HTTP_PATH . "uploads/ads/" . $filename;
				
				//echo $destination; exit;
				
				@move_uploaded_file($this->file['tmp_name'], $destination);
				if(file_exists($destination)) {
					
					$result = $this->db->query("INSERT INTO roo_ads (userid, isadmin, type,title, content, name, duration, amount, watch_count, clicks_remain, date_added, status, extension, filename, filehash) VALUES ('".$_SESSION['roo']['admin_user']['id']."', 1, '".$this->addtype."', '','".$httpPath."', '".$this->adname."', '".$this->adduration."', '".$this->adamount."', '".$this->adclicks."', '".$this->adclicks."', '". DATETIME24H ."', 1, '".$extn."', '".$org_filename."', '".$filehash."')");
					unset($_SESSION['roo']['ads']);
					if($result) { 
						return true;
					} else {
						return false;
					}
				}
				return false;
			}
		}
		
	}
	
	public function getAd($id) {
		if($id > 0) {
			$qry = $this->db->query("SELECT * FROM roo_ads WHERE id='".$id."'");
			$row = $this->db->fetch_array($qry);
			
		$queryCount = "SELECT COUNT(t.adid) AS cnt FROM roo_transaction AS t WHERE (adid='$id' and visitor_area != '')"; 
		
		//echo $queryCount; exit;
		//echo $this->db->num_rows($qry); exit;
		
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);

		//$cntv=$this->db->num_rows($qryCount);
			
			
			$this->id = $id;
			$this->adname = $row['name'];
			$this->adwatch = $row['watch_count'];
			$this->adclicks = $row['clicks_remain'];
			$this->adduration = $row['duration'];
			$this->addtitle = $row['title'];
			$this->addcontent = $row['content'];
			$this->addtype = $row['type'];
			$this->adamount = $row['amount'];
			$this->adstatus = $row['status'];
			$this->addate = $row['date_added'];
			$this->adhtml= $this->getAdHtml($row);
			$this->totalvcount=$rowCount['cnt'];
			
		}
		return false;
	}
	
	
	public function getAllAdsviews($id,$page) {
		
		
		//echo "SELECT count(adid) as cnt,visitor_area  FROM roo_transaction where adid='$id' group by visitor_area LIMIT $start, $limit"; exit;
		$sql="SELECT count(adid) as cnt,visitor_area FROM roo_transaction where (adid='$id' and visitor_area != '') group by visitor_area LIMIT ".$this->start.','.$this->rowLimit;
		
		$qry = $this->db->query($sql);
		$queryCount = "SELECT COUNT(t.adid) AS cnt FROM roo_transaction AS t WHERE (adid='$id' and visitor_area != '') group by visitor_area"; 
		$queryCount1 = "SELECT COUNT(t.adid) AS cnt FROM roo_transaction AS t WHERE (adid='$id' and visitor_area != '')"; 
		//echo $queryCount; exit;
		//echo $this->db->num_rows($qry); exit;
		
		$qryCount = $this->db->query($queryCount);
		$qryCount1 = $this->db->query($queryCount1);
		
		
		$rowCount = $this->db->num_rows($qryCount);

		$cntv=$this->db->fetch_array($qryCount1);
		
		 $cntot=$cntv['cnt']; 
		
		if($this->db->num_rows($qry) > 0) {
			$adlist = array();
			while($row=$this->db->fetch_array($qry)) {
				
				$row['totalcount']=$cntot;
				$row['avg']=round(($row['cnt']/$row['totalcount'])*100);
				
				
				$adlist[] = $row;
			}
			
			
		//echo $rowCount; exit;
		
		$totalPage = getTotalPage($rowCount,$this->rowLimit);
		$pagination = pagination("ads_details.php", "action=details&id=$id", $this->page, $totalPage, 6);
		return array($adlist, $pagination);
			//return array($adlist, '');
		} 
		return array(false, '');
	}
	
	public function getAllAds($page = 1) {
		
		$where = '';
		if($_SESSION['roo']['admin_user']['type'] != 0) {
			$where = "WHERE userid = '".$_SESSION['roo']['admin_user']['id']."'";
		}
		
		$qry = $this->db->query("SELECT id, userid,name, type, watch_count, clicks_remain, date_added, status FROM roo_ads ".$where." ORDER BY date_added DESC LIMIT ".$this->start.','.$this->rowLimit);
		
		$queryCount = "SELECT count(id) as cnt FROM roo_ads ".$where; 
		
		if($this->db->num_rows($qry) > 0) {
			$adlist = array();
			while($row=$this->db->fetch_array($qry)) {
                $queryy = "SELECT u.id, u.email, u.username FROM roo_admin_users AS u WHERE u.id='$row[userid]' order by u.email asc";
		
		//echo $query; 
		$qryy = $this->db->query($queryy);
		
		$resulty= $this->db->fetch_array($qryy);				
                 $row['username']=$resulty['username'];
				 $row['email']=$resulty['email'];
				$adlist[] = $row;
			}
			
			$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		//echo $rowCount['cnt']; exit;
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("ads.php", "", $this->page, $totalPage, 6);
	
			return array($adlist, $pagination);
		} 
		return array(false, '');
	}
	
	public function adActivate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_ads SET status=0 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function adDeactivate($id=0) {
		if($id > 0) {
			$this->db->query("UPDATE roo_ads SET status=1 WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function adDelete($id=0) {
		if($id > 0) {
			$this->db->query("DELETE FROM roo_ads WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	public function adChangeUser($id=0,$email) {
		
		$userid=$this->getadminuser($email);
		
		//echo "UPDATE roo_ads SET userid='".$userid."' WHERE id='".$id."' LIMIT 1"; exit;
		if($id > 0) {
			$this->db->query("UPDATE roo_ads SET userid='".$userid."' WHERE id='".$id."' LIMIT 1");
			return true;
		}
		return false;
	}
	
	
	
	public function getAdHtml($ads) {
		$html = '';
		if($ads['type'] == 'image') {
			$html = '<div class="imagead">
        				<img src="'.$ads['content'].'" />
        			</div>';
		} elseif($ads['type'] == 'video') {
			$html = '<div class="videoad">
						<div>
							<video src="'.$ads['content'].'" controls></video>
						</div>
					</div>';
		} elseif($ads['type'] == 'text') {
			$html = '<div class="videoad">
						<div>
							'.decodehtml($ads['content']).'
						</div>
					</div>';
		} 
		elseif($ads['type'] == 'scroll') {
			
			$exp=explode("~",decodehtml($ads['content']));
			$val="";
			for($i=0;count($exp)>$i;$i++)
			{
			$val.="<img src='./img/bullet.png' /> ".$exp[$i];	
			}
			
			
			$html = '<div class="videoad">
			<div class="scroll" style="width:400px;">
						<marquee>
							'.$val.'
						</marquee>
					</div>
					</div>';
		} 
		return $html;
	}
	
}
?>