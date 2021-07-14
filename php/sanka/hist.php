<?PHP
class hist{
	function __construct(){
		global $db;
		$this->db = $db;
		global $array_konshinkai_sts;
		$this->konshin = $array_konshinkai_sts;
		global $array_pay_sts;
		$this->psts = $array_pay_sts;
		global $array_join_type;
		$this->jointype = $array_join_type;
		global $array_address;
		$this->array_address = $array_address;
		global $array_konshinkai_sts;
		$this->array_konshinkai_sts = $array_konshinkai_sts;
	}
	public function index(){

		if($_REQUEST[ 'getList' ]){
			$limit = 50;
			$p = ($_REQUEST[ 'pg' ])?$_REQUEST[ 'pg' ]:0;
			$where = array();
			$where[ 'limit'  ] = $limit;
			$where[ 'offset' ] = $limit * $p;
			$where[ 'code'   ] = $_REQUEST[ 'search' ][ 'code' ];
			$row = $this->db->getHistData($where,1);
			$data[ 'ceil' ] = ceil($row/$limit);
			$rlt = $this->db->getHistData($where);
			if(count($rlt)){
				foreach($rlt as $key=>$val){
					$rlt[ $key ][ 'address_types' ] = $this->array_address[ $val[ 'address_type' ] ];
					$rlt[ $key ][ 'ty'   ] = $this->jointype[ $val[ 'join_type' ] ];
					$rlt[ $key ][ 'kty'  ] = $this->array_konshinkai_sts[ $val[ 'koushinkai' ] ];
					$rlt[ $key ][ 'psts' ] = $this->psts[ $val[ 'sanka_pay_status' ] ];
				}
			}
			$data[ 'data' ] = $rlt;
			$data[ 'max'  ] = $row;
			$echo = json_encode( $data );
			echo $echo;
			exit();
		}
		$html[ 'konshin'          ] = $this->konshin;
		$html[ 'psts'             ] = $this->psts;
		$html[ 'jointype'         ] = $this->jointype;
		$html[ 'array_address'    ] = $this->array_address;
		$html[ 'array_konshinkai_sts'    ] = $this->array_konshinkai_sts;
		return $html;
	}

}
?>