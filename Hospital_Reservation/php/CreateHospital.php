<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<link href="../css/CreateHospital.css" rel="stylesheet" type="text/css" />
	<script src="../include/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="../include/qiniu_adapter/demo/js/plupload.full.min.js"></script>
		<script type="text/javascript" src="../include/qiniu_adapter/demo/js/qiniu.js"></script>
		<script type="text/javascript" src="../include/qiniu_adapter/demo/js/hospital.js"></script>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
	<script src="../include/artDialog/plugins/iframeTools.source.js"></script>
	<script src="../include/My97DatePicker/WdatePicker.js"></script>
	<script language="JavaScript" src="../include/sha1.js"></script>
	<script language="JavaScript" src="../js/CreateHospital.js"> </script>
    <body>
		<div id="title">
			<p>添加医院</p>
		</div>
		
		<div id="content">
			<form name="frm" method="post" enctype="multipart/form-data">
			<br />
			<table id="Hospital_Info_tb">
				<tr>
					
					<td id="picture_area" rowspan="8">  
						    <div id="container">
	        					<a href="#" id="pickfiles">
	        						<img id="hospital_picture" src='http://hospital.qiniudn.com/picture_upload_logo.jpg' />
	        					</a>
      						</div>
					        <input type="text" id="picture_url" style="display: none" />
					</td>
					
					
				</tr>
				<tr>
					<td>
						<span id="tag_hospital_name">医院名称</span>
						<input type="text" id="Hospital_Name"/>
	                    <span id="span_hospital_level">医院等级</span>
						<select id="Hospital_Level">
							<option value="31">三级甲等</option>
							<option value="32">三级乙等</option>
							<option value="33">三级丙等</option>
							<option value="31">二级甲等</option>
							<option value="32">二级乙等</option>
							<option value="33">二级丙等</option>
							<option value="31">一级甲等</option>
							<option value="32">一级乙等</option>
							<option value="33">一级丙等</option>
						</select>
					</td>
					
				</tr>
				<tr>
					<td class="tag">医院简介
					<span id="time_tag">预约时间</span>
					<input name="StartDate" id="StartDate" 
		            class="Wdate" value="00:00:00" onclick="WdatePicker({dateFmt:'HH:mm:ss'})">
		            <span id="little_tag">~</span>
					<input name="EndDate" id="EndDate" 
		            class="Wdate" value="23:59:59" onclick="WdatePicker({dateFmt:'HH:mm:ss'})">	
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea id="Hospital_Introduction"></textarea>
					</td>
				</tr>
				
				<tr>
					<td class="tag" >医院地址
					&nbsp;
					<select id="Province" onchange="show_area()">
						<option value="-1">选择省份</option>
					</select>
					&nbsp;
					<select id="Area">
						<option value="-1">选择地区</option>
					</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="Hospital_Location"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" id="confirm_info_btn" value="确定" onclick="confirm_info()"/>
					</td>
				</tr>
			</table>
			</form>
		</div>
		<div id="province_layer" style="display:none">
				<table id="province">
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
				</table>
				
		</div>
		
		<div id="area_layer" style="display:none">
				<table id="area">
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						
					</tr>
					
				</table>
		</div>
		
	</body>


</html>