<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<head>
		<link href="../css/CreateDoctor.css" rel="stylesheet" type="text/css" />
	    <script src="../include/jquery-2.1.1.js"></script>
        <script src="../include/artDialog/artDialog.js?skin=default"></script>
	    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
	    <script src="../include/uploadPreview/uploadPreview.js"></script>
	    <script src="../include/AjaxFileUploaderV2.1/ajaxfileupload.js"></script>
	    <script language="JavaScript" src="../include/sha1.js"></script>
	    <script language="JavaScript" src="../js/CreateDoctor.js"> </script>
	</head>
	<body>
		<div id="title">
			<p>添加医生</p>
		</div>
		<div id="content">
			<br />
			<table id="Doctor_Info_tb">
				<tr>	
					<td id="picture_area" rowspan="8">  
							<img onclick="upload_picture()" id="doctor_picture" src='../images/picture_upload_logo.jpg' />
							<input type="file" id="scan_file" name="PicturetoUpload" style="display: none"/>
					        <br />
					        <a class="pic_option" id="submitPic" onclick="submitPicture()">提交</a>
						    <a class="pic_option" id="cancelPic" onclick="cancelPicture()">移除</a> 
					        <input type="text" id="picture_url" value="" style="display: none" />
					        <input type="text" id="picture_name" value="" style="display: none" />
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
						<span id="tag_depart_name">选择医院及科室</span>
						<select id="Hospital_ID" onchange="show_depart()">
							<option value="-1">选择医院</option>
						</select>
						<select id="Depart_ID" >
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
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" id="confirm_info_btn" value="确定" onclick="confirm_info()"/>
					</td>
				</tr>
			</table>
			<div id="Hospital_Select">
				
			</div>
		</div>
	</body>
</html>