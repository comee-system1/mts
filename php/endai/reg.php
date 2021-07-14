<?PHP
class reg{
	function __construct(){
		global $db;
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
		global $array_syotai;
		$this->array_syotai = $array_syotai;
		global $array_korokiumu;
		$this->array_korokiumu = $array_korokiumu;
	}
	public function index(){
		global $endaiform;
		//編集用データ
		global $third;
		global $four;;
		if($third == "eid"){
			$where = array();
			$where[ 'id' ] = $four;
			$edit = $this->db->getEndaiData($where);
			$html[ 'edit' ] = $edit;
			if($edit[ 'syozoku' ]){
				$ex = explode(",",$edit[ 'syozoku' ]);
				foreach($ex as $key=>$val){
					$syozoku[$val] = $val;
				}
				$html['edit'][ 'syozoku' ] = $syozoku;
			}
		}
		//データ削除
		if($third == "did"){
			$table = "kagaku_endai";
			$edit = array();
			$edit[ 'edit'  ][ 'status' ] = 0;
			$edit[ 'where' ][ 'id'     ] = $four;
			$this->db->editUserData($table,$edit);

			$table = "syozoku_kyokai";
			$edit = array();
			$edit[ 'edit'  ][ 'status' ] = 0;
			$edit[ 'where' ][ 'eid'     ] = $four;
			$this->db->editUserData($table,$edit);

			$table = "syozoku_tyosya";
			$edit = array();
			$edit[ 'edit'  ][ 'status' ] = 0;
			$edit[ 'where' ][ 'eid'     ] = $four;
			$this->db->editUserData($table,$edit);

			$table = "syozoku_tyosya_name";
			$edit = array();
			$edit[ 'edit'  ][ 'status' ] = 0;
			$edit[ 'where' ][ 'eid'     ] = $four;
			$this->db->editUserData($table,$edit);
			header("Location:/endai/cus/");
			exit();
		}
		//データ登録
		if($_REQUEST[ 'regist' ]){
			//エラーメッセージ
			$err = $this->db->endaiErr($_REQUEST,$endaiform);

			if(count($err)){
				$html[ 'errmsg' ] = $err;
			}else{
				//添付ファイル削除
				//登録時間を空欄にする
				if($_REQUEST[ 'deleteFile' ]){
					$_REQUEST[ 'fileUpdate_ts'  ] = "";
					$_REQUEST[ 'fileUpdate_ext' ] = "";
				}else{
					//登録時間があるときはその時間を利用する
					if($four){
						$times = $this->db->getFileUpload($four);
					}
					$_REQUEST[ 'fileUpdate_ts'  ] = $times[ 'fileUpdate_ts'  ];
					$_REQUEST[ 'fileUpdate_ext' ] = $times[ 'fileUpdate_ext' ];
				}
				//ファイルのアップロード
				//予稿現行
				if($_FILES[ 'files' ][ 'name' ]){
					if($_FILES[ 'files' ][ 'error' ]){
						$err = "ファイルのアップロードに失敗しました。";
						$html[ 'errmsg' ] = $err;
					}else{

						$uploadfile = "";
						if($four > 0){
							$codes = $this->db->getEndaiCodeWhere($four);
						}else{
							$codes = $this->db->getEndaiCode();
						}
						//拡張子の取得
						$info = new SplFileInfo($_FILES[ 'files' ][ 'name' ]);
						//$files = date('YmdHis')."-".$codes[ 'code' ].".".$info->getExtension();
						//講演番号、講演者ID、日付
						$files = $_REQUEST[ 'publication' ]."-".$codes[ 'code' ]."-".date('YmdHis').".".$info->getExtension();
						$uploadfile = D_PATH_HOME."pdf/".$files;

						move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile);
						$_REQUEST[ 'fileUpdate_ts'  ] = date("Y-m-d H:i:s");
						$_REQUEST[ 'fileUpdate_ext' ] = $files;
					}
				}
				//フラッシュ
				if($_FILES[ 'files_flash' ][ 'name' ]){
					if($_FILES[ 'files_flash' ][ 'error' ]){
						$err = "ファイルのアップロードに失敗しました。";
						$html[ 'errmsg' ] = $err;
					}else{

						$uploadfile = "";
						if($four > 0){
							$codes = $this->db->getEndaiCodeWhere($four);
						}else{
							$codes = $this->db->getEndaiCode();
						}
						//拡張子の取得
						$info = new SplFileInfo($_FILES[ 'files_flash' ][ 'name' ]);
						//$files = date('YmdHis')."-".$codes[ 'code' ].".".$info->getExtension();
						//講演番号、講演者ID、日付
						$files = $_REQUEST[ 'publication' ]."-".$codes[ 'code' ]."-".date('YmdHis').".".$info->getExtension();
						$uploadfile = D_PATH_HOME."flash/".$files;

						move_uploaded_file($_FILES['files_flash']['tmp_name'], $uploadfile);
						$_REQUEST[ 'fileUpdate_flash_ts'  ] = date("Y-m-d H:i:s");
						$_REQUEST[ 'fileUpdate_flash_ext' ] = $files;
					}
				}
				//ポスター
				if($_FILES[ 'files_poster' ][ 'name' ]){
					if($_FILES[ 'files_poster' ][ 'error' ]){
						$err = "ファイルのアップロードに失敗しました。";
						$html[ 'errmsg' ] = $err;
					}else{

						$uploadfile = "";
						if($four > 0){
							$codes = $this->db->getEndaiCodeWhere($four);
						}else{
							$codes = $this->db->getEndaiCode();
						}
						//拡張子の取得
						$info = new SplFileInfo($_FILES[ 'files_poster' ][ 'name' ]);
						//$files = date('YmdHis')."-".$codes[ 'code' ].".".$info->getExtension();
						//講演番号、講演者ID、日付
						$files = $_REQUEST[ 'publication' ]."-".$codes[ 'code' ]."-".date('YmdHis').".".$info->getExtension();
						$uploadfile = D_PATH_HOME."poster/".$files;

						move_uploaded_file($_FILES['files_poster']['tmp_name'], $uploadfile);
						$_REQUEST[ 'fileUpdate_poster_ts'  ] = date("Y-m-d H:i:s");
						$_REQUEST[ 'fileUpdate_poster_ext' ] = $files;
					}
				}








				if(!$err){
					//eidがあるときはステータスを0にして以下で新規登録を行う
					if($third == "eid"){
						$table = "kagaku_endai";
						$edit = array();
						$edit[ 'edit'  ][ 'status' ] = 0;
						$edit[ 'where' ][ 'id'     ] = $four;
						$this->db->editUserData($table,$edit);

						$table = "syozoku_kyokai";
						$edit = array();
						$edit[ 'edit'  ][ 'status' ] = 0;
						$edit[ 'where' ][ 'eid'     ] = $four;
						$this->db->editUserData($table,$edit);

						$table = "syozoku_tyosya";
						$edit = array();
						$edit[ 'edit'  ][ 'status' ] = 0;
						$edit[ 'where' ][ 'eid'     ] = $four;
						$this->db->editUserData($table,$edit);

						$table = "syozoku_tyosya_name";
						$edit = array();
						$edit[ 'edit'  ][ 'status' ] = 0;
						$edit[ 'where' ][ 'eid'     ] = $four;
						$this->db->editUserData($table,$edit);

					}
					//第2引数編集用
					$flg = $this->db->setEndaiData($_REQUEST,$four);
					$eid = $this->db->eid;

					//メールデータ取得

					$endai = $this->db->getEndaiData2($eid);
					//講演登録
					if($_REQUEST[ 'mail1' ]){
						$where = array();
						$where[ 'mailtype' ] = 1;

						$maildata = $this->db->getMailSendData($where,$endai);

						$mail = array();
						if($third == "eid"){
							$mail[ 'subject' ] = $maildata[ 'titleEdit' ];
						}else{
							$mail[ 'subject' ] = $maildata[ 'title' ];
						}
						$mail[ 'body'    ] = $maildata[ 'note' ];
						$mail[ 'to'      ] = $endai[ 'mail'            ];
						//第２匹数は管理者にメールを配信する
						$this->db->sendMailer($mail,1);
					}

					if($_REQUEST[ 'mail2' ]){
						$where = array();
						$where[ 'mailtype' ] = 3;
						$maildata = $this->db->getMailSendData($where,$endai);
						$mail = array();
						$mail[ 'subject' ] = $maildata[ 'title' ];
						$mail[ 'body'    ] = $maildata[ 'note' ];
						$mail[ 'to'      ] = $endai[ 'mail'            ];
						//第２匹数は管理者にメールを配信する
						$this->db->sendMailer($mail,1);
					}

					header("Location:/endai/cus/");
				}
			}
		}
		//参加者データ取得
		if($_REQUEST[ 'getList' ]){
			$data[ 'data' ] = $this->db->getEndaiSankaData($_REQUEST[ 'sid' ]);
			$data[ 'array_address' ] = $this->array_address;
			echo json_encode($data);
			exit();
		}
		$html[ 'array_address' ] = $this->array_address;
		$html[ 'array_syozoku' ] = $this->array_syozoku;
		$html[ 'array_happyo'  ] = $this->array_happyo;
		$html[ 'array_ippanKouenkouto'  ] = $this->array_ippanKouenkouto;
		$html[ 'array_ippanKouenposter' ] = $this->array_ippanKouenposter;
		$html[ 'array_pc'      ] = $this->array_pc;
		$html[ 'array_saitaku' ] = $this->array_saitaku;
		$html[ 'array_syotai'  ] = $this->array_syotai;
		$html[ 'array_korokiumu'  ] = $this->array_korokiumu;
		$html[ 'endaiform' ]  = $endaiform;
		return $html;
	}




}
?>