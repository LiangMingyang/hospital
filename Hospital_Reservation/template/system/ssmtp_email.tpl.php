<?php
/**
 * userInfo.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-1,created by Xu Guozhi
 */
include header_inc();

 ?>
<script type="text/javascript" src="<?php echo JS_PATH?>user.js"></script>
<script type="text/javascript">
function update() {
	id=$("#id").val();
	root = $("#root").val();
	mailhub = $("#mailhub").val();
	rewriteDomain = $("#rewriteDomain").val();
	AuthUser = $("#AuthUser").val();
	AuthPass = $("#AuthPass").val();
	hostname = $("#hostname").val();
	if(checkLength('root')&&checkLength('mailhub')&&
			checkLength('rewriteDomain')&&checkLength('AuthUser')&&
			checkLength('AuthPass')&&checkLength('hostname')){
		$.ajax({
			url:"ssmtp_email.php?cmd=save",
			type:"post",
			data:{
				"root":root,
				"mailhub":mailhub,
				"rewriteDomain":rewriteDomain,
				"AuthUser":AuthUser,
				"AuthPass":AuthPass,
				"hostname":hostname
			},
			dataType:"text",
			success:function(data){
				if(data=='NO_UPDATE'){
					artDialog({content:'未修改任何字段内容！', style:'alert'}, function(){});
				}else if(data=='UPDATE_OK'){
					artDialog({content:'修改成功！', style:'succeed'}, function(){});
				}else if(data=='ADD_OK'){
					artDialog({content:'添加成功！', style:'succeed'}, function(){});
				}else if(data=='ADD_ERROR'){
					artDialog({content:'，服务器出错，添加失败，请稍后重试！', style:'error'}, function(){});
				}
			}
		});	
	} 
}
function checkNonEmpty(value){
	if(isNull(value)){return false;}
	if($.trim(value)==""){
		return false;
	}
	return true;
}
function checkLength(id){
	var value = $('#'+id).val();

	if($.trim(value).length == 0) {
		$('#'+id).removeClass();
		$('#'+id).addClass('inputError');
		$('#'+id+'Tip').html('该项不能为空！');
		$('#'+id).focus();
		return false;
	}
	
	if(value.length > 30) {
		$('#'+id).removeClass();
		$('#'+id).addClass('inputError');
		$('#'+id+'Tip').html('不能超过30个字符！');
		$('#'+id).focus();
		return false;
	}
	$('#'+id).addClass('inputRight');
	$('#'+id+'Tip').html('');
	return true;
	
}

function reset() {
	$("#root").val('');
	$("#mailhub").val('');
	$("#rewriteDomain").val('');
	$("#AuthUser").val('');
	$("#AuthPass").val('');
	$("#hostname").val('');
}
</script>
 <body>
 <h5 class="title102"><em>邮件SMTP配置</em></h5>
  <div class="celue p20" style="margin-top:0px;">
 <table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<td width="32%">
				<div><form action="" method="post" onsubmit="">
					<input type="hidden" id="id" name="id" value=<?php echo $targetSsmtp['id']?>/>
					<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
						<tbody>
							<tr>
								<th width="250px">根地址(root)：</th>
								<td><input type="text" id="root" name="root" style="width:200px;" value="<?php echo $targetSsmtp['root']?>" onblur="checkLength('root')" /><span style="color:red">*</span><span class="errorTip" id='rootTip'></span></td>
                            </tr>
                            <tr>
								<th>邮件中心(mailhub)：</th>
								<td><input type="text" id="mailhub" name="mailhub" style="width:200px;" value="<?php echo $targetSsmtp['mailhub']?>" onblur="checkLength('mailhub')"/><span style="color:red">*</span><span class="errorTip" id='mailhubTip'></span></td>
                            </tr>
                            <tr>
								<th>本地域(rewriteDomain)：</th>
								<td><input type="text" id="rewriteDomain" name="rewriteDomain" style="width:200px;" value="<?php echo $targetSsmtp['rewriteDomain']?>" onblur="checkLength('rewriteDomain')"/><span style="color:red">*</span><span class="errorTip" id='rewriteDomainTip'></span></td>
                            </tr>
                            <tr>
								<th>SMTP认证用户名(AuthUser)：</th>
								<td><input type="text" id="AuthUser" name="AuthUser" style="width:200px;" value="<?php echo $targetSsmtp['AuthUser']?>" onblur="checkLength('AuthUser')"/><span style="color:red">*</span><span class="errorTip" id='AuthUserTip'></span></td>
                            </tr>
                            <tr>
								<th>SMTP认证密码(AuthPass)：</th>
								<td><input type="password" id="AuthPass" name="AuthPass" style="width:200px;" value="<?php echo $targetSsmtp['AuthPass']?>" onblur="checkLength('AuthPass')"/><span style="color:red">*</span><span class="errorTip" id='AuthPassTip'></span></td>
                            </tr>
                            <tr>
								<th>SMTP主机名(hostname)：</th>
								<td><input type="text" id="hostname" name="hostname" style="width:200px;" value="<?php echo $targetSsmtp['hostname']?>" onblur="checkLength('hostname')"/><span style="color:red">*</span><span class="errorTip" id='hostnameTip'></span></td>
                            </tr>
							<tr>
								<td colspan="2">
                            	<a href="#" class="tijiao" onclick="update();">保存</a><a href="#" class="repire" onclick="reset();">重置</a>
                            	</td>
                            </tr>
						</tbody>
					</table></form>
				</div>
			</td>
		</tr>
	</tbody>
</table>
</div>                     
 </body>
 </html>