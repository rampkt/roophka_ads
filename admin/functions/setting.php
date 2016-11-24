<?php
class settings
{
	private $db = '';
	public $file = array();
	public $id = '';
	
	public function __construct() {
		global $db;
		$this->db = $db;
		
	}
	
	
	public function save($id=0) {
			
				$org_filename = $this->file['name'];
				$field="";
				if($org_filename!="")
				{
				$extn = pathinfo($org_filename, PATHINFO_EXTENSION);
				
				$path = DOCUMENT_PATH . "uploads/logo/";
				$filehash = randomString(20);
				
				$filename = $filehash . '.attach';
				
				$destination = $path . $filename;
				
				$httpPath = HTTP_PATH . "uploads/logo/" . $filename;
				
				@move_uploaded_file($this->file['tmp_name'], $destination);
				
				$field=",upload_image='".$org_filename."',filehash='".$filehash."',extension='".$extn."'";
				}
				
				//if(file_exists($destination)) {
					$result=$this->db->query("UPDATE roo_settings set sitename='".$this->website_name."',title='".$this->website_title."',weburl='".$this->website_url."',keyword='".$this->keywords."',email='".$this->admin_mail."',description='".$this->description."' $field where id='1'");
					
					
					if($result) { 
						return true;
					} else {
						return false;
					}
				//}
				//return false;
			
		
		
	}
	
	public function getsetting($id) {
		if($id > 0) {
			$qry = $this->db->query("SELECT * FROM roo_settings WHERE id='".$id."'");
			$row = $this->db->fetch_array($qry);
			
			$this->id = $id;
			$this->webname = $row['sitename'];
			$this->title = $row['title'];
			$this->webkeyword = $row['keyword'];
			$this->description = $row['description'];
			$this->email = $row['email'];
			$this->weburl = $row['weburl'];
			$this->upload_image = $row['upload_image'];
			$this->filehash = $row['filehash'];
			$this->extension = $row['extension'];
		}
		return false;
	}
	
	
}
?>