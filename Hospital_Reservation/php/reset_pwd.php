<?php
if(!isset($_SESSION)){
	session_start();
}
    $_SESSION['Reset_ID']=$_REQUEST['Reset_ID'];
	$_SESSION['randstr']=$_REQUEST['randstr'];
?>
<html>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	 <script type="text/javascript" src="../include/jquery-2.1.1.js"></script>
     <script type="text/javascript"  src="../include/sha1.js"></script>
	 <script type="text/javascript"  src="../include/artDialog/artDialog.js?skin=default"></script>
<script type="text/javascript"  src="../include/artDialog/plugins/iframeTools.source.js"></script>
	<style>
		span{
			font-size:20px;
			font-weight: 700;
			font-family: '楷体';
		}
		#confirm_btn{
			background-color: #006699;
			color:white;
			font-weight: 700;
			font-size:20px;
		}
	</style>
	<span id="rst_pwd_tag">重置密码</span>
	<input type="password" id="rst_pwd" />
	<br />
	<span id="rpt_pwd_tag">重复输入</span>
	<input type="password" id="rpt_pwd" />
	<br />
	<input type="button" id="confirm_btn"  onclick="change_pwd()" value="确定"/>
	<script>
		function change_pwd(){
			if($('#rst_pwd').val()!=$('#rpt_pwd').val()){
				art.dialog({
					title:'系统提示',
					icon:'error',
					content:'两次输入密码不一致！',
					ok:true,
					okVal:'确定'
				});
				return;
			}
			var Password=hex_sha1($('#rst_pwd').val());
			var encrypttime=getEncryptTime();
			$.ajax({
					url:"../php/change_pwd.php",
					//url:'../php/TransferStation.php',
					type:'POST',
					dataType:'json',
					data:{
						encrypttime:encrypttime,
						Password:Password
					},
					success:function(data){
						if(data.msg==0){
				            art.dialog({
				            	title:'系统消息',
				            	content:'密码重置成功',
				            	icon:'face-smile',
								ok:true,
								okVal:'确定',
				            });
						}else{
							art.dialog({
								title:'系统消息',
								content:'操作失败！+失败信息<br/>'+data.info,
								icon:'error',
								cancel:true,
								cancelVal:'关闭',
							});
						}
					},
					error:function(data){
						art.dialog({
								title:'系统消息',
								content:'与服务器交互失败，请稍后重试！',
								icon:'error',
								cancel:true,
								cancelVal:'关闭',
						});
					}
			});
		}
	</script>
</html>