<?PHP
class editForm{
	function __construct(){
		global $db;
		$this->db = $db;
		global $array_konshinkai_sts;
		$this->konshin = $array_konshinkai_sts;
		global $array_pay_sts;
		$this->psts = $array_pay_sts;
		global $array_address;
		$this->address_type = $array_address;

		global $array_join_type;
		$this->join_type = $array_join_type;

		global $array_join_type_money;
		$this->join_money = $array_join_type_money;

		global $array_konshinkai;
		$this->konshinkai = $array_konshinkai;

		global $array_konshinkai_money;
		$this->konshinkai_money = $array_konshinkai_money;

		global $array_syotai;
		$this->syotai_mst = $array_syotai;

		global $third;
		$this->third = $third;

		global $four;
		$this->four = $four;
		global $array_syozoku;


	}
	public function index(){
		global $array_syozoku;
		if($_REQUEST[ 'regist' ]){
			$table = "endai_form_mst";
			foreach($_REQUEST[ 'ordername' ] as $key=>$val){
				$edit = array();
				$edit[ 'where' ][ 'ordercode'          ] = $key;
				$edit[ 'edit'  ][ 'name'               ] = ($_REQUEST[ 'name' ][ $key ])?$_REQUEST[ 'name' ][ $key ]:"";
				$edit[ 'edit'  ][ 'name_text1'         ] = ($_REQUEST[ 'name_text1'          ][ $key ])?$_REQUEST[ 'name_text1' ][ $key ]:"";
				$edit[ 'edit'  ][ 'name_text2'         ] = ($_REQUEST[ 'name_text2'          ][ $key ])?$_REQUEST[ 'name_text2' ][ $key ]:"";
				$edit[ 'edit'  ][ 'name_text3'         ] = ($_REQUEST[ 'name_text3'          ][ $key ])?$_REQUEST[ 'name_text3' ][ $key ]:"";
				$edit[ 'edit'  ][ 'name_text4'         ] = ($_REQUEST[ 'name_text4'          ][ $key ])?$_REQUEST[ 'name_text4' ][ $key ]:"";
				$edit[ 'edit'  ][ 'name_text5'         ] = ($_REQUEST[ 'name_text5'          ][ $key ])?$_REQUEST[ 'name_text5' ][ $key ]:"";
				$edit[ 'edit'  ][ 'errmsg'             ] = ($_REQUEST[ 'errmsg'              ][ $key ])?$_REQUEST[ 'errmsg'     ][ $key ]:"";
				$edit[ 'edit'  ][ 'status'             ] = ($_REQUEST[ 'status'              ][ $key ])?1:0;
				$edit[ 'edit'  ][ 'indispensible'      ] = ($_REQUEST[ 'indispensible'       ][ $key ])?1:0;
				$edit[ 'edit'  ][ 'indispensible_text' ] = ($_REQUEST[ 'indispensible_text'  ][ $key ])?$_REQUEST[ 'indispensible_text' ][ $key ]:"";
				$edit[ 'edit'  ][ 'explaintext'        ] = $_REQUEST[ 'explain' ][ $key ];

				$this->db->editUserData($table,$edit);
			}
			$table = "syozoku_mst";
			foreach($_REQUEST[ 'syozoku_mst' ] as $key=>$val){
				$edit = array();
				$edit[ 'where' ][ 'code' ] = $key;
				$edit[ 'edit'  ][ 'name' ] = $val[ 'name' ];
				$edit[ 'edit'  ][ 'status' ] = $val[ 'status' ];
				$this->db->editUserData($table,$edit);
			}
			$table = "happyo_mst";
			foreach($_REQUEST[ 'happyo_mst' ] as $key=>$val){
				$edit = array();
				$edit[ 'where' ][ 'code' ] = $key;
				$edit[ 'edit'  ][ 'name' ] = $val[ 'name' ];
				$edit[ 'edit'  ][ 'status' ] = $val[ 'status' ];
				$this->db->editUserData($table,$edit);
			}
			$table = "ippankouenkouto_mst";
			foreach($_REQUEST[ 'ippanKouenkouto_mst' ] as $key=>$val){
				$edit = array();
				$edit[ 'where' ][ 'code' ] = $key;
				$edit[ 'edit'  ][ 'name' ] = $val[ 'name' ];
				$edit[ 'edit'  ][ 'status' ] = $val[ 'status' ];
				$this->db->editUserData($table,$edit);
			}
			$table = "ippankouenposter_mst";
			foreach($_REQUEST[ 'ippanKouenposter_mst' ] as $key=>$val){
				$edit = array();
				$edit[ 'where' ][ 'code' ] = $key;
				$edit[ 'edit'  ][ 'name' ] = $val[ 'name' ];
				$edit[ 'edit'  ][ 'status' ] = $val[ 'status' ];
				$this->db->editUserData($table,$edit);
			}
			$table = "syotai_mst";
			foreach($_REQUEST[ 'syotai_mst' ] as $key=>$val){
				$edit = array();
				$edit[ 'where' ][ 'code' ] = $key;
				$edit[ 'edit'  ][ 'name' ] = $val[ 'name' ];
				$edit[ 'edit'  ][ 'status' ] = $val[ 'status' ];
				$this->db->editUserData($table,$edit);
			}

			$table = "korokiumu_mst";
			foreach($_REQUEST[ 'korokiumu_mst' ] as $key=>$val){
				$edit = array();
				$edit[ 'where' ][ 'code' ] = $key;
				$edit[ 'edit'  ][ 'name' ] = $val[ 'name' ];
				$edit[ 'edit'  ][ 'status' ] = $val[ 'status' ];
				$this->db->editUserData($table,$edit);
			}

			$table = "pc_mst";
			foreach($_REQUEST[ 'pc_mst' ] as $key=>$val){
				$edit = array();
				$edit[ 'where' ][ 'code' ] = $key;
				$edit[ 'edit'  ][ 'name' ] = $val[ 'name' ];
				$edit[ 'edit'  ][ 'status' ] = $val[ 'status' ];
				$this->db->editUserData($table,$edit);
			}
		}
		//参加フォームデータ取得
		$endaiform = array();
		$endaiform = $this->db->getEndaiEndaiForm();
		$html[ 'endaiform'       ] = $endaiform;
		$html[ 'array_syozoku'   ] = $this->db->getSyozokuMaster();
		$html[ 'array_happyo'    ] = $this->db->getHappyoMaster();
		$html[ 'array_ippanKouenkouto'     ] = $this->db->getIppanKouenkoutoMaster();
		$html[ 'array_ippanKouenposter'    ] = $this->db->getIppanKouenposterMaster();
		$html[ 'syotai_mst'                ] = $this->db->getSyotaiMaster();
		$html[ 'korokiumu_mst'                ] = $this->db->getKorokiumuMaster();
		$html[ 'array_pc'                  ] = $this->db->getPCMaster();

		return $html;
	}



}
?>