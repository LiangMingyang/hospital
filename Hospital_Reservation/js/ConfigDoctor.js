/**
 * @author acer
 */
$(document).ready(function(){
	artDialog.fn.shake = function (){
    var style = this.DOM.wrap[0].style,
        p = [4, 8, 4, 0, -4, -8, -4, 0],
        fx = function () {
            style.marginLeft = p.shift() + 'px';
            if (p.length <= 0) {
                style.marginLeft = 0;
                clearInterval(timerId);
            };
        };
    p = p.concat(p.concat(p));
    timerId = setInterval(fx, 13);
    return this;
    };
	show_hospital();
	show_depart();
});
function show_hospital(){
	//var Admin_ID=$('#ID',window.parent.document).val();
	var Admin_ID=1;
    var encrypttime=getEncryptTime();
    $.ajax({
				url:'../php/TransferStation.php',
				type:'POST',
				async:false,
				dataType:'json',
				data:{
					url:'Get_Privilege',
					encrypttime:encrypttime,
					Admin_ID:Admin_ID
				},
				success:function(data){	
					if(data.msg=='0'){
							var content=data.content;
							var len=content.length;
							$('#Hospital_ID option').remove();
							for(var i=0;i<len;i++){
								$('#Hospital_ID').append('<option value="'
								                         +content[i].Hospital_ID
								                         +'">'
								                         +content[i].Hospital_Name
								                         +'</option>');
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
function show_depart(){
	var Hospital_ID=$('#Hospital_ID').val();
	var encrypttime=getEncryptTime();
	if(Hospital_ID>0){
 		$.ajax({
				//url:'../php/TransferStation.php',
				url:'../test_get_depart.php',
				type:'POST',
				dataType:'json',
				data:{
					url:'Get_DepartInfo',
					encrypttime:encrypttime,
					Hospital_ID:Hospital_ID
				},
				success:function(data){	
					if(data.msg=='0'){
						var content=data.content;
						var len=content.length;
						$('#Depart_ID option').remove();
						for(var i=0;i<len;i++){
							$('#Depart_ID').append('<option value="'
								               +content[i].Depart_ID
								               +'">'
								               +content[i].Depart_Name
								               +'</option>');
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
	}else{
		$('#Depart_ID option').remove();
		$('#Depart_ID').append('<option value="-1">选择科室</option>');
	}
}
function show_doctor(){
	var Depart_ID=$('#Depart_ID').val();
	if(isNaN(Depart_ID)||Depart_ID<=0)return;
	if(Depart_ID>0){
		var encrypttime=getEncryptTime();
		$.ajax({
				url:'../php/TransferStation.php',
				type:'POST',
				dataType:'json',
				data:{
					url:'Get_DoctorInfo',
					encrypttime:encrypttime,
					Depart_ID:Depart_ID
				},
				success:function(data){	
					if(data.msg=='0'){
						$('#doctor_tb tr').remove();
						var content=data.content;
						var len=content.length;
						var content_txt="";
						for(var i=0;i<len;i++){
							if(i%4==0){
								content_txt+='<tr>';
							}
							content_txt+='<td id="'+content[i].Doctor_ID+'">'+content[i].Doctor_Name+'</td>';
							if(i%3==0 && i!=0||i==len-1){
								content_txt+='</tr>';
							}
						}
						$('#doctor_tb').append(content_txt);
						$('#doctor_tb td').click(function() {
							show_doctor_info($(this).attr('id'));
							$('#Hospital_ID').attr('disabled',true);
							$('#Depart_ID').attr('disabled',true);
							$('#return_doctor_btn').show();
							$('#show_doctor_btn').hide();
						});
						$('#doctor_area').fadeIn('1000');	
						$('#Hospital_ID').attr('disabled',false);
						$('#Depart_ID').attr('disabled',false);
						$('#return_doctor_btn').hide();
						$('#show_doctor_btn').show();
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
}
function return_doctor(){
	$('#doctor_info_area').hide();
	$('#return_doctor_btn').hide();
	$('#show_doctor_btn').show();
	
	show_doctor();
						
}
function show_doctor_info(Doctor_ID){
	var encrypttime=getEncryptTime();
	$.ajax({
		//url:'../php/TransferStation.php',
		url:'../test_get_doctor_detail.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Get_DoctorInfo_detail',
			encrypttime:encrypttime,
			Doctor_ID:Doctor_ID
		},
		success:function(data){	
			if(data.msg=='0'){
				$('#Doctor_Name').val(data.Doctor_Name);
				$('#Doctor_Name').attr('name',Doctor_ID);//name 键用来存Doctor_ID
				$('#Doctor_Level').val(data.Doctor_Level);
				$('#Doctor_Fee').val(data.Doctor_Fee);
				$('#Doctor_Limit').val(data.Doctor_Limit);
				$('#Doctor_Major').val(data.Doctor_Major);
				$('#Doctor_Picture_url').val(data.Doctor_Picture_url);
				var Duty_Time=Array();
				$('input[name=Duty_Time]:checked').each(function(index) {
				  Duty_Time.push($(this).val());
				});
				$('#Depart_ID_1 option').remove();
				//把Depart_ID的内容复制到Depart_ID_1，同时让Depart_ID不可操作
				$('#Depart_ID option').each(function(index) {
				   $('#Depart_ID_1').append('<option value="'
				                            +$(this).val()
				                            +'">'
				                            +$(this).text()
				                            +'</option>');
				});
				$('#Depart_ID_1').val(data.Depart_ID);
				var duty_time_len=data.Duty_Time.length;
				for(var j=0;j<duty_time_len;j++){
					$("input:checkbox[value='"+data.Duty_Time[j]+"']").attr('checked','true');
				}
				$("#scan_file").uploadPreview({ Img: "doctor_picture"});
                $('#doctor_picture').attr('src',data.Doctor_Picture_url);
                $('#doctor_area').hide();
                $('#doctor_info_area').fadeIn('1000');
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
		var oldfile=$('#picture_name').val();
		var pic=/doctor_pic_/g;
        var idx=oldfile.search(pic);
        if(idx!=-1){
     		oldfile=oldfile.substr(idx);
        }    
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
          url:'../php/addImage_Doctor.php',//处理图片脚本
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
               	  	$('#picture_url').val(data.Doctor_Picture_url);
               	  	$('#picture_name').val(data.filename);
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
    $("#scan_file").uploadPreview({ Img: "doctor_picture"});
}
function upload_picture(){
	$('#scan_file').trigger("click");	
}
function cancelPicture(){
	$('#doctor_picture').attr('src','../images/picture_upload_logo.jpg');
	$("#scan_file").uploadPreview({ Img: "doctor_picture"});
}
function del_doctor(){
	var dialog=art.dialog({
   	   	 		title:'系统提示',
   	   	 		content:'确定要删除此用户吗？',
   	   	 		icon:'warning',
   	   	 		ok:function(){
   	   	 			del_doctor_confirm();
   	   	 		},okVal:"确定",
   	   	 		cancel:function(){
   	   	 			return true;
   	   			},cancelVal:'取消',
   	   	 		fixed:false,
   	   	 		resize:false
   	  		 });
  dialog.shake()&&dialog.shake();
}
function confirm_info(){
	var encrypttime=getEncryptTime();
	var Doctor_ID=$('#Doctor_ID').val();
	var Depart_ID=$('#Depart_ID').val();
   	var Doctor_Name=$('#Doctor_Name').val();
   	var Doctor_Level=$('#Doctor_Level').val();
   	var Doctor_Fee=$('#Doctor_Fee').val();
  	var Doctor_Limit=$('#Doctor_Limit').val();
    var Doctor_Major=$('#Doctor_Major').val();
   	var Doctor_Picture_url=$('#picture_url').attr('name');
   	var Duty_Time=Array();
   	$('input[name=Duty_Time]:checked').each(function(index) {
		 Duty_Time.push($(this).val());
	   });
    $.ajax({
		//url:'../php/TransferStation.php',
		url:'../test_get_doctor_detail.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Set_DoctorInfo',
			encrypttime:encrypttime,
			Doctor_ID:Doctor_ID,
			Depart_ID: Depart_ID,
   			Doctor_Name:Doctor_Name,
   			Doctor_Level:Doctor_Level,
   			Doctor_Fee:Doctor_Fee,
  			Doctor_Limit:Doctor_Limit,
   			Doctor_Major:Doctor_Major,
   			Duty_Time:Duty_Time,
   			Doctor_Picture_url:Doctor_Picture_url
		},
		success:function(data){	
			if(data.msg==0){
				art.dialog({
					title:'系统消息',
					icon:'succeed',
					content:'保存成功！',
					ok:true,
					okVal:'确定'
			    });
			}else{
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
function del_doctor_confirm(){
	var Doctor_ID=$('Doctor_Name').attr('name');
	var encrypttime=getEncryptTime();
	$.ajax({
		//url:'../php/TransferStation.php',
		url:'../test_get_doctor_detail.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Get_DoctorInfo_detail',
			encrypttime:encrypttime,
			Doctor_ID:Doctor_ID
		},
		success:function(data){	
			if(data.msg==0){
				     art.dialog({
							title:'系统消息',
							icon:'succeed',
							content:'操作成功！',
							ok:true,
							okVal:'确定'
			     	    });
			        $('#doctor_info_area').fadeOut('1000');
			        show_doctor();
			     	 
			}else{
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
