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
 function checkValue(id) {
 	var value = $("#"+id).val();
 	if(isNull(value)){
 		$('#'+id).removeClass();
 		$('#'+id).addClass('inputError');
 		$('#'+id+'Tip').html('参数不能为空！');
		// $("#"+id).val('');
 	//	$('#'+id).focus();
 		return false;
 	}

 	if((/^\d+\.\d+$/.test(value))&& (value>0)&&(value<1)){
 		$('#'+id).addClass('inputRight');
 	 	$('#'+id+'Tip').html('');
		
 	 	return true;
 	}else {
 		$('#'+id).removeClass();
 		$('#'+id).addClass('inputError');
 		$('#'+id+'Tip').html('参数必须大于0小于1！');
		// $("#"+id).val('');
 		//$('#'+id).focus();
 		return false;
 	}
 	$('#'+id).addClass('inputRight');
 	$('#'+id+'Tip').html('');
 	return true;
 }
 function isNull(str){
		if(str==null)return true;
		return false;
	}
/*added by gengjinkun 2014-08-19*/
 function check_danger(str){
				var reg = /[|&;$%@,\'"<>()+]/;
				//var spec=/[,.<>{}~!@#$%^&*]/;
				var res=reg.test(str);
			if(res){
				
					return true;
				}
			else if(str.length>64){
				return true;
			}
			else{
					return false;
			}
	
}
 function savePlan(){
	 
	
	var check1=$("#AnalysisId").val();
	var check2=$("#serviceId").val();
	var check3=$("#useCloud").val();
	var check4=$("#param1").val();
	var check5=$("#param2").val();
	var check6=$("#param3").val();
	var check7=$("#param4").val();
	var check8=$("#param5").val();
	var check9=$("#AnalysisStartDay").val();
	var check10=$("#LogRange").val();
	
	
	if(check_danger(check1)||check_danger(check2)
		||check_danger(check3)||check_danger(check4)
		||check_danger(check5)||check_danger(check6)
		||check_danger(check7)||check_danger(check8)
		||check_danger(check9)||check_danger(check10)){
               artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
	}
	
	$.ajax({
		url:"analyseInfo.php?cmd=save",
		data:{
			AnalysisId:$("#AnalysisId").val(),
			serviceId:$("#serviceId").val(),
			useCloud:$("#useCloud").val(),
			param1:$("#param1").val(),
			param2:$("#param2").val(),
			param3:$("#param3").val(),
			param4:$("#param4").val(),
			param5:$("#param5").val(),
			AnalysisStartDay:$("#AnalysisStartDay").val(),
			LogRange:$("#LogRange").val()
		},
		type:"post",
		dataType:"text",
		success:function(data){
			
			if(data=="OK"){
				artDialog({content:'保存成功！', style:'succeed'}, function(){
					window.location.href="analyse.php";
				});
			}else{
				artDialog({content:'保存失败！', style:'error'}, function(){
					window.location.href="analyse.php";
				});
				
			}
		}
	});		
 } 
 </script>
 <body>
 <div>
	<div><h5 class="title102"><em>用户行为模式挖掘计划</em> <span ></span></h5></div>
	<div class="box102 p20"><form action="?cmd=save" method="post">
		<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
			<tbody>
				<tr>
					<th width="20%">数据库</th><td><select name="sch[ServiceID]" id="serviceId" style="width:250px;">
					<?php foreach($services as $service){?><option value="<?php echo $service['ServiceId']?>" <?php if($service['ServiceId']==$sch['ServiceId']) echo "selected"?>><?php echo $service['ServerName'].":".$service['Name'].":".$service['ServiceName']?><?php }?>
					</select></td>
					</tr>
					<tr><th>是否启用云平台</th><td><select name="sch[UseCloud]" id="useCloud" style="width:250px;"><option value="0" <?php if($sch['UseCloud']==0)echo "selected"?>>关闭</option><option value="1" <?php if($sch['UseCloud']==1)echo "selected"?>>启用</option></select></td></tr>
					<tr>
						<th>副属性支持度阈值</th>
						<td><input type="text" name="sch[param1]" id="param1" value="<?php echo strlen(trim($sch['param1']))==0?0.15:$sch['param1']?>" onblur="checkValue('param1');" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param1Tip'></span></td>
					</tr>
					<tr>
						<th>主属性支持度阈值</th>
						<td><input type="text" name="sch[param2]" id="param2" value="<?php echo strlen(trim($sch['param2']))==0?0.05:$sch['param2']?>" onblur="checkValue('param2');" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param2Tip'></span></td>
					</tr>
					<tr>
						<th>正常行为置信度</th>
						<td><input type="text" name="sch[param3]" id="param3" value="<?php echo strlen(trim($sch['param3']))==0?0.6:$sch['param3']?>" onblur="checkValue('param3');" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param3Tip'></span></td>
					</tr>
					<tr>
						<th>异常行为置信度</th>
						<td><input type="text" name="sch[param4]" id="param4" value="<?php echo strlen(trim($sch['param4']))==0?0.7:$sch['param4']?>" onblur="checkValue('param4');" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param4Tip'></span></td>
					</tr>
					<tr>
						<th>相关度</th>
						<td><input type="text" name="sch[param5]" id="param5" value="<?php echo strlen(trim($sch['param5']))==0?0.004:$sch['param5']?>" onblur="checkValue('param5');" style="width:250px;"/><span style="color:red">*</span><span class="errorTip" id='param5Tip'></span></td>
					</tr>
					<tr><th>分析的日志范围</th><td><select name="sch[LogRange]" id="LogRange" onchange="showDay(this)" style="width:250px;"><option value="0"<?php if($sch[LogRange]==0)echo "selected"?>>全部分析</option><option value="1"<?php if($sch[LogRange]==1)echo "selected"?>>从上次分析后的日志开始</option><option value="2"<?php if($sch[LogRange]==2)echo "selected"?>>从指定日期开始</option></select></td></tr>
					<tr style="display:<?php echo ($sch[LogRange]==2?"": "none")?>" id="startDayTr"><th>选择开始执行的日期</th><td><input type="text" name="sch[AnalysisStartDay]" id="AnalysisStartDay" value="<?php echo $sch[AnalysisStartDay]?>" class="Wdate" onClick="WdatePicker()"></td></tr>
					<input type="hidden" name="sch[AnalysisId]" id="AnalysisId" value="<?php echo $sch['AnalysisId']?>"/>
					<tr><td colspan="2"><input type="button" class="tijiao" value="保存" onclick="savePlan();"><input type="reset" class="repire" value="重置"></td></tr>               	
			</tbody>
		 </table></form>                            
	</div> 
</div> 
 </body>
 </html>