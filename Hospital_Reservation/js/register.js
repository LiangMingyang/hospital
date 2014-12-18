$(document).ready(function() {	
	get_Province();
	get_Area();
});
 /*判断输入是否为合法的手机号码*/
     function isphone2(inputString)
     {
          var partten = /^1[3,5,8]\d{9}$/;
          var fl=false;
          if(partten.test(inputString))
          {
               //alert('是手机号码');
               return true;
          }
          else
          {
               return false;
               //alert('不是手机号码');
          }
     }
     /*判断输入是否为合法的电话号码，匹配固定电话或小灵通*/
     function isphone1(inpurStr)
     {
          var partten = /^0(([1,2]\d)|([3-9]\d{2}))\d{7,8}$/;
          if(partten.test(inpurStr))
          {
               //alert('是电话号码');
               return true;
          }
          else
          {
               //alert('不是电话号码');
               return false;
          }
     }
     
   function checkemail(str){
		var filter=/^.+@.+\..{2,3}$/;
        if (filter.test(str))
			testresults=true;
		else{
			testresults=false;
		}
		return (testresults);
	}
function check_register(){	
	$('.tag_error').hide();
	var Birthday=$('#Birthday').val();
    var UserName=$('#UserName').val();
    var Identity_ID=$('#Identity_ID').val();
    var Location=$('#Location').val();
    var Password =$('#Password').val();
    var cfm_pwd=$('#confirm_password').val();
    var Phone=$('#Phone').val();
    var Sex=$('input:radio[name=sex]:checked').val();
    var Province_ID=$('#Province_ID').val();
    var Area_ID=$('#Area_ID').val();
    var Mail=$('#Mail').val();
    if(Birthday==''){
        $('#birthday_error_tag').show();	
        return false;
    }
    if(UserName.length>10||UserName==""){
    	 $('#username_error_tag').show();	
          return false;
    }
    if(Identity_ID==""){
    	$('#identity_id_error_tag').show();	
         return false;
    }
    if(Location.length>25){
    	$('#location_error_tag').show();	
          return false;
    }
    if(Password.length<6||Password.length>20){
    	$('#password_error_tag').show();	
          return false;
    }
    if((!isphone1(Phone))&&(!isphone2(Phone))){
    	$('#phone_error_tag').show();	
          return false;
    }
    if(Sex==""){
    	$('#sex_error_tag').show();
    	return false;
    }
    if(Province_ID==""){
    	$('#province_error_tag').show();
    	return false;
    }
    if(Area_ID==""){
    	$('#area_error_tag').show();
    	return false;
    }
    if(!checkemail(Mail)){
    	$('#mail_error_tag').show();
    	return false;
    }
    if(Password!=cfm_pwd){
    	$('#cfm_password_error_tag').show();
    	return false;
    }
	return true;
}
function get_Province(){
	$('#Province_ID option').remove();
	$('#Province_ID').append('<option value="-1">选择省份</option>');
		var encrypttime=getEncryptTime();
		$.ajax({
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
						$('#Province_ID').append('<option value="'
						                        +content[i].Province_ID
						                        +'">'
						                        +content[i].Province_Name
						                        +'</option>');
					}
				}
			}
			
		});
}
function get_Area(){
	  var encrypttime=getEncryptTime();
	  $('#Area_ID option').remove();
	  $('#Area_ID').append('<option value="-1">选择地区</option>');
	  var Province_ID=$('#Province_ID').val();
	  if(Province_ID<0){
	  	return;
	  }
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
						$('#Area_ID').append('<option value="'
						                        +content[i].Area_ID
						                        +'">'
						                        +content[i].Area_Name
						                        +'</option>');
					}
				}
			}
			
		});
}
function confirm_register(){
   if(!check_register())
   return;
   
   var Birthday=$('#Birthday').val();
   var UserName=$('#UserName').val();
   var Identity_ID=$('#Identity_ID').val();
   var Location=$('#Location').val();
   var Password =hex_sha1($('#Password').val());
   var Phone=$('#Phone').val();
   var Sex=$('input:radio[name=sex]:checked').val();
   var Province_ID=$('#Province_ID').val();
   var Area_ID=$('#Area_ID').val();
   var Mail=$('#Mail').val();
   var encrypttime=getEncryptTime();  
   $.ajax({
   	 url:'../php/TransferStation.php',
   	 type:'POST',
   	 dataType: "json",   
   	 data:{
   	 	url:'register',
   	 	Birthday:Birthday,
   		UserName:UserName,
   	    Identity_ID:Identity_ID,
   		Location:Location,
   		Password:Password,
   		Area_ID:Area_ID,
   		Phone:Phone,
   		Mail:Mail,
   		encrypttime:encrypttime
   	 },   	 
   	 success:function(data){
   	 	if(data.msg==0){
   	 			art.dialog({
					title:'系统消息',
					content:'注册成功，管理员会在5个工作日内完成审核',
					icon:'face-smile',
					okVal:'我知道了',
					ok:true
				});
   	 		    window.location.href="../php/login.php";
   	 	}else{
   	 			art.dialog({
					title:'系统消息',
					content:'系统异常，操作失败！<br/>'+"错误信息："+data.info,
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
