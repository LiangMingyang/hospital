<?php
require_once("gen_pdf.php");
if(!isset($_SESSION))session_start();
//print_r($_SESSION);
$Reservation_Time=$_REQUEST['Reservation_Time'];
$Reseration_Symptom=$_REQUEST['Reseration_Symptom'];
$Hospital_Name=$_REQUEST['Hospital_Name'];
$title=$Hospital_Name."预约单";
$Hospital_Location=$_REQUEST['Hospital_Location'];
$Depart_Name=$_REQUEST['Depart_Name'];
$Reservation_ID=$_REQUEST['Reservation_ID'];
$User_Name=$_SESSION['User_Name'];
$Birthday=$_SESSION['Birthday'];
$age=20;
$Sex=$_SESSION['Sex'];
if($Sex=='0')$Sex='女';
else if($Sex=='1')$Sex='男';
$html=<<<EOF
		<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div align="center">
			<div style="text-align: center">
				<h1>$title</h1>
			</div>
			<div id="content" align="center">
				<table cols="6" style="text-align: left">
					<tr>
						<td width="70px">
							<span>预约科室 </span>
						</td>
						<td  width="120px">
							<span class='content_class' id="depart" style="font-weight:700;margin-left:20px;margin-right:30px">
								<u>&nbsp;&nbsp;$Depart_Name&nbsp;&nbsp;</u>
							</span>
						</td>
						<td width="50px">
							<span>预约号</span>
						</td>
						<td width="70px">
							<span class='content_class' id="reservation_id" style="font-weight:700; margin-left:10px; margin-right:20px">
							<u>&nbsp;&nbsp;$Reservation_ID&nbsp;&nbsp;</u>
							</span>
						</td>
						<td width="70px">
							<span>预约时间</span>
						</td>
						<td width="150px">
							<span class='content_class' id="reservation_time" style="font-weight:700; margin-left:10px">
								<u>$Reservation_Time</u>
							</span>
						</td>
					</tr>
					<tr>
						<td>
							<span>姓名</span>
						</td>
						<td>
							<span class='content_class' id="name" style="font-weight:700; margin-left:20px; margin-right:100px;">
							<u>&nbsp;&nbsp;$User_Name&nbsp;&nbsp;</u>
							</span>
						</td>
						<td>
							<span>年龄</span>
						</td>
						<td>
							<span class='content_class' id="age" style="font-weight:700; margin-left:10px; margin-right:40px">
							<u>&nbsp;&nbsp;$age&nbsp;&nbsp;</u>
							</span>
						</td>
					    <td>
					    	<span>性别</span>
					    </td>
					    <td>
					    	<span class='content_class' id="sex" style="font-weight:700; margin-left:10px">
							<u>&nbsp;&nbsp;$Sex&nbsp;&nbsp;</u>
							</span>
					    </td>
					</tr>
					<tr>
						<td colspan="6">
							<span>症状摘要</span>
						</td>
					</tr>
					<tr >
						<td colspan="6" min-height="300px">
						<br/><br/>
						 <table  border="1" width="500px" min-height="300px">
								<tr >
									<td ><br/><br/>
						    			$Reseration_Symptom
									<br/></td>
								</tr>
						 </table>		
								
						</td>
					</tr>
					<tr>
						<td colspan="6">
							<span id="addr_tag" style="font-size: 10px">医院地址:&nbsp;&nbsp;&nbsp;</span>
				            <span id="addr" style="font-size: 10px">$Hospital_Location</span>
						</td>
						
					</tr>
				</table>
			</div>
			
		</div>
	</body>
</html>


EOF;
$html_arr[0]=$html;
$date=date('Ymd');
$filename="ReservationSheet_print".$date.".pdf";
gen_pdf($filename,$page_num,$html_arr);
?>