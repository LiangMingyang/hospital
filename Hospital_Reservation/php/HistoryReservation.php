<!DOCTYPE html >
<html>
<?php
date_default_timezone_set('PRC');
?>
<head>

    <script src="../include/jquery-2.1.1.js"></script>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <script src="../include/My97DatePicker/WdatePicker.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/flexigrid/css/flexigrid.css" />
    <script type="text/javascript" src="../include/flexigrid/jquery-1.2.3.pack.js"></script> 
    <script type="text/javascript" src="../include/flexigrid/flexigrid.js"></script>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
    <script src="../include/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
    <script src="../js/HistoryReservation.js"></script>
    <link href="../css/HistoryReservation.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="search_area">
	<p>预约起始时间</p> 
	<input name="StartDate" id="StartDate" 
		   class="Wdate" value="<?php echo date('Y-m-d 00:00:00') ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
    <p>预约截止时间</p> 
    <input name="EndDate" id="EndDate" 
			class="Wdate" value="<?php echo date('Y-m-d 23:59:59') ?>"onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">  
	<input type="button" readonly="readonly" id="search" onclick="search()" value="搜索"/>
    
</div>
<br /><br /><br />
<div id="presentation_area">
	<table id="history_tb"></table>
</div>   
<div id="addIn_area" style="display:none">
	<table id="op_add">
		<tr>
			<td style="text-align: center; font-family: 楷体">转账金额</td>
			<td>
				<input id="add_sum" type="text" style="" />

			</td>
			<td style="font-family: 楷体">元</td>
			<td>
				<select>
					<option>默认</option>
				</select>
			</td>
		</tr>
		<tr >
			<td colspan="3" align="center">
				<input type="button" class="button rosy" onclick="Add_In_OP()" value="确认"/>
			</td>
			
		</tr>
	</table>
</div>
<div id="type_info" style="display: none">

	 <table id="type_tb" style="border: 1px" >
	 	<tbody id="tbd">

	 	</tbody>
	 </table>
	 <div>
	 		<input type="button" id="type_op_btn" class="button green" value="自定义类型" onclick="self_add_type()" />
	 		<input type="text" 
	        	id="type_input_area"
	        	value="请输入自定义类型" 
	        	onmouseover="$(this).focus()"
	        	onmouseout="if($(this).val()=='')$(this).val('请输入自定义类型');" 
	        	onfocus="$(this).select()" 
	        	onclick="if($(this).val()=='请输入自定义类型')this.value=''"
	        	style="display:none"/>
	 </div>
	 <div>
	 		<input type="button" id="del_type_op_btn" class="button grey" value="删除类型" onclick="del_type()" />
	 </div>
</div>
</body>
</html>