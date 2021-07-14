<?PHP
class reg{
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

		global $sankaform;
		$this->sankaform = $sankaform;

		//参加者用フォームの取得
		$this->sankaformselect = $this->db->getSankaFormSelect(1);

	}
	public function index(){
		
		//データ編集用
		//編集前のデータは残しておく為、insertを行う
		if($this->third == "sid"){
			$sid = $this->four;
			$data = $this->db->getSankaData($sid);
			$ex = explode(",",$data[ 'sankaformselect' ]);
			$sankaformex = [];
			foreach($ex as $key=>$val){
				$sankaformex[$val] = $val;
			}
			$html[ 'sanka' ] = $data;
			$html[ 'sankaformex' ] = $sankaformex;
		}
		
		//エラーチェック
		if($_REQUEST[ 'regist' ] == "on"){
			$err = "";
			//参加登録エラーチェック
			$err = $this->db->sankaErrCheck($_REQUEST,$this->sankaform);
			if(count($err) == 0 ){
				$set = array();
				if($this->third == "sid"){
					//編集のときは既にあるものを利用
					$codes[ 'code' ] = $data[ 'code' ];
					$codes[ 'num'  ] = $data[ 'num'  ];
				}else{
					//参加者申込コード取得
					$codes = $this->db->getSankaCode();
				}
				$set[ 'code'            ] = $codes[ 'code' ];
				$set[ 'num'             ] = $codes[ 'num'  ];
				$set[ 'password'        ] = $_REQUEST[ 'password'        ];
				$set[ 'name1'           ] = $_REQUEST[ 'name1'           ];
				$set[ 'name2'           ] = $_REQUEST[ 'name2'           ];
				$set[ 'kana1'           ] = $_REQUEST[ 'kana1'           ];
				$set[ 'kana2'           ] = $_REQUEST[ 'kana2'           ];
				$set[ 'daigaku'         ] = $_REQUEST[ 'daigaku'         ];
				$set[ 'gakubu'          ] = $_REQUEST[ 'gakubu'          ];
				$set[ 'kenkyu'          ] = $_REQUEST[ 'kenkyu'          ];
				$set[ 'address_type'    ] = $_REQUEST[ 'address_type'    ];
				$set[ 'address'         ] = $_REQUEST[ 'address'         ];
				$set[ 'post'            ] = $_REQUEST[ 'post'            ];
				$set[ 'tel'             ] = $_REQUEST[ 'tel'             ];
				$set[ 'naisen'          ] = $_REQUEST[ 'naisen'          ];
				$set[ 'fax'             ] = $_REQUEST[ 'fax'             ];
				$set[ 'mail'            ] = $_REQUEST[ 'mail'            ];
				$set[ 'password'        ] = $_REQUEST[ 'password'        ];
				$set[ 'join_type'       ] = $_REQUEST[ 'join_type'       ];
				$set[ 'koushinkai'      ] = $_REQUEST[ 'konshinkai'      ];
				$set[ 'total'           ] = $_REQUEST[ 'all'             ];
				$set[ 'bikou'           ] = $_REQUEST[ 'bikou'           ];
				$set[ 'sankaformselect' ] = implode(',',$_REQUEST[ 'sankaformselect' ]);
				$set[ 'sankaformselectother' ] = $_REQUEST[ 'sankaformselectother'];

				$set[ 'sanka_pay_status' ] = $data[ 'sanka_pay_status'           ];

				$set[ 'regist_ts'       ] = date("Y-m-d H:i:s");
				$set[ 'sanka_money'     ] = $this->join_money[$_REQUEST[ 'join_type' ]];
				if($_REQUEST[ 'konshinkai' ] == 1){
					//懇親会参加するとき
					if($_REQUEST[ 'join_type' ] == 1 || $_REQUEST[ 'join_type' ] == 2){
						$set[ 'konshinkai_monay'] = $this->konshinkai_money[1];
					}elseif($_REQUEST[ 'join_type' ] == 3 ||  $_REQUEST[ 'join_type' ] == 4){
						$set[ 'konshinkai_monay'] = $this->konshinkai_money[2];
					}else{
						$set[ 'konshinkai_monay'] = 0;
					}
				}else{
					//懇親会参加しない
					$set[ 'konshinkai_monay'] = 0;
				}
				$table = "kagaku_sanka";
				
				$flg = $this->db->setUserData($table,$set);

				//$sid = mysql_insert_id();
				$sid = $this->db->lastid;
				//メール配信
				//今登録したidの取得
				$sanka = $this->db->getSankaData2($sid);
				//メールデータ取得
				$sender[ 'mailtype' ] = 2;
				$sends = $this->db->getMailSendData($sender,$sanka);
				$mail = array();
				if($_REQUEST[ 'sid' ]){
					//編集ようメールタイトル
					$mail[ 'subject' ] = $sends[ 'titleEdit' ];
				}else{
					$mail[ 'subject' ] = $sends[ 'title' ];
				}
				$mail[ 'body'    ] = $sends[ 'note' ];
				$mail[ 'to'      ] = $_REQUEST[ 'mail'            ];

				//「参加者へメールを送る」にチェックをいれると参加者にメールが送信される
				if($_REQUEST[ 'mail_send' ]){
					//参加者と管理者にメール配信する
					//第２匹数は管理者にメールを配信する
					$this->db->sendMailer($mail,1);
				}else{
					//管理者のみメール配信する。
				   $this->db->sendMailerSecretariat($mail);
				}

				if($flg && $_REQUEST[ 'sid' ]){
					//変更前のデータのステータスを0に変更する
					$edit = array();
					$edit[ 'edit'  ][ 'status' ] = 0;
					$edit[ 'where' ][ 'id'     ] = $_REQUEST[ 'sid' ];
					$this->db->editUserData($table,$edit);
				}
				header("Location:/sanka/cus/");
				exit();
			}else{
				$html[ 'errmsg' ] = $err;
			}
		}

		//print "ccc";
		//$this->getTest();
		$html[ 'konshin'          ] = $this->konshin;
		$html[ 'psts'             ] = $this->psts;
		$html[ 'address_type'     ] = $this->address_type;
		$html[ 'join_type'        ] = $this->join_type;
		$html[ 'join_money'       ] = $this->join_money;
		$html[ 'konshinkai'       ] = $this->konshinkai;
		$html[ 'konshinkai_money' ] = $this->konshinkai_money;
		$html[ 'sankaformselect' ] = $this->sankaformselect;

		return $html;
	}


}
?>