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
		// For pagination
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
				if($this->adname == '' || $this->adclicks == '' || $this->adduration == '' || $this->file['name'] == '' || $this->adamount == '') {
					return false;
				} else {
					return true;
				}
			}
		} 
		return false;
	}
	
	
	public function getAd($id,$field) {
		//echo $field; exit;
		if($id > 0) {
			$qry = $this->db->query("SELECT * FROM roo_ads WHERE id='".$id."'");
			$row = $this->db->fetch_array($qry);
			return $row[$field];
		}
		return false;
	}
	
	public function getUser($id) {
		if($id > 0) {
			$qry = $this->db->query("SELECT * FROM roo_users WHERE id='".$id."'");
			$row = $this->db->fetch_array($qry);
			
			$this->id = $id;
			$this->username = $row['firstname'];
			$this->email = $row['email'];
			
		}
		return false;
	}
	
	public function getAllads($date) {
		$field="";
		if($date!="")
		{	
		$datestr=date('Y-m-d',strtotime($date));
		$field='ad.date_added like '."'%$datestr%'".' and ';
		}
		
		//echo $datestr; exit;
		$result = array();
		
		$query = 'SELECT ad.id,ad.userid,ad.adid,ad.detail,ad.type,ad.date_added,ad.demo,ad.visitor_location,ad.ipaddr,(SELECT ra.type FROM roo_ads AS ra WHERE ra.id = ad.adid) AS adtype FROM roo_transaction AS ad WHERE '.$field.' ad.type='."'add'".' AND adid > 0 order by ad.date_added desc LIMIT '.$this->start.','.$this->rowLimit;
		
		//echo $query; exit;
		$queryCount = 'SELECT COUNT(ad.id) AS cnt FROM roo_transaction AS ad WHERE '.$field.' ad.type='."'add'".' AND adid > 0'; 
		//echo $queryCount;
		$qry = $this->db->query($query);
		
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
			
			          $adid=$row['adid'];
					  $userid=$row['userid'];
				   $qry2 = $this->db->query("SELECT * FROM roo_ads WHERE id='".$adid."'");
			       $row2 = $this->db->fetch_array($qry2);
				   
				   $qry3 = $this->db->query("SELECT * FROM roo_users WHERE id='".$userid."'");
			       $row3 = $this->db->fetch_array($qry3);
				   
				$row['adname']=$row2['name']; 
				$row['adstatus']=$row2['status'];
				$row['username']=$row3['firstname'];
				$row['email']=$row3['email'];
				//print_r($row);
				$result[] = $row;
			}
			//exit;
		}
		
		// Pagination code
		$qryCount = $this->db->query($queryCount);
		$rowCount = $this->db->fetch_array($qryCount);
		
		$totalPage = getTotalPage($rowCount['cnt'],$this->rowLimit);
		$pagination = pagination("ads_report.php", "todaydate=$date", $this->page, $totalPage, 6);
		return array($result, $pagination);
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
	
}
?>