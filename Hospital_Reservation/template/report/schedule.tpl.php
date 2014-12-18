<?php
/**
 * schedule.tpl.php-.
 * @author Liumoyao
 *
 * @copyright Copyright (c) 2014, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2014-1-6,created by LiuMoyao
 */
include header_inc();
 ?>
 <script>
 $(function(){
	 $('#newSchedule').dialog({
		 	autoOpen: false,
			resizable: true,
			height:'auto',
			width:'auto',
			modal: true,
			position:"top",
			title:"创建新日程",
			buttons: {
				"确定": function(){
					if(checkAll()){
						$.ajax({
					        url : 'schedule.php?cmd=generate',
					        type : 'POST',
					        dataType : 'text',
					        data:{
// 					        	schema:$('#schema:radio:checked').val(),
// 					        	schema:$("input[name='schema'][checked]").val(),
					        	schema:$("input[name='schema']:checked").val(),  
// 					        	schema:$("#schema").find("[checked]").val(),
					        	weekday:$("#weekday").val(),
						        day:$("#day").val(),
							    time:$("#time").val(),
								format:$("#format").val(),
								template:$("#template").val(),
								range:$("#range").val()
						    },
					        success : function(data) {
						        if(data == 'OK') {
					        		artDialog({content:'创建成功！', style:'succeed'}, function(){
									});
					        		window.location.href="schedule.php";
					        	}else if(data == 'EXSIT'){
					        		artDialog({content:"已存在相同日程！", style:'error'}, function(){
									});
						        }else{
					        		artDialog({content:"服务器出错，请重新创建！", style:'error'}, function(){
									});
								}
					        	
					        }
				   		});
					//	document.newScheduleFrm.submit();
						$(this).dialog("close");
					}
				},
				"取消": function() {
					$( this ).dialog( "close" );
				}
			}
	 });

	 
});
 
 function reportPage(pageNo)
 {
	 
	 if(pageNo == -1) {
		 pageNo = $('#reportPageNum').val();
	 }
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#pageCountHidden").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 var currentPageNo = parseInt($(".numon").html());
		 if(parseInt(pageNo)==currentPageNo){
			alert("当前为"+pageNo+"页");
		 } else{
			 tplId = $("#tplIdHidden").val();
			 window.location.href="report.php?tplId="+tplId+"&page=reportPage&pageNo="+pageNo;
		 }
		 
	 }
	 
 }

 function deleteSchedule(schID)
 {
	 $.post(WEB_ROOT+'report/schedule.php?schID='+schID+'&cmd=delete',
			function(data){
			if(data == "OK"){
//				alert("删除成功！");
				artDialog({content:'删除成功！', style:'succeed'}, function(){
					window.location.href="schedule.php";
				});
			} else {
//				alert("服务器出错，删除失败！请重试！");
				artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
					window.location.href="schedule.php";
				});
			} 
			
		});
 }

function checkAll()
{
	var time = $('#time').val();
	var format = $("#format").val();
	var template = $("#template").val();
	var schema = $("input[name='schema']:checked").val();
    var chkObjs = document.getElementsByName("schema");
    var i = 0;
    for(i=0;i<chkObjs.length;i++){
    	if(chkObjs[i].checked){
        	break;
        }
    }
    if(i==chkObjs.length){
		alert("请填写全部内容！");
		return false;
    }
	if(time=="" || format=="" || template==""){		
		alert("请填写全部内容！");
		return false;
	}
	if(document.newScheduleFrm.schema[2].checked){
		var day = $('#day').val();

		if(day==""){			
			alert("请填写全部内容！");
			return false;
		}
	}		
	var timeArray=time.split(':');
	if(timeArray[0]<"0" || timeArray[0]>"23" || timeArray[1]<"0" || timeArray[1]>"60" || timeArray[2]<"0" || timeArray[2]>"60"){
		alert("请输入正确的时间格式！");
		return false;
	}

	return true;
}
 </script>
 <body>
<h5 class="title102"><em>已创建的日程</em><span style="padding-top:5px"><a href="javascript:void(0)" onclick="$('#newSchedule').dialog('open');" class="neibu"><b>创建日程</b></a></span></h5>
<div class="box102 p20">

<!-- 
<input type="hidden" name="reportPageNum" id="reportPageNum" value="<?php echo $pageNo?>"/>
 -->
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">		
		<tr><th>编号</th><th>模式</th><th>执行时间</th><th>格式</th><th>保留时间</th><th>创建日期</th><th>操作</th></tr>
					<?php if($scheduleList){foreach ($scheduleList as $schedule){?>
		<tr>
			<td><?php echo $schedule['schID']?></td>
			<td><?php echo $schedule['tmp']?> </td>
			<td><?php if($schedule['tmp']=="每日"){echo $schedule['time'];}else if($schedule['tmp']=="每周"){echo $s->getWeekday($schedule['day']).'/'.$schedule['time'];}else{echo $schedule['day'].'日/'.$schedule['time'];}?></td>
			<td><?php echo $schedule['format']?></td>
			<td><?php if($schedule['range']=="0"){echo "半年";}else if($schedule['range']=="1"){echo "1年";}else{echo "2年";}?></td>
			<td><?php echo $schedule['timestamp']?></td>
			<td class="border_r0"><a href="#" class="neibu" style="color: white;" onclick="deleteSchedule(<?php echo $schedule['schID']?>);">删除</a></td>
		</tr>
		<?php }}?>				
	</table>
</div>

<div id="newSchedule" style="display:none;">
	<form action="" target="_self" name="newScheduleFrm" method="post">
	<table border="0" cellspacing="10" cellpadding="0" width="100%" class="tab5" style="line-height:250%">
		<tr><font color="red">*</font>报表模式：<br/></tr>
		<tr>&nbsp&nbsp&nbsp&nbsp<input type="radio" name="schema" id="schema" value="每日"/>每日</tr>
		
		<tr><th>&nbsp&nbsp&nbsp&nbsp<input type="radio" name="schema" id="schema" value="每周" />每周</th>
		<td><select name="weekday" id="weekday">
		<option value="1">周一</option>
		<option value="2">周二</option>
		<option value="3">周三</option>
		<option value="4">周四</option>
		<option value="5">周五</option>
		<option value="6">周六</option>
		<option value="7">周日</option>
		</select></td></tr>
		<tr><th>&nbsp&nbsp&nbsp&nbsp<input type="radio" name="schema" id="schema" value="每月">每月</th>
		<td><select name="day" id="day">
		<?php for($i=1;$i<32;$i++){?><option value="<?php echo $i?>"><?php echo $i?></option><?php }?>
		</select>日</td></tr>

		<tr><th><font color="red">*</font>生成报表的时刻：</th>
		<td><input name="time" id="time"  class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
		</td></tr>
		
		<tr><th><font color="red">*</font>报表格式：</th>
		<td><select name="format" id="format"><option value="pdf">pdf</option><option value="html">html</option></select><br/>
		</td></tr>
		
		<tr><th><font color="red">*</font>报表模板：</th>
		<td><select name="template" id="template">
			<option value="<?php echo $templateList['TplID']?>"><?php echo $templateList['TplName']?></option>
		</select></td></tr>
		
		<tr><th><font color="red">*</font>报表保留时间：</th>
		<td><select name="range" id="range">
		<option value="0">半年</option>
		<option value="1">1年</option>
		<option value="2">2年</option>
		</select>
		</td></tr>
		<input type="hidden" name="cmd" value="generate"/>
	</table>
	</form>
</div>
 </body>
 </html>