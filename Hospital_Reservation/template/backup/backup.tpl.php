<?php
/**
 * 手动备份
 * backup.tpl.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-8,created by Chenhuan
 */
include header_inc();
 ?>
 
 
<script type="text/javascript" src="<?php echo JS_PATH?>backup/backup.js?"></script>
<script type="text/javascript">
//function backup() {
//	var locationType = $("input:[name=backupLocation]:radio:checked").val();  
//	alert(locationType);
//	document.backupForm.action="export.php?locationType="+locationType;
//	document.backupForm.submit();
//}

function showDiv() {
//    document.getElementById('popWindow').style.display = 'block';
//    document.getElementById('maskLayer').style.display = 'block';    
    parent.popWindow.style.display = 'block';
    parent.maskLayer.style.display = 'block';
}
function closeDiv() {
    //document.getElementById('popWindow').style.display = 'none';
    //document.getElementById('maskLayer').style.display = 'none';
	parent.popWindow.style.display = 'none';
    parent.maskLayer.style.display = 'none';
}

function backup() {
	showDiv();
	
	var locationType = $("input:[name=backupLocation]:radio:checked").val();  
	if(locationType==0) {//备份到本地
		$.ajax({
			url:"export.php?locationType=0",
			type:"post",
			dataType:"text",
			timeout:30000*10,
			complete:function(){
				closeDiv();
			},
			success:function(data){
				if(data=='SUCCESS'){
				  artDialog({content:"备份成功!", style:'succeed'}, function(){});
				   //window.location.href="export.php?cmd=download";
				  //window.location.href="backup.php";
				}else {
                    artDialog({content:"备份失败!失败信息："+data, style:'succeed'}, function(){});
				   //window.location.href="export.php?cmd=download";
				 // window.location.href="backup.php";
				}
				
			},
			error:function(data){
                  artDialog({content:"与服务器交互失败!失败信息："+data, style:'succeed'}, function(){});
				   //window.location.href="export.php?cmd=download";
				  //window.location.href="backup.php";
			}
		});
//		window.location.href="export.php?locationType=0";
	} else {//备份至服务器  
		$.ajax({
			url:"export.php?locationType=1",
			type:"post",
			dataType:"text",
			timeout:30000*10,
			complete:function(){
				closeDiv();
			},
			success:function(data){
				alert(data);
			}
		});
//		window.location.href="export.php?locationType=1";
	}
	
}

</script>
<body>
<h5 class="title102"><em>手动备份</em></h5>

<div class="box102 p20">
	<div class="tabContent">
	
<div style="width:100%;margin-top:20px;text-align:center;">
<p style="font-size:24px;">欢迎使用数据备份服务</p>
	<img src="<?php echo IMAGE_PATH?>backup_logo600.jpg" width="60%">
</div>
<div style="width:100%;margin-top:20px;">
		<form action="export.php" name="backupForm" method="post">
			<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab1" style="font-size: 16px;">    
                    <tr>
                    <td><font>1.备份至服务器将会在服务器上保存最近的备份文件，可以用从服务器恢复</font></td>
                    </tr>
                    <tr>
                    <td><font>2.备份至本地将sql文件下载到本地，可以用于从本地进行恢复</font></td>
                    </tr>
                    <tr>
                    <td><font>请选择您要被备份到的地址：</font></td>
                    </tr>
                    <tr>
                    	<td align="center">
                    		<input type="radio" name="backupLocation" value="1" checked="checked"/>备份到服务器
                    		<input type="radio" name="backupLocation" value="0"/>备份到本地
                    	</td>
                    </tr>
                    <tr>
                    	<td class="btn">
                        	<a href="#" class="tijiao" onclick="backup();">备份</a><a href="javascript:history.go(-1);" class="repire">返回</a>
                        </td>   
                    </tr>
             </table>   
		</form>
		</div>
</div>


</body>
</html>