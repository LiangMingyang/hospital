/**
 * @author acer
 */

function login(){ 
	var type=$('input[name="radiobutton"]:checked').val();
	if(type==0){//管理员
		login_admin(type);
	}else{
		login_user(type);
	}
}
function tiaozhuan()
{
	$.ajax({
		type: "post",//使用post方法访问后台
		dataType: "json",//返回json格式的数据
		url:'../php/tiaozhuan.php',
		async:false
	});
}
function login_user(type){
	var loginname=$("#loginname").val();
	var password=$("#password").val();
	var encrypttime=getEncryptTime();
	password=hex_sha1(password); 
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		async:false,
		data:{
			url:"LogIn_User",
			encrypttime:encrypttime,
			Identity_ID:loginname,
            PASSWORD:password
		},
		success:function(data){
			if(data.msg=='0'){
				    data=data.content;
				    if(data.isChecked==0){
				    	art.dialog({
				    		title:'系统提示',
				    		content:'用户尚未被审核',
				    		ok:true,
				    		okVal:'确定'
				    	});
				    	return;
				    }
					tiaozhuan();
					$('#UserName').val(data.UserName);
					$('#User_ID').val(data.User_ID);
				 	$('#Province_ID').val(data.Province_ID);
				 	$('#Province_Name').val(data.Province_Name);
				 	$('#Credit_Rank').val(data.Credit_Rank);
				 	$('#Area_ID').val(data.Area_ID);
					$('#Area_Name').val(data.Area_Name);
				 	$('#Identity_ID').val(data.Identity_ID);
				 	$('#Appointment_Limit').val(data.Appointment_Limit);
					$('#Sex').val(data.Sex);
				 	$('#Birthday').val(data.Birthday);
				 	$('#Location').val(data.Location);
				 	$('#Phone').val(data.Phone);
				 	$('#Mail').val(data.Mail);
				 	//alert(data.LastLogInTime);
				 	/*
				 	if(isNaN(data.LastLogInTime)){
				 		data.LastLogInTime=getStandardDate(data.LastLogInTime);
				 	}
				 	*/
				 	//var sdt=getStandardDate(data.LastLogInTime);
				 	//alert(sdt);
				 	$('#LastLogInTime_User').val(data.LastLogInTime);
			     	$('#backinfo_User').submit();
			}else{
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'登录失败，失败信息<br/>'+data.info,
							ok:true,
							okVal:'确定'
						});
			}
		},
		error:function(data){
			art.dialog({
							title:'系统消息',
							icon:'error',
							content:'与服务器交互失败！',
							ok:true,
							okVal:'确定'
						});
		}
	});
	
}
function login_admin(type){
	var Admin_Name=$("#loginname").val();
	var Password=$("#password").val();
	var encrypttime=getEncryptTime();
	Password=hex_sha1(Password); 
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		async:false,
		data:{
			url:"LogIn_Admin",
			encrypttime:encrypttime,
			Admin_Name:Admin_Name,
            PASSWORD:Password
		},
		success:function(data){
			if(data.msg=='0'){	
					tiaozhuan();
				    data=data.content;
					$('#Admin_Name').val(Admin_Name);
					$('#Admin_ID').val(data.Admin_ID);
					$('#isSuper').val(data.isSuper);
					$('#LastLogInTime_Admin').val(data.LastLogInTime);
					$('#backinfo_Admin').submit();	
			}else{
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'登录失败，失败信息<br/>'+data.info,
							ok:true,
							okVal:'确定'
						});
			}
		},
		error:function(data){
					art.dialog({
							title:'系统消息',
							icon:'error',
							content:'与服务器交互失败！',
							ok:true,
							okVal:'确定'
						});
		}
	});
}
function find_pwd(){
	var type=$('input[name="radiobutton"]:checked').val();
	if(type==0){
		art.dialog({
			title:'系统提示',
			content:'管理员请联系超级管理员进行密码重置！',
			ok:true,
			okVal:'我知道了'
		});
		return;
	}
	else{
		$('#Identity_ID').val('');
		art.dialog({
		title:'找回密码',
		content:document.getElementById('find_pwd_div'),
	    });
	}
	
}
function changeReminder(){
	var type=$('input[name="radiobutton"]:checked').val();
	if(type==0){
		$("#loginname").val('请输入管理员账号');
	}else {
		$("#loginname").val('请输入身份证号');
	}
}
function clear_blank(t){
	$(t).val('');
}
function send_mail(){
	var encrypttime=getEncryptTime();
	var Identity_ID=$('#Identity_ID').val();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Find_User_By_Identity_ID',
			encrypttime:encrypttime,
			Identity_ID:Identity_ID
		},
		success:function(data){
			if(data.msg==0){
				data=data.content[0];
				var User_ID=data.User_ID;
				var Mail=data.Mail;
				send_mail_mk(User_ID,Mail);
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
function send_mail_mk(User_ID,Mail){
	$.ajax({
		url:'../php/mail_for_pwd.php',
		dataType:'text',
		type:'POST',
		data:{
			User_ID:User_ID,
			Mail:Mail
		},
		success:function(data){
			if(data=='OK'){
				art.dialog({
					icon:'face-smile',
					title:'系统消息',
					content:'邮件已经发送至您的注册邮箱，请通过邮件中的重置链接进行密码重置！',
					ok:true,
					okVal:'我知道了'
				});
			}else{
				art.dialog({
					icon:'error',
					title:'系统消息',
					content:'操作失败，请稍后重试！',
					cancel:true,
					cancelVal:'我知道了'
				});
			}
		},
		error:function(data){
			art.dialog({
					icon:'error',
					title:'系统消息',
					content:'与服务器交互失败！',
					cancel:true,
					cancelVal:'关闭'
				});
		}
	});
}

		