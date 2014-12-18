<?php
$data=array();
$data['msg']=0;
    $data['token']=$_POST['token'];;  
    $data['encrypttime']=$_POST['encrypttime'];
   	$data['Hospital_Name']=$_POST['Hospital_Name'];
	$data['Hospital_Level']=$_POST['Hospital_Level'];
	$data['Hospital_Introduction']=$_POST['Hospital_Introduction'];
	$data['Hospital_Location']=$_POST['Hospital_Location'];
	$data['Reservation_Start_Time']=$_POST['Reservation_Start_Time'];
	$data['Reservation_End_Time']=$_POST['Reservation_End_Time'];
    $data['Province_ID']=$_POST['Province_ID'];
    $data['Area_ID']=$_POST['Area_ID'];
    $data['Hospital_Picture_url']=$_POST['Hospital_Picture_url'];
	echo json_encode($data);
	
?>