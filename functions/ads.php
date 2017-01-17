<?php

class ads {
	
	private $db;
	
	function __construct() {
		global $db;
		$this->db = $db;
	}
	
	public function resetAd() {
		
		$this->db->query("UPDATE roo_ads SET viewing = 0 WHERE (view_time + INTERVAL 2 MINUTE) < '".DATETIME24H."' AND viewing = 1");
		
	}
	
	public function getDemoAd($demotry = false) {
		
		$this->resetAd();
		
		$user_id = $_SESSION['roo']['user']['id'];
		
		$qry = $this->db->query("SELECT ra.id, ra.type, ra.content, ra.duration, ra.clicks_remain FROM roo_ads AS ra WHERE ra.clicks_remain > 0 AND ra.viewing = 0 AND ((SELECT COUNT(id) AS cnt FROM roo_transaction AS rt WHERE rt.adid = ra.id AND rt.userid = '".$user_id."' AND rt.demo = 1) = 0) AND ra.status=0 ORDER BY ra.date_added DESC LIMIT 1");
		if($this->db->num_rows($qry) > 0) {
			$result = $this->db->fetch_array($qry);
			if($result['clicks_remain'] < 6) {
				$this->db->query("UPDATE roo_ads SET viewing = 1, view_time = '".DATETIME24H."' WHERE id = '".$result['id']."' LIMIT 1");
			}
			unset($result['clicks_remain']);
			$result['html'] = $this->getAdHtml($result);
			$demotry = true;
			return $result;
		} else {
			if($demotry == false) {
				$this->db->query("UPDATE roo_transaction SET demo=0 WHERE userid = '".$user_id."'");
				return $this->getAd(true);
			}
			return false;
		}

	}
	
	public function getAd($id,$type) {
		
		$this->resetAd();
		
		$user_id = $_SESSION['roo']['user']['id'];
        if($id>0){
			$qry = $this->db->query("SELECT ra.id, ra.type, ra.content, ra.duration, ra.clicks_remain,ra.filehash FROM roo_ads AS ra WHERE ra.clicks_remain > 0 AND ra.viewing = 0 AND ((SELECT COUNT(id) AS cnt FROM roo_transaction AS rt WHERE rt.adid = ra.id AND rt.userid = '".$user_id."' AND rt.date_added >= '".DATE_TODAY."') = 0) AND (ra.status=0 and ra.id='$id') AND ra.type='".$type."' ORDER BY ra.date_added DESC LIMIT 1");
		}else{
			if($type=='all')
			{
				$qry = $this->db->query("SELECT ra.id, ra.type, ra.content, ra.duration, ra.clicks_remain,ra.filehash FROM roo_ads AS ra WHERE ra.clicks_remain > 0 AND ra.viewing = 0 AND ((SELECT COUNT(id) AS cnt FROM roo_transaction AS rt WHERE rt.adid = ra.id AND rt.userid = '".$user_id."' AND rt.date_added >= '".DATE_TODAY."') = 0) AND (ra.status=0) ORDER BY ra.date_added DESC LIMIT 1");
			}else{
		$qry = $this->db->query("SELECT ra.id, ra.type, ra.content, ra.duration, ra.clicks_remain,ra.filehash FROM roo_ads AS ra WHERE ra.clicks_remain > 0 AND ra.viewing = 0 AND ((SELECT COUNT(id) AS cnt FROM roo_transaction AS rt WHERE rt.adid = ra.id AND rt.userid = '".$user_id."' AND rt.date_added >= '".DATE_TODAY."') = 0) AND (ra.status=0 AND ra.type='".$type."') ORDER BY ra.date_added DESC LIMIT 1");
		}
		}
		if($this->db->num_rows($qry) > 0) {
			$result = $this->db->fetch_array($qry);
			if($result['clicks_remain'] < 6) {
				$this->db->query("UPDATE roo_ads SET viewing = 1, view_time = '".DATETIME24H."' WHERE id = '".$result['id']."' LIMIT 1");
			}
			unset($result['clicks_remain']);
			$result['html'] = $this->getAdHtml($result);
			return $result;
		} else {
			return false;
		}
		
	}

	public function getHomeSliderAd() {
		$qry = $this->db->query("SELECT ra.id, ra.name, ra.content FROM roo_ads AS ra WHERE ra.type = 'video' AND ra.status=0 LIMIT 5");
		$result = array();
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
	public function getHomevideoAd() {
		$qry = $this->db->query("SELECT * FROM roo_videopopup  WHERE status = '0'");
		$row = $this->db->fetch_array($qry);
		$id=$row['video_id'];
		//echo "SELECT ra.id, ra.name, ra.content FROM roo_ads AS ra WHERE (ra.type = 'video' AND ra.status=0) and ra.id='$id'";
		$qry2 = $this->db->query("SELECT ra.id, ra.name, ra.content FROM roo_ads AS ra WHERE (ra.type = 'video' AND ra.status=0) and ra.id='$id'");
		$row2 = $this->db->fetch_array($qry2);
		//echo $row2['content']; exit;
		
		
		$html = '<div class="videoad">
						<div>
							<video id="videoID" src="'.$row2['content'].'" autoplay onended="videoEnded()" style="width:600px;"></video>
						</div>
					</div>';
		return $html;
	}
	
	public function getAdlist($type) {
		$user_id = $_SESSION['roo']['user']['id'];
		//echo "SELECT ra.id, ra.name,ra.amount,ra.content FROM roo_ads AS ra WHERE (ra.type = '$type' AND ra.status=0)AND ra.viewing=0 AND ((SELECT COUNT(id) AS cnt FROM roo_transaction AS rt WHERE rt.adid = ra.id AND rt.userid = '".$user_id."' AND rt.date_added >= '".DATE_TODAY."') = 0)"; exit;
		$qry = $this->db->query("SELECT ra.id, ra.name,ra.amount,ra.content FROM roo_ads AS ra WHERE (ra.type = '$type' AND ra.status=0)AND ra.viewing=0 AND ((SELECT COUNT(id) AS cnt FROM roo_transaction AS rt WHERE rt.adid = ra.id AND rt.userid = '".$user_id."' AND rt.date_added >= '".DATE_TODAY."') = 0)");
		$result = array();
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				
				$result[] = $row;
			}
		}
		return $result;
	}
	public function getplanlist($type) {
		//echo "select * from roo_plancategory where category_name='".$type."'"; exit;
		
		$qrycat=$this->db->query("select * from roo_plancategory where category_name='".$type."'");
		$row1 = $this->db->fetch_array($qrycat);
		//echo $row1['id']; exit;
		
		$qry = $this->db->query("SELECT * from roo_plan_details where status=0 and catid='".$row1['id']."'");
		$result = array();
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				
				$result[] = $row;
			}
		}
		return $result;
	}
	public function getplanlistvideo($type,$from,$to) {
		//echo "select * from roo_plancategory where category_name='".$type."'"; exit;
		
		$qrycat=$this->db->query("select * from roo_plancategory where category_name='".$type."'");
		$row1 = $this->db->fetch_array($qrycat);
		//echo $row1['id']; exit;
		
		$qry = $this->db->query("SELECT * from roo_plan_details where (status=0 and catid='".$row1['id']."') and (from_sec='".$from."' and to_sec='".$to."')");
		$result = array();
		if($this->db->num_rows($qry) > 0) {
			while($row = $this->db->fetch_array($qry)) {
				
				$result[] = $row;
			}
		}
		return $result;
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
							<video src="'.$ads['content'].'" controls autoplay></video>
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
			$val.="<img src='assets/img/bullet.png' /> ".$exp[$i];	
			}
			
			
			$html = '<div class="videoad">
			<div class="scroll">
						<marquee>
							'.$val.'
						</marquee>
					</div>
					</div>';
		}
		return $html;
	}
	
}