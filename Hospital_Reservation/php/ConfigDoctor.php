<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<head>
		<link href="../css/ConfigDoctor.css" rel="stylesheet" type="text/css" />
	    <script src="../include/jquery-2.1.1.js"></script>
        <script src="../include/artDialog/artDialog.js?skin=default"></script>
	    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
	    <script src="../include/uploadPreview/uploadPreview.js"></script>
	    <script src="../include/AjaxFileUploaderV2.1/ajaxfileupload.js"></script>
	    <script language="JavaScript" src="../include/sha1.js"></script>
	    <script language="JavaScript" src="../js/ConfigDoctor.js"> </script>
	</head>
	<body>
		<div id="title">
			<p>配置医生信息</p>
		</div>
		<div id="tag_head">
			<span id="tag_hospital">所属医院</span>
			<select id="Hospital_ID" onchange="show_depart()">
			</select>
			<span id="tag_depart">所属科室</span>
			<select id="Depart_ID">	
			</select>
			<a id="show_doctor_btn" onclick="show_doctor()" >显示医生列表</a>
			<a id="return_doctor_btn" onclick="return_doctor()" style="display: none">回到医生列表</a>
		</div>
		<div id="doctor_area" style="display: none">
			<table id="doctor_tb">
			</table>
			<span id="no_record_signal" style="display: none">没有相关记录</span>
		</div>
		<div id="doctor_info_area" style="display: none">
			<br />
			<table id="Doctor_Info_tb">
				<tr>	
					<td id="picture_area" rowspan="8"> 
						    <div id="container">
	        					<a href="#" id="pickfiles">
	        						<img id="doctor_picture" src='http://hospital.qiniudn.com/picture_upload_logo.jpg' />
	        					</a>
      						</div>
					        <br />
					        <input type="text" id="picture_url" value="" style="display: none" />
					</td>
					
					
				</tr>
				<tr>
					<td>
						<span id="tag_doctor_name">医生姓名</span>
						<input type="text" id="Doctor_Name"/>
						<span id="tag_doctor_level">医生等级</span>
						<select id="Doctor_Level">
							<option value="1">一级医师</option>
							<option value="2">二级医师</option>
							<option value="3">三级医师</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<span id="tag_depart_name">所属科室</span>
						<select id="Depart_ID_1" >
							<option value="-1">选择科室</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<span id="tag_doctor_fee">挂号费&nbsp;&nbsp;</span>
						<input type="text" id="Doctor_Fee" />
						<span id="tag_doctor_limit">挂号上限</span>
						<input type="text" id="Doctor_Limit" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<span id="tag_doctor_major">主治方向</span>
					<br />
						<textarea id="Doctor_Major"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<span>坐诊时间</span>
						<a id="show_duty_time" onclick="show_duty_time()">显示</a>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" id="confirm_info_btn" value="保存配置" onclick="confirm_info()"/>
						<input type="button" id="del_doctor_btn" value="删除医生" onclick="del_doctor()"/>
					</td>
				</tr>
			</table>
		</div>
		<div id="duty_time_div" style="display: none">
			        <input type="text" id="old_duty_time" style="display: none" />
					<span id="tag_duty_time">坐诊时间</span>
					<br />
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="11" />周一上午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="12" />周一下午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="21" />周二上午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="22" />周二下午</label>
					<br />
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="31" />周三上午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="32" />周三下午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="41" />周四上午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="42" />周四下午</label>
					<br />
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="51" />周五上午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="52" />周五下午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="61" />周六上午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="62" />周六下午</label>
					<br />
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="71" />周日上午</label>
					<label><input type="checkbox" class="Duty_Time" name="Duty_Time" value="72" />周日下午</label>
					<br />
					<input type="button" id="save_duty_time_btn" onclick="save_duty_time()" value="保存"/>
					<input type="button" id="close_dlg_btn"  onclick="close_duty_time()" value="关闭"/>
					
		</div>
	</body>
</html>