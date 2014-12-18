$(function(){
	
	/*select操作*/
	var checkText=$("#pathSelector").find("option:selected").text();
	if(checkText=="服务器端磁盘"){
		$("#localDiskSelector").css("display","");
		$("#ftpPathSelector").css("display","none");
	} else {
		$("#localDiskSelector").css("display","none");
		$("#ftpPathSelector").css("display","");
	}
	
	$("#pathSelector").change(function(){
		var selectValue = $(this).children('option:selected').text();
		if(selectValue=="服务器端磁盘"){
			$("#localDiskSelector").css("display","");
			$("#ftpPathSelector").css("display","none");
		} else {
			$("#localDiskSelector").css("display","none");
			$("#ftpPathSelector").css("display","");
		}
	});
	
});

//验证是否是正确的IP
function validateIp(ipObj)
{
   var patrn = /^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/;
   if(!patrn.exec(ipObj))
   {
       return false;
   }
   return true;
}

//验证是否不为空
function checkNonEmpty(str) {
	if(str.length > 0) {
		return true;
	} else {
		return false;
	}
}

function check_danger(str){
		var reg = /[|&;$%@,\'"<>()+]/;	
		var res=reg.test(str);
		if(res){
					return true;
				}
		else{
	             return false;
			}
	
}
function submitForm() {
	var yesOrNoStart = $("input:[name=startRadio]:radio:checked").val();  
	var backupCycle = $("#backupCycle").children('option:selected').val();
	var backupTime = $("#backupTime").val();
	
	var selectValue = $("#pathSelector").children('option:selected').val();
	if(selectValue==1) { //FTP服务器
		var bValid = true;
		var ipObj = $("#ftpIp").val();//&&validateIp(ipObj)
		var socketObj = $("#ftpSocket").val();
		var pathObj = $("#ftpAllPath").val();
		var userNameObj = $("#ftpUsername").val();
		var passwordObj = $("#ftpPassword").val();
		bValid = bValid&&validateIp(ipObj)&&checkNonEmpty(pathObj)&&checkNonEmpty(userNameObj)&&checkNonEmpty(passwordObj);
		if(bValid) {
			showDiv();
			$.ajax({
				url:"cfg.php?cmd=update&type=ftp",
				type:"POST",
				dataType:"text",
				data:{
					yesOrNoStart:yesOrNoStart,
					backupCycle:backupCycle,
					backupTime:backupTime,
					ftpIp:ipObj,
					ftpSocket:socketObj,
					ftpPath:pathObj,
					ftpUserName:userNameObj,
					ftpPassword:passwordObj
				},
				success:function(data){
					if(data=="OK"){
						artDialog({content:'保存成功！', style:'succeed'}, function(){
						});
					} else if(data=="ERROR"){
						artDialog({content:'路径不存在，请检查！修改失败！', style:'error'}, function(){
						});
					}
					
					closeDiv();
//					window.location.href="backup.php?tab=log";
//					window.location.href="backup.php";
				}
			});
		} else {
			$("#warningInfo").html("请填写正确的FTP信息！");
		}
	} else {
		var bValid = true;
		var localPathObj = $("#localDiskPath").val();
		//alert(localPathObj);
		if(check_danger(localPathObj)){
			artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
			return;
		}
		bValid = bValid&&checkNonEmpty(localPathObj);
		if(bValid) {
			showDiv();
			$.ajax({
				url:"cfg.php?cmd=update&type=local",
				type:"POST",
				dataType:"text",
				data:{
					yesOrNoStart:yesOrNoStart,
					backupCycle:backupCycle,
					backupTime:backupTime,
					localPath:$("#localDiskPath").val()
				},
				success:function(data){
					if(data=="OK"){
						artDialog({content:'保存成功！', style:'succeed'}, function(){
						});
					} else if(data=="ERROR"){
						artDialog({content:'路径不存在，请检查！修改失败！', style:'error'}, function(){
						});
					}
//					alert(data);
					closeDiv();
//					window.location.href="backup.php?tab=log";
//					window.location.href="backup.php";
				}
			});
		} else {
			$("#warningInfo").html("请选择本地备份路径！");
		}
	}
}

function showDiv() {
    document.getElementById('popWindow').style.display = 'block';
    document.getElementById('maskLayer').style.display = 'block';      
}
function closeDiv() {
    document.getElementById('popWindow').style.display = 'none';
    document.getElementById('maskLayer').style.display = 'none';
}

function getSysInfo(){
	setTimeout(getDisk,500);
}
function getDisk(){
	$.get(WEB_ROOT+'backup/archive.php?cmd=disk',{dt:new Date().getTime()},function(data){
//		alert(data);
//		alert(JSON.stringif(data));
		try{
			arr = $.evalJSON(data);
			tmp = findSWF("disk");
			x = tmp.load(arr[0]);
		}catch(ex){
			alert(ex);
		}
		setTimeout(getDisk,5000);
	});
}

function findSWF(movieName) {
	  if (navigator.appName.indexOf("Microsoft")!= -1) {
	    return window[movieName];
	  } else {
	    return document[movieName];
	  }
	}