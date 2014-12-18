<?php
/**
 * addSqlInj.tpl.php-.
 * @modification history 
 * ---------------------
 * 2014-4-25,created by zhangxin
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

 function saveSqlInj(){
	 var value = $("#sqlsen").val();
	 	
	 if(value==""||value==null){
		 alert("SQL注入语句不能为空！");
		 obj.select();
	 	}
   
	 
	$.ajax({
		url:"addSqlInj.php?cmd=save",
		data:{
			sqlId:$("#sqlId").val(),
			sqlsen:$("#sqlsen").val(),
			focusseq:$("#focusseq").val(),
			approxseq:$("#approxseq").val()	
		},
		type:"post",
		dataType:"text",
		success:function(data){
			
			if(data=="OK"){
				artDialog({content:'保存成功！', style:'succeed'}, function(){
					window.location.href="kbaseView.php";
				});
			}else{
				artDialog({content:'保存失败！', style:'error'}, function(){
					window.location.href="kbaseView.php";
				});
				
			}
		}
	});		
 } 
 </script>
 <body>
 <div>
	<div><h5 class="title102"><em>添加SQL注入攻击规则</em> <span ></span></h5></div>
	<div class="box102 p20"><form action="?cmd=save" method="post">
		<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
			<tbody>
				<tr>
					<th width="10%" style="text-align:center;">SQL注入语句</th>
					<td><input type="text" name="sqlsen" id="sqlsen" value="<?php echo strlen(trim($sq['SQLSeq']))==0?"":$sq['SQLSeq']?>" style="width:250px;"/><span style="color:red">*</span></td>
				</tr>
				<tr>
					<th style="text-align:center;">关注序列</th>
					<td><input type="text" name="focusseq" id="focusseq" value="<?php echo strlen(trim($sq['FocusSeq']))==0?"":$sq['FocusSeq']?>" style="width:250px;"/></td>
				</t>
				<tr>
					<th style="text-align:center;">近似序列</th>
					<td><input type="text" name="approxseq" id="approxseq" value="<?php echo strlen(trim($sq['ApproxSeq']))==0?"":$sq['ApproxSeq']?>" style="width:250px;"/></td>
				</tr>				
				<input type="hidden" name="sqlId" id="sqlId" value="<?php echo $sq['SQLInjID']?>"/>
				<tr><td colspan="2"><input type="button" class="tijiao" value="保存" onclick="saveSqlInj();"><input type="reset" class="repire" value="重置"></td></tr>               	
			</tbody>
		 </table></form>                            
	</div> 
</div> 
 </body>
 </html>