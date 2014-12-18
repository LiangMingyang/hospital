<?php
/**
 * cfg.php-.
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
  <style type="text/css">
    .popWindow{
        text-align: center;
        z-index:2;
        width:600px;
        height:300px;
        left: 50%;
        top: 50%;
        margin-left: -250px;
        margin-top: -150px;
        position: absolute;
        background:#FFFFFF;
    }
    .head-box{
        width:500px;
        height:25px;
        background:#4A4AFF;
    }
    .maskLayer {
        background-color:#9D9D9D;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        filter: alpha(opacity=50);
        opacity: 0.5;
        z-index: 1;
        position: absolute;
    }
</style>
<script type="text/javascript" src="<?php echo JS_PATH?>backup/backup.js?"></script>

<script type="text/javascript">
/*Add By Yip Date:2014.8.5*/
	function ismysqlSpecialChar(character){ 
			var mysqlSpecialChars = [ "_", "%", "[", "]", "^" , "'" , "\""];
	    var len = mysqlSpecialChars.length; 
	    var ch; 
	    for(var i = 0; i < len; i++ )
	    { 
	        ch = mysqlSpecialChars[i]; 
	        if(character == ch) return true; 
	    } 
	    return false; 
	}
	
	function safe_string_escape(str)
	{ 
	  var len=str.length;
	  var targetString=''; 
	  for(var i=0;i<len;i++) 
	  { 
	  	var c=str.charAt(i);
	    if (ismysqlSpecialChar(c))
	    {
	    	targetString+='\\';
	    }
	    targetString+=c;
	  }
	  return targetString; 
	}

	function check_username()
  {
  	var login_Name=$('#ftpUsername').val();
  	if(login_Name != null && login_Name != "")
  	{
  		login_Name=safe_string_escape(login_Name);
	  	if (login_Name!=$('#ftpUsername').val())
	  	{
	  		alert('输入用户名中含有特殊字符，已作特殊处理！');
	  		$('#ftpUsername').val(login_Name);
  		}
  	}
  	return true;
  }
  function check_password()
  {
  	var login_Name=$('#ftpPassword').val();
  	if(login_Name != null && login_Name != "")
  	{
  		login_Name=safe_string_escape(login_Name);
	  	if (login_Name!=$('#ftpPassword').val())
	  	{
	  		alert('输入密码中含有特殊字符，已作特殊处理！');
	  		$('#ftpPassword').val(login_Name);
  		}
  	}
  	return true;
  }
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
	function ip_check()
  {
		var srcIP = $('#ftpIp').val();
		if(srcIP != null && srcIP != "")
		if (ipaddr_check(srcIP))
		{
			return true;
		}else
		{
			alert('请输入正确的IP地址！');
			$('#ftpIp').val('');
			return false;
		}
	}
	function check_ftpSocket()
	{
		var port = $('#ftpSocket').val();
		if(port != null && port != "")
		{
	    if(port > 0 && port < 65536){
	            return true;
	        }else{
	             alert("请输入正确的端口号（0-65535）！");
	             $('#ftpSocket').val('');
	             return false;
	        }
		}
	}
	function check_ftpPath()
	{
		var ftpPath=$('#ftpAllPath').val();
  	if(ftpPath != null && ftpPath != "")
  	{
  		ftpPath=safe_string_escape(ftpPath);
	  	if (ftpPath!=$('#ftpAllPath').val())
	  	{
	  		alert('FTP路径中含有特殊字符，已作特殊处理！');
	  		$('#ftpAllPath').val(ftpPath);
  		}
  	}
  	return true;
	}
function check_danger_patch(str){
	var reg = /[|&$%@,\'"<>()+]/;
    var res=reg.test(str);
	if(res){		
			return true;
		    }
	else if(str.length>64){
		return true;
	}
	else{
			return false;
	}
}
function check_path(){
	var path=$('#localDiskPath').val();
	if(check_danger_patch(path)){
		artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});

	}
}
// artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
/**************************/	
</script>

<body>
<h5 class="title102"><em>自动备份设置</em></h5>
          <div class="box102 p20">
       		 <form action="" method="post" name="updateBackUpForm">
       		 <table border="0" cellspacing="0" width="100%" cellpadding="0" class="tab3">
             	<tbody>
                	<tr>
                    	<td width="200" class="td1">
                        	是否开启自动备份：
                        </td>
                        <td>
                        <?php 
                        if ($backupRecord['autoStart']==0){
                        	?>
                        	<input type="radio" name="startRadio" value="1"/>开启
                        	<input type="radio" name="startRadio" value="0" checked="checked"/>禁用
                        	<?php
                        } else {
                        	?>
                        	<input type="radio" name="startRadio" value="1" checked="checked"/>开启
                        	<input type="radio" name="startRadio" value="0"/>禁用
                        	<?php
                        }
                        ?>
                        </td>
                    </tr>
                	<tr>
                    	<td class="td1">
                        	自动备份周期：
                        </td>
                        <td>
                        	<select id="backupCycle" name="backupCycle">
                        		<?php 
                        		if($backupRecord['backupCycle']==1){
                        			?>
                        			<option value="1" selected="selected">一天</option>
                        			<option value="7">一周</option>
                        			<option value="30">一个月</option>
                        			<?php
                        		} else if($backupRecord['backupCycle']==7) {
                        			?>
                        			<option value="1">一天</option>
                        			<option value="7" selected="selected">一周</option>
                        			<option value="30">一个月</option>
                        			<?php
                        		} else if($backupRecord['backupCycle']==30) {
                        			?>
                        			<option value="1">一天</option>
                        			<option value="7">一周</option>
                        			<option value="30" selected="selected">一个月</option>
                        			<?php
                        		}
                        		?>
                        	</select>
                        </td>
                    </tr>
                    <tr>
                    	<td  class="td1">
                        	自动备份时间：
                        </td>
                        <td>
                        	<input name="backupTime" id="backupTime" value='<?php echo $backupRecord['backupTime']?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                        </td>
                    </tr>
                    <tr>
                    	<td  class="td1">
                    		备份路径:
                    	</td>
                    	<td>
                    		<select id="pathSelector">
                    		<?php 
                    		if($backupRecord['pathType']==0) {
                    			?>
                    			<option value="0" selected="selected">服务器端磁盘</option>
                    			<option value="1">FTP服务器</option>
                    			<?php
                    		} else {
                    			?>
                    			<option value="0">服务器端磁盘</option>
                    			<option value="1" selected="selected">FTP服务器</option>
                    			<?php
                    		}
                    		?>
                    		</select>
                    	</td>
                    </tr>
                   	<tr id="localDiskSelector">
                    	<td class="td1">所选的备份路径:</td>
                    	<td>
                    		<input type="text" name="localDiskPath" id="localDiskPath" 
							 value="<?php echo $backupRecord['localPath']?>"/> 
                    	</td>
                    </tr>
                    <tr id="ftpPathSelector">
                    	<td class="td1">FTP路径信息:</td>
                    	<td>
                    		<table>
                    			<tr>
                    				<td></td>
                    				<td>IP地址</td>
                    				<td>端口号</td>
                    				<td>路径</td>
                    			</tr>
                    			<tr>
                    				<td class="td1">ftp://</td>
                    				<td class="td1"><input type="text" name="ftpIp" id="ftpIp" value="<?php echo $backupRecord['ftpIp']?>" onchange="ip_check()"/>:</td>
                    				<td class="td1"><input type="text" name="ftpSocket" id="ftpSocket" value="<?php echo $backupRecord['ftpPort']?>" onchange="check_ftpSocket()"/>/</td>
                    				<td><input type="text" name="ftpAllPath" id="ftpAllPath" value="<?php echo $backupRecord['ftpPath']?>" onchange="check_ftpPath()"/></td>
                    			</tr>
                    			<tr>
                    				<td colspan="2">用户名：</td>
                    				<td colspan="2"><input type="text" name="ftpUsername" id="ftpUsername" value="<?php echo $backupRecord['ftpUsername']?>"/></td>
                    			</tr>
                    			<tr>
                    				<td colspan="2">密码：</td>
                    				<td colspan="2"><input type="password" name="ftpPassword" id="ftpPassword" value="<?php echo $backupRecord['ftpPassword']?>"/></td>
                    			</tr>
                    		</table>
                    	</td>
                    </tr>
                    <tr>
                    	<td colspan="2"><span id="warningInfo"></span></td>
                    </tr>
                    <tr>
                        <td class="btn" colspan="2">
                        	<a href="#" class="tijiao" onclick="submitForm();">修改</a><a href="javascript:history.go(-1);" class="repire">返回</a>
                        </td>
                    </tr>
                </tbody>
             </table>
             </form>
          </div>

<!-- warning info  -->
<div id="popWindow" class="popWindow" style="display: none;">
	<img src="<?php echo IMAGE_PATH?>waiting_check.jpg" width="100%">
</div>
<div id="maskLayer" class="maskLayer" style="display: none;">
</div>
 </body>
 </html>