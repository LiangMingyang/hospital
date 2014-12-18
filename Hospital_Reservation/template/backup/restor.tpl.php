<?php
/**
 * 数据库还原
 * restor.tpl.php-.
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
<script src="<?php echo JS_PATH?>jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH?>uploadify.css">
<script type="text/javascript">

function showDiv() {
    document.getElementById('popWindow').style.display = 'block';
    document.getElementById('maskLayer').style.display = 'block';      
}
function closeDiv() {
    document.getElementById('popWindow').style.display = 'none';
    document.getElementById('maskLayer').style.display = 'none';
}

function contains(string,substr,isIgnoreCase)
{
    if(isIgnoreCase)
    {
     string=string.toLowerCase();
     substr=substr.toLowerCase();
    }
     var startChar=substr.substring(0,1);
     var strLen=substr.length;
         for(var j=0;j<string.length-strLen+1;j++)
         {
             if(string.charAt(j)==startChar)//如果匹配起始字符,开始查找
             {
                   if(string.substring(j,j+strLen)==substr)//如果从j开始的字符与str匹配，那ok
                   {
                         return true;
                   }   
             }
         }
         return false;
}

/*检查是否不为空*/
function checkNonEmpty(o){
	if(o.val().length > 0){
		return true;
	}else {
		return false;
	}
}

/*判断输入的是不是Sql文件名*/
function checkSqlFile(o) {
	var fileName = o.val();
	var sql = fileName.substring(fileName.length-4);
	return contains(sql.toLowerCase(),".sql",true);
}

function restore() {
	showDiv();
	var locationType = $("input:[name=locationType]:radio:checked").val(); 
	if(locationType==0) { //从本地上传sql文件还原
		$.ajax({
			url:"restore.php?dosubmit=restore&locationType=0",
			type:"get",
			dataType:"text",
			complete:function(){
				closeDiv();
			},
			success:function(data){
				alert(data);
			}
		});	
	} else { //从服务器还原
		$.ajax({
			url:"restore.php?dosubmit=restore&locationType=1",
			type:"get",
			dataType:"text",
			complete:function(){
				closeDiv();
			},
			success:function(data){
				alert(data);
			}
		});	
	}
}
</script>

<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : 'uploadify.swf',
				'uploader' : 'uploadify.php',
                'auto': true,
                'multi': false,
        'onUploadSuccess':function(file, data, response){ 
            alert(data);
        } 

			});
		});
	</script>

<body>
<h5 class="title102"><em>数据库恢复</em></h5>
<div class="box102 p20">
	<div class="tabContent">
<div style="width:100%;margin-top:20px;text-align:center;">
<p style="font-size:24px;">欢迎使用数据恢复服务</p>
	<img src="<?php echo IMAGE_PATH?>upload600.jpg" width="60%">
</div>
		<div style="width:100%;font-size:18px;">
		<table width="100%" class="tab1">
		<tr>
					<td>1. 选择从服务器中恢复，服务器会恢复到最近的备份sql数据</td>
				</tr>
				<tr>
					<td>2. 选择本地的sql文件上传进行数据恢复</td>
				</tr>
		</table>
		</div>
		<div style="margin-top:30px;">
		<form action="restore.php?dosubmit=restore&locationType=0" name="restoreForm" method="post" enctype="multipart/form-data">
			<div style="margin-top:30px; width:100%;">
			<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab1" style="font-size:16px;">    
				
				<tr>
				<td><span><font style="font-size:14px;font-weight:bold;">请选择恢复数据的来源：</font></span></td>
				</tr>
				<tr>
                   	<td>
                   		<input type="radio" name="locationType" value="1" checked="checked"/>从服务器恢复
                	</td>   
                </tr>
                <tr>
                	<td>
                		<input type="radio" name="locationType" value="0"/>从本地恢复
                    	点击选择上传本地文件<input id="file_upload" name="file_upload" type="file" multiple="true">
                	</td>
                </tr>
             </table>   
			</div>
			<div style="width:100%;margin-top:30px;text-align:center;">
				<a href="#" class="tijiao" onclick="restore();">恢复</a><a href="javascript:history.go(-1);" class="repire">返回</a>
			</div>
		</form>
		</div>
	</div>
</div>
<div id="popWindow" class="popWindow" style="display: none;">
       <img src="<?php echo IMAGE_PATH?>waiting_restore.jpg" width="100%">
    </div>
    <div id="maskLayer" class="maskLayer" style="display: none;">
    </div>
</body>

</html>