<?PHP
class method extends Auth{
	public function __construct(){
		global $array_mailEdit;
		global $array_mailEdit2;
		global $array_address;
		global $array_join_type;
		global $array_konshinkai_sts;
		global $array_syozoku;
		global $array_happyo;
		global $array_ippanKouenkouto;
		global $array_ippanKouenposter;
		global $array_studentPoster;
		global $array_pc;
		global $array_movie;
		$array_movie_alpha = [];
		foreach($array_movie as $k=>$val){
			$array_movie_alpha[$k] = substr($val,0,1);	
		}
		$this->array_movie_alpha = $array_movie_alpha;
		try {
		    $pdo = new PDO('mysql:host='.DEFAULT_HOST.';dbname='.DEFAULT_DBNAME.';charset=utf8',DEFAULT_USER,DEFAULT_PASSWORD,
		        array(PDO::ATTR_EMULATE_PREPARES => false));
		} catch (PDOException $e) {
		    exit('データベース接続失敗。'.$e->getMessage());
		}
		$this->db=$pdo;
	}
	//-----------------------------
	//movieデータ削除
	//-----------------------------
	public function deleteUserData($where){
		$date = $where['date'];
		$sql = "
			DELETE FROM movie WHERE 
			date = :date
		";
		$r = $this->db->prepare($sql);
		$r->bindValue(':date',$date,PDO::PARAM_STR);
		$flg = $r->execute();
		return $flg;
	}
	public function deleteSankaJudge(){
		$sql = "
			DELETE FROM sanka_judge 
		";
		$r = $this->db->prepare($sql);
		$flg = $r->execute();
		return $flg;
	}
	public function deleteEndaiPublicate(){
		$sql = "
			DELETE FROM endai_publicate 
		";
		$r = $this->db->prepare($sql);
		$flg = $r->execute();
		return $flg;
	}
	//------------------
	//movieデータ取得
	//-------------------
	public function getMovieList(){
		$sql = "
			SELECT 
				* 
			FROM 
				movie 
		";
		$r = $this->db->prepare($sql);
		$r->execute();
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$date = $rlt['date'];
			$type = $rlt['type'];
			$number = $rlt[ 'number' ];
			$place = $rlt[ 'place' ];
			$list[$date][$type][$number][$place]['id'] = $rlt[ 'id' ];
			$list[$date][$type][$number][$place]['number'] = $rlt[ 'number' ];
			$list[$date][$type][$number][$place]['session'] = $rlt[ 'session' ];
			$list[$date][$type][$number][$place]['zoom'] = $rlt[ 'zoom' ];
		}
		return $list;
	}
	//------------------
	//movieデータ取得
	//-------------------
	public function getMovieData($where){
		$date = $where['date'];
		$sql = "
			SELECT * FROM movie WHERE 
			date = :date
		";
		$r = $this->db->prepare($sql);
		$r->bindValue(':date',$date,PDO::PARAM_STR);
		$session = [];
		$zoom = [];
		$r->execute();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			//$list[] = $rlt;
			$place = $rlt['place'];
			$type = $rlt['type'];
			$number = $rlt[ 'number' ];
			$session[$place][$type][$number] = $rlt[ 'session' ];
			$zoom[$place][$type][$number] = $rlt[ 'zoom' ];
		}
		
		$list['session'] = $session;
		$list['zoom'] = $zoom;
		return $list;
	}
	//------------------
	//movieデータ取得
	//-------------------
	public function getMovieDetail($where){
		$id = $where['id'];
		$sql = "
			SELECT 
				* 
			FROM 
				movie 
			WHERE 
				session != ''
			ORDER BY date,type,place,number
		";
		$r = $this->db->prepare($sql);
		$session = [];
		$zoom = [];
		$r->execute();
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
		}
		return $list;
	}
	/***************
	 * ポスター
	 */
	public function getPosterList($id=""){
		$sql = "
			SELECT 
			a.*,
				GROUP_CONCAT(DISTINCT tyosya_name1 ORDER BY stnNum,tyosya_name1 ASC SEPARATOR '/') AS tyosya_name,
				GROUP_CONCAT(DISTINCT syozokuKikanRyaku ORDER BY stNum ASC SEPARATOR '/') AS syozokuKikanRyaku
			FROM (
			SELECT 
				ke.* ,
				stn.id as stnid,
				concat(stn.tyosya_name1,stn.tyosya_name2) AS tyosya_name1,
				stn.num as stnNum,
				st.num as stNum,
				st.id as stid,
				st.syozokuKikanRyaku,
				SUBSTRING(ke.publication,3,1) as alpha
			FROM 
				kagaku_endai  as ke 
				LEFT JOIN syozoku_tyosya_name as stn ON ke.id = stn.eid AND stn.status=1 
				LEFT JOIN syozoku_tyosya as st ON ke.id = st.eid AND st.status=1
			where 
				ke.status = 1 AND
				ke.publication LIKE 'P%'  
		";
		if($_REQUEST[ 'publication' ]){
			$sql .= " AND ke.publication LIKE '%".$_REQUEST[ 'publication' ]."%'";
		}
		if($_REQUEST[ 'endai' ]){
			$sql .= " AND ke.endainame LIKE '%".$_REQUEST[ 'endai' ]."%'";
		}
		if($_REQUEST[ 'ippan' ]){
			$sql .= " AND ke.ippanKouenposter = '".$_REQUEST[ 'ippan' ]."'";
		}
		if($id){
			$sql .= " AND ke.code = '".$id."'";
		}
		$sql .= "
			) as a 
			GROUP BY a.id
			ORDER BY a.publication ASC
	
		";
		$r = $this->db->query($sql);
		$list = [];
		$i=0;
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[$i] = $rlt;
			//著者名に〇をつける
			$ex = explode("/",$rlt['tyosya_name']);
			$num=1;
			$tyosya_name=[];
			foreach($ex as $key=>$values){
				$maru = "";
				if($num == $rlt[ 'tyosya' ]) $maru="〇";
				$tyosya_name[]=$maru.$values;
				$num++;
			}
			$imp = implode("/",$tyosya_name);
			$list[$i]['tyosya_name'] = $imp;
			$i++;
		}
		return $list;
	}
	/**************
	 * 審査員確認
	 */
	public function checkJudgeMan($user){
		$sql = "
				SELECT 
					*
				FROM 
					sanka_judge
				WHERE
				code = :code
		";

		$r = $this->db->prepare($sql);
		$r->bindValue(':code', $user['code'], PDO::PARAM_STR);
		$r->execute();
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);
		
		if($rlt){
			return true;
		}else{
			return false;
		}
		
	}
	public function checkJudgeData($user){
		$sql = "
				SELECT 
					*
				FROM 
					sanka_judge
				WHERE
				code = :code
		";


		$r = $this->db->prepare($sql);
		$r->bindValue(':code', $user['code'], PDO::PARAM_STR);
		$r->execute();
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
		}
		return $list;
		
	}
	//------------------
	//movieデータ説明文
	//-------------------
	public function getMovieExplain(){
		$sql = "
			SELECT 
				* 
			FROM 
				movie_explain
			where
				id=1
		";
		$r = $this->db->query($sql);
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);
		return $rlt;
	}
	//------------------
	//セッション画面
	//-------------------
	public function getSessionData($where){
		$day = $where[ 'day' ];

		$sql = "
			SELECT 
			a.*,
				GROUP_CONCAT(DISTINCT tyosya_name1 ORDER BY stnNum ASC SEPARATOR '/') AS tyosya_name,
				GROUP_CONCAT(DISTINCT syozokuKikanRyaku ORDER BY stNum ASC SEPARATOR '/') AS syozokuKikanRyaku
			FROM (
			SELECT 
				ke.* ,
				stn.id as stnid,
				stn.num as stnNum,
				st.num as stNum,
				concat(stn.tyosya_name1,stn.tyosya_name2) AS tyosya_name1,
				st.id as stid,
				st.syozokuKikanRyaku,
				SUBSTRING(ke.publication,3,1) as alpha,
				ed.zatyo_name,
				ed.zatyo_group
			FROM 
				kagaku_endai  as ke 
				LEFT JOIN syozoku_tyosya_name as stn ON ke.id = stn.eid AND stn.status=1 
				LEFT JOIN syozoku_tyosya as st ON ke.id = st.eid AND st.status=1
				LEFT JOIN endai_publicate as ed ON ed.publication=ke.publication
			where 
				ke.status = 1 AND 
				ke.publication LIKE '".$day."%' 
			
			) as a 
			GROUP BY a.id
			ORDER BY a.publication ASC
	
		";
		$r = $this->db->query($sql);
		$list = [];
		$i=0;
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
			//著者名に〇をつける
			$ex = explode("/",$rlt['tyosya_name']);
			$num=1;
			$tyosya_name=[];
			foreach($ex as $key=>$values){
				$maru = "";
				if($num == $rlt[ 'tyosya' ]) $maru="〇";
				$tyosya_name[]=$maru.$values;
				$num++;
			}
			$imp = implode("/",$tyosya_name);
			$list[$i]['tyosya_name'] = $imp;
			$i++;

		}
		return $list;

	}
	/*************************
	 * zoom用URL取得
	 */
	public function getMoveData(){
		
		$sql = "
			SELECT 
				date,
				place,
				GROUP_CONCAT(session ORDER BY type ASC ,number ASC separator ',' ) as session,
				GROUP_CONCAT(zoom ORDER BY type ASC ,number ASC separator ',' ) as zoom
			FROM 
				movie 
			GROUP BY date,place
			
		";
		$r = $this->db->query($sql);
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$day = explode("-",$rlt[ 'date' ]);
			$d = $day[2];
			$p = $this->array_movie_alpha[$rlt[ 'place' ]];
			$ex = explode(",",$rlt[ 'zoom' ]);
			
			$list[$d][$p]['url'] = $ex;
			$ex2 = explode(",",$rlt[ 'session' ]);
			$list[$d][$p]['session'] = $ex2;
		}
		return $list;
	}

	//------------------------------------
	//データ修正
	//------------------------------------
	public function editUserData($table,$data){
		$edit = "";
	    foreach($data[ 'edit' ] as $k=>$v){
	        $edit .= ",".$k."=:".$k."";
		}
	    $edit = preg_replace("/^,/","",$edit);
		$where = "";
		foreach($data[ 'where' ] as $k=>$v){
	        $where .= $k."=:".$k." AND ";
	    }

		$sql = "";
		$sql = " UPDATE ".$table." SET ";
		$sql .= $edit;
		$sql .= " WHERE ";
		$sql .= $where;
		$sql .= " 1=1 ";
		$r = $this->db->prepare($sql);

		foreach($data[ 'edit' ] as $k=>$v){
		    $r->bindValue(':'.$k,$v,PDO::PARAM_STR);
		}
		foreach($data[ 'where' ] as $k=>$v){
		    $r->bindValue(':'.$k,$v,PDO::PARAM_STR);
		}
		$flg = $r->execute();
		return $flg;
	}
	//-----------------------------------------------
	//データ登録
	//-----------------------------------------------
	public function setUserData($table,$data){
		foreach($data as $key=>$val){
			$calum .= ",".$key;
			$value .= ",:".$key."";
		}
		$calum = preg_replace("/^,/","",$calum);
		$value = preg_replace("/^,/","",$value);
		$sql = "";
		$sql = "INSERT INTO ".$table." (";
		$sql .= $calum;
		$sql .= ") VALUES (";
		$sql .= $value;
		$sql .= ")";
		$r = $this->db->prepare($sql);
		$vals = "";
		foreach($data as $key=>$val){
		    $k = ":".$key;
		    if(strlen($val) < 1 ) $val = "";
		 //   $r->bindValue($k,$val,PDO::PARAM_STR);
			$vals .= ",'".$val."'";
		}

		$flg = $r->execute();

		if($flg){
		    $this->lastid = $this->db->lastInsertId('id');
			return true;
		}else{
			return false;
		}
	}
	//-----------------------------------------------
	//参加者登録フォーム用select
	//-----------------------------------------------
	public function getSankaFormSelect($status = ""){
		$sql = "";
		$sql = "SELECT 
					*
				FROM
					sanka_form_select
		";
		if($status){
			$sql .= "WHERE status = 1 ";
		}
		$list = [];
		$r = $this->db->query($sql);
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
		}
		return $list;

	}
	public function getSyozokuSankaFormSelect($status = ""){
		$sql = "";
		$sql = "SELECT 
					*
				FROM
					sanka_syozoku_mst
		";
		if($status){
			$sql .= " WHERE status = 1 ";
		}
		$list = [];
		$r = $this->db->query($sql);
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
		}
		return $list;

	}

	//-----------------------------------------------
	//メール配信処理
	//-----------------------------------------------
	public function sendMailer($data,$bcc=""){
		$subject = $data[ 'subject'  ];
		$to      = $data[ 'to'       ];
		$body    = $data[ 'body'     ];
		$pwd     = $data[ 'login_pw' ];
		mb_language("uni");
		mb_internal_encoding("UTF-8");

		$from = D_FROM_MAIL;
		
		if($to){
			mb_send_mail($to,$subject,$body,"From:".$from);
		}
		if($bcc){
			$to      = $from;
			mb_send_mail($to,$subject,$body,"From:".$from);
		}
	}

	//-----------------------------------------------
	//メール配信処理　事務局にのみメールを配信
	//-----------------------------------------------
	public function sendMailerSecretariat($data){
		$from = D_FROM_MAIL;
		$subject = $data[ 'subject'  ];
		$to      = $from;
		$body    = $data[ 'body'     ];
		$pwd     = $data[ 'login_pw' ];
		mb_language("uni");
		mb_internal_encoding("UTF-8");
		mb_send_mail($to,$subject,$body,"From:".$from);
	}

	public function get_age($birth){
	  $ty = date("Y");
	  $tm = date("m");
	  $td = date("d");
	  list($by, $bm, $bd) = explode('/', $birth);
	  $age = $ty - $by;
	  if($tm * 100 + $td < $bm * 100 + $bd) $age--;
	  return $age;
	}


	public function imageResize($file,$path){
		$file_nm = $file['images']['name'];
		$tmp_ary = explode('.', $file_nm);
		$extension = $tmp_ary[count($tmp_ary)-1];
		$files = $path.".".$extension;
		$temp = $file[ 'images' ][ 'tmp_name' ];
		list($width, $height, $type, $attr) = getimagesize($temp);
		$size = $this->getFileSize($width,$height,$type,$attr);
		switch($extension){
			case "gif":
			case "GIF":
				$image_in = imagecreatefromgif($temp);
			break;
			case "png":
			case "PNG":
				$image_in = imagecreatefrompng($temp);
			break;
			case "jpg":
			case "jpeg":
			case "JPG":
			case "JPEG":
				$image_in = imagecreatefromjpeg($temp);
			break;
		}
		$image_out = imagecreate( $size[ 'width' ], $size[ 'height' ] );
		imagecopyresized( $image_out, $image_in, 0, 0, 0, 0, $size[ 'width' ], $size[ 'height' ], $width, $height );
		switch($extension){
			case "gif":
			case "GIF":
				imagegif( $image_out, $files );
			break;
			case "png":
			case "PNG":
				imagepng( $image_out, $files );
			break;
			case "jpg":
			case "jpeg":
			case "JPG":
			case "JPEG":
				imagejpeg( $image_out, $files );
			break;
		}

		// 画像をメモリ上から解放
		imagedestroy( $image_in );
		imagedestroy( $image_out );
		return $files;
	}

	public function getFileSize($width,$height,$type,$attr){
		$newwidth = 0; // 新しい横幅
		$newheight = 0; // 新しい縦幅
		$w = 150; // 最大横幅
		$h = 50; // 最大縦幅
		// 両方オーバーしていた場合
		if ($h < $height && $w < $width)  {
			if ($w < $h) {
				$newwidth = $w;
				$newheight = $height * ($w / $width);
			} else if ($h < $w) {
				$newwidth = $width * ($h / $height);
				$newheight = $h;
			} else {
				if ($width < $height) {
					$newwidth = $width * ($h / $height);
					$newheight = $h;
				} else if($height < $width) {
					$newwidth = $w;
					$newheight = $height * ($w / $width);
				}
			}
		} else if ($height < $h && $width < $w) { // 両方オーバーしていない場合
			$newwidth = $width;
			$newheight = $height;
		} else if ($h < $height && $width <= $w) {
			// 縦がオーバー、横は新しい横より短い場合
			// 縦がオーバー、横は同じ長さの場合
			$newwidth = $width * ($h / $height);
			$newheight = $h;
		} else if ($height <= $h && $w < $width) {
			// 縦が新しい縦より短く、横はオーバーしている場合
			// 縦は同じ長さ、横はオーバーしている場合
			$newwidth = $w;
			$newheight = $height * ($w / $width);
		} else if ($height == $h && $width < $w) {
			// 横が新しい横より短く、縦は同じ長さの場合
			$newwidth = $width * ($h / $height);
			$newheight = $h;
		} else if ($height < $h && $width == $w) {
			// 縦が新しい縦より短く、横は同じ長さの場合
			$newwidth = $w;
			$newheight = $height * ($w / $width);
		} else {
			// 縦も横も、新しい長さと同じ長さの場合
			// または、縦と横が同じ長さで、かつ最大サイズを超えない場合
			$newwidth = $width;
			$newheight = $height;
		}
		$size[ 'width'  ] = $newwidth;
		$size[ 'height' ] = $newheight;
		return $size;
	}
	//-----------------------------------
	//参加者用コード
	//----------------------------------
	public function getSankaCode(){
		$sql = "SELECT MAX(num) as code FROM kagaku_sanka ";

		$r = $this->db->query($sql);
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);
		$code[ 'code' ] = sprintf("R%04d%s",(int)$rlt['code']+1,D_SANKA_CODE);
		$code[ 'num'  ] = sprintf("%04d",(int)$rlt[ 'code' ]+1);
		return $code;
	}
	//-----------------------------------
	//演題コード
	//----------------------------------
	public function getEndaiCode(){
		$sql = "SELECT MAX(num) as code FROM kagaku_endai ";

		$r = $this->db->query($sql);
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);
		$code[ 'code' ] = sprintf("P%04d%s",$rlt['code']+1,D_SANKA_CODE);
		$code[ 'num'  ] = sprintf("%04d",$rlt[ 'code' ]+1);
		return $code;
	}
	public function getEndaiCodeWhere($eid){
		$sql = "SELECT num,code as code FROM kagaku_endai
				WHERE
				id = :id
		";


		$r = $this->db->prepare($sql);
		$r->bindValue(':id', $eid, PDO::PARAM_STR);
		$r->execute();
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);

		$code[ 'code' ] = $rlt[ 'code' ];
		$code[ 'num'  ] = $rlt[ 'num' ];
		return $code;
	}
	//-----------------------------------
	//登録済みファイルアップロード時間
	//----------------------------------
	public function getFileUpload($eid){
		$sql = "
				SELECT
					fileUpdate_ts
					,fileUpdate_ext
				FROM
					kagaku_endai
				WHERE
					id=:id
				";

		$r = $this->db->prepare($sql);
		$r->bindValue(':id', $eid, PDO::PARAM_INT);
		$r->execute();
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);

		return $rlt;
	}
	//-----------------------------------
	//参加登録用エラーチェック
	//----------------------------------
	public function sankaErrCheck($data,$sform){
		$err = array();
		if($sform[ 'sform' ][ 4 ][ 'indispensible' ] == 1){
			if(!$data[ 'name1' ] || !$data[ 'name2' ]){
				$i=0;
				$err[$i] = $sform[ 'sform' ][ 4 ][ 'errmsg' ];
			}
		}
		if($sform[ 'sform' ][ 5 ][ 'indispensible' ] == 1){
			if(!$data[ 'kana1' ] || !$data[ 'kana2' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 5 ][ 'errmsg' ];
			}
		}
		if($sform[ 'sform' ][ 6 ][ 'indispensible' ] == 1){
			if(!$data[ 'daigaku' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 6 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 7 ][ 'indispensible' ] == 1){
			if(!$data[ 'gakubu' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 7 ][ 'errmsg' ];
			}
		}
		if($sform[ 'sform' ][ 8 ][ 'indispensible' ] == 1){
			if(!$data[ 'kenkyu' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 8 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 9 ][ 'indispensible' ] == 1){
			if(!$data[ 'post' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 9 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 10 ][ 'indispensible' ] == 1){
			if(!$data[ 'address_type' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 10 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 11 ][ 'indispensible' ] == 1){
			if(!$data[ 'address' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 11 ][ 'errmsg' ];
			}
		}
		if($sform[ 'sform' ][ 12 ][ 'indispensible' ] == 1){
			if(!$data[ 'tel' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 12 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 13 ][ 'indispensible' ] == 1){
			if(!$data[ 'naisen' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 13 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 14 ][ 'indispensible' ] == 1){
			if(!$data[ 'fax' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 14 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 15 ][ 'indispensible' ] == 1){
			if(!$data[ 'mail' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 15 ][ 'errmsg' ];
			}else{
				if(!preg_match('/^[-+.\\w]+@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i',$data[ 'mail' ])){
					$i++;
					$err[$i] = $sform[ 'sform' ][ 15 ][ 'errmsg' ];
				}
			}
		}
		//メールアドレスのチェック
		if($sform[ 'sform' ][ 16 ][ 'indispensible' ] == 1){
			if($data[ 'mail' ] != $data[ 'mail2' ] || !$data[ 'mail2' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 16 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 17 ][ 'indispensible' ] == 1){
			if(!$data[ 'password' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 17 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 18 ][ 'indispensible' ] == 1){
			if(!$data[ 'join_type' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 18 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 20 ][ 'indispensible' ] == 1){
			if(!$data[ 'bikou' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 20 ][ 'errmsg' ];
			}
		}

		if($sform[ 'sform' ][ 27 ][ 'indispensible' ] == 1){

			if(!$data['sankaformselect']){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 27 ][ 'errmsg' ];
			}else
			if(!$data['sankaformselect'] && !$data[ 'bikou' ]){
				$i++;
				$err[$i] = $sform[ 'sform' ][ 27 ][ 'errmsg' ];
			}
		}

		return $err;
	}



	//-----------------------------------------------
	//演題登録
	//-----------------------------------------------
	public function setEndaiData($data,$eid = ""){
		//参加ナンバーの最大値
	    $this->db->beginTransaction();
	    try{
    		if($eid){
    			$num = $this->getEndaiCodeWhere($eid);
    		}else{
    			$num = $this->getEndaiCode();
    		}
    		$stu = 0;
    		if($data[ 'studentPoster'    ]) $stu = 1;

    		$sid    = (isset($data[ 'sid']))?$data[ 'sid']:"";
    		$nums   = (isset($num[ 'num' ]))?$num[ 'num']:"";
    		$code   = (isset($num[ 'code']))?$num[ 'code']:"";
    		$happyo = (isset($data[ 'happyo']) && $data[ 'happyo'] )?$data[ 'happyo']:0;
    		$syoutai = (isset($data[ 'syoutai']) && $data[ 'syoutai'] )?$data[ 'syoutai']:0;
    		$korokiumu = (isset($data[ 'korokiumu']))?$data[ 'korokiumu']:0;
    		$ippanKouenposter = (isset($data[ 'ippanKouenposter']))?$data[ 'ippanKouenposter']:0;
    		$ippanKouenkouto  = (isset($data[ 'ippanKouenkouto']))?$data[ 'ippanKouenkouto']:0;
    		$endainame = (isset($data[ 'endainame']))?$data[ 'endainame']:"";
    		$syozoku_count = (isset($data[ 'syozoku_count']))?$data[ 'syozoku_count']:"";
    		$tyosya_count = (isset($data[ 'tyosya_count']))?$data[ 'tyosya_count']:"";
    		$tyosya = (isset($data[ 'tyosya']))?$data[ 'tyosya']:"";
    		$pc = (isset($data[ 'pc']))?$data[ 'pc']:"";
    		$otheros = (isset($data[ 'otheros']))?$data[ 'otheros']:"";
    		$bikou = (isset($data[ 'bikou']))?$data[ 'bikou']:"";
    		$otheros = (isset($data[ 'otheros']))?$data[ 'otheros']:"";
    		$publication = (isset($data[ 'publication']))?$data[ 'publication']:"";
    		$vote = (isset($data[ 'vote']) && $data[ 'vote' ])?$data[ 'vote']:0;
    		$vote_text = (isset($data[ 'vote_text']))?$data[ 'vote_text']:"";
    		$fileUpdate_ts = (isset($data[ 'fileUpdate_ts']))?$data[ 'fileUpdate_ts']:"";
    		$fileUpdate_ext = (isset($data[ 'fileUpdate_ext']))?$data[ 'fileUpdate_ext']:"";
    		$fileUpdate_flash_ts = (isset($data[ 'fileUpdate_flash_ts']))?$data[ 'fileUpdate_flash_ts']:"";
    		$fileUpdate_flash_ext = (isset($data[ 'fileUpdate_flash_ext']))?$data[ 'fileUpdate_flash_ext']:"";
    		$fileUpdate_poster_ts = (isset($data[ 'fileUpdate_poster_ts']))?$data[ 'fileUpdate_poster_ts']:"";
    		$fileUpdate_poster_ext = (isset($data[ 'fileUpdate_poster_ext']))?$data[ 'fileUpdate_poster_ext']:"";
				$teacher = (isset($data[ 'teacher']))?$data[ 'teacher']:"";

    		$sql = "
    				INSERT INTO
    					kagaku_endai
    					(
    						snum
    						,num
    						,code
    						,happyo
    						,syoutai
    						,korokiumu
    						,ippanKouenposter
    						,ippanKouenkouto
    						,studentPoster
    						,endainame
    						,syozoku_count
    						,tyosya_count
    						,tyosya
    						,pc
    						,otheros
    						,bikou
    						,publication
    						,vote
    						,vote_text
    						,regist_ts
    						,fileUpdate_ts
    						,fileUpdate_ext
    						,fileUpdate_flash_ts
    						,fileUpdate_flash_ext
    						,fileUpdate_poster_ts
    						,fileUpdate_poster_ext
    						,teacher
    					)VALUES(
    						 :sid
    						,:num
    						,:code
    						,:happyo
    						,:syoutai
    						,:korokiumu
    						,:ippanKouenposter
    						,:ippanKouenkouto
    						,:stu
    						,:endainame
    						,:syozoku_count
    						,:tyosya_count
    						,:tyosya
    						,:pc
    						,:otheros
    						,:bikou
    						,:publication
    						,:vote
    						,:vote_text
    						,NOW()
    						,:fileUpdate_ts
								,:fileUpdate_ext
								,:fileUpdate_flash_ts
    						,:fileUpdate_flash_ext
    						,:fileUpdate_poster_ts
    						,:fileUpdate_poster_ext
    						,:teacher
    					)
    				";

    		$r = $this->db->prepare($sql);


    		$r->bindValue(":sid",$sid,PDO::PARAM_STR);
    		$r->bindValue(":num",$nums,PDO::PARAM_STR);
    		$r->bindValue(":code",$code,PDO::PARAM_STR);
    		$r->bindValue(":happyo",$happyo,PDO::PARAM_STR);
    		$r->bindValue(":syoutai",$syoutai,PDO::PARAM_STR);
    		$r->bindValue(":korokiumu",$korokiumu,PDO::PARAM_STR);
    		$r->bindValue(":ippanKouenposter",$ippanKouenposter,PDO::PARAM_STR);
    		$r->bindValue(":ippanKouenkouto",$ippanKouenkouto,PDO::PARAM_STR);
    		$r->bindValue(":stu",$stu,PDO::PARAM_STR);
    		$r->bindValue(":endainame",$endainame,PDO::PARAM_STR);
    		$r->bindValue(":syozoku_count",$syozoku_count,PDO::PARAM_STR);
    		$r->bindValue(":tyosya_count",$tyosya_count,PDO::PARAM_STR);
    		$r->bindValue(":tyosya",$tyosya,PDO::PARAM_STR);
    		$r->bindValue(":pc",$pc,PDO::PARAM_STR);
    		$r->bindValue(":otheros",$otheros,PDO::PARAM_STR);
    		$r->bindValue(":bikou",$bikou,PDO::PARAM_STR);
    		$r->bindValue(":publication",$publication,PDO::PARAM_STR);
    		$r->bindValue(":vote",$vote,PDO::PARAM_STR);
    		$r->bindValue(":vote_text",$vote_text,PDO::PARAM_STR);
    		$r->bindValue(":fileUpdate_ts",$fileUpdate_ts,PDO::PARAM_STR);
    		$r->bindValue(":fileUpdate_ext",$fileUpdate_ext,PDO::PARAM_STR);
    		$r->bindValue(":fileUpdate_flash_ts",$fileUpdate_flash_ts,PDO::PARAM_STR);
    		$r->bindValue(":fileUpdate_flash_ext",$fileUpdate_flash_ext,PDO::PARAM_STR);
    		$r->bindValue(":fileUpdate_poster_ts",$fileUpdate_poster_ts,PDO::PARAM_STR);
    		$r->bindValue(":fileUpdate_poster_ext",$fileUpdate_poster_ext,PDO::PARAM_STR);
    		$r->bindValue(":teacher",$teacher,PDO::PARAM_STR);

    		$flg = $r->execute();
    		$id = $this->db->lastInsertId('id');

    		//演題データのinsertid
    		//endailg.phpで利用
    		$this->eid = $id;

    		//講演者の所属協会
    		if(count($data[ 'syozoku' ])){
    			foreach($data[ 'syozoku' ] as $k=>$v){
    				$ary[$k] = $k;
    			}
    			$syozoku = implode(",",$ary);
    		}else{
    			$syozoku = "";
    		}
    		$sql = "
    				INSERT INTO
    					syozoku_kyokai
    					(
    						eid
    						,syozoku
    						,other
    						,nyukai
    					)VALUES(
    						:id
                            ,:syozoku
                            ,:text11
                            ,:text12
    					)
    				";

    		$r = $this->db->prepare($sql);
            $id = (isset($id))?$id:"";
    		$r->bindValue(":id",$id,PDO::PARAM_STR);
    		$syozoku = (isset($syozoku))?$syozoku:"";
    		$r->bindValue(":syozoku",$syozoku,PDO::PARAM_STR);
    		$text11 = (isset($data[ 'text' ][11]))?$data[ 'text' ][11]:"";
    		$r->bindValue(":text11",$text11,PDO::PARAM_STR);
    		$text12 = (isset($data[ 'text' ][12]))?$data[ 'text' ][12]:"";
    		$r->bindValue(":text12",$text12,PDO::PARAM_STR);

    		$flg = $r->execute();


    		for($i = 1; $i<=$data[ 'syozoku_count' ];$i++){
    			$sql = "
    					INSERT INTO
    						syozoku_tyosya
    						(
    							eid
    							,num
    							,syozokuKikanD
    							,syozokuKikanG
    							,syozokuKikanRyaku
    							,syozokuKikanDEng
    							,syozokuKikanGEng
    							,regist_ts

    						)VALUES(
    							 :id
    							,:i
    							,:syozokuKikanD
    							,:syozokuKikanG
    							,:syozokuKikanRyaku
    							,:syozokuKikanDEng
    							,:syozokuKikanGEng
    							,NOW()
    						)
    					";
    			$r = $this->db->prepare($sql);
    			$id = (isset($id))?$id:"";
    			$r->bindValue(":id",$id,PDO::PARAM_STR);
    			$no = (isset($i))?$i:"";
    			$r->bindValue(":i",$no,PDO::PARAM_STR);

    			$syozokuKikanD = (isset($data[ 'syozokuKikanD' ][$i]))?$data[ 'syozokuKikanD' ][$i]:"";
    			$r->bindValue(":syozokuKikanD",$syozokuKikanD,PDO::PARAM_STR);

    			$syozokuKikanG = (isset($data[ 'syozokuKikanG' ][$i]))?$data[ 'syozokuKikanG' ][$i]:"";
    			$r->bindValue(":syozokuKikanG",$syozokuKikanG,PDO::PARAM_STR);

    			$syozokuKikanRyaku = (isset($data[ 'syozokuKikanRyaku' ][$i]))?$data[ 'syozokuKikanRyaku' ][$i]:"";
    			$r->bindValue(":syozokuKikanRyaku",$syozokuKikanRyaku,PDO::PARAM_STR);

    			$syozokuKikanDEng = (isset($data[ 'syozokuKikanDEng' ][$i]))?$data[ 'syozokuKikanDEng' ][$i]:"";
    			$r->bindValue(":syozokuKikanDEng",$syozokuKikanDEng,PDO::PARAM_STR);

    			$syozokuKikanGEng = (isset($data[ 'syozokuKikanGEng' ][$i]))?$data[ 'syozokuKikanGEng' ][$i]:"";
    			$r->bindValue(":syozokuKikanGEng",$syozokuKikanGEng,PDO::PARAM_STR);

    			$flg = $r->execute();

    		}

    		for($i = 1; $i<=$data[ 'tyosya_count' ];$i++){
    			$sql = "
    					INSERT INTO
    						syozoku_tyosya_name
    						(
    							eid
    							,num
    							,tyosya_name1
    							,tyosya_name2
    							,tyosya_name1Eng
    							,tyosya_name2Eng
    							,tyosya_syozoku
    							,regist_ts

    						)VALUES(
    							 :id
    							,:i
    							,:tyosya_name1
    							,:tyosya_name2
    							,:tyosya_name1Eng
    							,:tyosya_name2Eng
    							,:tyosya_syozoku
    							,NOW()
    						)
    					";


    			$r = $this->db->prepare($sql);

    			$id = (isset($id))?$id:"";
    			$r->bindValue(":id",$id,PDO::PARAM_STR);

    			$no = (isset($i))?$i:"";
    			$r->bindValue(":i",$no,PDO::PARAM_STR);

    			$tyosya_name1 = (isset($data[ 'tyosya_name1' ][$i]))?$data[ 'tyosya_name1' ][$i]:"";
    			$r->bindValue(":tyosya_name1",$tyosya_name1,PDO::PARAM_STR);

    			$tyosya_name2 = (isset($data[ 'tyosya_name2' ][$i]))?$data[ 'tyosya_name2' ][$i]:"";
    			$r->bindValue(":tyosya_name2",$tyosya_name2,PDO::PARAM_STR);

    			$tyosya_name1Eng = (isset($data[ 'tyosya_name1Eng' ][$i]))?$data[ 'tyosya_name1Eng' ][$i]:"";
    			$r->bindValue(":tyosya_name1Eng",$tyosya_name1Eng,PDO::PARAM_STR);

    			$tyosya_name2Eng = (isset($data[ 'tyosya_name2Eng' ][$i]))?$data[ 'tyosya_name2Eng' ][$i]:"";
    			$r->bindValue(":tyosya_name2Eng",$tyosya_name2Eng,PDO::PARAM_STR);

    			$tyosya_syozoku = (isset($data[ 'tyosya_syozoku' ][$i]))?$data[ 'tyosya_syozoku' ][$i]:"";
    			$r->bindValue(":tyosya_syozoku",$tyosya_syozoku,PDO::PARAM_STR);

    			$flg = $r->execute();



    		}


    		$this->db->commit();
	    }catch(Exception $e){

	        $this->db->rollBack();
	    }

	}
	//-----------------------------------
	//参加登録用エラーチェック
	//----------------------------------
	public function endaiErr($data,$endai = ""){
		$err = array();
		$i=0;
		if($endai){
			
    		if($endai[ 'eform' ][ 6 ][ 'indispensible' ] == 1){
				
				if(isset($data['syozoku']) == false){



				}

    		    if( count($data[ 'syozoku' ]) == 0){
					$i++;
    				$err[$i] = $endai[ 'eform' ][ '6' ][ 'errmsg' ];
    			}
    		}
    		if($endai[ 'eform' ][ 7 ][ 'indispensible' ] == 1){
    			if(!$data[ 'happyo' ]){
    				$i++;
    				$err[$i] = $endai[ 'eform' ][ '7' ][ 'errmsg' ];
    			}
			}
			if($endai[ 'eform' ][ 36 ][ 'indispensible' ] == 1){
				if($data['ippanKouenkouto'] == 999){

					$i++;
					$err[$i] = $endai['eform']['36']['errmsg'];
				}
			}
			if($endai[ 'eform' ][ 37 ][ 'indispensible' ] == 1){
				if($data['syoutai'] == "-"){
					$i++;
					$err[$i] = $endai['eform']['37']['errmsg'];
				}
			}
			if($endai[ 'eform' ][ 38 ][ 'indispensible' ] == 1){
				if($data['korokiumu'] == "-"){
					$i++;
					$err[$i] = $endai['eform']['38']['errmsg'];
				}
			}
			if($endai[ 'eform' ][ 36 ][ 'indispensible' ] == 1){
				if($data['ippanKouenkouto'] == "-"){
					$i++;
					$err[$i] = $endai['eform']['36']['errmsg'];
				}
			}
			if($endai[ 'eform' ][ 8 ][ 'indispensible' ] == 1){
				if($data['ippanKouenposter'] == "-"){
					$i++;
					$err[$i] = $endai['eform']['8']['errmsg'];
				}
			}

    		if($endai[ 'eform' ][ 10 ][ 'indispensible' ] == 1){
    			$endainame = strip_tags($data[ 'endainame' ]);
    			if(strlen($endainame) < 1 ){
    				$i++;
    				$err[$i] = $endai[ 'eform' ][ '10' ][ 'errmsg' ];
    			}
    		}
    		if($endai[ 'eform' ][ 14 ][ 'indispensible' ] == 1){
    			if($data[ 'syozoku_count' ]){
    				for($j=1;$j<=$data[ 'syozoku_count' ];$j++){
    					if(strlen($data[ 'syozokuKikanD' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '23' ][ 'name_text1' ];
    					}
    					if(strlen($data[ 'syozokuKikanG' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '23' ][ 'name_text2' ];
    					}
    					if(strlen($data[ 'syozokuKikanRyaku' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '23' ][ 'name_text3' ];
    					}
    					if(strlen($data[ 'syozokuKikanDEng' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '23' ][ 'name_text4' ];
    					}
    					if(strlen($data[ 'syozokuKikanGEng' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '23' ][ 'name_text5' ];
    					}
    				}
    			}
    			if($data[ 'tyosya_count' ]){
    				for($j=1;$j<=$data[ 'tyosya_count' ];$j++){
    					if(strlen($data[ 'tyosya_name1' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '24' ][ 'name' ];
    					}
    					if(strlen($data[ 'tyosya_name2' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '24' ][ 'name_text1' ];
    					}
    					if(strlen($data[ 'tyosya_name1Eng' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '24' ][ 'name_text2' ];;
    					}
    					if(strlen($data[ 'tyosya_name2Eng' ][$j]) < 1 ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '24' ][ 'name_text3' ];
    					}
    					$ex = array();
    					$ex = explode(",",$data[ 'tyosya_syozoku' ][$j]);
    					$max = max($ex);
    					if($max > $data[ 'syozoku_count' ]){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '24' ][ 'name_text4' ];
    					}else
    					if(strlen($data[ 'tyosya_syozoku' ][$j]) < 1  ){
    						$i++;
    						$err[$i] = "[".$j."]".$endai[ 'eform' ][ '24' ][ 'name_text4' ];
    					}

    /*
    					elseif(!preg_match("/^[0-9,]+$/",$data[ 'tyosya_syozoku' ][$j])){
    						$i++;
    						$err[$i] = "[".$j."]所属番号は半角数字カンマ区切りで入力してください。";
    					}
    */
    				}
    			}
    		}

			if(isset($data['studentPoster' ]) && $data['studentPoster' ] == 'on' && empty($data['teacher'])){
				$i++;
    			$err[$i] = "受賞連絡先（指導教員）を選択してください。";

			}
		}
		return $err;
	}
	//-----------------------------------
	//メールデータ取得
	//----------------------------------
	public function getMailSendData($data,$sanka){
		$sql = "
				SELECT
					*
				FROM
					`kagaku_endai_mail`
				WHERE
                    mailtype = :mailtype
			";

		$r = $this->db->prepare($sql);
		$r->bindValue(':mailtype', $data[ 'mailtype' ], PDO::PARAM_STR);
		$r->execute();
		$mail = $r -> fetch(PDO::FETCH_ASSOC);

        $msg = array();
		//メールデータリプレイス
		$msg[ 'title' ] = $this->mailReplace($mail[ 'title' ],$sanka);
		$msg[ 'titleEdit' ] = $this->mailReplace($mail[ 'titleEdit' ],$sanka);
		$msg[ 'note'  ] = $this->mailReplace($mail[ 'note' ],$sanka);
		return $msg;
	}
	public function mailReplace($note,$rlt){
		global $array_mailEdit;
		global $array_mailEdit2;
		global $array_address;
		global $array_join_type;
		global $array_konshinkai_sts;
		global $array_syozoku;
		global $array_happyo;
		global $array_ippanKouenkouto;
		global $array_ippanKouenposter;
		global $array_studentPoster;
		global $array_pc;
		global $array_syotai;
		global $array_korokiumu;


		//所属学協会
		$ex = array();
		if($rlt[ 'syozoku' ]){
			$ex = explode(",",$rlt[ 'syozoku' ]);
			if(count($ex)){
				$syozoku = "";
				$i=0;
				foreach($ex as $key=>$val){
					$asyozoku[$i] = $array_syozoku[$val][ 'name' ];
					$i++;
				}
				$syozoku = implode(", ",$asyozoku);
			}
		}
		//発表形式
		$happyo = $array_happyo[ $rlt[ 'happyo' ] ][ 'name' ];
		//招待
		$syoutai = $array_syotai[$rlt['syoutai']]['name' ];
		//コロキウム
		$korokiumu = $array_korokiumu[$rlt['korokiumu']]['name' ];
		//一般公演口頭を選択したときの別回答選択
		if($rlt[ 'ippanKouenkouto' ]){
		    $happyo .= $array_ippanKouenkouto[ $rlt[ 'ippanKouenkouto' ]]['name'];
		}

		//一般講演口頭の分類
		$ippanKouenkouto = $array_ippanKouenkouto[ $rlt[ 'ippanKouenkouto' ]][ 'name' ];


		//一般講演ポスターの分類
		$ippanKouenposter = $array_ippanKouenposter[ $rlt[ 'ippanKouenposter' ] ][ 'name' ];

		//学生ポスター賞審査希望
		$studentPoster = $array_studentPoster[ $rlt[ 'studentPoster' ] ];

		$endai = $this->getEndaiForm(12);
		//著者の所属機関
		if($rlt[ 'syozoku_tyosya' ]){
			$syozoku_tyosya = "";
			$i=0;
			foreach($rlt[ 'syozoku_tyosya' ] as $key=>$val){
				$syozoku_tyosya .= $endai[ 'eform' ][12][ 'name' ].":".$val[ 'num' ]."\n".$endai[ 'eform' ][ 12 ][ 'name_text1' ].":".$val[ 'syozokuKikanD' ]." ".$val[ 'syozokuKikanG' ]."\n".$endai[ 'eform' ][ 12 ][ 'name_text2' ].":".$val[ 'syozokuKikanRyaku' ]."\n".$endai[ 'eform' ][ 12 ][ 'name_text3' ].":".$val[ 'syozokuKikanDEng' ]." ".$val[ 'syozokuKikanGEng' ]."\n\n";
				$i++;
			}
		}

		$tyosya = $this->getEndaiForm(15);
		//著者
		$teacher = "";
		if($rlt[ 'syozoku_tyosya_name' ]){
			$syozoku_tyosya_name = "";
			$i=0;
			foreach($rlt[ 'syozoku_tyosya_name' ] as $key=>$val){
				$syozoku_tyosya_name .= "No：".$val[ 'num' ]."\n".$tyosya[ 'eform' ][15][ 'name_text1' ].":".$val[ 'tyosya_name1' ]." ".$val[ 'tyosya_name2' ]."\n".$tyosya[ 'eform' ][15][ 'name_text2' ].":".$val[ 'tyosya_name1Eng' ]." ".$val[ 'tyosya_name2Eng' ]."\n".$tyosya[ 'eform' ][15][ 'name_text3' ].":".$val[ 'tyosya_syozoku' ]."\n\n";
				$i++;
				if($rlt['teacher'] == $val[ 'num' ]){
					$teacher = $val[ 'tyosya_name1' ]." ".$val[ 'tyosya_name2' ];
				}
			}
		}

		$msg = str_replace($array_mailEdit[0][0],$rlt[ 'scode'  ],$note);
		$msg = str_replace($array_mailEdit[1][0],$rlt[ 'daigaku' ],$msg);
		$msg = str_replace($array_mailEdit[2][0],$rlt[ 'gakubu' ],$msg);
		$msg = str_replace($array_mailEdit[3][0],$rlt[ 'kenkyu' ],$msg);
		$msg = str_replace($array_mailEdit[4][0],$array_address[$rlt[ 'address_type' ]],$msg);
		$msg = str_replace($array_mailEdit[5][0],$rlt[ 'address' ],$msg);
		$msg = str_replace($array_mailEdit[6][0],$rlt[ 'post'    ],$msg);
		$msg = str_replace($array_mailEdit[7][0],$rlt[ 'tel'     ],$msg);
		$msg = str_replace($array_mailEdit[8][0],$rlt[ 'naisen'  ],$msg);
		$msg = str_replace($array_mailEdit[9][0],$rlt[ 'fax'     ],$msg);
		$msg = str_replace($array_mailEdit[10][0],$rlt[ 'mail'     ],$msg);
		$msg = str_replace($array_mailEdit[11][0],$array_join_type[$rlt[ 'join_type'     ]],$msg);
		$msg = str_replace($array_mailEdit[12][0],$array_konshinkai_sts[$rlt[ 'koushinkai'    ]],$msg);

		$msg = str_replace($array_mailEdit[13][0],$rlt[ 'total'    ],$msg);
		$msg = str_replace($array_mailEdit[14][0],$rlt[ 'sanka_money'    ],$msg);
		$msg = str_replace($array_mailEdit[15][0],$rlt[ 'konshinkai_monay'    ],$msg);
		$msg = str_replace($array_mailEdit[16][0],$rlt[ 'sankaformselect'    ],$msg);
		$msg = str_replace($array_mailEdit[17][0],$rlt[ 'sankaformselectother'    ],$msg);
		$msg = str_replace($array_mailEdit[18][0],$rlt[ 'syozokuSankaformselect'    ],$msg);
		$msg = str_replace($array_mailEdit[19][0],$rlt[ 'syozokuSankaformselectOther'    ],$msg);

		$msg = str_replace($array_mailEdit2[0][0],$rlt[ 'password' ],$msg);
		$msg = str_replace($array_mailEdit2[1][0],$rlt[ 'ecode'    ],$msg);
		$msg = str_replace($array_mailEdit2[2][0],$rlt[ 'name1'    ].$rlt[ 'name2' ],$msg);
		$msg = str_replace($array_mailEdit2[3][0],$rlt[ 'kana1'    ].$rlt[ 'kana2' ],$msg);
		$msg = str_replace($array_mailEdit2[4][0],$syozoku,$msg);
		$msg = str_replace($array_mailEdit2[5][0],$rlt[ 'other'     ],$msg);
		$msg = str_replace($array_mailEdit2[6][0],$rlt[ 'nyukai'    ],$msg);
		$msg = str_replace($array_mailEdit2[7][0],$happyo,$msg);
		$msg = str_replace($array_mailEdit2[8][0],$ippanKouenposter,$msg);
		$msg = str_replace($array_mailEdit2[9][0],$studentPoster,$msg);
		$msg = str_replace($array_mailEdit2[10][0],strip_tags($rlt[ 'endainame'    ]),$msg);
		$msg = str_replace($array_mailEdit2[11][0],$rlt[ 'syozoku_count'    ],$msg);
		$msg = str_replace($array_mailEdit2[12][0],$syozoku_tyosya,$msg);
		$msg = str_replace($array_mailEdit2[18][0],$rlt['tyosya_count'],$msg);
		$msg = str_replace($array_mailEdit2[13][0],$syozoku_tyosya_name,$msg);
		$msg = str_replace($array_mailEdit2[14][0],$rlt['tyosya'],$msg);
		$msg = str_replace($array_mailEdit2[15][0],$array_pc[$rlt['pc']][ 'name' ],$msg);
		$msg = str_replace($array_mailEdit2[16][0],$rlt['otheros'],$msg);
		$msg = str_replace($array_mailEdit2[17][0],$rlt['ebikou'],$msg);
		$msg = str_replace($array_mailEdit2[19][0],$rlt['publication'],$msg);
		$msg = str_replace($array_mailEdit2[20][0],$ippanKouenkouto,$msg);
		$msg = str_replace($array_mailEdit2[21][0],$syoutai,$msg);
		$msg = str_replace($array_mailEdit2[22][0],$korokiumu,$msg);
		$msg = str_replace($array_mailEdit2[23][0],$teacher,$msg);

		return $msg;
	}
	public function getHppageEndai(){
		$sql = "
				SELECT
					note
				FROM
					hppageendai
				WHERE
					code = 'endai'
					AND areaname = 'endai1'
				";
		$r = $this->db->prepare($sql);
		$r->execute();
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);
		return $rlt;
	}

	public function gethappyoTitle(){
		$sql = "
				SELECT
					note as title1
				FROM
					hppageendai
				WHERE
					areaname = 'endai1';
			";


		$r = $this->db->prepare($sql);
		$r->execute();
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);

		return $rlt;
	}

	//参加情報フォーム取得
	public function getSankaForm(){
		$sql = "
				SELECT
					*
				FROM
					sanka_form_mst
				ORDER BY ordercode
				";
		$r = $this->db->query($sql);
		$list = array();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ 'sform' ][ $rlt[ 'ordercode' ] ] = $rlt;
		}

		$sql = "
				SELECT
					*
				FROM
					sanka_money_mst
				ORDER BY ordercode
				";
		$r = $this->db->query($sql);
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ 'sformmny' ][ $rlt[ 'ordercode' ] ] = $rlt;
		}
		return $list;
	}
	public function getEndaiForm($id=""){
		$sql = "
				SELECT
					*
				FROM
					endai_form_mst
				";
		if($id){
			$sql .= "
					WHERE
						id= :id
					";
		}
		$sql .= "
				ORDER BY ordercode
				";

		$r = $this->db->prepare($sql);
		$r->bindValue(':id', $id, PDO::PARAM_INT);
		$r->execute();
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ 'eform' ][ $rlt[ 'ordercode' ] ] = $rlt;
		}
		return $list;
	}

	public function getSyozokuMaster(){
		$sql = "
				SELECT
					*
				FROM
					syozoku_mst
				";
		$r = $this->db->query($sql);
		$list = array();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ $rlt[ 'code' ] ][ 'name'   ] = $rlt[ 'name' ];
			$list[ $rlt[ 'code' ] ][ 'status' ] = $rlt[ 'status' ];
		}

		return $list;
	}
	public function getHappyoMaster(){
		$sql = "
				SELECT
					*
				FROM
					happyo_mst
				";
		$r = $this->db->query($sql);
		$list = array();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ $rlt[ 'code' ] ][ 'name'   ] = $rlt[ 'name' ];
			$list[ $rlt[ 'code' ] ][ 'status' ] = $rlt[ 'status' ];
		}

		return $list;
	}

	public function getIppanKouenkoutoMaster(){
		$sql = "
				SELECT
					*
				FROM
					ippankouenkouto_mst
				";
		$r = $this->db->query($sql);
		$list = array();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ $rlt[ 'code' ] ][ 'name'   ] = $rlt[ 'name' ];
			$list[ $rlt[ 'code' ] ][ 'status' ] = $rlt[ 'status' ];
		}

		return $list;
	}

	public function getSyotaiMaster(){
		$sql = "
				SELECT
					*
				FROM
					syotai_mst

				";
		$r = $this->db->query($sql);
		$list = array();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ $rlt[ 'code' ] ][ 'name'   ] = $rlt[ 'name' ];
			$list[ $rlt[ 'code' ] ][ 'status' ] = $rlt[ 'status' ];
		}

		return $list;
	}
	public function getKorokiumuMaster(){
		$sql = "
				SELECT
					*
				FROM
					korokiumu_mst

				";
		$r = $this->db->query($sql);
		$list = array();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ $rlt[ 'code' ] ][ 'name'   ] = $rlt[ 'name' ];
			$list[ $rlt[ 'code' ] ][ 'status' ] = $rlt[ 'status' ];
		}

		return $list;
	}
	public function getIppanKouenposterMaster(){
		$sql = "
				SELECT
					*
				FROM
					ippankouenposter_mst

				";
		$r = $this->db->query($sql);
		$list = array();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ $rlt[ 'code' ] ][ 'name'   ] = $rlt[ 'name' ];
			$list[ $rlt[ 'code' ] ][ 'status' ] = $rlt[ 'status' ];
		}

		return $list;
	}
	public function getPCMaster(){
		$sql = "
				SELECT
					*
				FROM
					pc_mst
				";
		$r = $this->db->query($sql);
		$list = array();
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[ $rlt[ 'code' ] ][ 'name'   ] = $rlt[ 'name' ];
			$list[ $rlt[ 'code' ] ][ 'status' ] = $rlt[ 'status' ];
		}

		return $list;
	}

	public function getKagakuUser(){
		$sql = "
				SELECT
					*
				FROM
					kagaku_user
				";
		$r = $this->db->query($sql);
		$rlt = $r->fetch(PDO::FETCH_ASSOC);
		return $rlt;
	}
	public function loginCheck(){
	    if(!filter_input(INPUT_POST,"username")){
	        return false;
	    }
	    if(!filter_input(INPUT_POST,"password")){
	        return false;
	    }
	    $username = filter_input(INPUT_POST,"username");
	    $password = filter_input(INPUT_POST,"password");
	    $sql = "
				SELECT
					*
				FROM
					kagaku_user
                WHERE
                    username = :username AND
                    password = :password
				";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':username', $username, PDO::PARAM_STR);
	    $r->bindValue(':password', $password, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}
	public function getSankaCount(){
	    $sql = "SELECT id FROM kagaku_sanka
				WHERE
					status = 1
				GROUP BY num
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rst = $r->rowCount();
	    return $rst;
	}
	public function getEndaiCount(){
	    $sql = "SELECT
					COUNT(e.id) as cnt
				FROM
					kagaku_endai as e
					LEFT JOIN kagaku_sanka as s ON s.num = e.snum
				WHERE
					e.status = 1
					AND s.status = 1
				";
	    $r = $this->db->query($sql);
	    $rlt = $r->fetch(PDO::FETCH_ASSOC);
	    return $rlt;

	}
	public function getUserData($id){

	    $sql = "
				SELECT
					*
				FROM
					kagaku_user
				WHERE
					id=:id
				";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_INT);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}

	public function sankaGetList($max = "",$search = []){
        $this->search = $search[ 'search' ];
        $this->offset = $search[ 'offset' ];
        $this->limit  = $search[ 'limit' ];
	    if($max){
	        $sql = "
				SELECT
					count( s.id ) as cnt
				FROM
			";
	    }else{
	        $sql = "
				SELECT
					s.*
					,GROUP_CONCAT(e.code SEPARATOR '<br />') as ecode
				FROM
			";
	    }
	    $sql .= "kagaku_sanka as s";
	    $sql .= " LEFT JOIN kagaku_endai as e ON e.snum = s.num AND e.status = 1 ";
	    $sql .= " WHERE ";

	    if($this->search){
	        if($this->search[ 'code' ]){
	            $sql .= " s.code LIKE '%".$this->search[ 'code' ]."%' AND ";
	        }
	        if($this->search[ 'name' ]){
	            $sql .= "( s.name1 LIKE '%".$this->search[ 'name' ]."%' OR s.name2 LIKE '%".$this->search[ 'name' ]."%'
							) AND";
	        }
	        if($this->search[ 'kana' ]){
	            $sql .= "(  s.kana1 LIKE '%".$this->search[ 'kana' ]."%' OR s.kana2 LIKE '%".$this->search[ 'kana' ]."%'
							) AND";
	        }
	        if($this->search[ 'post' ]){
	            $sql .= "(  s.post LIKE '%".$this->search[ 'post' ]."%'
							) AND";
	        }
	        if($this->search[ 'address_type' ]){
	            $sql .= "(  s.address_type = '".$this->search[ 'address_type' ]."'
							) AND";
	        }
	        if($this->search[ 'address' ]){
	            $sql .= "(  s.address LIKE '%".$this->search[ 'address' ]."%'
							) AND";
	        }
	        if($this->search[ 'daigaku' ]){
	            $sql .= "( s.daigaku LIKE '%".$this->search[ 'daigaku' ]."%' OR s.gakubu LIKE '%".$this->search[ 'daigaku' ]."%'
						OR s.kenkyu LIKE '%".$this->search[ 'daigaku' ]."%'
							) AND";
	        }
	        if($this->search[ 'mail' ]){
	            $sql .= " s.mail LIKE '%".$this->search[ 'mail' ]."%' AND ";
	        }
	        if($this->search[ 'password' ]){
	            $sql .= " s.password LIKE '%".$this->search[ 'password' ]."%' AND ";
	        }
	        if($this->search[ 'tel' ]){
	            $sql .= " s.tel LIKE '%".$this->search[ 'tel' ]."%' AND ";
	        }
	        if($this->search[ 'naisen' ]){
	            $sql .= " s.naisen LIKE '%".$this->search[ 'naisen' ]."%' AND ";
	        }
	        if($this->search[ 'fax' ]){
	            $sql .= " s.fax LIKE '%".$this->search[ 'fax' ]."%' AND ";
	        }
	        if($this->search[ 'join_type' ]){
	            $sql .= " s.join_type = '".$this->search[ 'join_type' ]."' AND ";
	        }
	        if(strlen($this->search[ 'konshinkai' ]) > 0 ){
	            $sql .= " s.koushinkai = '".$this->search[ 'konshinkai' ]."' AND ";
	        }
	        if(strlen($this->search[ 'total' ]) > 0 ){
	            $sql .= " s.total LIKE '%".$this->search[ 'total' ]."%' AND ";
	        }
	        if(strlen($this->search[ 'sanka_pay_status' ]) > 0 ){
	            $sql .= " s.sanka_pay_status LIKE '%".$this->search[ 'sanka_pay_status' ]."%' AND ";
	        }
	        if(strlen($this->search[ 'bikou' ]) > 0 ){
	            $sql .= " s.bikou LIKE '%".$this->search[ 'bikou' ]."%' AND ";
	        }

	    }

	    $sql .= " s.status=1 ";
	    $sql .= "GROUP BY s.num ORDER BY s.num  ";

	    if($max == ""){
	        $sql .= " LIMIT ".$this->offset.",".$this->limit;
	    }
	    $r = $this->db->query($sql);
	    $list = [];
	    while($rlt = $r->fetch(PDO::FETCH_ASSOC)){
	        $list[] = $rlt;
	    }
	    if($max == ""){
	        return $list;
	    }else{
	       return count($list);
	    }


	}

	public function setGetPay($data){
	    $sql = "
				INSERT INTO kagaku_sanka
					(
						`num`, `password`, `code`, `name1`, `name2`, `kana1`, `kana2`, `daigaku`, `gakubu`, `kenkyu`, `address_type`, `address`, `post`, `tel`, `naisen`, `fax`, `mail`, `join_type`, `koushinkai`, `konshinkai_count`, `total`, `update_ts`, `regist_ts`, `sanka_pay_status`, `sanka_money`, `konshinkai_monay`, `bikou`, `status`,`sankaformselect`,`sankaformselectother`,`selecter`
					)
				SELECT
						`num`, `password`, `code`, `name1`, `name2`, `kana1`, `kana2`, `daigaku`, `gakubu`, `kenkyu`, `address_type`, `address`, `post`, `tel`, `naisen`, `fax`, `mail`, `join_type`, `koushinkai`, `konshinkai_count`, `total`, `update_ts`, `regist_ts`, `sanka_pay_status`, `sanka_money`, `konshinkai_monay`, `bikou`, `status`,`sankaformselect`,`sankaformselectother`,`selecter`

				 FROM kagaku_sanka
					WHERE id = :id
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $data[ 'sts' ][ 'id' ], PDO::PARAM_INT);
	    $r->execute();
	    $lastid = $this->db->lastInsertId('id');
	    return $lastid;

	}

	public function getSankaData($id){
	    $sql = "SELECT
					*
				FROM
					kagaku_sanka
				WHERE
					id=:id
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_INT);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}

	public function getSankaData2($id){
	    $sql = "SELECT
					*
					,s.code as scode
				FROM
					kagaku_sanka as s
				WHERE
					s.id=:id
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_INT);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}

	public function getMailData($data){
	    $sql = "
				SELECT
					*
				FROM
					kagaku_endai_mail
				WHERE
					mailtype = :mailtype
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':mailtype', $data[ 'mailtype' ], PDO::PARAM_INT);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}

	public function setMailData($data){
	    $sql = "
				SELECT
					id
				FROM
					kagaku_endai_mail
				WHERE
					mailtype = :mailtype
				";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':mailtype', $data[ 'mailtype' ], PDO::PARAM_INT);
	    $r->execute();
	    $rst = $r -> fetch(PDO::FETCH_ASSOC);
	    if(!$rst){

	        self::setUserData("kagaku_endai_mail", $data);
	    }else{

	        $edit = [];
	        $edit[ 'edit' ][ 'title' ] = $data[ 'title' ];
	        $edit[ 'edit' ][ 'titleEdit' ] = $data[ 'titleEdit' ];
	        $edit[ 'edit' ][ 'note' ] = $data[ 'note' ];
	        $edit[ 'where' ][ 'mailtype' ] = $data[ 'mailtype' ];
	        self::editUserData("kagaku_endai_mail",$edit);

	    }

	}

	public function getCsvData(){
	    $sql = "
				SELECT
					*
				FROM
					kagaku_sanka
				WHERE
					status = :status
                GROUP BY code
				ORDER BY code
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':status', 1, PDO::PARAM_INT);
	    $r->execute();
	    $list = [];
	    $i=0;
	    while($rlt =  $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[$i] = $rlt;
	        $i++;
	    }
	    return $list;
	}

	public function getHistData($where,$flg = ""){
	    $sql = "
				SELECT
					*
				FROM
					kagaku_sanka
				WHERE
					num LIKE '%".$where[ 'code' ]."%' AND
					1=1
				ORDER BY id DESC
				";

	    if($flg ){

	        $r = $this->db->prepare($sql);
	        $r->execute();
	        $list = [];
	        $i=0;
	        while($rlt =  $r -> fetch(PDO::FETCH_ASSOC)){
	            $list[$i] = $rlt;
	            $i++;
	        }
	        return count($list);

	    }
	    $sql .= " LIMIT ".$where[ 'offset' ].",".$where[ 'limit' ];


	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $list = [];
	    $i=0;
	    while($rlt =  $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[$i] = $rlt;
	        $i++;
	    }
	    return $list;
	}

	public function getSankaFormMst(){
	    $sql = "
				SELECT
					*
				FROM
					sanka_form_mst
				ORDER BY ordercode
				";

	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $list = [];
	    while($rlt =  $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[$rlt[ 'ordercode' ]] = $rlt;
	    }
	    return $list;


	}
	public function getSankaMoneyMst(){
	    $sql = "
				SELECT
					*
				FROM
					sanka_money_mst
				ORDER BY ordercode
				";

	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $list = [];
	    while($rlt =  $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[$rlt[ 'ordercode' ]] = $rlt;
	    }
	    return $list;

	}

	public function getCusList($max = "",$search=[]){
	    global $array_happyo;
	    $this->search = $search[ 'search' ];
	    $offset = $search[ 'offset' ];
	    $limit  = $search[ 'limit' ];
	    if($max){
	        $sql = "
				SELECT
					count( e.id ) as cnt
				FROM
			";
	    }else{
	        $sql = "
				SELECT
					e.*
					,s.id as sankaid
					,s.name1
					,s.name2
					,s.code as scode
				FROM
			";
	    }
	    $sql .= "kagaku_endai as e
				 INNER JOIN kagaku_sanka as s ON s.num = e.snum AND s.status=1
				";
	    $sql .= " WHERE ";

	    if($this->search){
	        if($this->search[ 'code' ]){
	            $sql .= " e.code LIKE '%".$this->search[ 'code' ]."%' AND ";
	        }
	        if($this->search[ 'name' ]){
	            $sql .= "( s.name1 LIKE '%".$this->search[ 'name' ]."%' OR s.name2 LIKE '%".$this->search[ 'name' ]."%'
						OR s.kana1 LIKE '%".$this->search[ 'name' ]."%' OR s.kana2 LIKE '%".$this->search[ 'name' ]."%'
							) AND";
	        }
	        if($this->search[ 'happyo' ]){
	            $sql .= " e.happyo = '".$this->search[ 'happyo' ]."' AND ";
	        }
	        if($this->search[ 'endainame' ]){
	            $sql .= " e.endainame LIKE '%".$this->search[ 'endainame' ]."%' AND ";
	        }
	        if($this->search[ 'publication' ]){
	            $sql .= " e.publication LIKE '%".$this->search[ 'publication' ]."%' AND ";
	        }
	        if($this->search[ 'fileupdate' ]){
	            $sql .= " e.fileUpdate_ts LIKE '%".$this->search[ 'fileupdate' ]."%' AND ";
	        }
	        if($this->search[ 'scode' ]){
	            $sql .= " s.code LIKE '%".$this->search[ 'scode' ]."%' AND ";
	        }
	    }

	    $sql .= " e.status=1 ";
	    $sql .= " AND s.status=1 ";


	    if($max == ""){
	        $sql .= " GROUP BY e.num";
	        $sql .= " ORDER BY e.num ASC";
	        $sql .= " LIMIT ".$offset.",".$limit;
	    }else{
	        $sql .= " GROUP BY e.num";
	    }

	    $r = $this->db->query($sql);

	    if($max){
	        $rlt =  $r -> fetchAll(PDO::FETCH_ASSOC);
	        return count($rlt);
	    }


	    $rlt = [];
	    $i = 0;
	    while($rst =  $r -> fetch(PDO::FETCH_ASSOC)){

	        $rlt[$i] = $rst;
	        $rlt[$i][ 'happyo'] = $array_happyo[ $rst['happyo'] ];
	        $rlt[$i][ 'endainame'] = strip_tags($rst['endainame'],"<em><br /><sup><sub><strong><b><u><i>");
	        $i++;
	    }

	    return $rlt;


	}

	public function getEndaiData($where){
	    $sql = "
				SELECT
					*
					,e.id as endaiid
				FROM
					kagaku_endai as e
					LEFT JOIN syozoku_kyokai as s ON s.eid = e.id AND s.status = 1
				WHERE
					e.id = :id
					AND e.status = 1
			";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $where[ 'id' ], PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    //著者の所属期間の総数
	    $sql = "
				SELECT
					*
				FROM
					syozoku_tyosya
				WHERE
					eid = :endaiid
				ORDER BY num
				";



	    $r = $this->db->prepare($sql);
	    $r->bindValue(':endaiid', $rlt[ 'endaiid' ], PDO::PARAM_STR);
	    $r->execute();
	    $i=0;
	    while($rst = $r -> fetch(PDO::FETCH_ASSOC) ){
	        $rlt[ 'tyosyadata' ][$rst[ 'num' ]] = $rst;
	        $i++;
	    }


	    //著者の所属期間の総数
	    $sql = "
				SELECT
					*
				FROM
					syozoku_tyosya_name
				WHERE
					eid = :endaiid
				ORDER BY num
				";



	    $r = $this->db->prepare($sql);
	    $r->bindValue(':endaiid', $rlt[ 'endaiid' ], PDO::PARAM_STR);
	    $r->execute();
	    $i=0;
	    while($rst = $r -> fetch(PDO::FETCH_ASSOC) ){
	        $rlt[ 'tyosyadataName' ][$rst[ 'num' ]] = $rst;
	        $i++;
	    }

	    return $rlt;
	}


	public function getEndaiSankaData($id){
	    $sql = "SELECT
					*
				FROM
					kagaku_sanka
				WHERE
					num=:id AND
					status = 1
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}

	public function getEndaiData2($id){
	    $sql = "SELECT
					*
					,e.code as ecode
					,s.code as scode
					,e.bikou as ebikou
					,s.bikou as sbikou

				FROM
					kagaku_endai as e
					LEFT JOIN kagaku_sanka as s ON s.num = e.snum
					LEFT JOIN syozoku_kyokai as sk ON sk.eid = e.id AND sk.status = 1
				WHERE
					e.id=:id
					AND s.status = 1
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    //所属機関
	    $sql = "SELECT
					*
				FROM
					syozoku_tyosya
				WHERE
					eid = :id
				ORDER BY num
			";


	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $i=0;
	    while($rlt2 = $r -> fetch(PDO::FETCH_ASSOC) ){
	        $rlt['syozoku_tyosya'][$i] = $rlt2;
	        $i++;
	    }


	    //著者
	    $sql = "SELECT
					*
				FROM
					syozoku_tyosya_name
				WHERE
					eid = :id
					AND status = 1
				ORDER BY num
			";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $i=0;
	    while($rlt3 = $r -> fetch(PDO::FETCH_ASSOC) ){
	        $rlt['syozoku_tyosya_name'][$rlt3[ 'num' ]] = $rlt3;
	        $i++;
	    }

	    return $rlt;
	}


	public function getCSVDataList(){
	    $sql = "
				SELECT
					eid
					,GROUP_CONCAT(tyosya_name1 SEPARATOR '||') as tyosya_name1
					,GROUP_CONCAT(tyosya_name2 SEPARATOR '||') as tyosya_name2
					,GROUP_CONCAT(tyosya_name1Eng SEPARATOR '||') as tyosya_name1Eng
					,GROUP_CONCAT(tyosya_name2Eng SEPARATOR '||') as tyosya_name2Eng
					,GROUP_CONCAT(tyosya_syozoku SEPARATOR '||') as tyosya_syozoku

				FROM
					syozoku_tyosya_name
				WHERE
					status = 1 AND
                    eid > 0
				GROUP BY eid
				";

	    $r = $this->db->prepare($sql);
	    $r->execute();//SQL文を実行
	    $tyo = [];
	    while($ty = $r -> fetch(PDO::FETCH_ASSOC)){
	        $tyo[$ty[ 'eid' ]] = $ty;
	    }


	    $sql = "
				SELECT
					ke.*
					,ks.name1
					,ks.name2
					,ks.kana1
					,ks.kana2
					,ks.code as scode
                    ,ks.mail as emailaddress
					,sk.syozoku as syozokus
					,sk.other
					,sk.nyukai
					,GROUP_CONCAT(st.syozokuKikanD SEPARATOR '||') as syozokuKikanD
					,GROUP_CONCAT(st.syozokuKikanG SEPARATOR '||') as syozokuKikanG
					,GROUP_CONCAT(st.syozokuKikanRyaku  SEPARATOR '||') as syozokuKikanRyaku
					,GROUP_CONCAT(st.syozokuKikanDEng  SEPARATOR '||') as syozokuKikanDEng
					,GROUP_CONCAT(st.syozokuKikanGEng  SEPARATOR '||') as syozokuKikanGEng
					,(SELECT CONCAT(tyosya_name1,tyosya_name2 ) FROM syozoku_tyosya_name WHERE num =ke.tyosya AND eid = ke.id AND status = 1 ) as tyosyaname
				FROM
					kagaku_endai as ke
					LEFT JOIN kagaku_sanka as ks ON ks.num = ke.snum AND ks.status = 1
					LEFT JOIN syozoku_kyokai as sk ON sk.eid = ke.id AND sk.status = 1
					LEFT JOIN syozoku_tyosya as st ON st.eid = ke.id AND st.status = 1
				WHERE
					ke.status = 1 AND
                    ks.status = 1
				GROUP BY ke.code
				ORDER BY ke.code
				";

	    $r = $this->db->prepare($sql);
	    $r->execute();

	    $i=0;
	    $list = [];

	    while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[$i] = $rlt;

	        //所属協会の日本語
	        $list[$i][ 'syozoku' ] = $this->changeSyozoku($rlt[ 'syozokus' ]);
	        $ex = array();
	        $ex = explode("||",$rlt[ 'syozokuKikanD' ]);
	        $ex2 = array();
	        $ex2 = explode("||",$rlt[ 'syozokuKikanG' ]);
	        $ex3 = array();
	        $ex3 = explode("||",$rlt[ 'syozokuKikanRyaku' ]);
	        $ex4 = array();
	        $ex4 = explode("||",$rlt[ 'syozokuKikanDEng' ]);
	        $ex5 = array();
	        $ex5 = explode("||",$rlt[ 'syozokuKikanGEng' ]);
	        $k = mb_convert_encoding("，","UTF-8","SJIS");



	        for($j=0;$j<15;$j++){
	            $list[$i][ 'syozokuKikanD_txt' ][$j] = str_replace(",",$k,$ex[$j]);
	            $list[$i][ 'syozokuKikanG_txt' ][$j] = str_replace(",",$k,$ex2[$j]);
	            $list[$i][ 'syozokuKikanRyaku_txt' ][$j] = str_replace(",",$k,$ex3[$j]);
	            $list[$i][ 'syozokuKikanDEng_txt'  ][$j] = str_replace(",",$k,$ex4[$j]);
	            $list[$i][ 'syozokuKikanGEng_txt'  ][$j] = str_replace(",",$k,$ex5[$j]);
	        }

	        $ex11 = array();
	        $ex11 = explode("||",$tyo[$rlt[ 'id' ]][ 'tyosya_name1' ]);
	        $ex12 = array();
	        $ex12 = explode("||",$tyo[$rlt[ 'id' ]][ 'tyosya_name2' ]);
	        $ex13 = array();
	        $ex13 = explode("||",$tyo[$rlt[ 'id' ]][ 'tyosya_name1Eng' ]);
	        $ex14 = array();
	        $ex14 = explode("||",$tyo[$rlt[ 'id' ]][ 'tyosya_name2Eng' ]);
	        $ex15 = array();
	        $ex15 = explode("||",$tyo[$rlt[ 'id' ]][ 'tyosya_syozoku' ]);
	        for($j=0;$j<15;$j++){
	            $list[$i][ 'tyosya_name1_txt'      ][$j] = $ex11[$j];
	            $list[$i][ 'tyosya_name2_txt'      ][$j] = $ex12[$j];
	            $list[$i][ 'tyosya_name1Eng_txt'  ][$j] = $ex13[$j];
	            $list[$i][ 'tyosya_name2Eng_txt'  ][$j] = $ex14[$j];
	            $list[$i][ 'tyosya_syozoku_txt'   ][$j] = $ex15[$j];
	        }

	        $i++;
	    }
	    return $list;
	}

	function commaEscape4csv($str)
	{

	    if(!(strstr($str, ',') === False)){
	        $str = preg_replace('/"/', '""',$str);
	        $str = '"' . $str . '"';
	    }
	    return $str;
	}
	function changeSyozoku($syozoku){
	    global $array_syozoku;
	    $ex = explode(",",$syozoku);
	    $i = 0;
	    $ary = array();
	    foreach($ex as $key=>$val){
	        $ary[$i] = mb_convert_encoding($array_syozoku[$val][ 'name' ],'SJIS-WIN','UTF-8');
	        $i++;
	    }
	    $imp = implode(",",$ary);
	    return $imp;
	}


	public function getImagePoster(){
	    $sql = "
				SELECT
					fileUpdate_poster_ext
				FROM
					kagaku_endai
				WHERE
					status = 1
				GROUP BY num
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();

	    $i = 0;
	    $list = [];
	    while($rst = $r -> fetch(PDO::FETCH_ASSOC) ){
	        $list[$i]= $rst;
	        $i++;
	    }
	    return $list;
	}
	public function getImageFlash(){
	    $sql = "
				SELECT
					fileUpdate_flash_ext
				FROM
					kagaku_endai
				WHERE
					status = 1
				GROUP BY num
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();

	    $i = 0;
	    $list = [];
	    while($rst = $r -> fetch(PDO::FETCH_ASSOC) ){
	        $list[$i]= $rst;
	        $i++;
	    }
	    return $list;
	}
	public function getImage(){
	    $sql = "
				SELECT
					fileUpdate_ext
				FROM
					kagaku_endai
				WHERE
					status = 1
				GROUP BY num
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();

	    $i = 0;
	    $list = [];
	    while($rst = $r -> fetch(PDO::FETCH_ASSOC) ){
	        $list[$i]= $rst;
	        $i++;
	    }
	    return $list;
	}

	public function getUpData(){
	    $sql = "
				SELECT
					ke.code
				FROM
					kagaku_endai as ke
					INNER JOIN kagaku_sanka as ks ON ks.num = ke.snum AND ks.status = 1
				WHERE
					ke.status = 1
				ORDER BY ke.num
				";

	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $i=0;
	    $list = [];
	    while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[$i] = $rlt;
	        $i++;
	    }
	    return $list;
	}


	public function getHistryData($where,$flg=""){
	    global $array_syozoku;
	    global $array_pc;
	    global $array_happyo;
	    global $array_ippanKouenkouto;
	    global $array_ippanKouenposter;


	    $this->array_syozoku = $array_syozoku;
	    $this->array_pc = $array_pc;
	    $this->array_happyo = $array_happyo;
	    $this->array_ippanKouenkouto = $array_ippanKouenkouto;
	    $this->array_ippanKouenposter = $array_ippanKouenposter;



	    $sql = "
				SELECT
					k.*
					,sk.*
					,k.id as endaiid
					,k.regist_ts as endairegist_ts
				FROM
					kagaku_endai as k
					LEFT JOIN syozoku_kyokai as sk ON k.id = sk.eid
				WHERE
					k.num LIKE '%".$where[ 'code' ]."%'
				GROUP BY k.id
				ORDER BY k.id DESC
				";
	    if($flg ){

	        $r = $this->db->query($sql);

	        $r->execute();
	        $row=$r->rowCount();
	        return $row;
	    }
	    $sql .= " LIMIT ".$where[ 'offset' ].",".$where[ 'limit' ];

	    $r = $this->db->prepare($sql);
	    $r->execute();

	    $i = 0;
	    while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[ $i ] = $rlt;
	        //講演者の所属学協会
	        $ex = explode(",",$rlt[ 'syozoku' ]);
	        $j=0;
	        $syozoku = array();
	        foreach($ex as $key=>$val){
	            $syozoku[$j] = $this->array_syozoku[$val][ 'name' ];
	            $j++;
	        }
	        $list[$i][ 'syozoku_txt' ] = implode("<br />",$syozoku);
	        $list[$i][ 'happyo_txt'  ] = $this->array_happyo[ $rlt[ 'happyo' ] ][ 'name' ];
	        $list[$i][ 'ippanKouenkouto_txt'  ] = $this->array_ippanKouenkouto[ $rlt[ 'ippanKouenkouto' ][ 'name' ] ];
	        $list[$i][ 'ippanKouenposter_txt'  ] = $this->array_ippanKouenposter[ $rlt[ 'ippanKouenposter' ] ][ 'name' ];
	        $list[$i][ 'pc'  ] = $this->array_pc[ $rlt[ 'pc' ] ][ 'name' ];

	        //著者の所属機関
	        $sql = "";
	        $sql = "SELECT
						GROUP_CONCAT( syozokuKikanD SEPARATOR '<br />') as syozokuKikanD
						,GROUP_CONCAT( syozokuKikanG SEPARATOR '<br />') as syozokuKikanG
						,GROUP_CONCAT( syozokuKikanRyaku SEPARATOR '<br />') as syozokuKikanRyaku
						,GROUP_CONCAT( syozokuKikanDEng SEPARATOR '<br />') as syozokuKikanDEng
						,GROUP_CONCAT( syozokuKikanGEng SEPARATOR '<br />') as syozokuKikanGEng
					FROM
						syozoku_tyosya
					WHERE
						eid = ".$rlt[ 'endaiid' ]."
						";

	        $r2 = $this->db->prepare($sql);
	        $r2->execute();
	        $rlt2 = $r2 -> fetch(PDO::FETCH_ASSOC);
	        $list[ $i ][ 'tyosyadata' ] = $rlt2;


	        //著者の所属機関
	        $sql = "";
	        $sql = "SELECT
						GROUP_CONCAT( tyosya_name1  SEPARATOR ',') as tyosya_name1
						,GROUP_CONCAT( tyosya_name2 SEPARATOR ',') as tyosya_name2
						,GROUP_CONCAT( tyosya_name1Eng SEPARATOR ',') as tyosya_name1Eng
						,GROUP_CONCAT( tyosya_name2Eng SEPARATOR ',') as tyosya_name2Eng
						,GROUP_CONCAT( tyosya_syozoku SEPARATOR '<br />') as tyosya_syozoku
					FROM
						syozoku_tyosya_name
					WHERE
						eid = ".$rlt[ 'endaiid' ]."
						";
	        $r3 = $this->db->prepare($sql);
	        $r3->execute();
	        $rlt3 = $r3 -> fetch(PDO::FETCH_ASSOC);

	        $list[ $i ][ 'tyosyadataName' ][ 'tyosya_syozoku' ] = $rlt3[ 'tyosya_syozoku' ];
	        $ex  = explode(",",$rlt3[ 'tyosya_name1'    ]);
	        $ex2 = explode(",",$rlt3[ 'tyosya_name2'    ]);
	        $ex3 = explode(",",$rlt3[ 'tyosya_name1Eng' ]);
	        $ex4 = explode(",",$rlt3[ 'tyosya_name2Eng' ]);
	        $j = 0;
	        $no = 1;
	        foreach($ex as $key=>$val){
	            $list[$i][ 'tyosyadataName' ]['typsya_name'   ] .= $no.".".$ex[$j].$ex2[$j]."<br />";
	            $list[$i][ 'tyosyadataName' ]['tyosya_nameEng'] .= $no.".".$ex3[$j].$ex4[$j]."<br />";
	            $j++;
	            $no++;
	        }
	        $i++;
	    }
	    //var_dump($list);
	    return $list;
	}

	public function getEndaiEndaiForm(){
	    $sql = "
				SELECT
					*
				FROM
					endai_form_mst
				ORDER BY ordercode
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[ $rlt[ 'ordercode' ] ] = $rlt;
	    }
	    return $list;
	}

	public function getSankaPage($areaname){
	    $sql = "
				SELECT
					*
				FROM
					hppagesanka
				WHERE
					areaname = '".$areaname."'
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;
	}
	public function getSankaPagedata(){
	    $sql = "
				SELECT
					code,areaname,note
				FROM
					hppagesanka
				WHERE
					code = 'sanka'
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $i=0;
	    while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[$rlt[ 'areaname' ]] = $rlt;
	        $i++;
	    }
	    return $list;
	}


	public function getUserEndai(){
	    $sql = "
				SELECT
					*
				FROM
					kagaku_user
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;
	}
	public function getEndaiEndai($areaname){
	    $sql = "
				SELECT
					*
				FROM
					hppageendai
				WHERE
					areaname = '".$areaname."'
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;
	}
	public function getdataEndai(){
	    $sql = "
				SELECT
					code,areaname,note
				FROM
					hppageendai
				WHERE
					code = 'endai'
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $i=0;
	    while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
	        $list[$rlt[ 'areaname' ]] = $rlt;
	        $i++;
	    }
	    return $list;
	}


	public function getIndivi($code,$yoko = ""){




	    $sql = "
				SELECT a.*
				,GROUP_CONCAT(stn.tyosya_name1 SEPARATOR ',') as tyosyaname1
				,GROUP_CONCAT(stn.tyosya_name2 SEPARATOR ',') as tyosyaname2
				 FROM (
				SELECT
					ke.code
					,ke.id as id
					,ke.num as num
					,ke.endainame
					,ke.studentPoster
					,ke.tyosya
					,ke.ippanKouenkouto
					,ke.ippanKouenposter
					,ke.publication
					,GROUP_CONCAT(st.syozokuKikanRyaku SEPARATOR ',') as ryaku
				FROM
					kagaku_endai as ke
					INNER JOIN kagaku_sanka as ks ON ke.snum = ks.num
					LEFT JOIN syozoku_tyosya as st ON st.eid = ke.id AND st.status = 1

				WHERE
					ke.happyo = ".$code."
					AND ke.status = 1
					AND ks.status = 1
				";
	    if($yoko){
	        $sql .= " AND ke.publication != '' ";
	        if($_REQUEST[ 'flg' ] == "jp"){
	            $sql .= "AND ke.englishflg = 0 ";
	        }
	        if($_REQUEST[ 'flg' ] == "en"){
	            $sql .= "AND ke.englishflg = 1 ";
	        }

	    }

		if($code == 4){
				$sql .= "
				GROUP BY ke.num
				ORDER BY ke.ippanKouenkouto , ke.num
				) as a
				LEFT JOIN syozoku_tyosya_name as stn ON stn.eid = a.id AND stn.status = 1
				GROUP BY a.ippanKouenkouto,a.num
				ORDER BY a.ippanKouenkouto ,a.publication, a.num
				";
		}else{

				$sql .= "
				GROUP BY ke.num
				ORDER BY ke.ippanKouenposter , ke.num
				) as a
				LEFT JOIN syozoku_tyosya_name as stn ON stn.eid = a.id AND stn.status = 1
				GROUP BY a.ippanKouenposter,a.num
				ORDER BY a.ippanKouenposter ,a.publication, a.num
				";
		}
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $i = 0;

	    while($rst = $r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt[$i] = $rst;
	        $ex1 = array();
	        $ex2 = array();
	        $ex1 = explode(",",$rst[ 'tyosyaname1' ]);
	        $ex2 = explode(",",$rst[ 'tyosyaname2' ]);
	        $no=1;
	        $txt = array();
	        foreach($ex1 as $key=>$val){
	            if($no == $rst[ 'tyosya' ]){
	                $txt[$no] = "○".$ex1[$key].$ex2[$key];
	            }else{
	                $txt[$no] = $ex1[$key].$ex2[$key];
	            }
	            $no++;
	        }
	        $rlt[ $i ][ 'tyosyaname' ] = implode(",",$txt);


	        $i++;
	    }
	    return $rlt;

	}


	public function regCheck($data){
	    $sql = "
				SELECT
					COUNT(id) as cnt
					,DATE_FORMAT(update_ts,'%Y年%m月%d日') as time1
				FROM
					kagaku_sanka
				WHERE
					name1 = '".$data[ 'name1' ]."'
					AND name2 = '".$data[ 'name2' ]."'
					AND kana1 = '".$data[ 'kana1' ]."'
					AND kana2 = '".$data[ 'kana2' ]."'
					AND mail = '".$data[ 'mail' ]."'
					AND status = 1
			";

	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    if($rlt[ 'cnt' ]){
	        return $rlt[ 'time1' ];
	    }else{
	        return 1;
	    }
	}
	public function getSankaDataReg($id){
	    $sql = "SELECT
					*
					,s.code as scode
				FROM
					kagaku_sanka as s
				WHERE
					s.id=:id
				";


	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;
	}
	public function getTitle(){
	    $sql = "
				SELECT
					note
				FROM
				hppagesanka
				WHERE
					code='sanka'
					AND areaname='sanka1'
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;

	}

	public function getKagakuUserSfin(){
	    $sql = "
				SELECT
					*
				FROM
					kagaku_user
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;

	}
	public function getSankaCodeSfin($third){
	    $sql = "
				SELECT
					code
				FROM
					kagaku_sanka
				WHERE
					id=:id
				";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $third, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;
	}
	public function getTitleSfin(){
	    $sql = "
				SELECT
					note
				FROM
					hppagesanka
				WHERE
					code='sanka'
					AND areaname='sanka1'
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;

	}

	public function loginCheckLog($data){
	    $sql = "
				SELECT
					id
				FROM
					kagaku_sanka
				WHERE
					num = '".$data[ 'num' ]."'
					AND password = '".$data[ 'password' ]."'
					AND status = 1
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $third, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;

	}
	public function getSankaCodeLog($third){
	    $sql = "
				SELECT
					code
				FROM
					kagaku_sanka
				WHERE
					id=:id
				";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $third, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;
	}
	public function getTitleLog(){
	    $sql = "
				SELECT
					note
				FROM
					hppagesanka
				WHERE
					code='sanka'
					AND areaname='sanka1'
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;

	}




	public function getEndaiDataEndailg($id){
	    $sql = "SELECT
					*
					,e.code as ecode
					,s.code as scode
				FROM
					kagaku_endai as e
					LEFT JOIN kagaku_sanka as s ON s.num = e.snum
					LEFT JOIN syozoku_kyokai as sk ON sk.eid = e.id AND sk.status = 1
				WHERE
					e.id=:id
					AND s.status = 1
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    //所属機関
	    $sql = "SELECT
					*
				FROM
					syozoku_tyosya
				WHERE
					eid = :eid
				ORDER BY num
			";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':eid', $id, PDO::PARAM_STR);
	    $r->execute();

	    $i=0;
	    while($rlt2 = $r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt['syozoku_tyosya'][$i] = $rlt2;
	        $i++;
	    }
	    //著者
	    $sql = "SELECT
					*
				FROM
					syozoku_tyosya_name
				WHERE
					eid = :eid
					AND status = 1
				ORDER BY num
			";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':eid', $id, PDO::PARAM_STR);
	    $r->execute();
	    $i=0;
	    while($rlt3 = $r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt['syozoku_tyosya_name'][$rlt3[ 'num' ]] = $rlt3;
	        $i++;
	    }


	    return $rlt;
	}
	public function checkLoginEndailg($data){
	    $sql = "
				SELECT
					*
				FROM
					kagaku_sanka
				WHERE
					num = '".$data[ 'num' ]."'
					AND password = '".$data[ 'password' ]."'
					AND status = 1
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}
	public function getSankaDataEndailg($id){
	    $sql = "SELECT
					*
				FROM
					kagaku_sanka
				WHERE
					num=:id AND
					status = 1
				";


	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}


	public function getKagakuEndai($third){
	    $sql = "
				SELECT
					code
				FROM
					kagaku_endai
				WHERE
					snum=:snum
				ORDER BY id DESC
				";


	    $r = $this->db->prepare($sql);
	    $r->bindValue(':snum', $third, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}


	public function getFileUpEditlg($id){
	    $sql = "
				SELECT
					publication
					,vote
					,vote_text
					,fileUpdate_ts
					,fileUpdate_ext
				FROM
					kagaku_endai
				WHERE
					id=:id
					AND status = 1
				";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);


	    return $rlt;
	}
	public function getEndaiDataEditlg($id){
	    $sql = "SELECT
					*
					,e.code as ecode
					,s.code as scode
					,e.bikou as ebikou
					,s.bikou as sbikou
				FROM
					kagaku_endai as e
					LEFT JOIN kagaku_sanka as s ON s.num = e.snum
					LEFT JOIN syozoku_kyokai as sk ON sk.eid = e.id AND sk.status = 1
				WHERE
					e.id=:id
					AND s.status = 1
				";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    //所属機関
	    $sql = "SELECT
					*
				FROM
					syozoku_tyosya
				WHERE
					eid = :eid
				ORDER BY num
			";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':eid', $id, PDO::PARAM_STR);
	    $r->execute();
	    $i=0;
	    while($rlt2 = $r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt['syozoku_tyosya'][$i] = $rlt2;
	        $i++;
	    }
	    //著者
	    $sql = "SELECT
					*
				FROM
					syozoku_tyosya_name
				WHERE
					eid = :eid
					AND status = 1
				ORDER BY num
			";

	    $r = $this->db->prepare($sql);
	    $r->bindValue(':eid', $id, PDO::PARAM_STR);
	    $r->execute();
	    $i=0;
	    while($rlt3 = $r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt['syozoku_tyosya_name'][$rlt3[ 'num' ]] = $rlt3;
	        $i++;
	    }


	    return $rlt;
	}
	public function checkLoginEditlg($data){
	    $sql = "
				SELECT
					*
					,e.id as endaiid
				FROM
					kagaku_sanka as s
					INNER JOIN kagaku_endai as e ON s.num = e.snum
					LEFT JOIN syozoku_kyokai as sk ON sk.eid = e.id AND sk.status = 1
				WHERE
					e.num = '".$data[ 'num' ]."'
					AND s.password = '".$data[ 'password' ]."'
					AND s.status = 1
					AND e.status = 1
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    //著者の所属期間の総数
	    $sql = "
				SELECT
					*
				FROM
					syozoku_tyosya
				WHERE
					eid = '".$rlt[ 'endaiid' ]."'
				ORDER BY num
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $i = 0;
	    while($rst = $r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt[ 'tyosyadata' ][$rst[ 'num' ]] = $rst;
	        $i++;
	    }

	    //著者の所属期間の総数
	    $sql = "
				SELECT
					*
				FROM
					syozoku_tyosya_name
				WHERE
					eid = '".$rlt[ 'endaiid' ]."'
				ORDER BY num
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $i = 0;
	    while($rst =$r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt[ 'tyosyadataName' ][$rst[ 'num' ]] = $rst;
	        $i++;
	    }


	    return $rlt;
	}
	public function getSankaDataEditlg($id){
	    $sql = "SELECT
					*
				FROM
					kagaku_sanka
				WHERE
					num=:num AND
					status = 1
				";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':num', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;
	}


	public function getFileUpAb($id){
	    $sql = "
				SELECT
					publication
					,vote
					,vote_text
					,fileUpdate_ts
					,fileUpdate_ext
				FROM
					kagaku_endai
				WHERE
					id=:id
					AND status = 1
				";
	    $r = $this->db->prepare($sql);
	    $r->bindValue(':id', $id, PDO::PARAM_STR);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    return $rlt;
	}

	public function getEndaiDataAb($id){
	    $sql = "SELECT
					*
					,e.code as ecode
					,s.code as scode
				FROM
					kagaku_endai as e
					LEFT JOIN kagaku_sanka as s ON s.num = e.snum
					LEFT JOIN syozoku_kyokai as sk ON sk.eid = e.id AND sk.status = 1
				WHERE
					e.id='".$id."'
					AND s.status = 1
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);
	    //所属機関
	    $sql = "SELECT
					*
				FROM
					syozoku_tyosya
				WHERE
					eid = '".$id."'
				ORDER BY num
			";

	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $i=0;
	    while($rlt2 = $r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt['syozoku_tyosya'][$i] = $rlt2;
	        $i++;
	    }
	    //著者
	    $sql = "SELECT
					*
				FROM
					syozoku_tyosya_name
				WHERE
					eid = '".$id."'
					AND status = 1
				ORDER BY num
			";

	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $i=0;
	    while($rlt3 = $r -> fetch(PDO::FETCH_ASSOC)){
	        $rlt['syozoku_tyosya_name'][$rlt3[ 'num' ]] = $rlt3;
	        $i++;
	    }


	    return $rlt;
	}


	public function checkLoginAb($data){
	    $sql = "
				SELECT
					*
					,e.id as eid
					,s.id as checkid
				FROM
					kagaku_sanka as s
					INNER JOIN kagaku_endai as e ON s.num = e.snum
					LEFT JOIN syozoku_kyokai as sk ON sk.eid = e.id AND sk.status = 1
				WHERE
					e.num = '".$data[ 'num' ]."'
					AND s.password = '".$data[ 'password' ]."'
					AND s.status = 1
					AND e.status = 1
				";

	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}

	public function getEndaiDataAbFin($id){
	    $sql = "SELECT
					*
					,e.code as ecode
					,s.code as scode
				FROM
					kagaku_endai as e
					LEFT JOIN kagaku_sanka as s ON s.num = e.snum
					LEFT JOIN syozoku_kyokai as sk ON sk.eid = e.id AND sk.status = 1
				WHERE
					e.id='".$id."'
					AND s.status = 1
				";
	    $r = $this->db->prepare($sql);
	    $r->execute();
	    $rlt = $r -> fetch(PDO::FETCH_ASSOC);

	    return $rlt;
	}

	public function getMovieLogin(){
		$id = filter_input(INPUT_POST,"id");
		$password = filter_input(INPUT_POST,"password");
		$sql = "SELECT 
			*  
				FROM
					kagaku_sanka 
				WHERE 
					num = :num AND 
					password = :password AND 
					status = 1 AND 
					sanka_pay_status = 1 
				";
		$r = $this->db->prepare($sql);
	    $r->bindValue(':num', $id, PDO::PARAM_STR);
	    $r->bindValue(':password', $password, PDO::PARAM_STR);
	    $r->execute();
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);
		return $rlt;
	}
	public function getQuestionData($where){
		$code = $where[ 'code' ];
		$sql = "
			SELECT 
				*,
				date_format(regist_date, '%M/%d') as date,
				date_format(regist_date, '%Y.%m.%d') as date_jp,
				date_format(regist_ts, '%H:%i') as time
			FROM
				question
			WHERE 
				endai_code = :endai_code AND 
				status = 1
			ORDER BY id asc
		";
		$r = $this->db->prepare($sql);
		$r->bindValue(':endai_code', $code, PDO::PARAM_STR);
		$r->execute();
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
		}
		return $list;
	}
	public function getReplayData($where){
		$question_id = $where[ 'question_id' ];
		$sql = "
			SELECT 
				*,
				date_format(regist_date, '%m/%d') as date,
				date_format(regist_ts, '%H:%i') as time
			FROM 
				replay 
			WHERE 
				question_id = :question_id AND 
				status = 1
			ORDER BY id asc
		";
		
		$r = $this->db->prepare($sql);
		$r->bindValue(':question_id', $question_id, PDO::PARAM_STR);
		$r->execute();
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
		}
		return $list;
	}

	public function getSankaJudge(){
		$sql = "
			SELECT 
				*
			FROM
				sanka_judge

		";
		$r = $this->db->prepare($sql);
		$r->execute();
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
		}
		return $list;

	}
	public function getEndaiPublicate(){
		$sql = "
			SELECT 
				*
			FROM
				endai_publicate

		";
		$r = $this->db->prepare($sql);
		$r->execute();
		$list = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			$list[] = $rlt;
		}
		return $list;

	}
	/**************
	 * CSV用データ出力
	 */
	public function getCsvResult(){
		global $array_ippanKouenposter;
		$sql = "

				SELECT 
					a.*,
					a.tyosya,
					group_concat(concat(stn.tyosya_name1,stn.tyosya_name2 ) ORDER BY stn.num  ) as tyosya_name
				FROM (

				SELECT 
					ks.code,
					ks.name1,
					ks.name2,
					sj.judge_publication,
					sj.result_select,
					sj.recomen,
					sj.other,
					ke.ippanKouenposter,
					ke.endainame,
					ke.id as kagaku_endai_id,
					ke.tyosya,
					GROUP_CONCAT(st.syozokuKikanD  ORDER BY st.num) as syozoku
				FROM 
					sanka_judge as sj 
					LEFT JOIN  kagaku_sanka as ks ON ks.code = sj.code AND ks.status = 1
					LEFT JOIN kagaku_endai as ke ON sj.judge_publication = ke.publication AND ke.status = 1
					LEFT JOIN syozoku_tyosya as st ON st.eid = ke.id 

				WHERE 
					ks.status = 1 
				GROUP BY sj.judge_publication,sj.code
				ORDER BY sj.code 
				) as a 
				LEFT JOIN syozoku_tyosya_name as stn ON a.kagaku_endai_id = stn.eid 
				GROUP BY a.judge_publication , a.code
			
			";
		$r = $this->db->prepare($sql);
		$r->execute();
		$key=0;
		$list = [];
		$check = [];
		while($rlt = $r -> fetch(PDO::FETCH_ASSOC)){
			//著者名
			$tyosya_name=[];
			$tyosya_name = explode(",",$rlt[ 'tyosya_name' ]);
			$num = 1;
			$list[$key] = $rlt;
			foreach($tyosya_name as $value){
				if($num == $rlt[ 'tyosya' ]){
					$list[$key]['tyosya_main'] = $value;
				}
				$num++;
			}
			//所属名
			$syozoku_name=[];
			$syozoku_name = explode(",",$rlt[ 'syozoku' ]);

			//該当なし
			$check[$rlt['code']] += $rlt[ 'recomen' ];

			$ippanKouenposter = $rlt[ 'ippanKouenposter' ];
			$list[$key]['ippanKouenposterName'] = $array_ippanKouenposter[$ippanKouenposter]['name'];
			$list[$key]['tyosya_list'] = $tyosya_name;
			$list[$key]['syozoku_name'] = $syozoku_name;

			$key++;
		}
		foreach($list as $key=>$value){
			if($check[$value['code']]){
				$list[$key]['recomCheck'] = "該当あり";
			}else{
				$list[$key]['recomCheck'] = "該当なし";
			}
		}
		return $list;
	}
	/**************
	 * 領収書用データ
	 */
	public function getRecipe($where){
		$sql = "
			SELECT 
				* 
			FROM 
				kagaku_sanka
			WHERE
				code=:code AND 
				status = 1
		";

		$r = $this->db->prepare($sql);
	    $r->bindValue(':code', $where[ 'code' ], PDO::PARAM_STR);
		$r->execute();
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);
		return $rlt;
	}
	/**************
	 * 領収書データログ
	 */
	public function getRecipeLog($where){
		$sql = "
			SELECT 
				* 
			FROM 
				recipe_output
			WHERE
				code=:code 
		";

		$r = $this->db->prepare($sql);
	    $r->bindValue(':code', $where[ 'code' ], PDO::PARAM_STR);
		$r->execute();
		$rlt = $r -> fetch(PDO::FETCH_ASSOC);
		return $rlt;
	}
}
?>