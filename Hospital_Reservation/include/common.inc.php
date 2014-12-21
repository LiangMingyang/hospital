<?php
define('ROOT', str_replace("\\", '/', substr(dirname(__FILE__), 0, -7)));

ini_set("include_path", ROOT."include");
ini_set("display_errors", "On");
ini_set('session.gc_maxlifetime',60);   //10分钟过期
ini_set('memory_limit', '-1');

error_reporting(E_ERROR & ~E_NOTICE);
//error_reporting(0);

date_default_timezone_set('Asia/Shanghai');

//require 'model.class.php';
//require 'mysql.class.php';

define('WEB_ROOT', '/Hospital_Reservation');
define('ROOT_PATH','/Hospital_Reservation');
define('CSS_PATH', WEB_ROOT.'/template/css/');
define('IMAGE_PATH', WEB_ROOT.'/images/');
define('JS_PATH', WEB_ROOT.'/template/js/');
define('INCLUDE_PATH', WEB_ROOT.'/include/');
define('MINI_PAGE_SIZE',5); //add by Chenhuan, 5 records per page

define('PAGE_SIZE',15);
define('RULE_TYPE_MINING_MIN',4);
define('RULE_TYPE_MINING_MAX',9);
define('RULE_TYPE_USER_PRIVILEGE_PATTERN',8);//定义用户权限模式所属的规则类型ID

define('RULE_TYPE_MINING_TRANS',4);
define('RULE_TYPE_MINING_NEG_TRANS',9);
define('RULE_TYPE_MINING_SEQ',5);
define('RULE_TYPE_MINING_TRANS_CLOUD',6);
define('RULE_TYPE_MINING_SEQ_CLOUD',7);
define('RULE_TYPE_RIGHT',8);
define('RULE_TYPE_BUILTIN',3);
define('SHELL_PATH','/var/www/utils');


//database connection
//$db = new mysql();

//读取数据库配置文件
//$file_handle = fopen(ROOT_PATH.WEB_ROOT."include/database.conf",'r');
/*
while (!feof($file_handle)) {
	$line = fgets($file_handle);
	if(substr($line,0,4)=="host"){
		$db_host = substr($line, strpos($line,"=")+1);
	}elseif(substr($line,0,6)=="schema"){
		$db_name = substr($line, strpos($line,"=")+1);
	}elseif(substr($line,0,8)=="username"){
		$db_user = substr($line, strpos($line,"=")+1);
	}elseif(substr($line,0,8)=="password"){
		$db_pass = substr($line, strpos($line,"=")+1);
	}
}
fclose($file_handle);

$db_host=trim($db_host);
$db_user=trim($db_user);
$db_pass=trim($db_pass);
$db_name=trim($db_name);

define('DB_HOST', $db_host);
define('DB_USER', $db_user);
define('DB_PWD', $db_pass);
define('DB_NAME', $db_name);

$db->connect(DB_HOST, DB_NAME, DB_USER, DB_PWD);
//--end database connection---

require 'global.func.php';
$url = $_SERVER['REQUEST_URI'];
*/
/*
preg_match($pattern, $url,$regs);
$module = $regs[1];
$menuName = $regs[2];

$para = $regs[3];
$saveFile=$_REQUEST['saveFile'];

if($menuName != 'login.php'&& $menuName != 'mining.php'
 && $saveFile != 1 && $module != 'report')
    authorize($module,$menuName,$para);
$l = new user_log();
$logType = new user_log_type();
$log = array();
$log['LogType'] = 0;
$log['OpTargets'] = '';
$log['OpItems'] = '';
$log['Result'] = 0;
*/

?>
