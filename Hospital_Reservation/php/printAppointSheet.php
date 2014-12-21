<?php
require_once("gen_pdf.php");
if(!isset($_SESSION))session_start();
$Reservation_Time=$_REQUEST['Reservation_Time'];
$Reseration_Symptom=$_REQUEST['Reseration_Symptom'];
$Hospital_Name=$_REQUEST['Hospital_Name'];
$title=$Hospital_Name."挂号单";
$Hospital_Location=$_REQUEST['Hospital_Location'];
$Reservation_ID=$_REQUEST['Reservation_ID'];
$User_Name=$_SESSION['UserName'];
$Birthday=$_SESSION['Birthday'];
$Identity_ID=$_SESSION['Identity_ID'];
$Sex=$_SESSION['Sex'];
if($Sex=='0')$Sex='女';
else if($Sex=='1')$Sex='男';
$Doctor_Name=$_REQUEST['Doctor_Name'];
$Doctor_Fee=$_REQUEST['Doctor_Fee'];
$Depart_Name=$_REQUEST['Depart_Name'];
$Doctor_Level=$_REQUEST['Doctor_Level'];
$doctor_type=$Depart_Name;
if($Doctor_Level=='1'){
	$doctor_type.="一级医师";
}else if($Doctor_Level=='2'){
	$doctor_type.="二级医师";
}else if($Doctor_Level=='2'){
	$doctor_type.="三级医师";
}else{
	$doctor_type.=$Depart_Name;
}
$Doctor_Name=$_REQUEST['Doctor_Name'];
$Reservation_PayTime=$_REQUEST['Reservation_PayTime'];
$html=<<<EOF
		<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>

	<body>
		<div>
			<div style="text-align: center">
				<h1>$title</h1>
			</div>
			<div id="content">
				<div>
				<table cellspacing=0 cellpadding=0 >
							<tr style="background-color: #000000">
								<td style="text-align: left;background-color: white" width="40px">序号</td>
								<td style="text-align: left;background-color: white" width="100px">$Reservation_ID</td>
								<td style="text-align: right;background-color: white" width="420px">温馨提示:您的就诊时间为：$Reservation_Time</td>
							</tr>
				</table>
	            <br />
				<table id="back_tb" border="1" style="margin-left: 30px"  cellspacing=0 cellpadding=0 >
							<tr>
								<td style="text-align: center" width="80px">身份证号</td>
								<td style="text-align: center" width="160px">$Identity_ID</td>
								<td style="text-align: center" width="80px">姓名</td>
								<td style="text-align: center" width="80px">$User_Name</td>
								<td style="text-align: center" width="80px">性别</td>
								<td style="text-align: center" width="80px">$Sex</td>
							</tr>
							<tr>
								<td style="text-align: center" width="80px">现金支付(￥)</td>
								<td style="text-align: center" width="160px">&nbsp;0.00&nbsp;</td>
								<td style="text-align: center" width="80px">卡支付(￥)</td>
								<td style="text-align: center" width="80px">&nbsp;0.00&nbsp;</td>
								<td style="text-align: center" width="80px">网上支付(￥)</td>
								<td style="text-align: center" width="80px">&nbsp;$Doctor_Fee&nbsp;</td>
							</tr>
						
				</table>
				
        	
				<br /><br />
				<table cellspacing=0 cellpadding=0 >
							<tr style="background-color: #000000">
								<td style="text-align: left;background-color: white;font-size: 10px" width="40px">号别:</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="150px">$doctor_type</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="40px">医生:</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="150px">$Doctor_Name</td>
							</tr>
				</table>
				<br />
			
				<span>_____________________________________________________________________________________________________________________</span>
		
				<br />
				
				<table cellspacing=0 cellpadding=0 >
							<tr style="background-color: #000000">
								<td style="text-align: left;background-color: white;font-size: 10px" width="140px">预约已付费：预约平台</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="40px"></td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="380px">$Reservation_PayTime</td>
							</tr>
				</table>
			</div>
	</body>
</html>
EOF;
$html_arr[0]=$html;
$date=date('Ymd');
$filename="AppointSheet_print".$date.".pdf";
gen_pdf($filename,$page_num,$html_arr);
?>