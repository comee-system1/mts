<?PHP
class comment{
	function __construct(){
		global $db;
		$this->db = $db;
	}
	public function index(){
		
		//質問用シート作成
		$this->__createQuestionSheet();
		//質問用解答シート
		$this->__createQuestionAnswerSheet();
		//質問用時間
		$this->__createQuestionTimeSheet();
		//解答時間シート
		$this->__createQuestionAnswerTimeSheet();

		//zipファイル作成
		$this->__createZipFile();
		

		exit();


	}
	public function __createZipFile(){
		$dir = "/home/nikkatohoku/www/test9/tmp";
		$glob = glob($dir."/*.csv");
		$list = [];
		foreach($glob as $key=>$value){
			$list[] = basename($value);
		}
		$imp = implode(" ",$list);

		$folder = "zips";
		$fileName = $folder.time();
		
		$zipPath = $dir. '/' .$fileName;
		$command =  "cd ". $dir ."; zip ". $fileName ." ".$imp;
		exec($command);
		//echo $command;
		
		// ファイルのパス
		$filepath = $dir."/".$fileName.".zip";
		
		// リネーム後のファイル名
		$filename = $fileName.'.zip';
		
		// ファイルタイプを指定
		header('Content-Type: application/force-download');
		
		// ファイルサイズを取得し、ダウンロードの進捗を表示
		header('Content-Length: '.filesize($filepath));
		
		// ファイルのダウンロード、リネームを指示
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		
		// ファイルを読み込みダウンロードを実行
		readfile($filepath);
		
		unlink( $zipPath.".zip" );
		
	}
	public function __createQuestionDateSheet(){
		$where = [];
		$rlt = $this->db->getQuestionLog($where);
		$path = "./tmp/";
		$fp = fopen($path.'questionTime.csv', 'w');


		$title = [];
		$title[] = "質問日付シート\n発表番号";

		for($i=1;$i<=10;$i++){
			$title[] = "質問-".$i."-ID";
		}
		
		$titles = implode(",",$title);
		$titles = mb_convert_encoding($titles,"SJIS","UTF-8");
		fwrite($fp, $titles . "\n");


		foreach($rlt as $data){
			

			$pub = $data[ 'publication' ];
			$line = $pub;
			$line .= ",".$data[ 'regist_line' ];
			fwrite($fp, $line . "\n");
		}

		fclose($fp);
	}

	public function __createQuestionAnswerTimeSheet(){
		$where = [];
		$rlt = $this->db->getQuestionAnswerTimeLog($where);
		$path = "./tmp/";
		$fp = fopen($path.'questionAnswerTimeQuestion.csv', 'w');
		

		$title = [];
		$title[] = "回答時間シート\n発表番号";
		for($j=1;$j<=5;$j++){
			for($i=1;$i<=5;$i++){
				$title[] = "質問-".$j."-回答-".$i."-時間";
			}
		}

		$titles = implode(",",$title);
		$titles = mb_convert_encoding($titles,"SJIS","UTF-8");
		fwrite($fp, $titles . "\n");


		foreach($rlt as $data){


			$pub = $data[ 'publication' ];
			$line = $pub;
			foreach($data['lists'] as $key=>$value){
				for($i=0;$i<5;$i++){
					$line .= ",".$value[$i];
				}

			}

			fwrite($fp, $line . "\n");
		}



		fclose($fp);

	}

	
	public function __createQuestionTimeSheet(){
		$where = [];
		$rlt = $this->db->getQuestionLog($where);
		$path = "./tmp/";
		$fp = fopen($path.'questionTime.csv', 'w');


		$title = [];
		$title[] = "質問時間シート\n発表番号";

		for($i=1;$i<=10;$i++){
			$title[] = "質問-".$i."-ID";
		}
		
		$titles = implode(",",$title);
		$titles = mb_convert_encoding($titles,"SJIS","UTF-8");
		fwrite($fp, $titles . "\n");


		foreach($rlt as $data){
			

			$pub = $data[ 'publication' ];
			$line = $pub;
			$line .= ",".$data[ 'regist_line' ];
			fwrite($fp, $line . "\n");
		}

		fclose($fp);
	}

	
	public function __createQuestionAnswerSheet(){
		$where = [];
		$rlt = $this->db->getQuestionAnswerLog($where);
		$path = "./tmp/";
		$fp = fopen($path.'questionAnswerQuestion.csv', 'w');
		

		$title = [];
		$title[] = "回答IDシート\n発表番号";
		for($j=1;$j<=5;$j++){
			for($i=1;$i<=5;$i++){
				$title[] = "質問-".$j."-回答-".$i;
			}
		}

		$titles = implode(",",$title);
		$titles = mb_convert_encoding($titles,"SJIS","UTF-8");
		fwrite($fp, $titles . "\n");


		foreach($rlt as $data){


			$pub = $data[ 'publication' ];
			$line = $pub;
			foreach($data['lists'] as $key=>$value){
				for($i=0;$i<5;$i++){
					$line .= ",".$value[$i];
				}

			}

			fwrite($fp, $line . "\n");
		}



		fclose($fp);

	}
	public function __createQuestionSheet(){
		$where = [];
		$rlt = $this->db->getQuestionLog($where);
		$path = "./tmp/";
		$fp = fopen($path.'question.csv', 'w');
		

		$title = [];
		$title[] = "発表番号";

		for($i=1;$i<=10;$i++){
			$title[] = "質問-".$i."-ID";
		}
		
		$titles = implode(",",$title);
		$titles = mb_convert_encoding($titles,"SJIS","UTF-8");
		fwrite($fp, $titles . "\n");


		foreach($rlt as $data){
			

			$pub = $data[ 'publication' ];
			$line = $pub;
			$line .= ",".$data[ 'line' ];
			fwrite($fp, $line . "\n");
		}

		fclose($fp);
	}
}
?>