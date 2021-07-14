<?PHP
class editlg{
	function __construct(){
		global $db;
		global $manage;
		$this->db = $db;
		global $array_address;
		$this->array_address = $array_address;
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
		global $array_saitaku;
		$this->array_saitaku = $array_saitaku;
		global $endaiform;

		global $array_korokiumu;
		$this->array_korokiumu = $array_korokiumu;
		global $array_syotai;
		$this->array_syotai = $array_syotai;
		global $array_korokiumu;
		$this->array_korokiumu = $array_korokiumu;

	}
	public function index(){
		global $manage;
		if($manage[ 'conf_status' ] == 1){
			//利用不可の時
			header("Location:/pre/");
			exit();
		}
		global $endaiform;
//var_dump($endaiform[ 'eform' ]);
		//ログインチェック
		//ログイン
		if($_REQUEST[ 'login' ]){
			$flg = $this->db->checkLoginEditlg($_REQUEST);
			if($flg[ 'id' ]){
				$html[ 'edit' ] = $flg;

				if($flg[ 'syozoku' ]){
					$ex = explode(",",$flg[ 'syozoku' ]);
					foreach($ex as $key=>$val){
						$syozoku[$val] = $val;
					}
					$html['edit'][ 'syozoku' ] = $syozoku;
				}

				$html[ 'file' ] = "eForm";
			}else{
				$errmsg = $endaiform[ 'eform' ][25][ 'errmsg' ];
			}
		}
		//確認画面
		if($_REQUEST[ 'conf' ]){
			$flg = $this->db->checkLoginEditlg($_REQUEST);
			if($flg[ 'id' ]){
				$html[ 'edit' ] = $flg;

				if($flg[ 'syozoku' ]){
					$ex = explode(",",$flg[ 'syozoku' ]);
					foreach($ex as $key=>$val){
						$syozoku[$val] = $val;
					}
					$html['edit'][ 'syozoku' ] = $syozoku;
				}

				//エラーチェック
				$err = $this->db->endaiErr($_REQUEST,$endaiform);
				$errmsg = $err;
				if($err){
					$html[ 'file' ] = "eForm";
				}else{
					$html[ 'file' ] = "eFormConf";
				}
			}
		}
		//確認画面～戻る
		if($_REQUEST[ 'back' ]){
			header("Location:../");
			exit();
		}
		if($_REQUEST[ 'back2' ]){
		    $flg = $this->db->checkLoginEditlg($_REQUEST);
			$html[ 'edit' ] = $flg;
			$html[ 'file' ] = "eForm";
		}else
		if($_REQUEST[ 'regist' ]){
			//データ登録

			//エラーメッセージ
			$err = $this->db->endaiErr($_REQUEST);
			if(count($err)){
				$html[ 'errmsg' ] = $err;
			}else{
				if(!$err){
					//ファイルが既にアップロードしているときは
					//そちらを利用する
					if($_REQUEST[ 'eid' ]){
						$fileup = $this->db->getFileUpEditlg($_REQUEST[ 'eid' ]);
						$_REQUEST[ 'publication'     ] = $fileup[ 'publication'    ];
						$_REQUEST[ 'vote'            ] = $fileup[ 'vote'           ];
						$_REQUEST[ 'vote_text'       ] = $fileup[ 'vote_text'      ];
						$_REQUEST[ 'fileUpdate_ts'   ] = $fileup[ 'fileUpdate_ts'  ];
						$_REQUEST[ 'fileUpdate_ext'  ] = $fileup[ 'fileUpdate_ext' ];

					}
					//var_dump($_REQUEST);
					//eidがあるときはステータスを0にして以下で新規登録を行う
					$table = "kagaku_endai";
					$edit = array();
					$edit[ 'edit'  ][ 'status' ] = 0;
					$edit[ 'where' ][ 'id'     ] = $_REQUEST[ 'eid' ];
					$this->db->editUserData($table,$edit);

					$table = "syozoku_kyokai";
					$edit = array();
					$edit[ 'edit'  ][ 'status' ] = 0;
					$edit[ 'where' ][ 'eid'     ] = $_REQUEST[ 'eid' ];
					$this->db->editUserData($table,$edit);

					$table = "syozoku_tyosya";
					$edit = array();
					$edit[ 'edit'  ][ 'status' ] = 0;
					$edit[ 'where' ][ 'eid'     ] = $_REQUEST[ 'eid' ];
					$this->db->editUserData($table,$edit);

					$table = "syozoku_tyosya_name";
					$edit = array();
					$edit[ 'edit'  ][ 'status' ] = 0;
					$edit[ 'where' ][ 'eid'     ] = $_REQUEST[ 'eid' ];
					$this->db->editUserData($table,$edit);


					//第2引数編集用
					$flg = $this->db->setEndaiData($_REQUEST,$_REQUEST[ 'eid' ]);
					//メール配信
					$eid = $this->db->eid;
					//メールデータ取得
					$where = array();
					$where[ 'mailtype' ] = 1;
					$endai = $this->db->getEndaiDataEditlg($eid);
					$maildata = $this->db->getMailSendData($where,$endai);

					$mail = array();
					if($_REQUEST[ 'eid' ]){
						$mail[ 'subject' ] = $maildata[ 'titleEdit' ];
					}else{
						$mail[ 'subject' ] = $maildata[ 'title' ];
					}
					$mail[ 'body'    ] = $maildata[ 'note' ];
					$mail[ 'to'      ] = $endai[ 'mail'            ];
					//第２匹数は管理者にメールを配信する
					$this->db->sendMailer($mail,1);

					header("Location:/pre/endaiFin/".$_REQUEST[ 'sid' ]);
					exit();
				}
			}
		}

//var_dump($_REQUEST);
		//参加者データ取得
		if($_REQUEST[ 'getList' ] ){
		    $data[ 'data' ] = $this->db->getSankaDataEditlg($_REQUEST[ 'sid' ]);
			$data[ 'array_address' ] = $this->array_address;
			echo json_encode($data);
			exit();
		}
		$title= $this->db->gethappyoTitle();
		$html[ 'title'  ] = $title[ 'title1' ];
		$html[ 'errmsg' ] = $errmsg;
		$html[ 'num' ] = $flg[ 'snum' ];
		$html[ 'eid' ] = $flg[ 'id'   ];
		$html[ 'array_address' ] = $this->array_address;
		$html[ 'array_syozoku' ] = $this->array_syozoku;
		$html[ 'array_happyo'  ] = $this->array_happyo;
		$html[ 'array_ippanKouenkouto'  ] = $this->array_ippanKouenkouto;
		$html[ 'array_ippanKouenposter' ] = $this->array_ippanKouenposter;
		$html[ 'array_pc'      ] = $this->array_pc;
		$html[ 'array_saitaku' ] = $this->array_saitaku;
		$html[ 'array_syotai' ] = $this->array_syotai;
		$html[ 'array_korokiumu' ] = $this->array_korokiumu;

		return $html;
	}

}
?>