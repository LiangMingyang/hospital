<?php
/**
 * PrivilegeAnalyzeInfo.tpl.php-权限分析配置.
 * @author Fu Cheng
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-28,created by Fu Cheng
 */
include header_inc();
 ?>

<!--
<script type="text/javascript" src="input_check.js"></script>
-->
 <script type="text/javascript">
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
 /*Add By Yip Date:2014.8.5*/
var mysqlSpecialChars = [ "_", "%", "[", "]", "^" , "'" , "\""];

function ismysqlSpecialChar(character){ 
    var len = mysqlSpecialChars.length; 
    var ch; 
    for(var i = 0; i < len; i++ )
    { 
        ch = mysqlSpecialChars[i]; 
        if(character == ch) return true; 
    } 
    return false; 
}

function safe_string_escape(str)
{ 
  var len=str.length;
  var targetString=''; 
  for(var i=0;i<len;i++) 
  { 
  	var c=str.charAt(i);
    if (ismysqlSpecialChar(c))
    {
    	targetString+='\\';
    }
    targetString+=c;
  }
  return targetString; 
}
 /****************************/
 function showDay(obj){
	if(obj.value==2){
$('#startDayTr').show();
		}else{
			$('#startDayTr').hide();
			}
	 }
/* function checkInt(obj){
	 var v = obj.value;
	 if(!/\d+$/.test(v)){
		alert("请输入数字");
		obj.select();
		 }
	 }  */

 function checkPwd(obj){
	 var v = obj.value;
	 if(!/\d+$/.test(v)){
		alert("请输入数字");
		obj.select();
		 }
	 }
 function RightAnalyzeSave()
 {
	if(checkUserName()&&checkPassword()){
		return true;
	}
 	return false;
 }
 
 function checkUserName(){
		var username = $('#username').val();
        if(check_danger(username)){
              artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
		      return false;
		} 
		if($.trim(username).length == 0) {
			$('#username').removeClass();
			$('#username').addClass('inputError');
			$('#userNameTip').html('用户名不能为空！');
//			$('#username').focus();
			return false;
		}
		
		if(username.length > 20) {
			$('#username').removeClass();
			$('#username').addClass('inputError');
			$('#userNameTip').html('用户名不能超过20个字符！');
//			$('#username').focus();
			return false;
		}
		 /*Add By Yip Date:2014.8.5*/
		var username_safe=safe_string_escape(username);
		//var username_safe="";
		if (username!=username_safe)
		{
			username=username_safe;
			$('#userNameTip').html('用户名含有特殊字符，会经过特殊处理！');
		}else {$('#userNameTip').html('');}
		$('#username').addClass('inputRight');
		//$('#userNameTip').html('');
		return true;
		/****************************/
}

 function checkSchema() {
	 	var schame = $('#Schema').val();
		
		if($.trim(schame).length == 0) {
			$('#Schema').removeClass();
			$('#Schema').addClass('inputError');
			$('#SchemaTip').html('模式名不能为空！');
//			$('#Schema').focus();
			return false;
		}
		
		if(schame.length > 20) {
			$('#Schema').removeClass();
			$('#Schema').addClass('inputError');
			$('#SchemaTip').html('模式名不能超过20个字符！');
//			$('#Schema').focus();
			return false;
		}
		$('#Schema').addClass('inputRight');
		$('#SchemaTip').html('');
		return true;
	 
 }
 
 function checkPassword(){
		var password = $('#password').val();
		 if(check_danger(password)){
              artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
		      return false;
		} 
//		if($.trim(password).length == 0) {
//			$('#password').removeClass();
//			$('#password').addClass('inputError');
//			$('#passwordTip').html('密码不能为空！');
//			$('#password').focus();
//			return false;
//		}
		
		if(password.length > 20) {
			$('#password').removeClass();
			$('#password').addClass('inputError');
			$('#passwordTip').html('密码不能超过20个字符！');
//			$('#password').focus();
			return false;
		}
		
		//密码特殊字符过滤
		var password_safe=safe_string_escape(password);
		if (password!=password_safe)
		{
			password=password_safe;
			$('#passwordTip').html('密码含有特殊字符，会经过特殊处理！');
		}else {$('#passwordTip').html('');}
		$('#password').addClass('inputRight');
		//$('#passwordTip').html('');
		return true;
	}
 
function addOrUpdateInfo() {
	if(RightAnalyzeSave()){
		var user=$('#username').val();
	 	var password=$('#password').val();
         /*added by gengjinkun 2014-08-19*/
		/*added by gengjinun*/
		if(check_danger(user)||check_danger(password)){
              artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
			  return;
		}

	 	$.ajax({
			url:"PrivilegeAnalyzeInfo.php?cmd=save",
			type:"POST",
			dataType:"",
			data:{
				user:user,
				password:password,
//				interval:interval,
//				FirstData:FirstData,
//				FirstTime:FirstTime,
//				Schema:$("#Schema").val(),
				Enabled:$("#Enabled").val(),
				RecordId:$("#RecordId").val(),
				database:$("#database").val()
			},
			success:function(data){
//				alert(data);
				if(data=="UPDATE_OK"){
//					alert("修改成功！");
					artDialog({content:'修改成功！', style:'succeed'}, function(){
						window.location.href="analyse_back.php";
					});
				} else if(data=="SAVE_OK"){
//					alert("保存成功！");
					artDialog({content:'保存成功！', style:'succeed'}, function(){
						window.location.href="analyse_back.php";
					});
				} else if(data=="SAVE_ERROR"){
//					alert("同一服务器的同一协议类型的权限管理计划已存在，保存失败！");
					artDialog({content:'同一服务器的同一协议类型的权限管理计划已存在，保存失败！', style:'alert'}, function(){
						//window.location.href="analyse_back.php";
					});
				}else if(data=="UPDATE_ERROR"){
					artDialog({content:'未修改任何字段！', style:'alert'}, function(){
						window.location.href="analyse_back.php";
					});
				} else {
					artDialog({content:'服务器出错，保存失败，请重试！', style:'error'}, function(){
						//window.location.href="analyse_back.php";
					});
				}
			}
		});
	 	
	}
}
 
 </script>
 
 <body>
 <div>
	<div><h5 class="title102"><em>数据库权限管理计划</em> <span ></span></h5></div>
	<div class="box102 p20"><form action="?cmd=save" method="post">
		<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
			<tbody>
			   <!-- 
				<tr>
					<th width="20%">数据库</th>
					<?php if($cmd == "get"){?>
					<td><?php echo $sch['ServerName'].":".$sch['Protocol'].":".$sch['ServiceName']?></td>
					<?php }else{?>
					<td>
					<select name="sch[database]" id="database" style="width: 200px;">
					<?php foreach($databases as $database){?><option value="<?php echo $database['ServiceID'].":".$database['Protocol'].":".$database['ServiceName']?>" <?php if($database['ServerID']==$sch['ServerID'] && $database['Protocol']==$sch['Protocol']) echo "selected"?>><?php echo $database['ServerName'].":".$database['Name'].":".$database['ServiceName']?><?php }?>
					</select>
					</td> <?php }?>
					</tr>
				-->
				  
					
					
					<tr>
					<th width="20%">数据库</th>
					<?php if($cmd == "get"){?>
					<td>
					<select name="sch[database]" id="database" style="width: 200px;">
					<?php foreach($databases as $database){?><option value="<?php echo $database['ServiceID'].":".$database['Protocol'].":".$database['ServiceName']?>" <?php if($database['ServerID']==$sch['ServerID'] && $database['Protocol']==$sch['Protocol']) echo "selected"?>><?php echo $database['ServerName'].":".$database['Name'].":".$database['ServiceName']?><?php }?>
					</select>
					</td>
					<?php }else{?>
					<td>
					<select name="sch[database]" id="database" style="width: 200px;">
					<?php foreach($databases as $database){?><option value="<?php echo $database['ServiceID'].":".$database['Protocol'].":".$database['ServiceName']?>" <?php if($database['ServerID']==$sch['ServerID'] && $database['Protocol']==$sch['Protocol']) echo "selected"?>><?php echo $database['ServerName'].":".$database['Name'].":".$database['ServiceName']?><?php }?>
					</select>
					</td> <?php }?>
					</tr>
					 
					<!-- 
					<tr>
						<th>是否启用</th>
						<td><select name="sch[Enabled]" id="Enabled" style="width: 200px;"><option value="0" <?php if($sch['Enabled']==0)echo "selected"?>>禁用</option><option value="1" <?php if($sch['Enabled']==1)echo "selected"?>>启用</option></select>
						</td>
					</tr>
					 -->
					<tr>
						<th>用户名</th>
						<td>
							<input type="text" id="username" name="sch[UserName]"value="<?php echo $sch['UserName']?>" style="width: 200px;" onblur='checkUserName()'/>
							<span style="color:red">*</span><span class="errorTip" id='userNameTip'></span>
						</td>
					</tr>
					<tr>
						<th>密码</th>
						<td>
							<input type="password" id="password" name="sch[Password]" value="<?php echo $sch['Password']?>" style="width: 200px;" onblur="checkPassword();"/>
							<span style="color:red">*</span><span class="errorTip" id='passwordTip'></span>
						</td>
					</tr>
					
					<!--
					<tr>
						<th>模式名</th>
						<td>
							<input type="text" id="Schema" name="sch[schame]" value="<?php echo $sch['Schema']?>" style="width: 200px;" onblur="checkSchema();"/>
							<span style="color:red">*</span><span class="errorTip" id='SchemaTip'></span>
						</td>
					</tr>		 
					<tr>
						<th>更新周期</th>
						<td>
							<input type="text" id="interval" name="sch[UpdateInterval]"value="<?php echo $sch['UpdateInterval']?>" />天
						</td>
					</tr>	
					<tr style="display:<?php echo !$sch?"": "none"?>" id="FirstUpdateTime"><th>第一次更新时间</th>
					<td>
					<input type="text" name="sch[FirstData]" id="FirstData"  value='<?php echo date('Y-m-d');?>' class="Wdate" onClick="WdatePicker()">
					<input type="text" name="sch[FirstTime]" id="FirstTime"  value='<?php echo date('H:i');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" >
					</td>
					</tr> 
					 -->
											
					<tr><td colspan="2"><input type="button" class="tijiao" value="保存" onclick="addOrUpdateInfo();"><input type="reset" class="repire" value="重置"></td></tr>               	
			</tbody>
		 </table>
		 <input type="hidden" id="RecordId" name="sch[RecordId]" value="<?php echo $sch['RecordId']?>"/>
		 </form>                            
	</div> 
</div> 
 </body>
 </html>
