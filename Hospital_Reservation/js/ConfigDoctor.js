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
	var Admin_ID=$('#Admin_ID',window.parent.document).val();
    var encrypttime=getEncryptTime();
     $('#Hospital_ID option').remove();
    $('#Hospital_ID').append('<option value="-1">选择医院</option>');				
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
							if(len>0)
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
	$('#Depart_ID option').remove();
	$('#Depart_ID').append('<option value="-1">选择科室</option>');
	if(Hospital_ID<0)return;
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
						if(len>0)
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
	$('#doctor_tb').show();
	$('#no_record_signal').hide();
	var Depart_ID=$('#Depart_ID').val();
	if(isNaN(Depart_ID)||Depart_ID<0)return;
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
						if(len<=0){
							$('#no_record_signal').show();
						}
						var content_txt="";
						for(var i=0;i<len;i++){
							if(i%4==0){
								content_txt+='<tr>';
							}
							content_txt+='<td id="'+content[i].Doctor_ID+'">'+content[i].Doctor_Name+'</td>';
							if(i%4==7||i==len-1){
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
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Get_DoctorInfo_detail',
			encrypttime:encrypttime,
			Doctor_ID:Doctor_ID
		},
		success:function(data){	
			if(data.msg=='0'){
				data=data.content[0];
				$('#Doctor_Name').val(data.Doctor_Name);
				$('#Doctor_Name').attr('name',Doctor_ID);//name 键用来存Doctor_ID
				$('#Doctor_Level').val(data.Doctor_Level);
				$('#Doctor_Fee').val(data.Doctor_Fee);
				$('#Doctor_Limit').val(data.Doctor_Limit);
				$('#Doctor_Major').val(data.Doctor_Major);
				$('#Doctor_Picture_url').val(data.Doctor_Picture_url);
				/*
				var Duty_Time=Array();
				$('input[name=Duty_Time]:checked').each(function(index) {
				  Duty_Time.push($(this).val());
				});
				*/
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
				/*
				var duty_time_len=data.Duty_Time.length;
				for(var j=0;j<duty_time_len;j++){
					$("input:checkbox[value='"+data.Duty_Time[j]+"']").attr('checked','true');
				}
				*/
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
function find_duty_time(){
	var encrypttime=getEncryptTime();
	var Doctor_ID=$('#Doctor_Name').attr('name');
	var old_duty_time="";
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		async:false,
		dataType:'json',
		data:{
			url:'Find_Doctor_Time',
			encrypttime:encrypttime,
			Doctor_ID:Doctor_ID
		},
		success:function(data){
			if(data.msg==0){
				data=data.content;
				var len=data.length;
				alert("len"+len);
				for(var i=0;i<len;i++){
					var dt=data[i].Duty_Time;
					$('input[name=Duty_Time]').each(function(index) {
						if(dt==$(this).val()){
							$(this).attr('checked',"checked");
						}
					});
				}
			}else{
				old_duty_time="";
			}
		},
		error:function(data){
			old_duty_time="";
		}
	});
	return old_duty_time;
}

function show_duty_time(){
	//tag_duty_time
	//以及Find_Doctor_Time和Del_Doctor_Time
	//$('#Doctor_Name').val();
	find_duty_time();
	art.dialog({
		id:'duty_time_dlg',
		title:'坐诊时间',
		content:document.getElementById('duty_time_div'),
	});
}
function save_duty_time(){
	var Duty_Time="";
	$('input[name=Duty_Time]:checked').each(function(index) {
		Duty_Time+=$(this).val()+",";
	});
	Duty_Time=Duty_Time.substr(0,Duty_Time.length-1);
	var encrypttime=getEncryptTime();
	var Doctor_ID=$('#Doctor_Name').attr('name');
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Update_Doctor_Time',
			encrypttime:encrypttime,
			Doctor_ID:Doctor_ID,
			Duty_Time:Duty_Time
		},
		success:function(data){
			if(data.msg==0){
				art.dialog({
			   		title:'系统消息',
			   		content:'保存成功！',
			   		ok:true,
			   		okVal:'确定',
		    	});
		    	$('#old_duty_time').val(Duty_Time);
		    }else{
		    	art.dialog({
			   		title:'系统消息',
			   		content:'操作失败！错误信息<br/>'+data.info,
			   		ok:true,
			   		okVal:'确定',
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
function close_duty_time(){
	art.dialog({id:'duty_time_dlg'}).close();
}
function del_doctor(){
	var dialog=art.dialog({
   	   	 		title:'系统提示',
   	   	 		content:'确定要删除此医生吗？',
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
   	/*
   	
	  */
    $.ajax({
		url:'../php/TransferStation.php',
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
	var Doctor_ID=$('#Doctor_Name').attr('name');
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		//url:'../test_get_doctor_detail.php',
		type:'POST',
		dataType:'json',
		data:{
			url:'Del_Doctor',
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
