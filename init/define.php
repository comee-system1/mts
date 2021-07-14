<?php
/*------------------------------------------------------------
各定義ファイル



------------------------------------------------------------*/
define( "D_DOMAIN"          , $_SERVER['HTTP_HOST'].""                           );
define( "D_URL_HOME"        , "http://".D_DOMAIN."/"                              );

//define( "D_URLS_HOME"       , "https://".D_DOMAIN."/"                             );
//define( "D_URLS_HOME"       , "https://nikkatohoku.sakura.ne.jp/"                  );

if(D_DOMAIN == "nikka.se-sendai.co.jp"){
	define( "D_URLS_HOME"       , "http://".D_DOMAIN."/"                             );
}else{
	define( "D_URLS_HOME"       , "http://".D_DOMAIN."/"                             );
}

define( "D_URL_TEMP_IMAGE"  , D_URL_HOME."img/"                                   );
define( "D_URL_IMAGES"      , D_URL_HOME."images/"                                );
define( "D_URL_LOGO"        , D_URL_HOME."img/"                                   );
define( "D_URL_HOME_BASE"   , D_URL_HOME                                          );


/*
define('DEFAULT_HOST',"mysql484.db.sakura.ne.jp");
define('DEFAULT_DBNAME',"nikkatohoku_csj");
define('DEFAULT_USER',"nikkatohoku");
define('DEFAULT_PASSWORD',"nikkatohoku22");


define( "D_URL"   , "https://csjtohoku.jp/"                                        );
define( "D_URLS"   , "https://csjtohoku.jp/"                                        );
define( "D_PATH_HOME"       , "/home/nikkatohoku/www/test9/"             );		// 表のメインページの場所

*/

define('DEFAULT_HOST',"localhost");
define('DEFAULT_DBNAME',"mts");
define('DEFAULT_USER',"root");
define('DEFAULT_PASSWORD',"");


define( "D_URL"   , "http://local-nikka:8088/"                                        );
define( "D_URLS"   , "http://local-nikka:8088/"                                        );
define( "D_PATH_HOME"       , '/' );







define('AUTH_IDLE_TIME'   , 18000                                               );
define('AUTH_IDLE_TIME_VF', 18000                                               );
//define('D_FROM_MAIL'        ,'nikka.tohoku@chemistry.or.jp'                                );
define('D_FROM_MAIL'        ,'chiba2@innovation-gate.jp'                                );

define( "D_PATH_LIB"        , D_PATH_HOME."lib/"                                );

define( "D_LOGO_PATH"        , D_PATH_HOME."html/image/logo/"                        );
define( "D_LOGO_URL"         , D_URL_HOME."html/image/logo/"                        );

//define("D_SANKA_CODE","-CSJ-TOHOKU16");
//define("D_ENDAI_CODE","-CSJ-TOHOKU16");
define("D_SANKA_CODE","-CSJ-TOHOKU21");
define("D_ENDAI_CODE","-CSJ-TOHOKU21");
define("D_LIMIT",60);



$invgfoot = "---株式会社イノベーションゲート---------------\n";
$invgfoot .= "■ システム運用についてのお問い合わせ ■\n";
$invgfoot .= "株式会社イノベーションゲート　サポートデスク\n";
$invgfoot .= "e-mail：".D_FROM_MAIL."  平日 10:00～17:00\n";
$invgfoot .= "--------------------------------------------- \n";



?>