<?php
  $data['msg']=0; 
   $array['Reservation_ID']=1;
   $array['Reservation_Time']=date('Y-m-d H:i:s');
   $array['Operation_Time']=date('Y-m-d H:i:s');
   $array['Doctor_Name']='耿金坤';
   $array['Reservation_Payed']='0';
   $data['content']=array();
   array_push($data['content'],$array);
      $array['Reservation_ID']=2;
   $array['Reservation_Time']=date('Y-12-28 H:i:s');
   $array['Operation_Time']=date('Y-m-02 H:i:s');
   $array['Doctor_Name']='耿金坤';
   $array['Reservation_Payed']='1';
   array_push($data['content'],$array);
   echo json_encode($data);


   
?>