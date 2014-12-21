$(document).ready(function() {
	get_privilege();
	$("#scan_file").uploadPreview({ Img: "hospital_picture"});
    $('#scan_file').val('');
});

function get_province(){
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Get_Province_Info',
			encrypttime:encrypttime
		},
		success:function(data){
			if(data.msg==0){
				var content=data.content;
				var len=content.length;
				for(var i=0;i<len;i++){
					$('#Province_Info')
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
function get_area(){
	var Province_ID=$('#Province_Info').val();
	if(Province_ID<0)return;
	var encrypttime=getEncryptTime();
	$.ajax({
			url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
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
								$('#Area_Info')
					            .append('<option value="'
					            +content[i].Area_ID
					            +'">'+content[i].Area_Name+'</option>');
							}
					}else {
						art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！错误信息：<br/>'+data.info,
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
function get_Depart(Hospital_ID){
	var encrypttime=getEncryptTime();
	$.ajax({
		        url:'../php/TransferStation.php',
		      	type:'POST',
				dataType:'json',
				data:{
					url: 'Get_DepartInfo',
					encrypttime:encrypttime,
					Hospital_ID:Hospital_ID,
				},
				success:function(data){
					if(data.msg==0){
						$('#depart_info_tb tr').remove();
						$('#del_depart_select option').remove();
						var content=data.content;
						var len=content.length;
						var content_txt="";
						for(var i=0;i<len;i++){
							if(i%4==0){
									content_txt+='<tr>';
							}
							content_txt+='<td id="'
								           +content[i].Depart_ID
                                           +'">'
                                           +content[i].Depart_Name
                                           +'</td>';
                            $('#del_depart_select').append('<option value="'
                                                          +content[i].Depart_ID
                                                          +'">'
                                                          +content[i].Depart_Name
                                                          +'</option>');             
                             if(i!=0&&i%4==3||i==len-1)
                             content_txt+='</tr>';
						}
						$('#depart_info_tb').append(content_txt);
						
					}else{
							art.dialog({
								title:'系统消息',
								content:'操作失败！失败信息<br/>'+data.info,
								icon:'error',
								cancel:true,
								cancelVal:'关闭',
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
function init_content_info(Hospital_ID){
	$('#Hospital_ID').val(Hospital_ID);
	var Province_ID;
	var Area_ID;
	var Hospital_Picture_url;
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		async:false,
		type:'POST',
		dataType:'json',
		data:{
			 url:'Get_HospitalInfo_detail',
			 Hospital_ID:Hospital_ID,
			 encrypttime:encrypttime
		},
		success:function(data){
             if(data.msg==0){
             	data=data.content[0];
             	$('#Hospital_Level').val(data.Hospital_Level);
             	$('#Hospital_Introduction').val(data.Hospital_Introduction);
             	$('#Hospital_Name').val(data.Hospital_Name);
             	$('#Hospital_Location').val(data.Hospital_Location);
             	var Reservation_Start_Time=data.Reservation_Start_Time.substr(11);
             	var Reservation_End_Time=data.Reservation_End_Time.substr(11);
             	$('#Reservation_Start_Time').val(Reservation_Start_Time);
             	$('#Reservation_End_Time').val(Reservation_End_Time);
                Area_ID=data.Area_ID;
                Hospital_Picture_url=data.Hospital_Picture_url;
             }else{
             	art.dialog({
             		title:'系统消息',
             		content:'操作失败，错误信息：'+data.info,
             		icon:'error',
             		ok:true,
             		okVal:'确定'
             	});
             }		
		}
     });
     Province_ID=Math.floor(Area_ID/100);
     get_province();
     $('#Province_Info').val(Province_ID);
     get_area(Province_ID);
     $('#Province_Info').val(Area_ID);
     $("#scan_file").uploadPreview({ Img: "hospital_picture"});
     $('#hospital_picture').attr('src',Hospital_Picture_url);
     var pic=/hospital_pic_/g;
     var idx=Hospital_Picture_url.search(pic);
     var pic_name="";
     if(idx!=-1){
     	pic_name=Hospital_Picture_url.substr(idx);
     }    
     $('#picture_name').val(pic_name);
     $('#picture_url').val(Hospital_Picture_url);
}
function show_province(){
	var encrypttime=getEncryptTime();
	$.ajax({
		//url:"../test_province.php",
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Get_Province_Info',
			encrypttime:encrypttime
		},
		success:function(data){
			if(data.msg==0){
				var content=data.content;
				var len=content.length;
				for(var i=0;i<len;i++){
						var row=i/6;
						var col=i%6;
						var t=$('#province tr:eq('+row+')'+' td:eq('+col+')');
						$(t).html(content[i].Province_Name);
						$(t).attr('name',content[i].Province_ID);
				}
				$('#province tr td').each(function(index) {
					  $(this).click(function() {
					  	  $('#Province').html($(this).html());
					  	  $('#Province').attr('name',$(this).attr('name'));
					  	  $('#province_layer').hide();
					  });
					});
				if($('#province_layer').is(":hidden")){
					$('#province_layer').show();
				}else{
					$('#province_layer').hide();
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
function show_area(){
	var encrypttime=getEncryptTime();
	var Province_ID=$('#Province').attr('name');
	if(Province_ID==-1){
		art.dialog({
			icon:'warning',
			content:'请先选择省份！',
			top:'15%',
			ok:true,
			okVal:'我知道了',
		});
		return;
	}
			$.ajax({
				//url:"host/Get_Area_Info_By_Province_ID",
				url:'../php/TransferStation.php',
				//url:'../test_get_area.php',
				type:'POST',
				dataType:'json',
				data:{
					url:'Get_Area_Info_By_Province_ID',
					encrypttime:encrypttime,
					Province_ID:Province_ID
				},
				success:function(data){
					//data=eval("("+data+")");
					if(data.msg=='0'){
							var content=data.content;
							var len=content.length;
							for(var i=0;i<len;i++){
								var row=i/4;
								var col=i%4;
								var t=$('#area tr:eq('+row+')'+' td:eq('+col+')');
								$(t).html(content[i].Area_Name);
								$(t).attr('name',content[i].Area_ID);
							}
							$('#area tr td').each(function(index) {
					  			$(this).click(function() {
					  	  			 $('#Area').html($(this).html());
					  	 			 $('#Area').attr('name',$(this).attr('name'));
					  	  			 $('#area_layer').hide();
					  			});
							});
						    if($('#area_layer').is(':hidden')){
						    	$('#area_layer').show();
						    }else{
						    	$('#area_layer').hide();
						    }
							
					}else {
						art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！错误信息：<br/>'+data.info,
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
function get_privilege(){
	$('#hospital_tb tr').remove();
	var Admin_ID=$('#Admin_ID',window.parent.document).val();
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url: 'Get_Privilege',
			encrypttime:encrypttime,
			Admin_ID:Admin_ID
		},
		success:function(data){
			if(data.msg==0){
				var content=data.content;
				var len=content.length;
				$('#hospital_num').html(len);
				if(len<=0){
					$('#no_signal').show();
				}else{
					$('#no_signal').hide();
					$('#page_num').html(Math.ceil(len/10));
					$('#num').html(len);
					$('#page_no').val(1);
					for(var i=0;i<len;i++){
						var Hospital_ID=content[i].Hospital_ID;
						var Hospital_Name=content[i].Hospital_Name;
						$('#hospital_tb').append('<tr>'
						                        +'<td class="hospital_item" id="'+Hospital_ID+'">'
						                        +Hospital_Name
						                        +'</td>'
						                         +'</tr>');
				    }
				    $('.hospital_item').click(function() {
				    	     getHospital_Info($(this).attr('id'));
						});
				    $('#page_div').show();
				}
				
			}else{
				art.dialog({
					title:'系统消息',
					content:'操作失败！失败信息<br/>'+data.info,
					icon:'error',
					cancel:true,
					cancelVal:'关闭',
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
function getHospital_Info(Hospital_ID){
	init_content_info(Hospital_ID);
     move_div();
}
function goPage(){
	var page_no=$('#page_no').val();
	if(parseInt(page_no)!=page_no){
		art.dialog({
			icon:'warning',
			content:'请输入合法整数！',
			ok:true,
			okVal:'确定'
		});
		return;
	}
	page_no=Math.ceil(page_no);
	$('#page_no').val(page_no);
	var page_num=$('#page_num').html();
	if(page_no>page_num||page_no<1){
		art.dialog({
			icon:'error',
			content:'页码超出界限！',
			ok:true,
			okVal:'确定'
		});
		
	}else {
		search();
	}
}
var t;
function move_div(){
	var mleft=$('#content_info').css('margin-left');
	mleft=parseInt(mleft);
	if(mleft>=50)
	{
		clearTimeout(t);
		return;
	}
	mleft+=50;
	$('#content_info').css('margin-left',mleft+'px');
	t=setTimeout('move_div()',50);
	
}
function close_div(){
	
	var mleft=$('#content_info').css('margin-left');
	mleft=parseInt(mleft);
	if(mleft>=1500)
	{
		clearTimeout(t);
		$('#content_info').css('margin-left','-1500px');
		return;
	}
	mleft+=50;
	$('#content_info').css('margin-left',mleft+'px');
	t=setTimeout('close_div()',50);
	
}
function upload_picture(){
	$('#scan_file').trigger("click");
}
function submitPicture(){
	var filename=$('#scan_file').val();
	var file_type=filename.substr(filename.lastIndexOf(".")+1);
	if($('#scan_file').val()=='undefined'||$('#scan_file').val()==''){
		art.dialog({
			title:'系统消息',
			icon:'warning',
			content:'请选择图片',
			top:'15%',
			ok:true,
			okVal:'我知道了'
		});
	}
	else if(file_type!='jpg'&&file_type!='jpeg'&&file_type!='png'&&file_type!='gif'){
		art.dialog({
			title:'系统消息',
			icon:'error',
			content:'文件类型错误！请选择jpg、jpeg、bmp、png、gif图片格式',
			top:'15%',
			ok:true,
			okVal:'我知道了'
		});
		('#scan_file').val('');
		return;
	}else{
		var oldfile=$('#picture_name').attr('name');
		if(oldfile!=''){
		    art.dialog({
		    	title:'系统提醒',
		    	top:'15%',
		    	content:'重复提交会覆盖原有的图片，确定执行此操作？',
		    	ok:function(){
                     UploadPicture(file_type,oldfile);
		    	},
		    	okVal:'确定',
		    	cancelVal:'取消',
		    	cancel:function(){
		    		return true;
		    	}
		    });	
		   
		}else {
			UploadPicture(file_type,oldfile);
		}
	}
}
function UploadPicture(file_type,oldfile){
	$.ajaxFileUpload({
           url:'../php/addImage_Hospital.php',//处理图片脚本
           secureuri :false,
           fileElementId :'scan_file',//file控件id
           dataType : 'json',
           data:{
            		filetype:file_type,
            		oldfile:oldfile
            	},
           success : function (data, status){
               	if(data.msg==0){
               	   		art.dialog({
               	  			icon:'succeed',
               	  			top:'15%',
               	  			content:"操作成功！",
               	  			title:'系统消息',
               	  			ok:true,
               	  			okVal:'确定'
               	  		});
               	  	alert(data.filename);
               	  	$('#picture_name').val(data.filename);
               	  	$('#picture_url').val(data.Hospital_Picture_url);
               	}else{
               	  	art.dialog({
               	  		icon:'error',
               	  		top:'15%',
               	  		content:'上传图片失败：<br/>'+"错误信息："+data.error,
               	  		title:'系统消息',
               	  		cancel:true,
               	  		cancelVal:'确定'
               	  	});
               	}
        },
        error: function(data, status, e){
               art.dialog({
               	  	icon:'error',
               	  	top:'15%',
               	  	content:"与服务器交互失败！",
               	  	title:'系统消息',
               	  	cancel:true,
               	  	cancelVal:'确定'
               	});
            }
       	});
       	$("#scan_file").uploadPreview({ Img: "hospital_picture"});
}

function cancelPicture(){
	var filename=$('#picture_name').attr('name');
	$.ajax({
		url:'../php/delImage_Hospital.php',
		type:'POST',
		dataType:'json',
		data:{
			filename:filename
		},
		success:function(data){
			if(data.msg==0){
				if(data.res){
					art.dialog({
						title:'系统消息',
						icon:'succeed',
						content:'移除成功',
						ok:function(){
							$('picture_name').val('');
							$('picture_url').val('');
							$('#hospital_picture').attr('src','../images/picture_upload_logo.jpg');
	                        $("#scan_file").uploadPreview({ Img: "hospital_picture"});
						},
						okVal:'确定',
					});
				}else{
					art.dialog({
						title:'系统消息',
						icon:'error',
						content:'操作失败',
						cancel:function(){
							
						},
						cancelVal:'关闭',
					});
				}
			}
		},
		error:function(data){
			       art.dialog({
						title:'系统消息',
						icon:'error',
						content:'操作失败',
						cancel:function(){
							
						},
						cancelVal:'关闭',
					});
		}
	});
	
}
function confirm_info(){
 	var encrypttime=getEncryptTime();
 	var Hospital_ID=$('#Hospital_ID').val();
 	var Hospital_Introduction=$('#Hospital_Introduction').val();
 	var Hospital_Name=$('#Hospital_Name').val();
 	var Hospital_Location=$('#Hospital_Location').val();
 	var Reservation_Start_Time="0000-00-00 "+$('#Reservation_Start_Time').val();
 	var Reservation_End_Time="0000-00-00 "+$('#Reservation_End_Time').val();
 	var Province_ID=$('#Province_Info').val();
 	var Area_ID=$('#Area_Info').val();
 	var Hospital_Picture_url=$('#picture_url').val();
 	var Hospital_Level=$('#Hospital_Level').val();
 	$.ajax({
        //url:"../test_get_hospital.php",
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url: 'Set_HospitalInfo',
			encrypttime:encrypttime,
            Hospital_ID:Hospital_ID,
            Hospital_Introduction:Hospital_Introduction,
            Hospital_Name:Hospital_Name,
            Hospital_Location:Hospital_Location,
            Reservation_Start_Time:Reservation_Start_Time,
            Reservation_End_Time:Reservation_End_Time,
            Area_ID:Area_ID,
            Hospital_Picture_url:Hospital_Picture_url,
            Hospital_Level:Hospital_Level
		},
		success:function(data){
			if(data.msg==0){
				art.dialog({
					title:'系统消息',
					icon:'succeed',
					content:'保存成功!',
					ok:true,
					okVal:'确定'
				});
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
				icon:'error',
				content:'与服务器交互失败！',
				ok:true,
				okVal:'确定'
			 });
		}
	});
}

function depart_name_repeat(Hospital_ID,Depart_Name){
	var repeat=false;
	var encrypttime=getEncryptTime();
	$.ajax({
        //url:"../test_get_depart.php",
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		async:false,
		data:{
			url: 'Get_DepartInfo',
			encrypttime:encrypttime,
			Hospital_ID:Hospital_ID
		},
		success:function(data){
			if(data.msg==0){
				var content=data.content;
				var len=content.length;
				for(var i=0;i<len;i++){
					if(content[i].Depart_Name==Depart_Name)
					{
						repeat=true;
						return repeat;
					}
				}
			}
		}
	});
	return repeat;
}
	
function config_depart(){
	Hospital_ID=$('#Hospital_ID').val();
	get_Depart(Hospital_ID);
	art.dialog({
		id:'add_depart_dialog',
		title:'添加科室',
		content:document.getElementById('add_depart_div'),
		width:'600',
	});
}
function del_Dpart(){
	var Depart_ID=$('#del_depart_select').val();
	art.dialog({
		title:'系统提示',
		icon:'warning',
		content:'确定删除该科室吗？',
		ok:function(){
			   var encrypttime=getEncryptTime();
			   $.ajax({
		         url:'../php/TransferStation.php',
		      	 type:'POST',
				 dataType:'json',
				 async:false,
				 data:{
					url: 'Del_Depart',
					encrypttime:encrypttime,
					Depart_ID:Depart_ID,
				 },
				 success:function(data){
					  if(data.msg==0){
					  	art.dialog({
					  		title:'系统提示',
					  		content:'操作成功！',
					  		icon:"succeed",
					  		ok:true,
					  		okVal:'确定'
					  	});
					  	get_Depart(Hospital_ID);
					  }else{
					  	art.dialog({
					  		title:'系统提示',
					  		content:'操作失败！失败信息<br/>'+data.info,
					  		icon:"error",
					  		cancel:true,
					  		cancelVal:'确定'
					  	});
					  }
				},
				error:function(data){
					art.dialog({
					  		title:'系统提示',
					  		content:'与服务器交互失败',
					  		icon:"error",
					  		cancel:true,
					  		cancelVal:'确定'
					  	});
			    }
			});
		},
		okVal:'确定',
		cancelVal:'取消',
		cancel:true,
	});
	dialog.shake()&&dialog.shake();
}
function confirm_op(){
	 $('#repeat_signal').hide();
			var encrypttime=getEncryptTime();
			var Hospital_ID=$('#Hospital_ID').val();
			var Depart_Name=$('#Depart_Name').val();
			if(depart_name_repeat(Hospital_ID,Depart_Name)){
				$('#repeat_signal').show();
			}
			else{
			$.ajax({
				// url:"../test_get_hospital.php",
		         url:'../php/TransferStation.php',
		      	 type:'POST',
				dataType:'json',
				data:{
					url: 'Get_DepartInfo',
					encrypttime:encrypttime,
					Hospital_ID:Hospital_ID,
					Depart_Name:Depart_Name
				},
				success:function(data){
					  if(data.msg==0){
							art.dialog({
								title:'系统消息',
								icon:'succeed',
								content:'保存成功!',
								ok:true,
								okVal:'确定'
							});
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
							icon:'error',
							content:'与服务器交互失败！',
							ok:true,
							okVal:'确定'
			 			});
				}
			});
			}
	
}
function cancel_op(){
	$('Depart_Name').val('');
	art.dialog({ id:'add_depart_dialog'}).close();
}
