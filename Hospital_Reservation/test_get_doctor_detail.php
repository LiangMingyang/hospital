<?php
    $data=array();
	$data['Doctor_ID']=1;
    $data['Depart_ID']='2';
    $data['Doctor_Name']='szm';
	$data['Doctor_Level']=1;
    $data['Doctor_Fee']='1.0';
    $data['Doctor_Limit']='3';
	$data['Doctor_Major']='fdp';
    $data['Duty_Time']='1';
    $data['Doctor_Name']='szm';
	$data[' Doctor_Picture_url']=
	"http://localhost/Hospital_Reservation//doctor_image/doctor_pic_20141213073804.jpg";
    $data['msg']=0;
	$data['Duty_Time']=array();
	array_push($data['Duty_Time'],11,12,21,32,71);
	echo json_encode($data);
?>