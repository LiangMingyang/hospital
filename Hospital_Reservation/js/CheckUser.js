/**
 * @author acer
 */
$(document).ready(function(){
	fillProvince();
	fillArea();
});
function fillProvince(){
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		async:false,
		dataType:'json',
		data:{
				url:"Get_Province_Info",
				encrypttime:encrypttime,
		},
		success:function(data){
			if(data.msg==0){
				$('#Province_ID option').remove();
				var content=data.content;
				var len=content.length;
				$('#Province_ID').append("<option value='-1'>"+"选择省份"+"</option>");
				for(var i=0;i<len;i++){
					$('#Province_ID').append("<option value='"+content[i].Province_ID+"'>"+content[i].Province_Name+"</option>");
				}
				$('#Province_ID').val(-1);

			}
		},
		error:function(data){
		}
	});
}
function fillArea(){
	var Province_ID=$('#Province_ID').val();
	if(Province_ID<0){
		$('#Area_ID option').remove();
		$('#Area_ID').append("<option value='-1'>"+"选择地区"+"</option>");
		return;
	}
	var encrypttime=getEncryptTime();
	$('#Area_ID option').remove();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		async:false,
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
					$('#Area_ID').append("<option value='"+content[i].Area_ID+"'>"+content[i].Area_Name+"</option>");
				}
			}
		},
		error:function(data){
		}
	});
}
function show_user(start,size){
	var Area_ID=$('#Area_ID').val();
	if(Area_ID<0){
		Area_ID="";
	}
	var Province_ID=$('#Province_ID').val();
	if(Province_ID<0){
		Province_ID="";
	}
	var encrypttime=getEncryptTime();
	var isChecked="";
	if($('#unchecked_only').is(':checked')){
		isChecked='0';
	}
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		async:false,
		data:{
			url:"Find_User_By_Condition",
			encrypttime:encrypttime,
            Area_ID:Area_ID,
            isChecked:isChecked,
            start:start,
            size:size
		},
		success:function(data){
			if(data.msg==0){
			    var content_txt="";
			    var content=data.content;
			    var len=content.length;
			    if(len==0){
			        $('#tb_footer').hide();
			    	return;
			    }
			    $('#user_tb tr td').remove();
			    for(var i=0;i<len;i++){
			    	content_txt+='<tr id="'+content[i].User_ID+'">';
			    	content_txt+=
			    	'<td>'+content[i].Identity_ID+'</td>'
			    	+'<td>'+content[i].UserName+'</td>';
			    	if(content[i].isChecked==0){
			    		content_txt+='<td><a class="unpass" >'+'未审核</a></td>';
			    	}
					else{
						content_txt+='<td><a class="pass" >'+'已审核</a></td>';
						
					}
					content_txt+='<td><a class="detail_info" id="'+content[i].User_ID+'" onclick="see_detail(this)">详细信息</a></td>';
				    if(content[i].isChecked==0){
				    	content_txt+='<td><a class="check_pass" id="'+content[i].User_ID+'"  onclick="check_user(this)">审核通过</a> </td>';
				    }else{
				    	content_txt+='<td><a class="check_unpass" id="'+content[i].User_ID+'" onclick="check_user(this)">审核不通过</a> </td>';
				    	
				    }
				                 
					    content_txt+='<td>'
						         +'<input name="del_u" type="checkbox" id="'+content[i].User_ID+'"/>'
					             +'</td>';
					   content_txt+='</tr>';
			    	
			    }
			    $('#user_tb').append(content_txt);
			    $('#total').html(len);
			    if(len==0){
			    	$('#no_signal').show();
			    }
			    $('#page_num').html(Math.ceil(len/size));
			    $('#tb_footer').show();
			}else {
				art.dialog({
					title:'系统消息',
					content:'拉取信息失败，错误信息<br/>'+data.info,
					icon:'error',
					cancel:true,
					cancelVal:'关闭'
				});
			}	
		},
		error:function(data){
			art.dialog({
					title:'系统消息',
					content:'与服务器交互失败！',
					icon:'error',
					cancel:true,
					cancelVal:'关闭'
			});
		}
	});
	
	
}
function check_user(t){
	var encrypttime=getEncryptTime();
	var User_ID=$(t).attr('id');
	var type="";
	if($(t).attr('class')=='check_unpass'){
		type=0;
	}else{
		type=1;
	}
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Check_Register',
			encrypttime:encrypttime,
            User_ID:User_ID,
            isChecked:type
		},
		success:function(data){
			if(data.msg==0){
				art.dialog({
					title:'系统消息',
					icon:'succeed',
					content:'审核成功',
					ok:true,
					okVal:'确定'
				});
				
			}else {
				art.dialog({
					title:'系统消息',
					icon:'error',
					content:'操作失败，失败信息:<br/>'+data.info,
					cancel:true,
					cancelVal:'确定'
				});
			}
		},
		error:function(data){
			art.dialog({
					title:'系统消息',
					icon:'error',
					content:'与服务器交互失败',
					cancel:true,
					cancelVal:'确定'
				});
		}
	});
}
function see_detail(t){
	var Identity_ID=$(t).parent().parent().find('td').eq(0).html();
	var encrypttime=getEncryptTime();
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
            	$('#UserName').html(data.UserName); 
            	$('#Identity_ID').html(data.Identity_ID);
            	if(data.Sex==0){
            		$('#Sex').html('女');
            	}else{
            		$('#Sex').html('男');
           		 }
            	$('#Birthday').html(data.Birthday);
            	$('#Location').html(data.Location);
            	$('#Phone').html(data.Phone);
            	$('#Mail').html(data.Mail);
            	$('#Province_Name').html(data.Province_Name);
            	$('#Area_Name').html(data.Area_Name);
			
				 art.dialog({
				 	content:document.getElementById('user_detail'),
				 	width:'600px',
				 	title:'用户信息',
				 	ok:true,
				 	okVal:'确定'
				 });
			}else{
				  art.dialog({
					title:'系统消息',
					icon:'error',
					content:'操作失败，失败信息:<br/>'+data.info,
					cancel:true,
					cancelVal:'确定'
				  });
			}
		},
		error:function(data){
			art.dialog({
					title:'系统消息',
					icon:'error',
					content:'与服务器交互失败',
					cancel:true,
					cancelVal:'确定'
				});
		}
	});
}
function del_user(){
	var User_ID="";
	var encrypttime=getEncryptTime();
	$('input:checkbox[name=del_u]:checked').each(function(index) {
	  User_ID+=$(this).attr('id')+",";
	});
	User_ID=User_ID.substr(0,User_ID.length-1);
	$.ajax({
		//url:'',
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			encrypttime:encrypttime,
			User_ID:User_ID,
			url:'Del_User'
		},
		success:function(data){
			if(data.msg==0){
				art.dialog({
					title:'系统消息',
					content:'操作成功！',
					icon:'succeed',
					ok:true,
					okVal:'确定',
				});
			}else{
				art.dialog({
					title:'系统消息',
					content:'操作失败，错误信息<br/>'+data.info,
					icon:'error',
					cancel:true,
					cancelVal:'关闭',
				});
			}
		},
		error:function(data){
			 art.dialog({
					title:'系统消息',
					content:'与服务器交互失败！',
					icon:'error',
					cancel:true,
					cancelVal:'关闭',
				});
		}
		
	});
}
function goPage3(){
	
}
