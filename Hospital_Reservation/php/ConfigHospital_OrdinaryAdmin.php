<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<link href="../css/ConfigHospital_OrdinaryAdmin.css" rel="stylesheet" type="text/css" />
	<script src="../include/jquery-2.1.1.js"></script>
	<script src="../include/uploadPreview/uploadPreview.js"></script>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
	<script src="../include/artDialog/plugins/iframeTools.source.js"></script>
	<script src="../include/My97DatePicker/WdatePicker.js"></script>
	<script src="../include/AjaxFileUploaderV2.1/ajaxfileupload.js"></script>
	<script language="JavaScript" src="../include/sha1.js"></script>
	<script language="JavaScript" src="../js/ConfigHospital_OrdinaryAdmin.js"> </script>
    <body>
		<div id="title">
			<p>配置医院信息</p>
		</div>
		<div id="content">
			<div id="title_introduction">
				<span>当前权限内有医院&nbsp;<span id="hospital_num"></span>&nbsp;家</span>
			</div>
			<table id="hospital_tb">
				<tr>
					<td id="no_signal" style="display:none;cursor:auto; color: red">无符合条件的结果</td>
				</tr>
			</table>
			<div id="page_div" style="display: none">
				<span>共</span><span id="page_num"></span><span>页,</span><span id="num"></span><span>条记录</span>
				<span id="GO_tag" onclick="goPage()">GO&nbsp;&nbsp;</span><span>第</span>
				<input type="text" id="page_no" value="1"/>
				<span>页</span>
			</div>
		</div>
		<div id="content_info">
			<form name="frm" method="post" enctype="multipart/form-data">
			<br />
			<table id="Hospital_Info_tb">
				<tr>	
					<td id="picture_area" rowspan="8">  
							<img onclick="upload_picture()" id="hospital_picture" 
							src='../images/picture_upload_logo.jpg' />
							<input type="file" id="scan_file" name="PicturetoUpload" style="display: none"/>
					        <br />
					        <a class="pic_option" id="submitPic" onclick="submitPicture()">提交</a>
						    <a class="pic_option" id="cancelPic" onclick="cancelPicture()">移除</a> 
					        <input type="text" id="picture_url" style="display: none" />
					        <input type="text" id="picture_name" style="display: none" />
					</td>
					
					
				</tr>
				<tr>
					<td>
						<span id="tag_hospital_name">医院名称</span>
						<input type="text" id="Hospital_Name"/>
						<input type="text" id="Hospital_ID" style="display: none" />
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
						<a id="add_depart_btn" onclick="add_depart()">添加科室</a>
					</td>
					
				</tr>
				<tr>
					<td class="tag">医院简介
					<span id="time_tag">预约时间</span>
					<input name="StartDate" id="Reservation_Start_Time" 
		            class="Wdate" value="00:00:00" onclick="WdatePicker({dateFmt:'HH:mm:ss'})">
		            <span id="little_tag">~</span>
					<input name="EndDate" id="Reservation_End_Time" 
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
					<select id="Province_Info">
					</select>
					&nbsp;
					<select id="Area_Info"></select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						
						<input type="text" id="Hospital_Location"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" id="confirm_info_btn" value="保存" onclick="confirm_info()"/>
						<input type="button" id="close_btn" value="关闭" onclick="close_div()"/>
					
					</td>
				</tr>
			</table>
			</form>
		</div>
		<div id="add_depart_div" style="display: none">
			<span>科室名</span>
			<input type="text" id="Depart_Name" />
			<br />
			<span id="repeat_signal" style="display: none">该医院已经存在此科室名</span>
			<br />
			<input type="button" id="confirm_2"  value="确定" onclick="confirm_op()"/>
			<input type="button" id="cancel_2" value="取消" onclick="cancel_op()" />
		</div>
	</body>
	
</html>