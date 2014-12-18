<?php
    $data['msg']=0;
	$data['content']=array();
	$item['Doctor_ID']='1';
	$item['Doctor_Name']='szm';
	array_push($data['content'],$item);
	$item['Doctor_ID']='2';
	$item['Doctor_Name']='db';
	array_push($data['content'],$item);
	echo json_encode($data);
?>