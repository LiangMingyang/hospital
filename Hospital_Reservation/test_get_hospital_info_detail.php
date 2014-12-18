<?php
 $data['Hospital_Picture_url']
 ="http://localhost/Hospital_Reservation/hospital_image/hospital_pic_20141209143355.jpg";
 $data['Hospital_ID']=1;
 $data['Hospital_Level']=31;
 $data['Hospital_Introduction']="好Summary: 
 The world of web development tools is changing 
 quickly and Firebug doesn’t want to stay behind.
  If you are Firebug fan or just curious what the 
  future holds for Firebug and where the next 
  Firebug generation is heading, read on… In 2006,
   Firebug started a revolution of in-browser developer
    tools and it quickly becam";
 $data['Hospital_Name']='北医三院';
 $data['Hospital_Location']='学院路39号';
 $data['Reservation_Start_Time']=date('00:00:00');
 $data['Reservation_End_Time']=date('23:50:59');
 $data['Province_ID']=1;	
 $data['Area']=1;	
 $data['msg']=0;
 echo json_encode($data);
?>