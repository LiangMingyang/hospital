<?php
  if(!isset($_SESSION))
  session_start();
?>
<html>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
    <script src="../include/sha1.js"></script>
    <script src="../include/jquery-2.1.1.js"></script>
	<link href="../css/Individual_Info.css" rel="stylesheet" type="text/css" />
	<script src="../js/Individual_Info.js"> </script>	
	<body>
		<div id="title">
			<p>个人信息页面</p>
		</div>
		<div id="content">
			<br />
			<table id="individual_info_tb">
				<tr>
					<td class="tag">姓名</td>
					<td class="tag_1">
						<input type="text" id="name" name=<?php echo $_SESSION['User_ID']; ?> disabled="disabled"  readonly="readonly" value="<?php echo $_SESSION['User_Name']  ?>"/>
					</td>
				</tr>
				<tr>
					<td class="tag">性别</td>
					<td class="tag_1">
						<input type="text" id="sex" disabled="disabled"  readonly="readonly"  value="<?php if($_SESSION['Sex']=='0' )echo '女';else  echo '男';  ?>"/>
					</td>
				</tr>
				<tr>
					<td class="tag">身份证号</td>
					<td class="tag_1">	
						<input type="text" id="identity_id" disabled="disabled" readonly="readonly"  value="<?php echo $_SESSION['Identity_ID']  ?>"/>
					</td>
				</tr>
				<tr>
					<td class="tag">出生年月</td>
					<td class="tag_1">
						<input type="text" id="birthday"  value="<?php echo $_SESSION['Birthday']  ?> "/>
					</td>
				</tr>
				<tr>
					<td class="tag">手机号码</td>
					<td class="tag_1">
						<input type="text" id="phone"  value="<?php  echo $_SESSION['Phone'];?> "/>
					</td>
				</tr>
				<tr>
					<td class="tag">电子邮箱</td>
					<td class="tag_1">
						<input type="text" id="mail" value="<?php  echo $_SESSION['Mail']?> "/>
					</td>
				</tr>
				<tr>
					<td class="tag">
						居住地
						&nbsp;
						<select id="Province">
							<option value="1">北京</option>
							<option value='2'>上海</option>
						</select>
						<select id="Area">
							<option value="1">朝阳区</option>
							<option value="2">海淀区</option>
						</select>
					</td>
					<td class="tag_1">
						<input type="text" id="location" value="<?php  echo $_SESSION['Location']?> "/>
					</td>
				</tr>
				<tr>
					<td class="tag">信用等级</td>
					<td class="tag_1">
						<input type="text" id="credit_rank" disabled="disabled"  readonly="readonly"   value="<?php  echo $_SESSION['Credit_Rank'] ?>"/>
					</td>
				</tr>
				<tr>
					<td class="tag">密码 &nbsp;</td>
					<td class="tag_1"> <a id="change_pwd_a" onclick="changePwd()">[修改]</a></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" id="confim_update" onclick="update_info()" value="保存"/>
					</td>
				</tr>
			</table>
			<br />
		</div>
	</body>
	<div id="pwd_area" style="display: none">
		<span>旧密码&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<input type="password" id="old_pwd" />
		<br /><br />
		<span>新密码&nbsp;&nbsp;&nbsp;&nbsp; </span>
		<input type="password" id="new_pwd" />
		<br /><br />
		<span>重复新密码</span>
		<input type="password" id="confirm_pwd" />
		<span id="tag_info" style="color:red;display:none">两次输入密码不一致</span>
		<br /><br />
		<input type="button" id="confirm_pwd_btn" value="确定" onclick="confirm_change_pwd()"/>
		<input type="button" id="cancel_pwd_btn" value="取消" onclick="cancel_pwd()"/>
	</div>
	
</html>
