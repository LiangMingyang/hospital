<?php
/**
 * addFunction.tpl.php-.
 * @modification history 
 * ---------------------
 * 2014-4-25,created by zhangxin
 */
include header_inc();
 ?>
 <script>
/*added by gengjinkun 2014-08-19*/
 function check_danger(str){
		var reg = /[|&;$%@,\'"<>()+]/;
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
 function saveFunction(){
	 var value = $("#functionname").val();
	 var check1=$("#lowver").val();
	var check2=$("#highver").val();
	var check3=$("#parapos").val();
	/*added by gengjinun*/
	 if(check_danger(value)||check_danger(check1)||check_danger(check2)||check_danger(check3)){
               artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
		}

	 if(value==""||value==null){
		 alert("函数名不能为空！");
		 obj.select();
	 	}
	 
	$.ajax({
		url:"addFunction.php?cmd=save",
		data:{
			fid:$("#fid").val(),
			functionname:$("#functionname").val(),
			searchProtocol:$("#searchProtocol").val(),
			lowver:$("#lowver").val(),
			highver:$("#highver").val(),
			parapos:$("#parapos").val()
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
	<div><h5 class="title102"><em>添加漏洞函数</em> <span ></span></h5></div>
	<div class="box102 p20"><form action="?cmd=save" method="post">
		<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
			<tbody>
				<tr>
					<th width="20%">漏洞函数名</th>
					<td><input type="text" name="functionname" id="functionname" value="<?php echo strlen(trim($fun['FName']))==0?"":$fun['FName']?>" style="width:250px;"/><span style="color:red">*</span></td>
				</tr>
				<tr>
				    <th>数据库类型</th>
				    <td>
				    <select id="searchProtocol" name="searchProtocol" style="width: 250px;">
                				<?php 
                				foreach ($protocolList as $pro) {
if($fun['DBTypeID']==$pro['Protocol']){
	?>
	                				<option value="<?php echo $pro['Protocol']?>" selected="selected"><?php echo $pro['Name']?></option>
	                				<?php 
}else {
?>
	                				<option value="<?php echo $pro['Protocol']?>"><?php echo $pro['Name']?></option>
	                				<?php 
}
                					
                				}
                				?>
                			</select>
				    </td>
				</tr>
				<tr>
					<th>可成功利用最低版本</th>
					<td><input type="text" name="lowver" id="lowver" value="<?php echo strlen(trim($fun['LowVer']))==0?"":$fun['LowVer']?>" style="width:250px;"/></td>
				</t>
				<tr>
					<th>可成功利用最高版本</th>
					<td><input type="text" name="highver" id="highver" value="<?php echo strlen(trim($fun['HighVer']))==0?"":$fun['HighVer']?>" style="width:250px;"/></td>
				</tr>
				<tr>
					<th>漏洞参数值位置</th>
					<td><input type="text" name="parapos" id="parapos" value="<?php echo strlen(trim($fun['ParaNum']))==0?"":$fun['ParaNum']?>" style="width:250px;"/></td>
				</tr>
					
				<input type="hidden" name="fid" id="fid" value="<?php echo $fun['FID']?>"/>
				<tr><td colspan="2"><input type="button" class="tijiao" value="保存" onclick="saveFunction();"><input type="reset" class="repire" value="重置"></td></tr>               	
			</tbody>
		 </table></form>                            
	</div> 
</div> 
 </body>
 </html>