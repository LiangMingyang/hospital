<?php
$data['total']=1;
$data['from']=1;
$data['to']=1;
$data['rows'] = array();
$entry['id']=1;
$cell=array();
/*
$cell['Reservation_ID']=1;
$cell['Reservation_Time']=date("Y-m-d H:i:s");
$cell['Operation_Time']=date("Y-m-d H:i:s");
$cell['Doctor_Name']='耿金坤';
$cell['State']='成功';
 * 
 */
array_push($cell,'1',date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),'耿金坤','成功');
$entry['cell']=$cell;
array_push($data['rows'],$entry);
echo json_encode($data);     		 		
?>