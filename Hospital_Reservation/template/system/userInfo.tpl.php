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
include header_inc()
 ?>
<script type="text/javascript" src="<?php echo JS_PATH?>user.js"></script>
 <body>
  <div class="celue p20" style="margin-top:0px;">
 <table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<td width="32%">
				<div><form action="<?php echo WEB_ROOT?>system/userInfo.php?cmd=save" method="post" onsubmit="return userSave()">
					<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
						<tbody>
							<tr>
								<th width="20%">登录名</th>
								<td><input type="text" id="username" value="<?php echo $user['Username']?>" name="User[Username]" onblur='checkUserName(true)' style="width:200px;"/><span style="color:red">*</span><span class="errorTip" id='userNameTip'></span></td>
                            </tr>
                            <!-- 
                            <tr>
								<th>密码</th>
								<td><input type="password" id="password" value="<?php echo $user['Passwd']?>" name="User[Passwd]" onblur='checkPwd()'/><span style="color:red">*</span><span class="errorTip" id='pwdTip'></span></td>
                            </tr>
                            <tr>
								<th>重复密码</th>
								<td><input type="password" id="password2" value="<?php echo $user['Passwd']?>" name="password2" onblur='checkPwd()'/><span style="color:red">*</span><span class="errorTip" id='pwd2Tip'></span></td>
                            </tr>
                             -->
                            <tr>
								<th>密码</th>
								<td><input type="password" id="password" value="" name="User[Passwd]" onblur='checkPwd()' style="width:200px;"/><span style="color:red">*</span><span class="errorTip" id='pwdTip'></span></td>
                            </tr>
                            <tr>
                            	<th>角色</th>
                            	<td>
                            	<?php if($user['RoleID']== User::USER_TYPE_SUPER){?>
                            	超级管理员
                            	<?php }else{?>
                            	<select id="roleId" name="User[RoleID]" style="width:200px;">
                            		<?php foreach($roles as $role){
                            		    ?>                            		
                            		<option value="<?php echo $role['RoleID'];?>" <?php if($role['RoleID']===$user['RoleID']) echo "selected"?>><?php echo $role['RoleName']?></option>
                            		<?php }?>
                            	</select>&nbsp;<!-- <a href="roleMgr.php">编辑</a> -->
                            	<?php }?>
                            	</td>
                            <tr>
								<th>姓名</th>
								<td><input type="text" value="<?php echo $user['FullName']?>" name="User[Fullname]" id="Fullname" style="width:200px;" onblur='checkFullName()'/><span class="errorTip" id='fullNameTip'></span></td>
                            </tr>
                            <tr>
								<th>电话</th>
								<td><input type="text" value="<?php echo $user['Tel']?>" name="User[Tel]" id="telText" style="width:200px;" onblur='checkTel()'/><span class="errorTip" id='telTip'></span></td>
                            </tr>
                            <tr>
								<th>电子邮箱</th>
								<td><input type="text" id="emailText" value="<?php echo $user['Email']?>" name="User[Email]"  style="width:200px;" onblur='checkEmail()'/><span class="errorTip" id='emailTip'></span></td>
                            </tr>
                            <!-- 
                            <tr>
                            	<th>接收报警等级</th>
                            	<td><select name="User[WarnLevel]"><option value="-1">不接收</option>
                            		<option value="0" <?php if($user['WarnLevel']===0) echo "selected"?>>低</option>
                            		<option value="1" <?php if($user['WarnLevel']===1) echo "selected"?>>中</option>
                            		<option value="2" <?php if($user['WarnLevel']===2) echo "selected"?>>高</option>
                            	</select></td>
                            </tr>
                             -->
                            <tr><td colspan="2"><input type="button" class="neibu" name="sbtUser" value="保存" onclick="saveNewUser();"/>
                            <input type="reset" class="neibu" name="rstUser" value="重置"/>
						</tbody>
					</table>
					<input type="hidden" id='userId' name="User[UID]" value="<?php echo $user['UID']?>"/>
					</form>
				</div>
			</td>
		</tr>
	</tbody>
</table>
</div>                     
 </body>
 </html>