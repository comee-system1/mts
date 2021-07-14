<?PHP
require_once('./install/Auth/Auth.php');
include_once("./smarty/libs/Smarty.class.php");
require_once("./init/init.php");
require_once("./lib/include_method.php");
require_once("./lib/tcpdf/tcpdf.php");
require_once("./lib/FPDI/src/autoload.php");

require_once './PHPWord/PHPWord.php';
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$db = new method();
$smarty = new Smarty();
//$tcpdf = new TCPDF("L", "mm", "A4", true, "UTF-8" );
use setasign\Fpdi\TcpdfFpdi;
$pdf = new TcpdfFpdi();

//kagaku_userデータ取得
$manage = $db->getKagakuUser();
$html[ 'manage'] = $manage;
// New Word Document
$PHPWord = new PHPWord();
//所属協会マスターの取得
$array_syozoku = array();
$array_syozoku = $db->getSyozokuMaster();
//発表形式マスターの取得
$array_happyo = array();
$array_happyo = $db->getHappyoMaster();
$array_ippanKouenkouto = array();
$array_ippanKouenkouto = $db->getIppanKouenkoutoMaster();
$array_ippanKouenposter = array();
$array_ippanKouenposter = $db->getIppanKouenposterMaster();
$array_syotai= array();
$array_syotai = $db->getSyotaiMaster();
$array_korokiumu= array();
$array_korokiumu = $db->getKorokiumuMaster();


//PCマスター
$array_pc = array();
$array_pc = $db->getPCMaster();

//参加フォームの取得
$sankaform = $db->getSankaForm();
//var_dump($sankaform);
//$array_address住所先の変更
$array_address[1] = $sankaform['sform'][10][ 'name_text1' ];
$array_address[2] = $sankaform['sform'][10][ 'name_text2' ];
$array_join_type[1] = $sankaform[ 'sform' ][ 18 ][ 'name_text1' ];
$array_join_type[2] = $sankaform[ 'sform' ][ 18 ][ 'name_text2' ];
$array_join_type[3] = $sankaform[ 'sform' ][ 18 ][ 'name_text3' ];
$array_join_type[4] = $sankaform[ 'sform' ][ 18 ][ 'name_text4' ];

$array_join_type_money[1] = $sankaform[ 'sformmny' ][ 1 ][ 'money' ];
$array_join_type_money[2] = $sankaform[ 'sformmny' ][ 2 ][ 'money' ];
$array_join_type_money[3] = $sankaform[ 'sformmny' ][ 3 ][ 'money' ];
$array_join_type_money[4] = $sankaform[ 'sformmny' ][ 4 ][ 'money' ];
$array_join_type_money_unit[1] = $sankaform[ 'sformmny' ][ 1 ][ 'money_text' ];
$array_join_type_money_unit[2] = $sankaform[ 'sformmny' ][ 2 ][ 'money_text' ];
$array_join_type_money_unit[3] = $sankaform[ 'sformmny' ][ 3 ][ 'money_text' ];
$array_join_type_money_unit[4] = $sankaform[ 'sformmny' ][ 4 ][ 'money_text' ];
$html[ 'moneyUnit' ] = $array_join_type_money_unit;
$array_konshinkai_money[1] = $sankaform[ 'sformmny' ][ 5 ][ 'money' ];
$array_konshinkai_money[2] = $sankaform[ 'sformmny' ][ 6 ][ 'money' ];
//演題フォームの取得
$endaiform = $db->getEndaiForm();

$uri = $_SERVER[ 'REQUEST_URI' ];
$ex  = explode("/",$uri);
$first = @$ex[1];
$sec   = @$ex[2];
$third = @$ex[3];
$four  = @$ex[4];
$five  = @$ex[5];
$six   = @$ex[6];
$seven = @$ex[7];


//--------------------------
//予稿原稿ダウンロード画面
//-------------------------
if($first == "draft"){
	if($sec){
		$inc = "draft";
		include_once("./php/draft/".$inc.".php");
		$file = $sec;
		$obj             = new $inc;
		$html[ 'data' ]  = $obj->$sec();
	}else{
		$_SESSION[ 'draft' ] = "";
		$inc = "draft";
		$dir = "draft";
		include_once("./php/".$dir."/".$inc.".php");
		$file = "index";
		$obj             = new $inc;
		$html[ 'data' ]  = $obj->index();
	}

	
	$html[ 'data' ][ 'draft' ]  = $draft;
	$html[ 'first' ] = $first;
	$html[ 'sec'   ] = $sec;
	$html[ 'third'   ] = $third;
	$html[ 'display' ] = "on";
	if($html[ 'data' ][ 'file' ]){
		$file = $html[ 'data' ][ 'file' ];
	}
	$hdir = "draft";
	global $html;
	$smarty->template_dir = './html/'.$hdir.'/';
	$smarty->compile_dir  = './smarty/templates_c/';
	$smarty->cache_dir    = './smarty/cache/';
	$smarty->assign('html',$html);

	//** 次の行のコメントをはずすと、デバッギングコンソールを表示します
	//$smarty->debugging = true;
	$smarty->display($file.'.html');
	exit();
}



//--------------------------
//プレゼンテーション動画
//-------------------------
if($first == "movie"){
	if($sec){
		$inc = "movie";
		include_once("./php/movie/".$inc.".php");
		$file = $sec;
		$obj             = new $inc;
		$html[ 'data' ]  = $obj->$sec();
	}else{
		$_SESSION[ 'movie' ] = "";
		$inc = "movie";
		$dir = "movie";
		include_once("./php/".$dir."/".$inc.".php");
		$file = "index";
		$obj             = new $inc;
		$html[ 'data' ]  = $obj->index();
	}

	
	$html[ 'data' ][ 'movie' ]  = $movie;
	$html[ 'first' ] = $first;
	$html[ 'sec'   ] = $sec;
	$html[ 'third'   ] = $third;
	$html[ 'display' ] = "on";
	if($html[ 'data' ][ 'file' ]){
		$file = $html[ 'data' ][ 'file' ];
	}
	$hdir = "movie";
	global $html;
	$smarty->template_dir = './html/'.$hdir.'/';
	$smarty->compile_dir  = './smarty/templates_c/';
	$smarty->cache_dir    = './smarty/cache/';
	$smarty->assign('html',$html);

	//** 次の行のコメントをはずすと、デバッギングコンソールを表示します
	//$smarty->debugging = true;
	$smarty->display($file.'.html');
	exit();
}

//--------------------------
//参加情報登録公開ページ
//-------------------------
if($first == "p_form"){
	if($sec){
		$inc = $sec;
		include_once("./php/p_form/".$sec.".php");
		$file = $sec;
	}else{
		$_SESSION[ 'sankaFin' ] = "";
		$inc = "page";
		$dir = "sanka";
		include_once("./php/".$dir."/".$inc.".php");
		$file = "index";
	}

	$obj             = new $inc;
	$html[ 'data' ]  = $obj->index();
	$html[ 'data' ][ 'sankaform' ]  = $sankaform;
	$html[ 'first' ] = $first;
	$html[ 'sec'   ] = $sec;
	$html[ 'third'   ] = $third;
	$html[ 'display' ] = "on";
	if($html[ 'data' ][ 'file' ]){
		$file = $html[ 'data' ][ 'file' ];
	}
	$hdir = "p_form";
	global $html;

	$smarty->template_dir = './html/'.$hdir.'/';
	$smarty->compile_dir  = './smarty/templates_c/';
	$smarty->cache_dir    = './smarty/cache/';
	$smarty->assign('html',$html);

	//** 次の行のコメントをはずすと、デバッギングコンソールを表示します
	//$smarty->debugging = true;
	$smarty->display($file.'.html');
	exit();
}
//----------------------------
//発表申込フォーム
//----------------------------
if($first == "pre"){

	$html[ 'first' ] = $first;
	$html[ 'display' ] = "on";
	$file = "index";

	$inc = "page";
	$dir = "endai";
	if($sec){
		$inc = $sec;
		$file = $sec;
		$dir = "pre";
	}
	include_once("./php/".$dir."/".$inc.".php");
	$obj             = new $inc;
	$html[ 'data' ]  = $obj->index();
	$html[ 'data' ][ 'endaiform' ]  = $endaiform;
	$html[ 'data' ][ 'sankaform' ]  = $sankaform;
	$html[ 'first' ] = $first;
	$html[ 'sec'   ] = $sec;
	$html[ 'third'   ] = $third;
	$html[ 'display' ] = "on";

	if($html[ 'data' ][ 'file' ]){
		$file = $html[ 'data' ][ 'file' ];
	}
	$smarty->template_dir = './html/pre/';
	$smarty->compile_dir  = './smarty/templates_c/';
	$smarty->cache_dir    = './smarty/cache/';
	$smarty->assign('html',$html);
	$smarty->display($file.'.html');

	exit();
}
//----------------------------
//発表申込フォーム終わり
//----------------------------
if($_SESSION[ 'loginflag' ]){
	$uri = $_SERVER[ 'REQUEST_URI' ];
	$ex  = explode("/",$uri);
	$first = $ex[1];
	$sec   = $ex[2];
	$third = $ex[3];
	$four  = $ex[4];
	$five  = $ex[5];
	$six   = $ex[6];
	$seven = $ex[7];
	//$html = array();
	//ログインした人のtypeを取得
	//var_dump($_SESSION);
	$type = 1;
	$id     = $_SESSION[ 'data' ]["id"   ];
	$logo   = $_SESSION["logo" ];
	//ログイン情報を保存
	$base_id     = $id;
	$base_type   = $type;

	$html[ 'type'          ] = $type;
	$html[ 'id'            ] = $id;
	$html[ 'base_type'     ] = $base_type;
	$html[ 'base_id'       ] = $base_id;

	//ログアウト処理
	if($first == "logout"){
		session_destroy();//セッションを破壊*
		header("Location:".D_URL_HOME);
		exit();
	}
	switch($first){
		case "sanka":
			$dir  = "sanka";
			$hdir = "sanka";
			$inc  = $sec;
			$file = $sec;
		break;
		case "endai":
			$dir  = "endai";
			$hdir = "endai";
			$inc  = $sec;
			$file = $sec;
		break;
		case "preview":
			$dir  = "preview";
			$hdir = "preview";
			$inc  = $sec;
			$file = $sec;
		break;
		case "":
			$file = "index";
			$dir  = "php1";
			$hdir = "html1";
			$inc  = "index";
		break;
		default:
			$inc  = $first;
			$file = $first;
			$dir  = "php1";
			$hdir = "html1";
		break;
	}
	if($inc){
		include_once("./php/".$dir."/".$inc.".php");
		$obj             = new $inc;
		$html[ 'data' ]  = $obj->index();
		$html[ 'data' ][ 'sankaform' ]  = $sankaform;
		//読み込みhtmlファイルの変更
		if($html[ 'data' ][ 'file' ]){
			$file = $html[ 'data' ][ 'file' ];
		}
		//ディレクトリの変更
		if($html[ 'data' ][ 'dir' ]){
			$hdir = $html[ 'data' ][ 'dir' ];
		}
	}
	//TOP画像
	if($logo && file_exists(D_LOGO_PATH.$logo)){
		$html[ 'mainImg' ] = "on";
	}
	$html[ 'first' ] = $first;
	$html[ 'sec'   ] = $sec;
	$html[ 'third' ] = $third;
	$html[ 'four'  ] = $four;
	$html[ 'five'  ] = $five;
	global $html;
	$smarty->template_dir = './html/'.$hdir.'/';
	$smarty->compile_dir  = './smarty/templates_c/';
	$smarty->cache_dir    = './smarty/cache/';
	$smarty->assign('html',$html);

	//** 次の行のコメントをはずすと、デバッギングコンソールを表示します
	//$smarty->debugging = true;
	$smarty->display($file.'.html');
}else{
    if($rlt = $db->loginCheck()){
        $_SESSION[ 'loginflag' ] = true;
        $_SESSION[ 'data'      ] = $rlt;
        header("Location:".D_URL_HOME);
    }else{
        $_SESSION[ 'loginflag' ] = false;
    }
    loginFunction();
}

function loginFunction($username = null, $status = null, &$auth = null )
{
	global $smarty;
	$html = "login";
	$smarty->template_dir = './html/';
	$smarty->compile_dir  = './smarty/templates_c/';
	$smarty->cache_dir    = './smarty/cache/';
	$smarty->display($html.'.html');

}
function loginFunctionEndai($username = null, $status = null, &$auth = null )
{
	global $db;
	global $smarty;
	$pages = $db->getHppageEndai();
	$html[ 'data' ] = $pages;
	$file = "login";
	$smarty->template_dir = './html/pre/';
	$smarty->compile_dir  = './smarty/templates_c/';
	$smarty->cache_dir    = './smarty/cache/';
	$smarty->assign('html',$html);
	$smarty->display($file.'.html');

}
?>