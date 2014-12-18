$(function () {
  $("#scan_file").uploadPreview({ Img: "hospital_picture"});
  $('#scan_file').val('');
  show_province();
});
function show_province(){
	    var encrypttime=getEncryptTime();
		$.ajax({
			//url:'host/ Get_Province_Info'
			url:'../php/TransferStation.php',
			type:'POST',
			dataType:'json',
			data:{
				url:'Get_Province_Info',
				encrypttime:encrypttime,
			},
			success:function(data){
				if(data.msg=='0'){
					var content=data.content;
					var len=content.length;
					for(var i=0;i<len;i++){
						$('#Province').append('<option value="'
						+content[i].Province_ID
						+'">'
						+content[i].Province_Name
						+'</option>');
					}
					
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
function show_area(){
	var Province_ID=$('#Province').val();
	if(Province_ID<0){
		art.dialog({
			title:'系统消息',
			icon:'warning',
			top:'10%',
			content:'请先选择省份！',
			ok:true,
			okVal:'确定'
		});
	}else{
			var encrypttime=getEncryptTime();
			$.ajax({
				//url:"host/Get_Area_Info_By_Province_ID",
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
								$('#Area').append('<option value="'
								+content[i].Area_ID
								+'">'
								+content[i].Area_Name
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
          url:'../php/addImage_Hospital.php',//处理图片脚本
          secureuri :false,
          fileElementId :'scan_file',//file控件id
          dataType : 'json',
          data:{
            	destination:"hospital",
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
               	  	$('#picture_url').val(data.Hospital_Picture_url);
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
    $("#scan_file").uploadPreview({ Img: "hospital_picture"});
}
function cancelPicture(){
	$('#hospital_picture').attr('src','../images/picture_upload_logo.jpg');
	$("#scan_file").uploadPreview({ Img: "hospital_picture"});
}
function confirm_info(){
  var Hospital_Name=$('#Hospital_Name').val();
  var Hospital_Level=$('#Hospital_Level').val();
  var Hospital_Introduction=$('#Hospital_Introduction').val();
  var Hospital_Location=$('#Hospital_Location').val();
  var Reservation_Start_Time=$('#StartDate').val();
  var Reservation_End_Time=$('#EndDate').val();
  var Province_ID=$('#Province').val();
  var Area_ID=$('#Area').val();
  var Hospital_Picture_url=$('#picture_url').val();
  //alert(Hospital_Picture_url);
  if(Province_ID==-1){
  	art.dialog({
  		title:'系统提示',
  		icon:'error',
  		top:'15%',
  		content:'请选择省份!',
  		ok:true,
  		okVal:'我知道了'
  	});
  	return;
  }
  if(Area_ID==-1){
  	art.dialog({
  		title:'系统提示',
  		icon:'error',
  		top:'15%',
  		content:'请选择地区!',
  		ok:true,
  		okVal:'我知道了'
  	});
  	return;
  }
  var encrypttime=getEncryptTime();
  $.ajax({
  	//url:'host/Create_Hospital',
  	url:'../php/TransferStation.php',
  	type:'POST',
  	dataType:'json',
  	data:{
  		    url:'Create_Hospital',  
            encrypttime:encrypttime,
   	        Hospital_Name:Hospital_Name,
	        Hospital_Level:Hospital_Level,
	        Hospital_Introduction:Hospital_Introduction,
	        Hospital_Location:Hospital_Location,
	        Reservation_Start_Time:Reservation_Start_Time,
	        Reservation_End_Time:Reservation_End_Time,
            Area_ID:Area_ID,
            Hospital_Picture_url:Hospital_Picture_url
  	},
  	success:function(data){
  		   if(data.msg=='0'){
  		   	  art.dialog({
  		   		title:'系统消息',
  		   		content:'创建成功！',
  		   		icon:'succeed',
  		   		ok:true,
  		   		top:'15%',
  		   		okVal:'确定'
  		   	   });
  		   }else {
  		   	  art.dialog({
  		   		title:'系统消息',
  		   		content:'操作失败！失败信息：<br/>'+data.info,
  		   		icon:'error',
  		   		top:'15%',
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
  		   		top:'15%',
  		   		cancel:true,
  		   		cancelVal:'关闭'
  		 });
  	}
  });

}
