
$(document).ready(function() {
	getAdminList(0,16);
});

function getAdminList(start,size){
	var encrypttime=getEncryptTime();
	$('#Admin_tb tr').remove();
	$.ajax(
		{
			url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
			data:{
				url:"Get_AdminInfo",
				encrypttime:encrypttime,
				start:start,
				size:size
			},
			success:function(data){
				if(data.msg==0){
					var content=data.content;
					var len=content.length;
					var tb_content="";
					for(var i=0;i<len;i++){
						if(i==0){
							//$('#Admin_tb').append('<tr>');
							tb_content+="<tr>";
						}
						//$('#Admin_tb').append("<td id='"+content[i].Admin_ID+"'>"+content[i].Admin_Name+"</td>");
						tb_content+="<td id='"+content[i].Admin_ID+"'>"+content[i].Admin_Name+"</td>";
						if(i%4==3||i==len-1){
							//$('#Admin_tb').append('</tr>');
							tb_content+="</tr>";
						}
					}
					$('#Admin_tb').append(tb_content);
					$('#Admin_tb td').click(function() {
						var Admin_ID=$(this).attr('id');
						var Admin_Name=$(this).html();
						show_Admin_Info(Admin_ID,Admin_Name);
					});
					$('#admin_num').html(len);
					$('#page_num').html(Math.ceil(len/16));
				}else{
					art.dialog({
						title:'系统消息',
						content:'拉取信息失败，错误信息：<br/>'+data.info,
						icon:'error',
						cancel:true,
						cancelVal:'确定'
					});
				}
			},
			error:function(data){
				art.dialog({
						title:'系统消息',
						content:"与服务器交互失败！",
						icon:'error',
						cancel:true,
						cancelVal:'确定'
					});
			}
		}
	);
}

function show_Admin_Info(Admin_ID,Admin_Name){
	var encrypttime=getEncryptTime();
	$.ajax({
		    url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
			data:{
				url:"Get_Privilege",
				encrypttime:encrypttime,
				Admin_ID:Admin_ID
			},
			success:function(data){
				if(data.msg==0){
					$('#Admin_Priv_tb tr').remove();
					var content=data.content;
					var len=content.length;
					var content_txt="";
					for(var i=0;i<len;i++){
						if(i%3==0){
							content_txt+="<tr>";
						}
						content_txt+='<td>'
						+'<input type="checkbox" '
						+'id="'+content[i].Hospital_ID+'"'
						+'name="hospital_priv_del"/>'
						+content[i].Hospital_Name
						+'</td>';
						if(i%3==2||i==len-1)
						content+="</tr>";
					}
					$('#Admin_Priv_tb').append(content_txt);
					fillProvince();
					fillArea();
					$('#Admin_Name').html(Admin_Name);
					$('#Admin_Name').attr('name',Admin_ID);
					$('#Admin_Info').fadeIn('1000');
				}else{
					art.dialog({
						title:'系统消息',
						content:'拉取信息失败，错误信息：<br/>'+data.info,
						icon:'error',
						cancel:true,
						cancelVal:'确定'
					});
				}
			},
			error:function(data){
				art.dialog({
						title:'系统消息',
						content:"与服务器交互失败！",
						icon:'error',
						cancel:true,
						cancelVal:'确定'
					});
			}
	});
	
}
function fillProvince(){
	$('#Province option').remove();
	$('#Province').append("<option value='-1'>"+"不限省份"+"</option>");
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
				url:"Get_Province_Info",
				encrypttime:encrypttime,
		},
		success:function(data){
			if(data.msg==0){
				var content=data.content;
				var len=content.length;
				for(var i=0;i<len;i++){
					$('#Province').append("<option value='"+content[i].Province_ID+"'>"+content[i].Province_Name+"</option>");
				}
				$('#Province').val(-1);
			}
		},
		error:function(data){
		}
	});
}
function fillArea(){
	var Province_ID=$('#Province').val();
	if(Province_ID<0){
		$('#Area').append("<option value='-1'>"+"不限地区"+"</option>");
		return;
	}
	var encrypttime=getEncryptTime();
	$('#Area option').remove();
	$('#Area').append("<option value='-1'>"+"不限地区"+"</option>");
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
				url:"Get_Area_Info_By_Province_ID",
				encrypttime:encrypttime,
				Province_ID:Province_ID
		},
		success:function(data){
			if(data.msg==0){
				var content=data.content;
				var len=content.length;
				for(var i=0;i<len;i++){
					$('#Area').append("<option value='"+content[i].Area_ID+"'>"+content[i].Area_Name+"</option>");
				}
			}
		},
		error:function(data){
		}
	});
}
function del_Priv(){
	var Admin_ID=$('#Admin_Name').attr('name');
	var encrypttime=getEncryptTime();
	var Hospital_ID="";
	$('input:checkbox[name=hospital_priv_del]:checked').each(function(i){
		Hospital_ID+=$(this).attr('id')+",";
	});
	Hospital_ID=Hospital_ID.substr(0,Hospital_ID.length-1);
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Del_Privilege',
			encrypttime:encrypttime,
			Admin_ID:Admin_ID,
			Hospital_ID:Hospital_ID
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
				show_Admin_Info();
			}else{
				art.dialog({
					title:'系统消息',
					content:'操作失败，失败信息：'+data.info,
					icon:'error',
					cancel:true,
					cancelVal:'确定'
				});
			}
		},
		error:function(data){
			art.dialog({
					title:'系统消息',
					content:'与服务器交互失败！',
					icon:'error',
					cancel:true,
					cancelVal:'确定'
				});
		}
	});

}
function add_Priv(){
	var Admin_ID=$('#Admin_Name').attr('name');
	var encrypttime=getEncryptTime();
	var Hospital_ID="";
	$('input:checkbox[name=hospital_priv_add]:checked').each(function(i){
		Hospital_ID+=$(this).attr('id')+",";
	});
	Hospital_ID=Hospital_ID.substr(0,Hospital_ID.length-1);
	$.ajax({
		url:'../php/TransferStation.php',
		//url:'../test_addPriv.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Give_Privilege',
			Admin_ID:Admin_ID,
			encrypttime:encrypttime,
			Hospital_ID:Hospital_ID
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
				show_Admin_Info();
			}else{
				art.dialog({
					title:'系统消息',
					content:'操作失败，失败信息：'+data.info,
					icon:'error',
					cancel:true,
					cancelVal:'确定'
				});
			}
		},
		error:function(data){
			art.dialog({
					title:'系统消息',
					content:'与服务器交互失败！',
					icon:'error',
					cancel:true,
					cancelVal:'确定'
				});
		}
	});
}
function returnList(){
	$('#Admin_Info').fadeOut('1000');
}
function getHospital(start,size){
	var Area_ID=$('#Area').val();
	if(Area_ID=='-1'){
		Area_ID="";
	}
	var Province_ID=$('#Province').val();
	if(Province_ID)
	var Hospital_Level=$('#Hospital_Level').val();
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Find_Hospital_By_Condition',
            encrypttime:encrypttime,
            Area_ID:Area_ID,
            Hospital_Level:Hospital_Level,
            start:start,
            size:size
		},
		success:function(data){
			$('#add_Hospital tr').remove();
			if(data.msg==0){
				$('#page_num').html(Math.ceil(data.total/size));
				var content=data.content;
				var len=content.length;
				$('#total').html(len);
				var content_txt="";
				for(var i=0;i<len;i++){
						if(i%3==0){
							content_txt+="<tr>";
						}
						content_txt+='<td>'
						+'<input type="checkbox" '
						+'id="'+content[i].Hospital_ID+'"'
						+'name="hospital_priv_add"/>'
						+content[i].Hospital_Name
						+'</td>';
						if(i%3==2||i==len-1)
						content+="</tr>";
				}
				$('#add_Hospital').append(content_txt);
			}else{
				art.dialog({
					title:'系统消息',
					content:'操作失败，错误信息：'+data.info,
					icon:'error',
					cancel:true,
					cancelVal:'确定'
				});
			}
		},
		error:function(data){
			art.dialog({
					title:'系统消息',
					content:'与服务器交互失败！',
					icon:'error',
					cancel:true,
					cancelVal:'确定'
				});
		}
		
	});
}
function show_hospital(){
	getHospital(0,15);
}
function goPage2(){
	var page_no=$('#page_no2').val();
	if(page_no%1==0){
		art.dialog({
			title:'系统消息',
			icon:'error',
			content:'请输入整数！',
			ok:function(){
				$('#page_no2').val('');
			},
			okVal:'我知道了'
		});
		return;
	}
	var page_num=$('#page_num').html();
	if(page_no>page_num||page_no<1){
		art.dialog({
			title:'系统消息',
			icon:'error',
			content:'页码超出范围！',
			ok:function(){
				$('#page_no2').val('');
			},
			okVal:'我知道了'
		});
		return;
	}
	var size=15;
	var start=(page_no-1)*size;
	getHospital(start,size);
}
function del_Admin(){
	art.dialog({
		icon:'warning',
		title:'系统消息',
		content:'确定删除该管理员吗？',
		okVal:'确定',
		ok:function(){
			var admin_ID=$('#Admin_Name').attr('name');
			var Admin_ID=Array();
			Admin_ID.push(admin_ID);
			var encrypttime=getEncryptTime();
			$.ajax({
				url:'../php/TransferStation.php',
				type:'POST',
				dataType:'json',
				data:{
						url:'del_Admin',
            			encrypttime:encrypttime,
                        Admin_ID:Admin_ID
		             },
		        success:function(data){
		        	if(data.msg==0){
		        		art.dialog({
		        			title:'系统消息',
		        			content:'操作成功',
		        			icon:'succeed',
		        			ok:true,
		        			okVal:'确定'
		        		});
		        	}else{
		        		art.dialog({
		        			title:'系统消息',
		        			content:'操作失败，错误信息：'+data.info,
		        			icon:'error',
		        			cancel:true,
		        			cancelVal:'确定'
		        		});
		        	}
		        },
		        error:function(data){
		        	art.dialog({
		        			title:'系统消息',
		        			content:'与服务器交互失败！',
		        			icon:'error',
		        			cancel:true,
		        			cancelVal:'确定'
		        		});
		        }
			});
		},
		cancel:true,
		cancelVal:'取消'
	});
}
function changePwd(){
	art.dialog({
		id:'change_pwd_dlg',
		title:'系统消息',
		content:document.getElementById('change_pwd_div'),
	});
}
function update_admin_pwd(){
	var Password=$('#Password').val();
	var encrypttime=getEncryptTime();
	var Admin_ID=$('#Admin_Name').attr('name');
	Password=hex_sha1(Password);
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'UpdatePwd_Admin',
			encrypttime:encrypttime,
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
						content:'操作失败，失败信息<br/>'+data.info,
						icon:'error',
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
