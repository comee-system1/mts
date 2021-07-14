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

		global $third;
		$this->third = $third;

		global $four;
		$this->four = $four;


	}
	public function index(){
		if($_REQUEST[ 'regist' ]){
			//参加者登録フォーム編集用selectbox
			$table = "sanka_form_select";
			foreach($_REQUEST[ 'sankaSelectid' ] as $key=>$val){
				$edit = [];
				$edit[ 'where' ][ 'id' ] = $val;
				$edit[ 'edit'  ][ 'text'   ] = $_REQUEST[ 'sankaSelectText' ][$val];
				$edit[ 'edit'  ][ 'status' ] = ($_REQUEST[ 'sankaSelectStatus' ][$val])?1:0;
				$this->db->editUserData($table,$edit);
			}
			$table = "sanka_syozoku_mst";
			foreach($_REQUEST[ 'syozokuSankaSelectid' ] as $key=>$val){
				$edit = [];
				$edit[ 'where' ][ 'id' ] = $val;
				$edit[ 'edit'  ][ 'name'   ] = $_REQUEST[ 'syozokuSankaSelectText' ][$val];
				$edit[ 'edit'  ][ 'status' ] = ($_REQUEST[ 'syozokuSankaSelectStatus' ][$val])?1:0;
				$this->db->editUserData($table,$edit);
			}
			$table = "sanka_form_mst";
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
			

			//金額の登録
			$table = "sanka_money_mst";
			for($i=1;$i<=10;$i++){
				$edit = array();
				$edit[ 'where' ][ 'ordercode'    ] = $i;
				$edit[ 'edit'  ][ 'money'        ] = $_REQUEST[ 'money'      ][$i];
				$edit[ 'edit'  ][ 'money_text'   ] = $_REQUEST[ 'money_text' ][$i];
				$edit[ 'edit'  ][ 'note_text'    ] = $_REQUEST[ 'note_text'  ][$i];
				$this->db->editUserData($table,$edit);
			}
		}
		//参加フォームデータ取得
		$sankaform = $this->db->getSankaFormMst();
		$sankamoney = $this->db->getSankaMoneyMst();
		$sankaselect = $this->db->getSankaFormSelect();
		$syozokuSankaselect = $this->db->getSyozokuSankaFormSelect();

		$html[ 'sankaFormer'   ] = $sankaform;
		$html[ 'sankamoney'    ] = $sankamoney;
		$html[ 'sankaselect'   ] = $sankaselect;
		$html[ 'syozokuSankaselect'   ] = $syozokuSankaselect;

		return $html;
	}

}
?>