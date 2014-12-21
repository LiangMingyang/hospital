<?php
    if(!isset($_SESSION))
	 session_start();
?>
<html>
	<link href="../css/ConfigHospital.css" rel="stylesheet" type="text/css" />
	<script src="../include/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="../include/qiniu_adapter/demo/js/plupload.full.min.js"></script>
	<script type="text/javascript" src="../include/qiniu_adapter/demo/js/qiniu.js"></script>
	<script type="text/javascript" src="../include/qiniu_adapter/demo/js/hospital.js"></script>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
	<script src="../include/artDialog/plugins/iframeTools.source.js"></script>
	<script src="../include/My97DatePicker/WdatePicker.js"></script>
	<script language="JavaScript" src="../include/sha1.js"></script>
	<script language="JavaScript" src="../js/ConfigHospital.js"> </script>
    <body>
		<div id="title">
			<p>配置医院信息</p>
		</div>
		<div id="content">
			<div id="title_introduction">
				<span>当前共有医院&nbsp;<span id="hospital_num"></span>&nbsp;家</span>
			</div>
			
			<div id="content_search">
				<select id="Province" onchange="get_area()">
					<option value="-1">选择省份</option>
				</select>
				<select id="Area">
					<option value="-1">选择地区</option>
				</select>
				<span id="level_tag">等级</span>
		        <select id="Hospital_Level">
		        	<option value="-1">选择等级</option>
		        	<option value="31">三级甲等</option>
		        	<option value="32">三级乙等</option>
		        	<option value="33">三级丙等</option>
		        	<option value="21">二级甲等</option>
		        	<option value="22">二级乙等</option>
		        	<option value="23">二级丙等</option>
		        	<option value="11">一级甲等</option>
		        	<option value="12">一级乙等</option>
		        	<option value="13">一级丙等</option>
		        </select>
		        <input type="button" id="search" value="查找" onclick="search()" />
		  	</div>
			<table id="hospital_tb">
			</table>
			<div id="page_div" style="display: none">
				<span>共</span><span id="page_num"></span><span>页,</span><span id="num"></span><span>条记录</span>
				<span id="GO_tag" onclick="goPage()">GO&nbsp;&nbsp;</span><span>第</span>
				<input type="text" id="page_no" value="1"/>
				<span>页</span>
			</div>
			<div id="no_signal" style="display: none">
				<span >无符合条件的结果</span>
			</div>
					
				
		</div>
		<div id="content_info">
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
						<a id="add_depart_btn" onclick="config_depart()">管理科室</a>
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
						<input type="button" id="del_2"  value="删除" onclick="del_op()"/>
						<input type="button" id="close_btn" value="关闭" onclick="close_div()"/>
					
					</td>
				</tr>
			</table>
			</form>
		</div>
		<div id="add_depart_div" style="display: none">
			<span>现有科室</span>
			<table id="depart_info_tb">
			</table>
			<span>待增加科室名</span>
			<input type="text" id="Depart_Name" />
			<input type="button" id="confirm_2"  value="确定" onclick="confirm_op()"/>
			<br />
			<span id="repeat_signal" style="display: none">该医院已经存在此科室名</span>
			<br />
			<span>待删除科室名</span>
			<select id="del_depart_select">
				
			</select>
			<input type="button" value="删除" id="del_depart_btn"  onclick="del_Dpart()"/>
			<br />
		</div>
	</body>
	
</html>