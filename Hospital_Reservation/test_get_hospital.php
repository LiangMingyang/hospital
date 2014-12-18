<?php
  $data['msg']=0;
  $content=array();
  $item['Hospital_ID']=1;
  $item['Hospital_Name']='北医三院';
  array_push($content,$item);
  $item['Hospital_ID']=2;
  $item['Hospital_Name']='同仁医院'; 
  array_push($content,$item); 
  $data['content']=$content;
  echo json_encode($data);

?>