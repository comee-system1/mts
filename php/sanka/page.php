<?PHP
class page{
	function __construct(){
		global $db;
		global $html;
		global $array_pref;
		$this->db   = $db;
		$this->html = $html;
		$this->pref = $array_pref;
	}
	public function index(){
		if($_REQUEST[ 'getList' ]){
			$this->areaname = $_REQUEST[ 'areaname' ];
			$area = $this->db->getSankaPage($this->areaname);
			echo json_encode($area);
			exit();
		}
		if($_REQUEST[ 'reg' ]){
			$edit[ 'edit'  ][ 'note'     ]= $_REQUEST[ 'note'      ];
			$edit[ 'where' ][ 'areaname' ]= $_REQUEST[ 'areaname'  ];
			$table = "hppagesanka";
			$flg = $this->db->editUserData($table,$edit);
			exit();
		}
		if($_REQUEST[ 'getData' ]){
			$data = $this->db->getSankaPagedata();
			echo json_encode($data);
			exit();
		}
//		$html[ 'sanka' ] = $data;
		return $html;
	}


}
?>