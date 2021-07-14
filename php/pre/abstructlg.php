<?PHP
class abstructlg{
	function __construct(){
		global $manage;
		global $db;
		$this->db = $db;
		global $endaiform;
	}
	public function index(){
		global $manage;
		if($manage[ 'yousi_status' ] == 1){
			//利用不可の時
			header("Location:/pre/");
			exit();
		}
		global $endaiform;
		//ログインチェック
		//ログイン
		if($_REQUEST[ 'login' ]){
			$flg = $this->db->checkLoginAb($_REQUEST);

			if($flg[ 'checkid' ]){
				$html[ 'edit' ] = $flg;

				if($flg[ 'syozoku' ]){
					$ex = explode(",",$flg[ 'syozoku' ]);
					foreach($ex as $key=>$val){
						$syozoku[$val] = $val;
					}
					$html['edit'][ 'syozoku' ] = $syozoku;
				}

				$html[ 'file' ] = "eUpload";
			}else{
				$errmsg = $endaiform[ 'eform' ][29][ 'errmsg' ];
			}
		}


		/*****************
		 * ポスターデータ
		 */
		if($_REQUEST[ 'regist_poster' ]){
			$html[ 'file' ] = "eUpload";
			$flg = $this->db->checkLoginAb($_REQUEST);
			$html[ 'edit' ] = $flg;
			//データ登録
			//添付ファイル削除
			//登録時間を空欄にする
			if($_REQUEST[ 'deleteFile_poster' ]){
				$_REQUEST[ 'fileUpdate_ts'  ] = "";
				$_REQUEST[ 'fileUpdate_ext' ] = "";



				$table = "kagaku_endai";
				$where = array();
				$where[ 'where' ][ 'id' ] = $flg[ 'eid' ];
				$where[ 'edit'  ][ 'fileUpdate_poster_ts'  ] = "";
				$where[ 'edit'  ][ 'fileUpdate_poster_ext' ] = "";
				$this->db->editUserData($table,$where);

				header("Location:/pre/abstructFin/".$flg[ 'eid' ]);
				exit();


			}else{

			}

			
			//ファイルのアップロード
			if($_FILES[ 'files_poster' ][ 'name' ]){
				if($_FILES[ 'files_poster' ][ 'error' ]){
					$err = $endaiform[ 'eform' ][ '40' ][ 'errmsg' ];
					$html[ 'errmsg' ] = $err;
				}else{

					$uploadfile = "";

					//拡張子の取得
					$info = new SplFileInfo($_FILES[ 'files_poster' ][ 'name' ]);
					$times = date('YmdHis');
					$times2 = date('Y-m-d H:i:s');
					$files = $flg[ 'publication' ]."-".$flg[ 'code' ]."-".$times.".".$info->getExtension();
					$uploadfile = D_PATH_HOME."poster/".$files;
					move_uploaded_file($_FILES['files_poster']['tmp_name'], $uploadfile);
					
					$table = "kagaku_endai";
					$where = array();
					$where[ 'where' ][ 'id' ] = $flg[ 'eid' ];
					$where[ 'edit'  ][ 'fileUpdate_poster_ts'  ] = $times2;
					$where[ 'edit'  ][ 'fileUpdate_poster_ext' ] = $files;
					$this->db->editUserData($table,$where);

					
					//メールデータ取得
					$where = array();
					$where[ 'mailtype' ] = 3;
					$eid = $flg[ 'eid' ];
					$endai = $this->db->getEndaiDataAb($eid);

					$maildata = $this->db->getMailSendData($where,$endai);
					$mail = array();
					$mail[ 'subject' ] = $maildata[ 'title' ];
					$mail[ 'body'    ] = $maildata[ 'note' ];
					$mail[ 'to'      ] = $flg[ 'mail'            ];
					//第２匹数は管理者にメールを配信する
					$this->db->sendMailer($mail,1);

					header("Location:/pre/abstructFin/".$flg[ 'eid' ]);
					exit();
				}
			}else{
				$errmsg = $endaiform[ 'eform' ][40][ 'errmsg' ];
			}
		}
		/*****************
		 * フラッシュ発表用
		 */
		if($_REQUEST[ 'regist_flash' ]){
			$html[ 'file' ] = "eUpload";
			$flg = $this->db->checkLoginAb($_REQUEST);
			$html[ 'edit' ] = $flg;
			//データ登録
			//添付ファイル削除
			//登録時間を空欄にする
			if($_REQUEST[ 'deleteFile_flash' ]){
				$_REQUEST[ 'fileUpdate_ts'  ] = "";
				$_REQUEST[ 'fileUpdate_ext' ] = "";

				$table = "kagaku_endai";
				$where = array();
				$where[ 'where' ][ 'id' ] = $flg[ 'eid' ];
				$where[ 'edit'  ][ 'fileUpdate_flash_ts'  ] = "";
				$where[ 'edit'  ][ 'fileUpdate_flash_ext' ] = "";
				$this->db->editUserData($table,$where);

				header("Location:/pre/abstructFin/".$flg[ 'eid' ]);
				exit();
			}else{

			}

			
			//ファイルのアップロード
			if($_FILES[ 'files_flash' ][ 'name' ]){
				if($_FILES[ 'files_flash' ][ 'error' ]){
					$err = $endaiform[ 'eform' ][ '39' ][ 'errmsg' ];
					$html[ 'errmsg' ] = $err;
				}else{

					$uploadfile = "";

					//拡張子の取得
					$info = new SplFileInfo($_FILES[ 'files_flash' ][ 'name' ]);
					$times = date('YmdHis');
					$times2 = date('Y-m-d H:i:s');
					$files = $flg[ 'publication' ]."-".$flg[ 'code' ]."-".$times.".".$info->getExtension();
					$uploadfile = D_PATH_HOME."flash/".$files;
					move_uploaded_file($_FILES['files_flash']['tmp_name'], $uploadfile);
					
					$table = "kagaku_endai";
					$where = array();
					$where[ 'where' ][ 'id' ] = $flg[ 'eid' ];
					$where[ 'edit'  ][ 'fileUpdate_flash_ts'  ] = $times2;
					$where[ 'edit'  ][ 'fileUpdate_flash_ext' ] = $files;
					$this->db->editUserData($table,$where);

					
					//メールデータ取得
					$where = array();
					$where[ 'mailtype' ] = 3;
					$eid = $flg[ 'eid' ];
					$endai = $this->db->getEndaiDataAb($eid);

					$maildata = $this->db->getMailSendData($where,$endai);
					$mail = array();
					$mail[ 'subject' ] = $maildata[ 'title' ];
					$mail[ 'body'    ] = $maildata[ 'note' ];
					$mail[ 'to'      ] = $flg[ 'mail'            ];
					//第２匹数は管理者にメールを配信する
					$this->db->sendMailer($mail,1);


					header("Location:/pre/abstructFin/".$flg[ 'eid' ]);
					exit();
				}
			}else{
				$errmsg = $endaiform[ 'eform' ][39][ 'errmsg' ];
			}
		}

		/*********************
		 * 予稿現行登録
		 */
		if($_REQUEST[ 'regist' ]){
			$html[ 'file' ] = "eUpload";
			$flg = $this->db->checkLoginAb($_REQUEST);
			$html[ 'edit' ] = $flg;
			//データ登録
			//添付ファイル削除
			//登録時間を空欄にする
			if($_REQUEST[ 'deleteFile' ]){
				$_REQUEST[ 'fileUpdate_ts'  ] = "";
				$_REQUEST[ 'fileUpdate_ext' ] = "";
			}else{

			}
			//ファイルのアップロード
			if($_FILES[ 'files' ][ 'name' ]){
				if($_FILES[ 'files' ][ 'error' ]){
					$err = $endaiform[ 'eform' ][ '33' ][ 'errmsg' ];
					$html[ 'errmsg' ] = $err;
				}else{

					$uploadfile = "";

					//拡張子の取得
					$info = new SplFileInfo($_FILES[ 'files' ][ 'name' ]);
					$times = date('YmdHis');
					$times2 = date('Y-m-d H:i:s');
					//$files = $times."-".$flg[ 'code' ].".".$info->getExtension();
					$files = $flg[ 'publication' ]."-".$flg[ 'code' ]."-".$times.".".$info->getExtension();
					$uploadfile = D_PATH_HOME."pdf/".$files;
					move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile);

					$table = "kagaku_endai";
					$where = array();
					$where[ 'where' ][ 'id' ] = $flg[ 'eid' ];
					$where[ 'edit'  ][ 'fileUpdate_ts'  ] = $times2;
					$where[ 'edit'  ][ 'fileUpdate_ext' ] = $files;
					$this->db->editUserData($table,$where);

					
					//メールデータ取得
					$where = array();
					$where[ 'mailtype' ] = 3;
					$eid = $flg[ 'eid' ];
					$endai = $this->db->getEndaiDataAb($eid);

					$maildata = $this->db->getMailSendData($where,$endai);
					$mail = array();
					$mail[ 'subject' ] = $maildata[ 'title' ];
					$mail[ 'body'    ] = $maildata[ 'note' ];
					$mail[ 'to'      ] = $flg[ 'mail'            ];
					//第２匹数は管理者にメールを配信する
					$this->db->sendMailer($mail,1);

					header("Location:/pre/abstructFin/".$flg[ 'eid' ]);
					exit();
				}
			}else{
				$errmsg = $endaiform[ 'eform' ][33][ 'errmsg' ];
			}
		}

		$title= $this->db->gethappyoTitle();
		$html[ 'title'  ] = $title[ 'title1' ];
		$html[ 'errmsg' ] = $errmsg;
		$html[ 'num' ] = $flg[ 'snum' ];
		$html[ 'eid' ] = $flg[ 'eid'   ];

		return $html;
	}


}
?>