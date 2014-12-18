<?php
    $filename=$_POST['filename'];
	$storage_path="../hospital_image//".$filename;
	$res=@unlink($storage_path);
	$data['msg']=0;
	$data['res']=$res;
	echo json_encode($data);
?>