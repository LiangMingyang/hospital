<?php
/**
 * addSqlInj.tpl.php-.
 * @modification history 
 * ---------------------
 * 2014-4-25,created by zhangxin
 */
include header_inc();
 ?>
 <script>
 
 function checkValue(id) {
 	var value = $("#"+id).val();
 	if(isNull(value)){
 		$('#'+id).removeClass();
 		$('#'+id).addClass('inputError');
 		$('#'+id+'Tip').html('参数不能为空！');
 	//	$('#'+id).focus();
 		return false;
 	}

 	if((/^\d+\.\d+$/.test(value))&& (value>0)&&(value<1)){
 		$('#'+id).addClass('inputRight');
 	 	$('#'+id+'Tip').html('');
 	 	return true;
 	}else {
 		$('#'+id).removeClass();
 		$('#'+id).addClass('inputError');
 		$('#'+id+'Tip').html('参数必须大于0小于1！');
 		//$('#'+id).focus();
 		return false;
 	}
 	$('#'+id).addClass('inputRight');
 	$('#'+id+'Tip').html('');
 	return true;
 }
 function isNull(str){
		if(str==null)return true;
		return false;
	}
/*纯正则表达式判断一个字符串是否是合法的ip地址，如果是返回true，不是则false*/
	function ipaddr_check(addr)
	{
	 var reg = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$/;
	 if(addr.match(reg)){
	     return true;
	 }
	 else{
	     return false;
	 }
	}
 function saveBlackIp(){
	 var value = $("#blackIp").val();
	 	
	 if(value==""||value==null){
		 alert("输入不能为空！");
		 obj.select();
	 	}
	 if(!ipaddr_check(value)){
		 alert("IP 不合法！");
         $("#blackIp").val("");
		 return;
	 }
	$.ajax({
		url:"addBlackIp.php?cmd=save",
		data:{
		     blackIp:$("#blackIp").val()
		},
		type:"post",
		dataType:"text",
		success:function(data){	
			if(data=="OK"){
				artDialog({content:'保存成功！', style:'succeed'}, function(){
					window.location.href="blackList.php";
				});
			}else{
				artDialog({content:'保存失败！', style:'error'}, function(){
					window.location.href="blackList.php";
				});
				
			}
		}
	});		
 } 
 </script>
 <body>
 <div>
	<div><h5 class="title102"><em>添加入侵检测黑名单</em> <span ></span></h5></div>
	<div class="box102 p20"><form action="?cmd=save" method="post">
		<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
			<tbody>
				<tr>
					<th width="20%" style="text-align:center;">要添加到黑名单的IP</th>
					<td><input type="text" name="blackIp" id="blackIp" value="" style="width:250px;"/><span style="color:red">*</span></td>
				</tr>
				<tr><td colspan="2"><input type="button" class="tijiao" value="保存" onclick="saveBlackIp();"><input type="reset" class="repire" value="重置"></td></tr>               	
			</tbody>
		 </table></form>                            
	</div> 
</div> 
 </body>
 </html>