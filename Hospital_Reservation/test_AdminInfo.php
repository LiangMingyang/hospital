<?php
     $data['msg']=0;
	 $data['content']=array();
	 $item=array();
	 $item['Hospital_ID']=1;
	 $item['Hospital_Name']='北医三院';
	 array_push($data['content'],$item);
	 $item['Hospital_ID']=2;
	 $item['Hospital_Name']='同仁医院';
	 array_push($data['content'],$item);
	 $item['Hospital_ID']=3;
	 $item['Hospital_Name']='解放军医院';
	 array_push($data['content'],$item);
	  echo json_encode($data);
?>