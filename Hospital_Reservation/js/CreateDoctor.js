/**
 * @author acer
 */
$(function () {
  show_hospital();
});
function show_hospital(){
	var Admin_ID=$('#Admin_ID',window.parent.document).val();
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
							$('#Hospital_ID').append('<option value="-1">选择医院</option>');
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
function confirm_info(){
	var encrypttime=getEncryptTime();
    var Depart_ID=$('#Depart_ID').val();
    var Doctor_Name=$('#Doctor_Name').val();
    var Doctor_Level=$('#Doctor_Level').val();
    var Doctor_Fee=$('#Doctor_Fee').val();
    var Doctor_Limit=$('#Doctor_Limit').val();
    var Doctor_Major=$('#Doctor_Major').val();
    var Doctor_Picture_url=$('#picture_url').val();
    $.ajax({
    	url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			encrypttime:encrypttime,
			url:'Add_Doctor',
            Depart_ID:Depart_ID,
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
