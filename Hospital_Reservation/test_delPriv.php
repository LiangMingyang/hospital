<?php
$h=$_POST['Hospital_ID'];
if($h[0]=='1'){
	$data['msg']=0;
	echo json_encode($data);
}

?>