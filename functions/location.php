<?php
class location
{
	private $db;
	public $country_id = 88;
	
	public function __construct() {
		global $db;
		$this->db = $db;
	}
	
	public function getCountryDropdown($cid = 0, $class = "", $required = false, $attrbute = '') {
		
	}
	
	public function getStateDropdown($cid, $sid = 0, $class = "", $required = false, $attrbute='') {
		$html = '<select name="state" id="state" class="form-control '.$class.'" '.(($required === true) ? 'required' : '').' '.$attrbute.'>';
		if($cid > 0) {
			$stateQry = $this->db->query("SELECT id, name FROM roo_state WHERE cid = '".$cid."' AND status=0");
			if($this->db->num_rows($stateQry) > 0) {
				$html .= '<option value="">Select State</option>';
				while($stateRow = $this->db->fetch_array($stateQry)) {
					$html .= '<option value="'.$stateRow['id'].'" '.(($stateRow['id'] == $sid) ? 'selected="selected"' : '').'>'.$stateRow['name'].'</option>';
				}
			} else {
				$html .= '<option value="">No state</option>';
			}
		} else {
			$html .= '<option value="">No state</option>';
		}
		$html .= '</select>';
		return $html;
	}
	
	public function getCityDropdown($sid, $ciid = 0, $class = "", $required = false, $attrbute='') {
		$html = '<select name="city" id="city" class="form-control '.$class.'" '.(($required === true) ? 'required' : '').' '.$attrbute.'>';
		if($sid > 0) {
			$cityQry = $this->db->query("SELECT id, name FROM roo_city WHERE sid = '".$sid."' AND status=0");
			if($this->db->num_rows($cityQry) > 0) {
				$html .= '<option value="">Select City</option>';
				while($cityRow = $this->db->fetch_array($cityQry)) {
					$html .= '<option value="'.$cityRow['id'].'" '.(($cityRow['id'] == $ciid) ? 'selected="selected"' : '').'>'.$cityRow['name'].'</option>';
				}
			} else {
				$html .= '<option value="">No city</option>';
			}
		} else {
			$html .= '<option value="">No city</option>';
		}
		$html .= '</select>';
		return $html;
	}
	
}
?>