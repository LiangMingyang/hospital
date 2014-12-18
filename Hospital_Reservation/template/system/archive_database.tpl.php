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
function reset() {
	$("#host").val("");
	$("#username").val("");
	$("#password").val("");
	$("#dbname").val("");
}

function update() {
	host = $("#host").val();
	username = $("#username").val();
	password = $("#password").val();
	dbname = $("#dbname").val();
	if(checkHost()&&checkUserName()&&checkDBName()){
		$.ajax({
			url:"archive_database.php?cmd=save",
			type:"post",
			data:{
				"host":host,
				"username":username,
				"password":password,
				"dbname":dbname
			},
			dataType:"text",
			success:function(data){
				if(data=="OK") {
					artDialog({content:'修改成功！', style:'succeed'}, function(){
						window.location.href="archive_database.php";
					});
				} else {
					artDialog({content:'修改失败，请重试！', style:'error'}, function(){
						
					});
				}
			}
		});	
	} 
}

function checkUserName(){
	var username = $('#username').val();

	if($.trim(username).length == 0) {
		$('#username').removeClass();
		$('#username').addClass('inputError');
		$('#userNameTip').html('用户名不能为空！');
		$('#username').focus();
		return false;
	}
	
	if(username.length > 20) {
		$('#username').removeClass();
		$('#username').addClass('inputError');
		$('#userNameTip').html('用户名不能超过20个字符！');
		$('#username').focus();
		return false;
	}
	$('#username').addClass('inputRight');
	$('#userNameTip').html('');
	return true;
}

function checkDBName(){
	var dbname = $('#dbname').val();

	if($.trim(dbname).length == 0) {
		$('#dbname').removeClass();
		$('#dbname').addClass('inputError');
		$('#dbNameTip').html('数据库名不能为空！');
		$('#dbname').focus();
		return false;
	}
	
	if(dbname.length > 20) {
		$('#dbname').removeClass();
		$('#dbname').addClass('inputError');
		$('#dbNameTip').html('数据库名不能超过20个字符！');
		$('#dbname').focus();
		return false;
	}
	$('#dbname').addClass('inputRight');
	$('#dbNameTip').html('');
	return true;
}

function checkNonEmpty(value){
	if(isNull(value)){return false;}
	if($.trim(value)==""){
		return false;
	}
	return true;
}
//验证host为localhost或者ip格式
function checkHost() {
	var host = $("#host").val();
	if(isNull(host)){
		$('#host').removeClass();
		$('#host').addClass('inputError');
		$('#ipTip').html('IP不能为空！');
		$('#host').focus();
		return false;
	}
	if($.trim(host)!="localhost" && !isIp(host)){
		$('#host').removeClass();
		$('#host').addClass('inputError');
		$('#ipTip').html('IP格式不对！');
		$('#host').focus();
		return false;
	}
	$('#host').addClass('inputRight');
	$('#ipTip').html('');
	return true;
}
function isIp(strIP) {
	if (isNull(strIP)) return false;
	var re=/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/g //匹配IP地址的正则表达式
	if(re.test(strIP))
	{
	if( RegExp.$1 <256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256) return true;
	}
	return false;
}
function isNull(str){
	if(str==null)return true;
	return false;
}
</script>
 <body>
 <h5 class="title102"><em>归档数据库配置</em></h5>
  <div class="celue p20" style="margin-top:0px;">
 <table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<td width="32%">
				<div><form action="" method="post" onsubmit="">
					<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
						<tbody>
							<tr>
								<th width="20%">数据库IP地址</th>
								<td><input type="text" id="host" name="host" style="width:200px;" value="<?php echo $targetArchive['host']?>" onblur='checkHost()'/><span style="color:red">*</span><span class="errorTip" id='ipTip'></span></td>
                            </tr>
                            <tr>
								<th>用户名</th>
								<td><input type="text" id="username" name="username" style="width:200px;" value="<?php echo $targetArchive['username']?>" onblur='checkUserName()'/><span style="color:red">*</span><span class="errorTip" id='userNameTip'></span></td>
                            </tr>
                            <tr>
								<th>密码</th>
								<td><input type="password" id="password" name="password" style="width:200px;" value=""/><span style="color:red">*</span></td>
                            </tr>
                            <tr>
								<th>数据库名</th>
								<td><input type="text" id="dbname" name="dbname" style="width:200px;" value="<?php echo $targetArchive['dbname']?>" onblur='checkDBName()'/><span style="color:red">*</span><span class="errorTip" id='dbNameTip'></span></td>
                            </tr>
							<tr>
								<td colspan="2">
                            		<a href="#" class="tijiao" onclick="update();">保存</a>
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