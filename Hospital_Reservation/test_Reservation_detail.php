<?php
  $data['msg']=0; 
   $data['Reservation_ID']=1;
   $data['Reservation_Time']=date('Y-m-d H:i:s');
   $data['Operation_Time']=date('Y-m-d H:i:s');
   $data['Doctor_Name']='耿金坤';
   
  $data['Reseration_Symptom']="感冒";
  $data['Reservation_Payed']=1;
  $data['Hospital_Name']='北京市第三人民医院';
  $data['Hospital_Location']='北京市学院路38号';
  $data['Depart_Name']='内科';
  $data['Doctor_Level']=1;
  $data['Doctor_Fee']=15.00;
   $data['Reservation_PayTime']=date('Y-m-d H:i:s');
	 echo json_encode($data);
?>