<?php
/**
 * analyseInfo.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-11,created by Xu Guozhi
 */
include header_inc();
 ?>
 <script>
 function showDay(obj){
	if(obj.value==2){
$('#startDayTr').show();
		}else{
			$('#startDayTr').hide();
			}
	 }
 function checkInt(obj){
	 var v = obj.value;
	 if(!/\d+$/.test(v)){
		alert("请输入数字");
		obj.select();
		 }
	 }
//
 function checkValue(id,flag) {
 	var value = $("#"+id).val();
 	if(isNull(value)){
 		$('#'+id).removeClass();
 		$('#'+id).addClass('inputError');
 		$('#'+id+'Tip').html('参数不能为空！');
 	//	$('#'+id).focus();
 		return false;
 	}
	if(flag ==0){
		if((/^\d+\.\d+$/.test(value))&& (value>0)&&(value<1)){	 	
	 		$('#'+id).addClass('inputRight');
	 	 	$('#'+id+'Tip').html('');
	 	 	return true;
		}else{
	 		$('#'+id).removeClass();
	 		$('#'+id).addClass('inputError');
	 		$('#'+id+'Tip').html('参数必须大于0小于1！');
	 		//$('#'+id).focus();
	 		return false;
	 	}
	}
	if(flag ==1){
		if((/^\d+$/.test(value))){
	 		$('#'+id).addClass('inputRight');
	 	 	$('#'+id+'Tip').html('');
	 	 	return true;
	 	}else{
	 		$('#'+id).removeClass();
	 		$('#'+id).addClass('inputError');
	 		$('#'+id+'Tip').html('参数必须为正整数');
	 		//$('#'+id).focus();
	 		return false;
	 	}
	}

 	$('#'+id).addClass('inputRight');
 	$('#'+id+'Tip').html('');
 	return true;
 }
 function isNull(str){
		if(str==null)return true;
		return false;
	}

 function savePlan(){

	$.ajax({
		url:"learnCfgInfo.php?cmd=save",
		data:{
			id:$("#traceId").val(),
			serviceId:$("#serviceId").val(),
			param1:$("#param1").val(),
			param2:$("#param2").val(),
			param3:$("#param3").val(),
			param4:$("#param4").val(),
			param5:$("#param5").val(),
			param6:$("#param6").val(),
			param7:$("#param7").val(),
			startTime:$("#startTime").val(),
			endTime:$("#endTime").val()
		},
		type:"post",
		dataType:"text",
		success:function(data){
			
			if(data=="OK"){
				artDialog({content:'保存成功！', style:'succeed'}, function(){
					window.location.href="learnCfg.php";
				});
			}else{
				artDialog({content:'保存失败！', style:'error'}, function(){
					window.location.href="learnCfg.php";
				});
				
			}
		}
	});		
 } 
 </script>
 <body>
 <div>
	<div><h5 class="title102"><em>三层关联挖掘计划</em> <span ></span></h5></div>
	<div class="box102 p20"><form action="?cmd=save" method="post">
		<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
			<tbody>
				<tr>
					<th width="20%">数据库</th><td><select name="sch[ServiceID]" id="serviceId" style="width:250px;">
					<?php foreach($services as $service){?><option value="<?php echo $service['ServiceId']?>" <?php if($service['ServiceId']==$sch['ServiceId']) echo "selected"?>><?php echo $service['ServerName'].":".$service['Name'].":".$service['ServiceName']?><?php }?>
					</select></td>
					</tr>
					<tr>
						<th>HTTP支持度阈值</th>
						<td><input type="text" name="sch[param2]" id="param2" value="<?php echo $sch['param2']?>" onblur="checkValue('param2',0);" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param2Tip'></span></td>
					</tr>
					<tr>
						<th>SQL支持度阈值</th>
						<td><input type="text" name="sch[param3]" id="param3" value="<?php echo $sch['param3']?>" onblur="checkValue('param3',0);" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param3Tip'></span></td>
					</tr>
					<tr>
						<th>2项集支持度阈值 </th>
						<td><input type="text" name="sch[param4]" id="param4" value="<?php echo $sch['param4']?>" onblur="checkValue('param4',0);" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param4Tip'></span></td>
					</tr>
					<tr>
						<th>实时监测sql请求时间窗</th>
						<td><input type="text" name="sch[param5]" id="param5" value="<?php echo $sch['param5']?>" onblur="checkValue('param5',1);" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param5Tip'></span></td>
					</tr>
					<tr>
						<th>实时监测http请求时间窗</th>
						<td><input type="text" name="sch[param6]" id="param6" value="<?php echo $sch['param6']?>" onblur="checkValue('param6',1);" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param6Tip'></span></td>
					</tr>
					<tr>
						<th>SQL序列相似度阈值</th>
						<td><input type="text" name="sch[param7]" id="param7" value="<?php echo $sch['param7']?>" onblur="checkValue('param7',0);" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param7Tip'></span></td>
					</tr>
					<tr>
						<th>选择开始执行的日期</th>
						<td><input type="text" name="sch[startTime]" id="startTime" value="<?php echo $sch['startTime']?>" class="Wdate" onClick="WdatePicker()" style="width:250px;"></td>
					</tr>
					<tr>
						<th>选择结束执行的日期</th>
						<td><input type="text" name="sch[endTime]" id="endTime" value="<?php echo $sch['endTime']?>" class="Wdate" onClick="WdatePicker()" style="width:250px;"></td>
					</tr>
					<input type="hidden" name="sch[traceId]" id="traceId" value="<?php echo $sch['traceId']?>"/>
					<tr><td colspan="2"><input type="button" class="tijiao" value="保存" onclick="savePlan();"><input type="reset" class="repire" value="重置"></td></tr>               	
			</tbody>
		 </table></form>                            
	</div> 
</div> 
 </body>
 </html>