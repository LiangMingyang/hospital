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
	if(checkNonEmpty(root)&&checkNonEmpty(mailhub) && checkNonEmpty(rewriteDomain) && checkNonEmpty(AuthUser) && checkNonEmpty(AuthPass) && checkNonEmpty(hostname)){
		$.ajax({
			url:"add_smtp.php?cmd=save",
			type:"post",
			data:{
				"id":id,
				"root":root,
				"mailhub":mailhub,
				"rewriteDomain":rewriteDomain,
				"AuthUser":AuthUser,
				"AuthPass":AuthPass,
				"hostname":hostname
			},
			dataType:"text",
			success:function(data){
				alert(data);
			}
		});	
	} else {
		alert("请将必填项填完整！");
	}
	
}

function checkLength(id){
	alert("vvalue:");
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

function checkNonEmpty(value){
	if(isNull(value)){return false;}
	if($.trim(value)==""){
		return false;
	}
	return true;
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
								<th width="20%">root</th>
								<td><input type="text" id="root" name="root" style="width:200px;" value="<?php echo $targetSsmtp['root']?>" onblur="checkLength('root')" /><span style="color:red">*</span><span class="errorTip" id='rootTip'></span></td>
                            </tr>
                            <tr>
								<th>mailhub</th>
								<td><input type="text" id="mailhub" name="mailhub" style="width:200px;" value="<?php echo $targetSsmtp['mailhub']?>" onblur="checkLength('mailhub')"/><span style="color:red">*</span><span class="errorTip" id='mailhubTip'></span></td>
                            </tr>
                            <tr>
								<th>rewriteDomain</th>
								<td><input type="text" id="rewriteDomain" name="rewriteDomain" style="width:200px;" value="<?php echo $targetSsmtp['rewriteDomain']?>" onblur="checkLength('rewriteDomain')"/><span style="color:red">*</span><span class="errorTip" id='rewriteDomainTip'></span></td>
                            </tr>
                            <tr>
								<th>AuthUser</th>
								<td><input type="text" id="AuthUser" name="AuthUser" style="width:200px;" value="<?php echo $targetSsmtp['AuthUser']?>" onblur="checkLength('AuthUser')"/><span style="color:red">*</span><span class="errorTip" id='AuthUserTip'></span></td>
                            </tr>
                            <tr>
								<th>AuthPass</th>
								<td><input type="password" id="AuthPass" name="AuthPass" style="width:200px;" value="<?php echo $targetSsmtp['AuthPass']?>" onblur="checkLength('AuthPass')"/><span style="color:red">*</span><span class="errorTip" id='AuthPassTip'></span></td>
                            </tr>
                            <tr>
								<th>hostname</th>
								<td><input type="text" id="hostname" name="hostname" style="width:200px;" value="<?php echo $targetSsmtp['hostname']?>" onblur="checkLength('hostname')"/><span style="color:red">*</span><span class="errorTip" id='hostnameTip'></span></td>
                            </tr>
							<tr><td colspan="2"><input type="button" class="neibu" name="sbtUser" value="保存" onclick="update();"/>
                            <input type="reset" class="neibu" name="rstUser" value="重置"/>
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