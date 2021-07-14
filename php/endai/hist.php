<?PHP
class hist{
	function __construct(){
		global $db;
		$this->db = $db;
		global $array_syozoku;
		$this->array_syozoku = $array_syozoku;
		global $array_happyo;
		$this->array_happyo = $array_happyo;
		global $array_ippanKouenkouto;
		$this->array_ippanKouenkouto = $array_ippanKouenkouto;
		global $array_ippanKouenposter;
		$this->array_ippanKouenposter = $array_ippanKouenposter;
		global $array_pc;
		$this->array_pc = $array_pc;
	}
	public function index(){
/*
		if($_REQUEST[ 'num' ]){
			$this->num = $_REQUEST[ 'num' ];
			$data = $this->getData();
			$html[ 'data' ] = $data;
		}
*/
		if( $_REQUEST[ 'getList' ]){
			$limit = 50;
			$p = ($_REQUEST[ 'pg' ])?$_REQUEST[ 'pg' ]:0;
			$where = array();
			$where[ 'limit'  ] = $limit;
			$where[ 'offset' ] = $limit * $p;
			$where[ 'code'   ] = $_REQUEST[ 'search' ][ 'code' ];
			$row = $this->db->getHistryData($where,1);
			$data[ 'ceil' ] = ceil($row/$limit);
			$rlt = $this->db->getHistryData($where);
/*
			if(count($rlt)){
				foreach($rlt as $key=>$val){
					$rlt[ $key ][ 'address_types' ] = $this->array_address[ $val[ 'address_type' ] ];
					$rlt[ $key ][ 'ty'   ] = $this->jointype[ $val[ 'join_type' ] ];
					$rlt[ $key ][ 'kty'  ] = $this->array_konshinkai_sts[ $val[ 'koushinkai' ] ];
					$rlt[ $key ][ 'psts' ] = $this->psts[ $val[ 'sanka_pay_status' ] ];
				}
			}
*/
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
		return $html;
	}

}
?>