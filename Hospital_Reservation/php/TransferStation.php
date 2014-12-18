<?php
    if(!isset($_SESSION))
	session_start();
	
    date_default_timezone_set('PRC');
    require_once('../include/HttpClient.class.php');
	$url="http://hospital.wannakissyou.com/".$_POST['url'];
	$url_back_op=$_POST['url'];
	unset($_POST['url']);
	$token="songzimingdb$".$_POST['encrypttime'];
	$token=sha1($token);
	$_POST['token']=$token;
	$pageContents = HttpClient::quickPost($url,$_POST); 
	echo $pageContents;
	if($url_back_op=='In_Cash'&&$pageContents['msg']==0){
		$_SESSION['Amount']+=$_POST['Amount'];
	}
	
?>