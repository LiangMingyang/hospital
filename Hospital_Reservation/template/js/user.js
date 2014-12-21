
function saveNewUser(){
	var name = $("#username").val();
	//alert("hha");
	$.ajax({ 
        type : "get", 
        url : WEB_ROOT+'system/user.php', 
        data : {
	  			userName:name,
				userId:$('#userId').val(),
				rm:Math.random()
				}, 
        success : function(data){ 
      	  if(data == 'OK'){
      		  if($('#userId').val()==''){
      			if(checkPwd()&&checkTel()&&checkFullName()&&checkEmail()){
          			$.ajax({
          				url:"userInfo.php?cmd=save",
          				type:"POST",
          				dataType:"text",
          				data:{
          					username:$("#username").val(),
          					password:$("#password").val(),
          					roleId:$("#roleId").val(),
          					fullname:$("#Fullname").val(),
          					telephone:$("#telText").val(),
          					email:$("#emailText").val(),
          					userId:$("#userId").val()
          				},
          				success:function(data){
          					if(data=="OK"){
          						artDialog({content:'保存成功！', style:'succeed'}, function(){
          							window.location.href="userMgr.php";
          						});
          					} else {
          						artDialog({content:'服务器出错，保存失败，请重试！', style:'error'}, function(){
          							window.location.href="userMgr.php";
          						});
          					}
          				}
          			});
          		}
          		 else {
          			artDialog({content:'必填项不能为空，且输入正确格式！', style:'alert'}, function(){
    				});
          		}
      		  }else{
      			if(checkTel()&&checkFullName()&&checkEmail()){
      			$.ajax({
      				url:"userInfo.php?cmd=save",
      				type:"POST",
      				dataType:"text",
      				data:{
      					username:$("#username").val(),
      					password:$("#password").val(),
      					roleId:$("#roleId").val(),
      					fullname:$("#Fullname").val(),
      					telephone:$("#telText").val(),
      					email:$("#emailText").val(),
      					userId:$("#userId").val()
      				},
      				success:function(data){
      					if(data=="OK"){
      						artDialog({content:'保存成功！', style:'succeed'}, function(){
      							window.location.href="userMgr.php";
      						});
      					} else {
      						artDialog({content:'服务器出错，保存失败，请重试！', style:'error'}, function(){
      							window.location.href="userMgr.php";
      						});
      					}
      				}
      			});
      		}
      		 else {
      			artDialog({content:'必填项不能为空，且输入正确格式！', style:'alert'}, function(){
				});
      		}
      		  }
			  }else{
					$('#username').removeClass();
					$('#username').addClass('inputError');
					$('#userNameTip').html('用户名已存在，请重新输入');
					status = false; 
			  }				
        } 
       });
	
}

function userSave()
{
	var username=$('#username').val();
	if(username== null || username==''){

		$('#username').removeClass();
		$('#username').addClass('inputError');
		$('#userNameTip').html('用户名不能为空');
//		$('#username').focus();
		return false;
	}
	if(checkUserName(false) != 'OK')
		return false;
	if(checkPwd() != true)
		return false;
	if(checkTel() != true){
		return false;
	}
	if(checkFullName() != true){
		return false;
	}
	if(checkEmail() != true){
		return false;
	}
	return true;
}

function checkTel(){
	//验证电话号码
	var phone = $("#telText").val();
	if($.trim(phone).length>0) {
		var tel = /(^[0-9]{3,4}\-[0-9]{7,8}$)|(^[0-9]{7,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)|(13\d{9}$)|(15[0135-9]\d{8}$)|(18[267]\d{8}$)/;
		if(phone != "" && phone.replace(/\s/g,"")!="" && !(tel.exec(phone))) {
	//		alert("电话号码格式不对，正确格式如下：\n座机号码：区号-座机号码(或)\n手机号码：11位手机号码");
			$('#telText').removeClass();
			$('#telText').addClass('inputError');
			$('#telTip').html('电话号码格式不对，正确格式如下：\n座机号码：区号-座机号码(或)\n手机号码：11位手机号码！');
//			$('#telText').focus();
			return false;
		}
	}
	$('#telText').addClass('inputRight');
	$('#telTip').html('');
	return true;
}

function checkEmail(){
	//验证电话号码
	var email = $("#emailText").val();
	if($.trim(email).length>0) {
		var emailRex =/^(?:\w+\.?)*\w+@(?:\w+\.)+\w+$/;
		if(emailRex.test(email)!=true) {
	//		alert("电话号码格式不对，正确格式如下：\n座机号码：区号-座机号码(或)\n手机号码：11位手机号码");
			$('#emailText').removeClass();
			$('#emailText').addClass('inputError');
			$('#emailTip').html('请输入正确的电子邮箱地址！');
//			$('#emailText').focus();
			return false;
		}
	}
	if($.trim(email).length>20) {
		$('#emailText').removeClass();
		$('#emailText').addClass('inputError');
		$('#emailTip').html('电子邮箱地址不能超过20个字符！');
//		$('#emailText').focus();
		return false;
	}
	$('#emailText').addClass('inputRight');
	$('#emailTip').html('');
	return true;
}

function updatePwd(){
	var username=$('#oldpwd').val();
	if(username== null || username==''){
//		alert('旧密码不能为空');
//		$('#oldpwd').focus();
		$('#oldpwd').removeClass();
		$('#oldpwd').addClass('inputError');
		$('#oldpwdTip').html('旧密码不能为空！');
//		$('#oldpwd').focus();
		return false;
	}
	
	$('#oldpwd').addClass('inputRight');
	$('#oldpwdTip').html('');
	
	var password = $('#password').val();
	if(password==null || password==''){
//		alert('密码不能为空');
//		$('#password').focus();
		$('#password').removeClass();
		$('#password').addClass('inputError');
		$('#passwordTip').html('密码不能为空！');
//		$('#password').focus();
		return false;
	}
	$('#password').addClass('inputRight');
	$('#passwordTip').html('');
	if(password.length>20){
//		alert('密码不能为空');
//		$('#password').focus();
		$('#password').removeClass();
		$('#password').addClass('inputError');
		$('#passwordTip').html('密码不能超过20个字符！');
//		$('#password').focus();
		return false;
	}
	
	$('#password').addClass('inputRight');
	$('#passwordTip').html('');
	
	var password2 = $('#password2').val();
	if(password2 == null || password2 == ''){
//		alert('请重复输入密码');
//		$('#password2').focus();
		$('#password2').removeClass();
		$('#password2').addClass('inputError');
		$('#password2Tip').html('请重复输入密码！');
//		$('#password2').focus();
		return false;
	}
	$('#password2').addClass('inputRight');
	$('#password2Tip').html('');
	
	if(password != password2){
//		alert('两次输入的密码不一致，请重新输入');
//		$('#password').val('');
//		$('#password2').val('');
//		$('#password').focus();
		$('#password2').removeClass();
		$('#password2').addClass('inputError');
		$('#password2Tip').html('两次输入的密码不一致，请重新输入！');
//		$('#password2').focus();
		return false;
	}
	$('#password2').addClass('inputRight');
	$('#password2Tip').html('');
	
	$.get(WEB_ROOT+'system/pwdmodify.php',{
		cmd:'update',
		oldPwd:username,
		newPwd:password
	},function(data){
		if(data=='Error_Old_Pwd'){
			artDialog({content:'密码修改失败，请检查旧密码输入是否正确！', style:'error'}, function(){
//				$('#oldpwd').focus();
				$('#oldpwd').removeClass();
				$('#oldpwd').addClass('inputError');
				$('#oldpwdTip').html('密码修改失败，请检查旧密码输入是否正确！');
//				$('#oldpwd').focus();
			});
		} else {
			artDialog({content:'密码修改成功！', style:'succeed'}, function(){
				$('#oldPwd').addClass('inputRight');
				$('#oldPwdTip').html('');
				$('#password').addClass('inputRight');
				$('#passwordTip').html('');
				$('#password2').addClass('inputRight');
				$('#password2Tip').html('');
			});
		}
	});
	return false;
}
function checkUserName(async){
	var name= $('#username').val();
	if(name != null && name != ''){
		if(name.length > 20){
			$('#userNameTip').html('<font color="red">用户名不能超过20个字符！</font>');
			return false;
		} else {
			var status = false;
			$('#userNameTip').html('<img src="'+WEB_ROOT+'template/images/load.gif"/>');
			$.ajax({ 
		          type : "get", 
		          url : WEB_ROOT+'system/user.php', 
		          data : {
			  			userName:name,
						userId:$('#userId').val(),
						rm:Math.random()
						}, 
		          async : async, 
		          success : function(data){ 
		        	  if(data == 'OK'){
							$('#username').removeClass();
							$('#username').addClass('inputRight');
							$('#userNameTip').html('');		
							status = true; 
					  }else{
							$('#username').removeClass();
							$('#username').addClass('inputError');
							$('#userNameTip').html('用户名已存在，请重新输入');
							status = false; 
					  }
		        	  return status;
						
		          } 
		         });
	        
		}
		
	} else {
		return false;
	}
}
function checkPwd(){
	
	var password = $('#password').val();
	if(password== null || password==''){
		$('#password').removeClass();
		$('#password').addClass('inputError');
		$('#passwordTip').html('密码不能为空！');
//		$('#password').focus();
		return false;
	}
	$('#password').addClass('inputRight');
	$('#passwordTip').html('');
	
	if(password.length > 20) {
		$('#password').removeClass();
		$('#password').addClass('inputError');
		$('#passwordTip').html('密码不能超过20个字符！');
//		$('#password').focus();
		return false;
	}
	$('#password').addClass('inputRight');
	$('#passwordTip').html('');
	return true;
}

function checkFullName(){
	var Fullname = $('#Fullname').val();
	if($.trim(Fullname).length>0) {
		if(Fullname.length > 20) {
			$('#Fullname').removeClass();
			$('#Fullname').addClass('inputError');
			$('#fullNameTip').html('名字不能超过20个字符！');
//			$('#Fullname').focus();
			return false;
		}
	}
	$('#Fullname').addClass('inputRight');
	$('#fullNameTip').html('');
	return true;
}
//function checkPwd(){
//	var password = $('#password').val();
//	if(password==null || password==''){
//		$('#password').removeClass();
//		$('#password').addClass('inputError');
//		$('#pwdTip').html('密码不能为空');
//		$('#password').focus();
//		return false;
//	}
//	$('#password').addClass('inputRight');
//	$('#pwdTip').html('');
//	var password2 = $('#password2').val();
//	if(password2 == null || password2 == ''){
//		$('#password2').removeClass();
//		$('#password2').addClass('inputError');
//		$('#pwd2Tip').html('密码不能为空');
//		$('#password2').focus();
//		return false;
//	}
//	$('#password2').addClass('inputRight');
//	$('#pwd2Tip').html('');
//	if(password != password2){
//		$('#password').removeClass();
//		$('#password').addClass('inputError');
//		$('#password2').removeClass();
//		$('#password2').addClass('inputError');
//		$('#pwdTip').html('两次输入的密码不一致，请重新输入');
////		$('#password').focus();
////		$('#password').val('');
////		$('#password2').val('');
////		$('#password').focus();
//		return false;
//	}
//	$('#password').addClass('inputRight');
//	$('#pwdTip').html('');
//	$('#password2').addClass('inputRight');
//	$('#pwd2Tip').html('');
//	return true;
//}