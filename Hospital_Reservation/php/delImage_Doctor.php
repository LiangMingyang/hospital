<?php
    $filename=$_POST['filename'];
	$storage_path="../doctor_image//".$filename;
	$res=@unlink($filename);
	$data['msg']=0;
	$data['res']=$res;
	echo json_encode($data);
?>