<?php
if(!isset($_SESSION))session_start();
//print_r($_SESSION);
?>

<html>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
    <script src="../include/sha1.js"></script>
    <script src="../include/jquery-2.1.1.js"></script>
    <link href="../include/main.css" rel="stylesheet" type="text/css" />
	<link href="../css/CurReservation.css" rel="stylesheet" type="text/css" />
	<script src="../js/CurReservation.js"> </script>	
	<input style="display: none" id="User_ID" value="<?php echo $_SESSION['User_ID']  ?>" />
	<table id="reservation_tb">
		<tr>
			<td id="num">序号</td>
			<td id="reservation_time">预约时间</td>
			<td id="reservation_doctor">预约医生</td>
			<td id="op_time">操作时间</td>
			<td id="reservation_detail">详情</td>
			<td id="op">打印操作</td>	
			<td id="pay">支付</td>
			<td id="cancel">取消预约</td>
		</tr>
		
		<tr id="nosignal" style="display: none">
			<td colspan="7">当前暂无预约记录</td>
			
		</tr>
	</table>
	<input type="button" onclick="test()"  value="test" />
	<div id="detail_area" style="display: none">
		<span class="tag">预约医院</span> 
		<span class="tag_1" id="Hospital_Name"></span> 
		<br />
		<span class="tag">医院地址</span>
		<span class="tag_1" id="Hospital_Location"></span> 
		<br />
		<span class="tag">预约科室</span>
		<span class="tag_1" id="Depart_Name"></span> 
		<br />
		<span class="tag">预约医生</span>
		<span class="tag_1" id="Doctor_Name"></span> 
		<br />
		<span class="tag">医生级别</span>
		<span class="tag_1" id="Doctor_Level"></span> 
		<br />
		<span class="tag">症状描述</span><br />
		<textarea id="Reseration_Symptom" disabled="disabled"></textarea>
		<br />
		<span class="tag">预约时间</span>
		<span class="tag_1" id="Reservation_Time"></span> 
		<br />
		<span class="tag">挂号费￥ </span>
		<span class="tag_1" id="Doctor_Fee"></span> 
		<br />
		<span class="tag">支付状态</span>
		<span class="tag_1" id="Reservation_Payed"></span> 
		<input type="button" class="pay_btn" id="pay_btn" value="支付" onclick="Pay(this)" />
		<br />
		
	</div>
</html>
