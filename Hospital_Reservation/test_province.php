<?php
    $data['msg']=0;
	$pro=array();
	$pro['Province_ID']=1;
    $pro['Province_Name']="北京";
    $data['content']=array();
    array_push($data['content'],$pro);
	$pro['Province_ID']=2;
    $pro['Province_Name']="上海";
	array_push($data['content'],$pro);
	echo json_encode($data);  
?>