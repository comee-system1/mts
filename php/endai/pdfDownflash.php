<?PHP
class pdfDownflash{
	function __construct(){
		global $db;
		global $html;
		global $array_pref;
		$this->db   = $db;
		$this->html = $html;
		$this->pref = $array_pref;
	}
	public function index(){
		ini_set('memory_limit',-1);
		// Zipクラスロード
		$zip = new ZipArchive();

		// Zipファイル名
		$zipFileName = date('YmdHis').'.zip';
		// Zipファイル一時保存ディレクトリ
		$zipTmpDir = D_PATH_HOME.'flash/temp/';

		$result = $zip->open($zipTmpDir.$zipFileName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

		$image_data_array = $this->db->getImageFlash();

		// 処理制限時間を外す
		set_time_limit(0);
		foreach ($image_data_array as $filepath) {
			// 取得ファイルをZipに追加していく
			if($filepath[ 'fileUpdate_flash_ext' ]){
				$filename = basename($filepath[ 'fileUpdate_flash_ext' ]);
				$path = D_PATH_HOME."flash/".$filepath[ 'fileUpdate_flash_ext' ];
				$zip->addFromString($filename,file_get_contents($path));
			}
		}
		$zip->close();

/*
		// ストリームに出力
		header('Content-Type: application/zip; name="' . $zipFileName . '"');
		header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
		header('Content-Length: '.filesize($zipTmpDir.$zipFileName));
		file_get_contents($zipTmpDir.$zipFileName);
		// 一時ファイルを削除しておく
		unlink($zipTmpDir.$zipFileName);
*/
		$filepath = $zipTmpDir.$zipFileName;
		header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($filepath));
		readfile($filepath);
		exit();

	}

}
?>