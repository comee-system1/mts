<?PHP
class cus{
	function __construct(){
		global $db;
		$this->db = $db;
		global $sec;
		global $third;
		global $four;
		global $array_konshinkai_sts;
		global $array_address;
		$this->konshin = $array_konshinkai_sts;
		$this->array_address = $array_address;
		global $array_pay_sts;
		$this->psts = $array_pay_sts;
		global $array_join_type;
		$this->jointype = $array_join_type;

	}
	public function index(){
		global $sec;
		global $third;
		global $four;
		//支払ステータス
		if($_REQUEST[ 'paysts' ]){
			$id = $_REQUEST[ 'sts' ][ 'id' ];
			$table = "kagaku_sanka";
			$where[ 'edit'  ][ 'status' ] = 0;
			$where[ 'where' ][ 'id'     ] = $_REQUEST[ 'sts' ][ 'id' ];
			//無効にする
			$this->db->editUserData($table,$where);
			$id = $this->db->setGetPay($_REQUEST);
			//$id = mysql_insert_id();

			//支払
			$where = array();
			$table = "kagaku_sanka";
			$where[ 'edit'  ][ 'sanka_pay_status' ] = $_REQUEST[ 'sts' ][ 'sts' ];
			$where[ 'edit'  ][ 'status' ] = 1;
			$where[ 'where' ][ 'id'     ] = $id;
			//無効にする
			$this->db->editUserData($table,$where);
			exit();
		}

		if($third == "did"){
			$table = "kagaku_sanka";
			$edit = array();
			$edit[ 'edit'  ][ 'status' ] = 0;
			$edit[ 'where' ][ 'id'     ] = $four;
			$this->db->editUserData($table,$edit);
			header("Location:/sanka/cus/");
			exit();
		}

		//print "ccc";
		if($_REQUEST[ 'getList' ]){
			$limit  = D_LIMIT;
			$offset = sprintf("%d",$_REQUEST[ 'pg' ]*D_LIMIT);
			$search = "";
			if($_REQUEST[ 'search' ]){
				$search = $_REQUEST[ 'search' ];
			}
			$array = [];
			$array[ 'limit'  ] = $limit;
			$array[ 'offset' ] = $offset;
			$array[ 'search' ] = $search;

			$max = $this->db->sankaGetList(1,$array);
			$ceil = ceil($max/D_LIMIT);

			$lists[ 'data'    ] = $this->db->sankaGetList("",$array);
			$lists[ 'max'     ] = $max;
			$lists[ 'ceil'    ] = $ceil;
			$lists[ 'jtype'   ] = $this->jointype;
			$lists[ 'konshin' ] = $this->konshin;
			$lists[ 'psts'    ] = $this->psts;
			$lists[ 'aryad'   ] = $this->array_address;
			echo json_encode($lists);
			exit();
		}
		$html[ 'konshin'          ] = $this->konshin;
		$html[ 'psts'             ] = $this->psts;
		$html[ 'jointype'         ] = $this->jointype;
		$html[ 'array_address'    ] = $this->array_address;
		return $html;
	}



}
?>