<?php
/**
 * scancfg.tpl.php-.
 * ---------------------
 * 2013-12-31,created by zhangxin
 */
include header_inc ();
?>
<script type="text/javascript">
function checkScanIp(){
	var scanIp=$('#scanIp').val();
	if(scanIp.length==0){
		alert('请输入漏洞扫描服务器IP!');
		$('#scanIp').val('');
		$('#scanIp').focus();
		return false;
		}
	return true;
}
function ipaddr_check()
	{
	var scanIp=$('#scanIp').val();
	 var reg = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$/;
	 if(scanIp.match(reg)){
		
	     return true;
	 }
	 else{
		   artDialog({content:'输入IP格式不合法', style:'alert'}, function(){});
	     return false;
	 }
	}
function saveScanServer(){
	if(ipaddr_check()){
		$.ajax({
	        url : 'scancfg.php?cmd=tijiao',
	        type : 'POST',
	        dataType : 'text',
	        data:{
	        	ScanIP:$("#scanIp").val()
		    },
	        success : function(data) {
		        if(data == 'OK') {
	        		artDialog({content:'提交成功！', style:'succeed'}, function(){
	        			window.open("http://"+$('#scanIp').val());
					});

	        	} else {
	        		artDialog({content:"服务器出错，提交失败，请重试！", style:'error'}, function(){
	        			window.location.href="scancfg.php";
					});
	        	}
	        	
	        }
   		});
		}
}

</script>
<html>
<body>
	<h5 class="title102">
		<em>漏洞扫描配置</em>
	</h5>
	<div class="celue p20" style="margin-top: 0px;">
			<table border="0" cellspacing="0" cellpadding="0" width="100%"
				class="tab6">
				<tbody>
					<tr>
						<th width="15%"><font color="red">*</font>漏洞扫描服务器IP：</th>
						<td><input type="text" id="scanIp" name="scanIp"
							onchange="checkScanIp();" style="width: 300px;" /> <span
							style="color: red;">请输入正确格式IP（如：192.168.1.10）</span></td>
					</tr>
					<tr>
						<td colspan="2">
						<input type="button" class="neibu" name="scanServer" value="提交" onClick="saveScanServer();"/>
						</td>
					</tr>
				</tbody>
			</table>
	</div>
</body>
</html>
