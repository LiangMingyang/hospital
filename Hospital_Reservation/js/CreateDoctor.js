/**
 * @author acer
 */
$(function () {
  $("#scan_file").uploadPreview({ Img: "doctor_picture"});
  $('#scan_file').val('');
  show_hospital();
});
function show_hospital(){
	var Admin_ID=$('#ID',window.parent.document).val();
    var encrypttime=getEncryptTime();
    $.ajax({
				url:'../php/TransferStation.php',
				type:'POST',
				dataType:'json',
				data:{
					url:'Get_HospitalInfo_simple',
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
				url:'../php/TransferStation.php',
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
		var oldfile=$('#picture_name').val();
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
               	  	alert(data.filename);
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
function cancelPicture(){
	$('#doctor_picture').attr('src','../images/picture_upload_logo.jpg');
	$("#scan_file").uploadPreview({ Img: "doctor_picture"});
}
function confirm_info(){
	var encrypttime=getEncryptTime();
    var Depart_ID=$('#Depart_ID').val();
    var Doctor_Name=$('#Doctor_Name').val();
    var Doctor_Level=$('#Doctor_Level').val();
    var Doctor_Fee=$('#Doctor_Fee').val();
    var Doctor_Limit=$('#Doctor_Limit').val();
    var Doctor_Major=$('#Doctor_Major').val();
    var Duty_Time=Array();
    var Doctor_Picture_url=$('#picture_url').val();
    $('input[name=Duty_Time]:checked').each(function(index) {
      Duty_Time.push($(this).val());
    });
    $.ajax({
    	url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			encrypttime:encrypttime,
            Depart_ID:Depart_ID,
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
					content:'添加成功！',
					icon:'succeed',
					ok:true,
					okVal:'确定'
				});
			}else{
				art.dialog({
					title:'系统消息',
					content:'操作失败！错误信息<br/>'+data.info,
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
