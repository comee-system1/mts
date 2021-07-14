<?PHP
class pReg{
	function __construct(){
		global $db;
		global $manage;
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

		$this->sankaformselect = $this->db->getSankaFormSelect(1);
		$this->syozokuSankaformselect = $this->db->getSyozokuSankaFormSelect(1);

	}
	public function index(){
		global $manage;
		if($manage[ 'mousikomi_status' ] == 1){
			//利用不可の時
			header("Location:/p_form/");
			exit();
		}
		//データチェック
		//重複登録のチェックを行う
		if($_REQUEST[ 'regCheck' ]){
			$flg = $this->db->regCheck($_REQUEST[ 'search' ]);
			if($flg == 1){
				//重複なし
				echo "0";
			}else{
				//重複
				echo $flg;
			}
			exit();
		}
		//データ編集用
		//編集前のデータは残しておく為、insertを行う
		if($_REQUEST["sid"]){
			$sid = $_REQUEST[ 'sid' ];
			$data = $this->db->getSankaDataReg($sid);
			$ex = explode(",",$data[ 'sankaformselect' ]);
			$sankaformselect = [];
			foreach($ex as $k=>$v){
				$sankaformselect[$v] =$v; 
			}
			$ex = [];
			$ex = explode(",",$data[ 'syozokuSankaformselect' ]);
			$syozokuSankaformex = [];
			foreach($ex as $key=>$val){
				$syozokuSankaformex[$val] = $val;
			}
			$html[ 'sankaformex' ] = $sankaformselect;
			$html[ 'sanka' ] = $data;
			$html[ 'syozokuSankaformex' ] = $syozokuSankaformex;
		}
		//エラーチェック
		if($_REQUEST[ 'back' ] == "on"){
			header("Location:/p_form/");
			exit();
		}
		//エラーチェック
		if($_REQUEST[ 'conf' ] == "on"){
			$err = "";
			//参加登録エラーチェック
			$err = $this->db->sankaErrCheck($_REQUEST,$this->sankaform);
			if($err){
				$html[ 'errmsg' ] = $err;
			}else{
				//確認画面表示
				$html[ 'file' ] = "pConf";
			}
			$_SESSION[ 'joinall' ] = $_REQUEST[ 'all'];
		}

		//エラーチェック
		if($_REQUEST[ 'regist' ] == "on" || $_REQUEST[ 'stripeToken' ]){

			require_once('./stripe/stripe-php-master/init.php');
			// APIのシークレットキー
			\Stripe\Stripe::setApiKey('sk_test_51J4hgvLofq6whqU5JadMYzeluluwb4l6gkMISQ8lwYELOuwejH8cIvJvvfnefH3nXewKO5tLSbVzs5r4TfYu597d00jMxCJyOX');

			//振込処理

			
			$chargeId = null;
			if($_REQUEST[ 'regist' ] != "on"){

				$set = array();
				if($_REQUEST["sid"]){
					//編集のときは既にあるものを利用
					$codes[ 'code' ] = $data[ 'code' ];
					$codes[ 'num'  ] = $data[ 'num'  ];
				}else{
					//参加者申込コード取得
					$codes = $this->db->getSankaCode();
				}


				$description = "名前:".$_REQUEST[ 'name1'].$_REQUEST[ 'name2'];
				$description .= "/参加登録ID:".$codes[ 'code' ];
				$description .= "/電話番号:".$_REQUEST[ 'tel' ];
				try {
					// (1) オーソリ（与信枠の確保）
					$token = $_POST['stripeToken'];
					if($_SESSION[ 'joinall' ] > 0 ){
						$charge = \Stripe\Charge::create(array(
							'amount' => $_SESSION[ 'joinall' ] ,
							'currency' => 'jpy',
							'description' => $description,
							'source' => $token,
							'capture' => false,
						));
						$chargeId = $charge['id'];

						// (2) 注文データベースの更新などStripeとは関係ない処理
						// :
						// :
						// :
					}


					if($chargeId){
						// (3) 売上の確定
						$charge->capture();
					}
					// 購入完了画面にリダイレクト
				//	header("Location: /stripe/complete.html");
				//	exit;
				} catch(Exception $e) {
					if ($chargeId !== null) {
						// 例外が発生すればオーソリを取り消す
						\Stripe\Refund::create(array(
							'charge' => $chargeId,
						));
					}

					// エラー画面にリダイレクト
					//header("Location: /stripe/error.html");
					echo "ERROR";
					exit;
				}
			}

/*
			if($_SESSION[ 'sankaFin' ] == 1){
				//既に参加登録をしている為
				header("Location:/p_form/");
				exit();
			}
*/
			

			$set[ 'code'            ] = $codes[ 'code' ];
			$set[ 'num'             ] = $codes[ 'num'  ];
			if($_REQUEST[ 'stripeToken' ]){
				$set[ 'sanka_pay_status' ] = 1;
			}else{
				$set[ 'sanka_pay_status' ] = (strlen($data[ 'sanka_pay_status' ]) > 0 )?$data[ 'sanka_pay_status' ]:0;
			}

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
			$set[ 'sankaformselect' ] = implode(',',$_REQUEST[ 'sankaformselect' ]);
			$set[ 'sankaformselectother'] = $_REQUEST[ 'sankaformselectother'];
			$set[ 'syozokuSankaformselect' ] = implode(',',$_REQUEST[ 'syozokuSankaformselect' ]);
			$set[ 'syozokuSankaformselectOther' ] = $_REQUEST[ 'syozokuSankaformselectOther'];

			$set[ 'password'        ] = $_REQUEST[ 'password'        ];
			$set[ 'join_type'       ] = (int)$_REQUEST[ 'join_type'       ];
			$set[ 'koushinkai'      ] = (int)$_REQUEST[ 'konshinkai'      ];
			$set[ 'total'           ] = (int)$_REQUEST[ 'all'             ];
			$set[ 'bikou'           ] = $_REQUEST[ 'bikou'           ];
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
			$sid = $this->db->lastid;

			if($flg && $_REQUEST[ 'sid' ]){
				//変更前のデータのステータスを0に変更する
				$edit = array();
				$edit[ 'edit'  ][ 'status' ] = 0;
				$edit[ 'where' ][ 'id'     ] = $_REQUEST[ 'sid' ];
				$this->db->editUserData($table,$edit);
			}
			


			$_SESSION[ 'sankaFin' ] = 1;
			//メール配信
			//今登録したidの取得
			$sanka = $this->db->getSankaDataReg($sid);

			//メールデータ取得
			$sender[ 'mailtype' ] = 2;
			$sends = $this->db->getMailSendData($sender,$sanka);
			$mail = array();
			if($_REQUEST[ 'sid' ]){
				$mail[ 'subject' ] = $sends[ 'titleEdit' ];
			}else{
				$mail[ 'subject' ] = $sends[ 'title' ];
			}
			$mail[ 'body'    ] = $sends[ 'note' ];
			$mail[ 'to'      ] = $_REQUEST[ 'mail'            ];
			//第２匹数は管理者にメールを配信する
			$this->db->sendMailer($mail,1);
			header("Location:/p_form/pSfin/".$sid);
			exit();
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
		$html[ 'syozokuSankaformselect' ] = $this->syozokuSankaformselect;
		$title = $this->db->getTitle();
		$html[ 'title' ] = $title[ 'note' ];
		return $html;
	}


}
?>