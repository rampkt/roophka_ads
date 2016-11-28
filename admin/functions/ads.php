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
	
	public function __construct() {
		global $db;
		$this->db = $db;
		
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
				if($this->adname == '' || $this->adclicks == '' || $this->adduration == '' || $this->file['name'] == '' || $this->adamount == '') {
					return false;
				} else {
					return true;
				}
			}
		} 
		return false;
	}
	
	public function save($id=0) {
		$this->emptycheck();
		if($id > 0) {
			
		} else {
			if($this->addtype == 'text' ) {
				$result = $this->db->query("INSERT INTO roo_ads (userid, isadmin, type, title, content, name, duration, amount, watch_count, clicks_remain, date_added, status) VALUES ('".$_SESSION['roo']['admin_user']['id']."', 1, '".$this->addtype."', '".$this->addtitle."', '".$this->addcontent."', '".$this->adname."', '".$this->adduration."', '".$this->adamount."', '".$this->adclicks."', '".$this->adclicks."', '". DATETIME24H ."', 1)");
				unset($_SESSION['roo']['ads']);
				if($result) { 
					return true;
				} else {
					return false;
				}
			} else {
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
				
				@move_uploaded_file($this->file['tmp_name'], $destination);
				if(file_exists($destination)) {
					$result = $this->db->query("INSERT INTO roo_ads (userid, isadmin, type, content, name, duration, amount, watch_count, clicks_remain, date_added, status, extension, filename, filehash) VALUES ('".$_SESSION['roo']['admin_user']['id']."', 1, '".$this->addtype."', '".$httpPath."', '".$this->adname."', '".$this->adduration."', '".$this->adamount."', '".$this->adclicks."', '".$this->adclicks."', '". DATETIME24H ."', 1, '".$extn."', '".$org_filename."', '".$filehash."')");
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
		
		$limit = 10;
		$start = (($page == 1) ? 0 : (($page * $limit) - 1));
		
		//echo "SELECT count(adid) as cnt,visitor_area  FROM roo_transaction where adid='$id' group by visitor_area LIMIT $start, $limit"; exit;
		$sql="SELECT count(adid) as cnt,visitor_area FROM roo_transaction where (adid='$id' and visitor_area != '') group by visitor_area LIMIT $start, $limit";
		
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
		
		$totalPage = getTotalPage($rowCount,$limit);
		$pagination = pagination("ads_details.php", "action=details&id=$id", $page, $totalPage, 6);
		return array($adlist, $pagination);
			//return array($adlist, '');
		} 
		return array(false, '');
	}
	
	public function getAllAds($page = 1) {
		
		$limit = 15;
		$start = (($page == 1) ? 0 : (($page * $limit) - 1));
		
		$where = '';
		if($_SESSION['roo']['admin_user']['type'] != 0) {
			$where = "WHERE userid = '".$_SESSION['roo']['admin_user']['id']."'";
		}
		
		$qry = $this->db->query("SELECT id, name, type, watch_count, clicks_remain, date_added, status FROM roo_ads ".$where." ORDER BY date_added DESC LIMIT $start, $limit");
		
		$queryCount = "SELECT count(id) as cnt FROM roo_ads ".$where; 
		
		if($this->db->num_rows($qry) > 0) {
			$adlist = array();
			while($row=$this->db->fetch_array($qry)) {
				$adlist[] = $row;
			}
			
			$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		//echo $rowCount['cnt']; exit;
		
		$totalPage = getTotalPage($rowCount['cnt'],$limit);
		$pagination = pagination("ads.php", "", $page, $totalPage, 6);
	
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
		return $html;
	}
	
}
?>