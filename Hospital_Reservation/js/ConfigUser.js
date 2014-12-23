/**
 * @author acer
 */
function get_province(){
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		async:false,
		data:{
			url:'Get_Province_Info',
			encrypttime:encrypttime
		},
		success:function(data){
			if(data.msg==0){
				var content=data.content;
				var len=content.length;
				for(var i=0;i<len;i++){
					$('#Province_ID')
					.append('<option value="'
					+content[i].Province_ID
					+'">'+content[i].Province_Name+'</option>');
				}
				
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
					content:'拉取医院信息失败，请稍后重试！',
					icon:'error',
					cancel:true,
					cancelVal:'关闭',
				});
		}
	});
}
function getArea(Province_ID){
	var encrypttime=getEncryptTime();
	$.ajax({
		    url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
			async:false,
			data:{
					url:'Get_Area_Info_By_Province_ID',
					encrypttime:encrypttime,
					Province_ID:Province_ID
			},
			success:function(data){
					if(data.msg=='0'){
							var content=data.content;
							var len=content.length;
							for(var i=0;i<len;i++){
								$('#Area_ID')
					            .append('<option value="'
					            +content[i].Area_ID
					            +'">'+content[i].Area_Name+'</option>');
							}
					}else {
						art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！错误信息：'+data.info,
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
function search_user(){
	var encrypttime=getEncryptTime();
	var Identity_ID=$('#ID').val();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		async:false,
		data:{
			url:'Find_User_By_Identity_ID',
			encrypttime:encrypttime,
			Identity_ID:Identity_ID
		},
		success:function(data){
			$('#user_info').hide();
			$('#no_signal').hide();
			if(data.msg==0){
				if(data.content.length==0){
					$('#no_signal').show();
					return;
				}
				
				data=data.content[0];
				$('#UserName').attr('name',data.User_ID);
				$('#UserName').val(data.UserName);
				$('#Identity_ID').val(data.Identity_ID);
				$('#Credit_Rank').val(data.Credit_Rank);
				$('#Appointment_Limit').val(data.Appointment_Limit);
				$('#Birthday').val(data.Birthday);
				$('#Location').val(data.Location);
				$('#Phone').val(data.Phone);
				$('#Mail').val(data.Mail);
				if(data.Sex==0){
					$('input:radio[name=Sex]')[0].checked = true;
				}else{
					$('input:radio[name=Sex]')[1].checked = true;
				}
				get_province();
				var Area_ID=data.Area_ID;
				var Province_ID=Math.floor(Area_ID/100);
				$('#Area_ID').val(Area_ID);
				$('#Province_ID').val(Province_ID);
				getArea(Province_ID);
				$('#user_info').show();
			}else{
				art.dialog({
					title:'系统消息',
					content:'系统异常，异常信息：'+data.info,
					icon:"error",
					ok:true,
					okVal:'确定'
				});
			}
		},
		error:function(data){
			art.dialog({
					title:'系统消息',
					content:'与服务器交互失败！',
					icon:'error',
					ok:true,
					okVal:'确定'
				});
		}
	});
}
function save_change(){
	var encrypttime=getEncryptTime();
	var User_ID=$('#UserName').attr('name');
	var UserName=$('#UserName').val();
	var Identity_ID=$('#Identity_ID').val();
	var Credit_Rank=$('#Credit_Rank').val();
	var Appointment_Limit=$('#Appointment_Limit').val();
	var Birthday=$('#Birthday').val();
	var Location=$('#Location').val();
	var Area_ID=$('#Area_ID').val();
	var Phone=$('#Phone').val();
	var Mail=$('#Mail').val();
	var Sex=$('input:radio[name=Sex]:checked').val();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'update_user',
			encrypttime:encrypttime,
			User_ID:User_ID,
    		UserName:UserName, 
    		Identity_ID:Identity_ID,
     		Credit_Rank:Credit_Rank,
			Appointment_Limit:Appointment_Limit,
			Sex:Sex,
    		Birthday:Birthday,
    		Location:Location,
    		Phone:Phone,
			Mail:Mail,
			Area_ID:Area_ID 
		},
		success:function(data){
			if(data.msg==0){
				art.dialog({
					title:'系统消息',
					content:'操作成功！',
					icon:"succeed",
					ok:true,
					okVal:'确定'
				});
			}else{
				art.dialog({
					title:'系统消息',
					content:'系统异常，异常信息：'+data.info,
					icon:"error",
					ok:true,
					okVal:'确定'
				});
			}
		},
		error:function(data){
			 art.dialog({
					title:'系统消息',
					content:'与服务器交互失败！',
					icon:'error',
					ok:true,
					okVal:'确定'
				});
		}
	});
	
}
