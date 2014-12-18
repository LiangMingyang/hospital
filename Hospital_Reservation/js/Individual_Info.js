/**
 * @author acer
 */

function check_accord_pwd(){
	if($("#confirm_pwd").val()!=$('#new_pwd').val()){
		$('#tag_info').show();
		return false;
	}
    else
    return true;
}
function confirm_change_pwd(){
	var encrypttime=getEncryptTime();
	var token=getToken(encrypttime);
	var old_pwd=$('#old_pwd').val();
	var new_pwd=$('#new_pwd').val();
	var User_ID=$('#name').attr('name');
	if(check_accord_pwd()){
		$('#tag_info').hide();
		$.ajax({
				url:"../test_reset_pwd.php",
				datatype:"json",
				type:'POST',
				data:{
					encrypttime:encrypttime,
					token:token,
					User_ID:User_ID,
					Old_Pwd:old_pwd,
  					New_Pwd:new_pwd
				},
				success:function(data){
					data=eval("("+data+")");
					if(data.msg==0){
						art.dialog({
							title:'系统消息',
							content:'更新密码成功',
							icon:'succeed',
							okVal:'确定',
							ok:function(){
								art.dialog({id:'change_Pwd'}).close();
						}
				       });
				   }else if(data.msg==3){
							art.dialog({
								title:'系统消息',
								content:'请求超时',
								icon:'fail',
								okVal:'确定',
								ok:true
							});
				   }else {
							art.dialog({
								title:'系统消息',
								content:'旧密码错误',
								icon:'error',
								okVal:'确定',
								ok:true
							});
						}
					},
					error:function(data){
						art.dialog({
								title:'系统消息',
								content:'与服务器交互失败',
								icon:'error',
								okVal:'确定',
								ok:true
							});
					}
				});
	}
			
		
}
function cancel_pwd(){
	art.dialog({id:'change_Pwd'}).close();
}
function changePwd(){
	$('#confirm_pwd').val('');
	$("#new_pwd").val('');
	$('#old_pwd').val('');
	
	art.dialog({
		id:'change_Pwd',
		title:'更改密码',
		top:'15%',
		left:'40%',
		lock: true,
		width:600,
        background: '#457387', // 背景色
        opacity: 0.87,	// 透明度
		content:document.getElementById("pwd_area"),
		
	});
	//art.dialog({id:'Fetch_Pwd'}).close();
}
function update_info(){
	var User_ID=$('#name').attr('name');
	var User_Name=$('#name').val();
	var Sex=$('#sex').val();
	var Identity_ID=$('#identity_id').val();
	var Birthday=$('#birthday').val();
	var Province_ID=$('#Province').val();
	var Phone=$('#phone').val();
	var Mail=$('#mail').val();
	var Area_ID=$('#Area').val();
	$.ajax({
		url:"../test_updateInfo.php",
		//url:" host/Update_Individual_Info
		type:'POST',
		datatype:'json',
		data:{
			 User_ID:User_ID,
	 		 User_Name:User_Name,
	 		 Sex:Sex,
	 		 Identity_ID:Identity_ID,
	 		 Birthday:Birthday,
	 		 Province_ID:Province_ID,
	 		 Phone:Phone,
	 		 Mail:Mail,
	 		 Area_ID:Area_ID
		},
		success:function(data){
			data=eval("("+data+")");
			if(data.msg=='0'){
				art.dialog({
					icon:'succeed',
					content:'保存成功',
					ok:true,
					okVal:'确定'
				});
			}else if(data.msg=='3'){
				art.dialog({
					title:'系统消息',
					content:'请求超时',
					icon:'error',
					ok:true,
					okVal:'确定'
				});
				
			}else{
				art.dialog({
					title:'系统消息',
					content:'操作失败',
					icon:'error',
					ok:true,
					okVal:'确定'
				});
			}
		},
		error:function(data){
			art.dialog({
				title:'系统消息',
				content:'与服务器交互失败',
				ok:true,
				okVal:'确定'
			});
		}
	});
}
