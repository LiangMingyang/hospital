<?php
/**
 * pwdmodify.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-13,created by Xu Guozhi
 */
include header_inc();
 ?>
 <script type="text/javascript" src="<?php echo JS_PATH?>user.js?<?php echo microtime()?>"></script>
<script type="text/javascript">
function reset() {
	$("#oldpwd").val("");
	$("#password").val("");
	$("#password2").val("");
}
</script>
 <body>
 <h5 class="title102"><em>修改密码</em></h5>
 <div class="celue p20" style="margin-top:0px;">
 <table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<td width="32%">
				<div><form action="<?php echo WEB_ROOT?>system/pwdmodify.php?cmd=update" method="post" name="myForm" onsubmit="return updatePwd()">
					<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
						<tbody>
							<tr>
								<th width="20%">旧密码</th>
								<td><input type="password" id="oldpwd" name="oldPwd" onblur='checkPwd()'/><span style="color:red">*</span><span class="errorTip" id='oldpwdTip'></span></td>
                            </tr>
                            <tr>
								<th>新密码</th>
								<td><input type="password" id="password" name="newPwd" onblur='checkPwd()'/><span style="color:red">*</span><span class="errorTip" id='passwordTip'></span></td>
                            </tr>
                            <tr>
								<th>重复密码</th>
								<td><input type="password" id="password2" name="password2" /><span style="color:red">*</span><span class="errorTip" id='password2Tip'></span></td>
                            </tr>                            
                            <tr>
	                            <td colspan="2">
	                            	<a href="#" class="tijiao" onclick="javascript:if(updatePwd()){document.myForm.submit();}">保存</a>
	                            	<a href="#" class="repire" onclick="reset();">重置</a>
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