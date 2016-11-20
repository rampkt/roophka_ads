<?php
class dashboard
{
	private $db;
	
	public function __construct() {
		global $db;
		$this->db = $db;
	}
	
	public function totalCount() {
		$result = array();
		$result['users'] = $this->db->fetch_field("roo_users", "1", "COUNT(id) AS cnt");
		$result['ads'] = $this->db->fetch_field("roo_ads", "1", "COUNT(id) AS cnt");
		$result['transaction'] = $this->db->fetch_field("roo_transaction", "type='add' AND adid > 0", "COUNT(id) AS cnt");
		$result['withdraw'] = $this->db->fetch_field("roo_withdraw", "status=1", "COUNT(id) AS cnt");
		
		return $result;
	}
	
	public function totalCounttoday($date) {
		$result = array();
		$result['users'] = $this->db->fetch_field("roo_users", "lastlogin like '%$date%'", "COUNT(id) AS cnt");
		$result['ads'] = $this->db->fetch_field("roo_ads", "date_added like '%$date%'", "COUNT(id) AS cnt");
		$result['transaction'] = $this->db->fetch_field("roo_transaction", "date_added like '%$date%' and type='add' AND adid > 0", "COUNT(id) AS cnt");
		$result['withdraw'] = $this->db->fetch_field("roo_withdraw", "date_added like '%$date%' and status=1", "COUNT(id) AS cnt");
		
		return $result;
	}
	
}
?>