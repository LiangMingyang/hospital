/**
 * @author gengjinkun
 */
function command(module,url)
{
	$('#rightFrame').attr('src',WEB_ROOT+module+'/'+url);
}
function logout(){
	art.dialog({
		title:'提示',
		content:'确定退出吗？',
		icon:'warning',
		okVal:'确定',
		ok:function(){
			window.location.href="../php/login.php";
		},
		cancelVal:'取消',
		cancel:true
	});
}
function changePwd(){
	$('#pwd_no_match').hide();
	$('#old_incorrect').hide();
	art.dialog({
		id:'Pwd_dlg',
		title:'修改密码',
		content:document.getElementById('changePwd_div'),
	});
}
function confirm_pwd(){
	var old_pwd=$('#old_pwd').val();
	var new_pwd=$('#new_pwd').val();
	var confirm_pwd=$('#confirm_pwd').val();
	if(new_pwd!=confirm_pwd){
		$('#pwd_no_match').show();
		return;
	}
	old_pwd=hex_sha1(old_pwd);
	var Password=hex_sha1(new_pwd);
	var ID=$('#ID').val();
	var isUser=$('#isUser').val();
	var url="";
	var encrypttime=getEncryptTime();
	var pwd="";
	if(isUser==1){
		url='UpdatePwd_User';
		$.ajax({
			//url:'../php/TransferStation.php',
			url:"../test_get_hospital.php",
			type:'POST',
			dataType:'json',
			async:false,
			data:{
				encrypttime:encrypttime,
				url:url,
				User_ID:ID
			},
			success:function(data){
			    if(data.msg==0){
			    	pwd=data.Password;
			    }else{
			    	pwd='error';
			    }
			},
			error:function(data){
			    pwd='error';
			}
		});
		if(pwd=='error'){
			art.dialog({
				title:'系统消息',
				icon:'error',
				content:'系统异常,请稍后重试！',
				ok:true,
				okVal:'确定'
			});
			return;
		}else{
			if(old_pwd!=pwd){
				$('#old_incorrect').show();
			}else{
				   $.ajax({
						//url:'../php/TransferStation.php',
						url:"../test_get_hospital.php",
						type:'POST',
						dataType:'json',
						async:false,
						data:{
							encrypttime:encrypttime,
							url:url,
							User_ID:ID
						},
						success:function(data){
			    			if(data.msg==0){
			    				art.dialog({
			    					content:'修改密码成功！',
			    					title:'系统消息',
			    					icon:'succeed',
			    					ok:function(){
			    						art.dialog({ id:'Pwd_dlg'}).close();
			    					},
			    					okVal:'确定'
			    				});
			    			}else{
			    				 art.dialog({
			    					content:'操作失败！错误信息:<br/>'+data.info,
			    					title:'系统消息',
			    					icon:'error',
			    					ok:true,
			    					okVal:'确定'
			    				});
			    			}	
						},
						error:function(data){
			    			   art.dialog({
			    					url:'与服务器交互失败！',
			    					title:'系统消息',
			    					icon:'error',
			    					ok:true,
			    					okVal:'确定'
			    				});
						}
					});
			}
		}
	}else{
		url="UpdatePwd_Admin";
		$.ajax({
			//url:'../php/TransferStation.php',
			url:"../test_get_hospital.php",
			type:'POST',
			dataType:'json',
			async:false,
			data:{
				encrypttime:encrypttime,
				url:url,
				User_ID:ID
			},
			success:function(data){
			    if(data.msg==0){
			    	pwd=data.Password;
			    }else{
			    	pwd='error';
			    }
			},
			error:function(data){
			    pwd='error';
			}
		});
		if(pwd=='error'){
			art.dialog({
				title:'系统消息',
				icon:'error',
				content:'系统异常,请稍后重试！',
				ok:true,
				okVal:'确定'
			});
			return;
		}else{
			if(old_pwd!=pwd){
				$('#old_incorrect').show();
			}else{
				   $.ajax({
						//url:'../php/TransferStation.php',
						url:"../test_get_hospital.php",
						type:'POST',
						dataType:'json',
						async:false,
						data:{
							encrypttime:encrypttime,
							url:url,
							User_ID:ID
						},
						success:function(data){
			    			if(data.msg==0){
			    				art.dialog({
			    					content:'修改密码成功！',
			    					title:'系统消息',
			    					icon:'succeed',
			    					ok:function(){
			    						art.dialog({ id:'Pwd_dlg'}).close();
			    					},
			    					okVal:'确定'
			    				});
			    			}else{
			    				 art.dialog({
			    					content:'操作失败！错误信息:<br/>'+data.info,
			    					title:'系统消息',
			    					icon:'error',
			    					ok:true,
			    					okVal:'确定'
			    				});
			    			}	
						},
						error:function(data){
			    			   art.dialog({
			    					url:'与服务器交互失败！',
			    					title:'系统消息',
			    					icon:'error',
			    					ok:true,
			    					okVal:'确定'
			    				});
						}
					});
			}
		}
	}
	
	
}
function cancel_pwd(){
	$('#old_pwd').val('');
	$('#new_pwd').val('');
	$('confirm_pwd').val('');
	art.dialog({ id:'Pwd_dlg' }).close();
}
function check_reservation(){
    $('#rightFrame').attr('src',"../php/CurReservation.php");
}
function check_history(){
	 $('#rightFrame').attr('src',"../php/HistoryReservation.php");
}
function set_individual_info(){
	$('#rightFrame').attr('src',"../php/Individual_Info.php");
}
function cash_in(){
	$('#rightFrame').attr('src',"../php/Cash_In.php");
}
function create_hospital(){
	$('#rightFrame').attr('src',"../php/CreateHospital.php");
}
function create_doctor(){
	$('#rightFrame').attr('src',"../php/CreateDoctor.php");
}
function config_hospital(){
	$('#rightFrame').attr('src',"../php/ConfigHospital.php");
}
function check_user(){
    $('#rightFrame').attr('src',"../php/CheckUser.php");
}
function create_admin(){
	$('#rightFrame').attr('src',"../php/CreateAdmin.php");
}
function config_admin(){
	$('#rightFrame').attr('src',"../php/ConfigAdmin.php");
}
function config_user(){
	$('#rightFrame').attr('src',"../php/ConfigUser.php");
}
function config_doctor(){
	$('#rightFrame').attr('src',"../php/ConfigDoctor.php");
}
function config_hospital_ordinary_admin(){
	$('#rightFrame').attr('src',"../php/ConfigHospital_OrdinaryAdmin.php");
}
