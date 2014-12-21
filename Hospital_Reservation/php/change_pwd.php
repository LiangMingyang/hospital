<?php
    if(!isset($_SESSION)){
    	session_start();
    }
	date_default_timezone_set('PRC');
    require_once('../include/HttpClient.class.php');
	$Reset_ID=$_SESSION['Reset_ID'];
	$randstr=$_SESSION['randstr'];
	$conn=mysql_connect("localhost","root","");//xiu gai
	if(!$conn){
		echo "Fail to Connect ".mysql_error();
	}
	mysql_select_db("password_reset");
	$select="select User_ID,Time from Reset_Pwd where ID=$Reset_ID 
	         and rand_str='$randstr'";
	//echo $select;
    $ans=mysql_query($select,$conn);
	$row=mysql_fetch_assoc($ans);
	//print_r($row);
	/*
	echo strtotime('now')-strtotime($row['Time']);
	echo "\n";
	echo date('Y-m-d H:i:s');
	echo "\n";
	echo "now  ".strtotime('now');
	echo "\n";
	echo "rr   ".strtotime($row['Time']);
	echo "\n";
	echo $row['Time'];
	 * 
	 */
	if($row['User_ID']!='' && strtotime('now')-strtotime($row['Time'])<=30*60){
		$User_ID=$row['User_ID'];
		$url="http://hospital.wannakissyou.com/UpdatePwd_User";
		$data=array();
		$data['encrypttime']=$_POST['encrypttime'];
		$token="songzimingdb$".$data['encrypttime'];
		$token=sha1($token);
		$data['token']=$token;
		$data['User_ID']=$User_ID;
		$data['Password']=$_POST['Password'];
	    $pageContents = HttpClient::quickPost($url, $data); 
	    echo $pageContents;
		json_decode($pageContents);
		if($pageContents['msg']==0){
			$delete_sql="delete from Reset_Pwd where ID=$Reset_ID";
			mysql_query($delete_sql);
		}
	}else{
		$delete="delete from Reset_Pwd where ID=$Reset_ID";
		mysql_query($delete);
		$res=array();
		$res['msg']=1;
		$res['info']='链接已失效';
		echo json_encode($res);
	}
?>