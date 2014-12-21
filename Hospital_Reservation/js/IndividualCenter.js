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
			$.ajax({
				type: "post",//使用post方法访问后台
				dataType: "json",//返回json格式的数据
				url:'php/logout.php'
			});
			window.location.href="../php/login.php";
		},
		cancelVal:'取消',
		cancel:true
	});
}
function changePwd(){
	$('#pwd_no_match').hide();
	$('#old_incorrect').hide();
		$('#old_pwd').val('');
	$('#new_pwd').val('');
	$('#confirm_pwd').val('');
	art.dialog({
		id:'Pwd_dlg',
		title:'修改密码',
		content:document.getElementById('changePwd_div'),
	});
}
function check_pwd(old_pwd){
	var ans=false;
	var isUser=$('#isUser').val();
	var url="";
	var encrypttime=getEncryptTime();
	var pwd="";
	if(isUser==1){
		url="Get_Password_User";
		var User_ID=$('#User_ID').val();
		$.ajax({
			url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
			async:false,
			data:{
				encrypttime:encrypttime,
				url:url,
				User_ID:User_ID,
			},
			success:function(data){
				//alert(old_pwd);
				//7c4a8d09ca3762af61e59520943dc26494f8941b
				if(data.msg==0){
					if(data.password==old_pwd){
						ans=true;
					}else{
						ans=false;
					}
				}else{
					ans=false;
				}
			},
			error:function(data){
				ans=false;
			}
			
			
		});
	}else{
		url="Get_Password_Admin";
		var Admin_ID=$('#Admin_ID').val();
		$.ajax({
			url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
			async:false,
			data:{
				encrypttime:encrypttime,
				url:url,
				Admin_ID:Admin_ID,
			},
			success:function(data){
			
				if(data.msg==0){
					if(data.password==old_pwd){
						ans=true;
					}else{
						ans=false;
					}
				}else{
					ans=false;
				}
			},
			error:function(data){
				ans=false;
			}
		});
	}
	return ans;
}
function confirm_pwd(){
	var old_pwd=$('#old_pwd').val();
	var new_pwd=$('#new_pwd').val();
	$('#pwd_no_match').hide();
	$('#old_incorrect').hide();
	var confirm_pwd=$('#confirm_pwd').val();

	if(new_pwd!=confirm_pwd){
		$('#pwd_no_match').show();
		
		return;
	}
	old_pwd=hex_sha1(old_pwd);
	if(!check_pwd(old_pwd)){
		$('#old_incorrect').show();
		return;
	}
	var Password=hex_sha1(new_pwd);
	var isUser=$('#isUser').val();
	var url="";
	var encrypttime=getEncryptTime();
	var pwd="";
	if(isUser==1){
		url='UpdatePwd_User';
		var User_ID=$('#User_ID').val();
		$.ajax({
			url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
			async:false,
			data:{
				encrypttime:encrypttime,
				url:url,
				User_ID:User_ID,
				Password:Password
			},
			success:function(data){
			    if(data.msg==0){
			    	art.dialog({
			    		title:'系统消息',
			    		content:'操作成功！',
			    		icon:'succeed',
			    		ok:true,
			    		okVal:'确定'
			    	});
			    }else{
			    	art.dialog({
			    		title:'系统消息',
			    		content:'操作失败！<br/>'+data.info,
			    		icon:'error',
			    		cancel:true,
			    	    cancelVal:'确定'
			    	});
			    }
			},
			error:function(data){
			      art.dialog({
			    		title:'系统消息',
			    		content:'与服务器交互失败',
			    		icon:'error',
			    		cancel:true,
			    	    cancelVal:'确定'
			    	});
			}
		});	
    }else{
    	url='UpdatePwd_Admin';
		var Admin_ID=$('#Admin_ID').val();
		$.ajax({
			url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
			async:false,
			data:{
				encrypttime:encrypttime,
				url:url,
				Admin_ID:Admin_ID,
				Password:Password
			},
			success:function(data){
			    if(data.msg==0){
			    	art.dialog({
			    		title:'系统消息',
			    		content:'操作成功！',
			    		icon:'succeed',
			    		ok:true,
			    		okVal:'确定'
			    	});
			    }else{
			    	art.dialog({
			    		title:'系统消息',
			    		content:'操作失败！<br/>'+data.info,
			    		icon:'error',
			    		cancel:true,
			    	    cancelVal:'确定'
			    	});
			    }
			},
			error:function(data){
			      art.dialog({
			    		title:'系统消息',
			    		content:'与服务器交互失败',
			    		icon:'error',
			    		cancel:true,
			    	    cancelVal:'确定'
			    	});
			}
		});	
    }
	
	
}
function cancel_pwd(){
	$('#old_pwd').val('');
	$('#new_pwd').val('');
	$('#confirm_pwd').val('');
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
