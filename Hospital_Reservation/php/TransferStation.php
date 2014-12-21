<?php
    date_default_timezone_set('PRC');
    require_once('../include/HttpClient.class.php');
	$url="http://hospital.wannakissyou.com/".$_POST['url'];
	unset($_POST['url']);
	$token="songzimingdb$".$_POST['encrypttime'];
	$token=sha1($token);
	$_POST['token']=$token;
	$pageContents = HttpClient::quickPost($url, $_POST); 
	echo $pageContents;
?>