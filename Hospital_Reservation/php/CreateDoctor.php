<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<head>
		
		<link href="../css/CreateDoctor.css" rel="stylesheet" type="text/css" />
	
        <script src="../include/artDialog/artDialog.js?skin=default"></script>
	    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
		<script src="../include/jquery-2.1.1.js"></script>
		<script type="text/javascript" src="../include/qiniu_adapter/demo/js/plupload.full.min.js"></script>
		<script type="text/javascript" src="../include/qiniu_adapter/demo/js/qiniu.js"></script>
		<script type="text/javascript" src="../include/qiniu_adapter/demo/js/hospital.js"></script>
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