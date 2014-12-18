<?php
    $data['msg']=0;
	$pro=array();
	$pro['Area_ID']=1;
    $pro['Area_Name']="朝阳区";
    $data['content']=array();
    array_push($data['content'],$pro);
	$pro['Area_ID']=2;
    $pro['Area_Name']="海淀区";
	array_push($data['content'],$pro);
	echo json_encode($data);  
?>