<?PHP
class cus{
	function __construct(){
		global $db;
		$this->db = $db;
		global $array_happyo;
		$this->array_happyo = $array_happyo;

	}
	public function index(){
		//print "ccc";
		//英語のステータスフラグを立てる
		if($_REQUEST[ 'english' ]){
			$table = "kagaku_endai";
			$edit = array();
			$edit[ 'where' ][ 'id' ] = $_REQUEST[ 'status' ][ 'id' ];
			$edit[ 'where' ][ 'status' ] = 1;
			$edit[ 'edit'  ][ 'englishflg' ] = $_REQUEST[ 'status' ][ 'englishflg' ];
			$rlt = $this->db->editUserData($table,$edit);
			if($rlt){
				echo 1;
			}else{
				echo 0;
			}
			exit();
		}
		if($_REQUEST[ 'getList' ]){

		    $search = [];
		    $search[ 'limit' ] = D_LIMIT;
		    $search[ 'offset' ] = sprintf("%d",$_REQUEST[ 'pg' ]*D_LIMIT);
		    if($_REQUEST[ 'search' ]){
		        $search[ 'search' ] = $_REQUEST[ 'search' ];
		    }

			$max = $this->db->getCusList(1,$search);
			$ceil = ceil($max/D_LIMIT);

			$lists[ 'data'    ] = $this->db->getCusList("",$search);
			$lists[ 'max'     ] = $max;
			$lists[ 'ceil'    ] = $ceil;
			$lists[ 'jtype'   ] = $this->jointype;
			$lists[ 'konshin' ] = $this->konshin;
			$lists[ 'psts'    ] = $this->psts;
			echo json_encode($lists);
			exit();
		}
		$html[ 'array_happyo'     ] = $this->array_happyo;

		return $html;
	}

}
?>