<?PHP
class index{
	function __construct(){

		global $id;
		global $db;
		$this->db = $db;
	}
	public function index(){
		global $id;
		$this->id = $id;
		//print "ccc";
		//$this->getTest();
		if($_REQUEST[ 'editSts' ]){
			
			$table = "kagaku_user";
			$edit[ 'edit' ][ $_REQUEST[ 'id' ] ] = $_REQUEST[ 'sts' ];
			$edit[ 'where' ][ 'id' ] = $id;
			$this->db->editUserData($table,$edit);
			
			exit();
		}
		$scount = $this->db->getSankaCount();
		$html[ 'scount' ] = $scount;
		$ecount = $this->db->getEndaiCount();
		$html[ 'ecount' ] = $ecount[ 'cnt' ];
		$data = $this->db->getUserData($id);
		$html[ 'user' ] = $data;
		return $html;
	}

}
?>