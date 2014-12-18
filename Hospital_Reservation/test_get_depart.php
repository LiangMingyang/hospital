<?php
    $data['msg']=0;
	$data['content']=array();
	$item=array();
	$item['Depart_ID']="1";
	$item['Depart_Name']="眼科";
	array_push($data['content'],$item);
	$item['Depart_ID']="2";
	$item['Depart_Name']="外科";
	array_push($data['content'],$item);
	echo json_encode($data);
?>