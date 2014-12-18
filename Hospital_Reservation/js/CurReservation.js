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
    getReservation();
});
function getReservation(){
	var encrypttime=getEncryptTime();
	var token=getToken(encrypttime);
	var User_ID=$('#User_ID').val();
	$.ajax({
		url:'../test_reservation.php',
		type:'POST',
		datatype:'json',
		data:{
			token:token,
			encrypttime:encrypttime,
			User_ID:User_ID
		},
		success:function(data){
			data=eval("("+data+")");
			if(data.msg==0){
				var content=data.content;
				var length=content.length;
				if(length>0){
					for(var i=0;i<length;i++){
						var obj=content[i];
						if(obj.Reservation_Payed=='0'){
							   $("#reservation_tb").append(
							"<tr>"
			                +"<td>"+(i+1)+"</td>"
			                +"<td>"+obj.Reservation_Time+"</td>"
			                +"<td>"+obj.Doctor_Name+"</td>"
			                +"<td>"+obj.Operation_Time+"</td>"
			                +"<td>"
			                +"<input type='button' class='detail' value='查看详情' id='detail_"+obj.Reservation_ID+"' onclick='getDetail(this)' />"
			                +"</td>"
			                +"<td>"
			                +"<input type='button' class='reservation' value='打印预约单' id='reservation_"+obj.Reservation_ID+"' onclick='printReservationSheet(this)' />"
				            +"<input type='button' class='appointment' value='打印挂号单'  id='appointment_"+obj.Reservation_ID+"' onclick='printAppointmentSheet(this)' />"
			                +"</td>"
			                +"<td>"
			                +"<input type='button' class='pay' value='支付' name='"+obj.Reservation_ID+"' id='pay_"+obj.Reservation_ID+"' onclick='Pay(this)' />"
			                +"<span style='display:none;color: yellow' id='span_"+obj.Reservation_ID +"' >已支付</span>"
			                +"</td>"
		                    +"<td>"
			                +"<input type='button' class='cancel_reservation' value='取消'  id='cancel_"+obj.Reservation_ID+"' onclick='cancel_reservation(this)' />"
		                    +"</td>"
		                    +"</tr>"
						    );
						}
						else if(obj.Reservation_Payed=='1'){
						//alert("jisd");
						    $("#reservation_tb").append(
							"<tr>"
			                +"<td>"+(i+1)+"</td>"
			                +"<td>"+obj.Reservation_Time+"</td>"
			                +"<td>"+obj.Doctor_Name+"</td>"
			                +"<td>"+obj.Operation_Time+"</td>"
			                +"<td>"
			                +"<input type='button' class='detail' value='查看详情' id='detail_"+obj.Reservation_ID+"' onclick='getDetail(this)' />"
			                +"</td>"
			                +"<td>"
			                +"<input type='button' class='reservation' value='打印预约单' id='reservation_"+obj.Reservation_ID+"' onclick='printReservationSheet(this)' />"
				            +"<input type='button' class='appointment' value='打印挂号单'  id='appointment_"+obj.Reservation_ID+"' onclick='printAppointmentSheet(this)' />"
			                +"</td>"
			                +"<td>"
			                +"<span id='span_"+obj.Reservation_ID +"' style='color: yellow'>已支付</span>"
			                +"<input style='display:none' type='button' class='pay' value='支付' name='"+obj.Reservation_ID+"' id='pay_"+obj.Reservation_ID+"' onclick='Pay(this)' />"
			                
			                +"</td>"
			                +"<td>"
			                +"<input type='button' class='cancel_reservation' value='取消' id='cancel_"+obj.Reservation_ID+"' onclick='cancel_reservation(this)' />"
		                    +"</td>"
		                    +"</tr>"
						    );
					     }
					}
					
				}else {
					$('#nosignal').show();
				}
			}else if(data.msg==3){
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'请求超时！',
							ok:true,
							okVal:'确定'
			     });
			}else{
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！',
							ok:true,
							okVal:'确定'
			     });
			}
		},
		error:function(data){
			art.dialog({
				title:'系统消息',
				icon:'error',
				content:'与服务器交互失败，请稍后重试！',
				ok:true,
				okVal:'确定'
			});
		}
	});
}
function test(){
	
}
/*
 * 	 Reservation_Time
  Reseration_Symptom
  Reservation_Payed
  Operation_Time
  Hospital_Name
  Hospital_Location
  Depart_Name
  Doctor_Name
  Doctor_Level
  Doctor_Fee
 */
/*
 * 
 */
function getDetail(t){
	var Reservation_ID=$(t).attr('id').substr(7);
	var encrypttime=getEncryptTime();
	var token=getToken(encrypttime);
	$.ajax({
		url:'../test_Reservation_detail.php',
		type:'POST',
		datatype:'json',
		data:{
			token:token,
			encrypttime:encrypttime,
			Reservation_ID:Reservation_ID
		},
		success:function(data){
			data=eval("("+data+")");
			if(data.msg==0){
				/*
				 * $data['msg']=0; 
   $data['Reservation_ID']=1;
   $data['Reservation_Time']=date('Y-m-d H:i:s');
   $data['Operation_Time']=date('Y-m-d H:i:s');
   $data['Doctor_Name']='耿金坤';
   
  $data['Reseration_Symptom']="感冒";
  $data['Reservation_Payed']=0;
  $data['Hospital_Name']='北京市第三人民医院';
  $data['Hospital_Location']='北京市学院路38号';
  $data['Depart_Name']='内科';
  $data['Doctor_Level']=1;
  $data['Doctor_Fee']=15.00;
				 */
				$('#Reservation_Time').html(data.Reservation_Time);
				$('#Doctor_Name').html(data.Doctor_Name);
				$('#Reseration_Symptom').val(data.Reseration_Symptom);
				
				if(data.Reservation_Payed=='0'){
					$('#Reservation_Payed').html("未支付");
					$('#Reservation_Payed').attr("style","color:red");
					$('#pay_btn').attr('name',data.Reservation_ID);
					$('#pay_btn').show();
				}else if(data.Reservation_Payed=='1'){
					$('#Reservation_Payed').html("已支付");
					$('#Reservation_Payed').attr("style","color:green");
					$('#pay_btn').hide();
				}
				
				$('#Hospital_Name').html(data.Hospital_Name);
				$('#Hospital_Location').html(data.Hospital_Location);
				$('#Depart_Name').html(data.Depart_Name);
				$('#Doctor_Level').html(data.Doctor_Level);
				$('#Doctor_Fee').html(data.Doctor_Fee);
				
				art.dialog({
							title:'预约记录详情',
							content:document.getElementById("detail_area"),
							ok:function(){
								$('#Reservation_Time').html('');
				                $('#Doctor_Name').html('');
				                $('#Reseration_Symptom').val('');
								$('#Reservation_Payed').html("");
								$('#pay_btn').hide();
								$('#Hospital_Name').html('');
								$('#Hospital_Location').html('');
								$('#Depart_Name').html('');
								$('#Doctor_Level').html('');
								$('#Doctor_Fee').html('');
							},
							okVal:'关闭'
			     });
			}else if(data.msg==3){
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'请求超时！',
							ok:true,
							okVal:'确定'
			     });
			}else{
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！',
							ok:true,
							okVal:'确定'
			     });
			}
		},
		error:function(data){
			art.dialog({
							title:'系统消息',
							icon:'error',
							content:'与服务器交互失败，请稍后重试！',
							ok:true,
							okVal:'确定'
			});
		}
	});
}
function Pay(t){
	var Reservation_ID=$(t).attr('name');
	var encrypttime=getEncryptTime();
	var token=getToken(encrypttime);
	$.ajax({
		//url:host/ Pay_Reservation
		url:'../testPayed.php',
		type:'POST',
		datatype:'json',
		data:{
			token:token,
			encrypttime:encrypttime,
			Reservation_ID:Reservation_ID
		},
		success:function(data){
			data=eval("("+data+")");
			if(data.msg=='0'){
				art.dialog({
							title:'系统消息',
							icon:'face-smile',
							content:'支付成功',
							ok:function(){
								$('#span_'+Reservation_ID).show();
								$('#pay_'+Reservation_ID).hide();
							},
							okVal:'确定'
			     });
			}else if(data.msg=='3'){
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'请求超时！',
							ok:true,
							okVal:'确定'
			     });
			}else{
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！',
							ok:true,
							okVal:'确定'
			     });
			}
		},
		error:function(data){
			art.dialog({
							title:'系统消息',
							icon:'error',
							content:'与服务器交互失败，请稍后重试！',
							ok:true,
							okVal:'确定'
			});
		}
	});
    

}
function Cancel_by_ID(Reservation_ID){
   var encrypttime=getEncryptTime();
   var token=getToken(encrypttime);
   var User_ID=$('#User_ID').val();
   $.ajax({
		//url:host/ Pay_Reservation
		url:'../testPayed.php',
		type:'POST',
		datatype:'json',
		data:{
			token:token,
			encrypttime:encrypttime,
			Reservation_ID:Reservation_ID,
			User_ID:User_ID
		},
		success:function(data){
			data=eval("("+data+")");
			if(data.msg=='0'){
				art.dialog({
							title:'系统消息',
							icon:'succeed',
							content:'取消成功',
							ok:function(){
								$('#span_'+Reservation_ID).hide();
								$('#pay_'+Reservation_ID).show();
							},
							okVal:'确定'
			     });
			}else if(data.msg=='3'){
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'请求超时！',
							ok:true,
							okVal:'确定'
			     });
			}else{
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！',
							ok:true,
							okVal:'确定'
			     });
			}
		},
		error:function(data){
			art.dialog({
							title:'系统消息',
							icon:'error',
							content:'与服务器交互失败，请稍后重试！',
							ok:true,
							okVal:'确定'
			});
		}
	});
    
}
function cancel_reservation(t){
	
	var Reservation_Time=$(t).parent().siblings().eq(1).html();
	//alert(Reservation_Time);
	//alert(Reservation_Time.replace(/-/g,"/"));
    var reservation_time=new Date(Reservation_Time.replace(/-/g,"/"));
    //alert(reservation_time.getTime());
    var now_time=new Date();
    //alert(now_time.getTime());
    //alert(reservation_time.getUTCDate());
    //alert(now_time.getUTCDate());
    var interval=(reservation_time.getTime()-now_time.getTime())/(24*60*60*1000);
    //alert(reservation_time.getTime()-now_time.getTime());
    //alert(interval);
   // alert(interval);
    if(interval<1){
    	 art.dialog({
   	   	 		title:'系统提示',
   	   	 		content:'距离预约时间小于24小时，不可取消，请联系相关医院管理人员协商解决',
   	   	 		icon:'warning',
   	   	 		ok:true,
   	   	 		okVal:"我知道了",
   	   	 		top:'10%',
   	   	 		fixed:false,
   	   	 		resize:false
   	  		 });
   	  		return;
    }
	var dialog=art.dialog({
   	   	 		title:'系统提示',
   	   	 		content:'确定要取消此预约吗？',
   	   	 		icon:'warning',
   	   	 		ok:function(){
   	   	 			var Reservation_ID=$(t).attr('id').substr(7);
   	   	 			Cancel_by_ID(Reservation_ID);
   	   	 		},okVal:"确定",
   	   	 		cancel:function(){
   	   	 			return true;
   	   			},cancelVal:'取消',
   	   	 		fixed:false,
   	   	 		resize:false
   	  		 });
  dialog.shake()&&dialog.shake();		
}
function printReservationSheet(t){
	var Reservation_ID=$(t).attr('id').substr(12);
    var Reservation_Time;
    var Reseration_Symptom;
    var Reservation_Payed;
    var Operation_Time;
    var Hospital_Name;
    var Hospital_Location;
    var Depart_Name;
    var Doctor_Name;
    var Doctor_Level;
    var Doctor_Fee;
    var encrypttime=getEncryptTime();
    var token=getToken(encrypttime);
	$.ajax({
		//url:"host/Check_Reservation_Detail",
		url:"../test_Reservation_detail.php",
	    type:'POST',
		datatype:'json',
		async:false,
		data:{
			token:token,
			encrypttime:encrypttime,
  			Reservation_ID:Reservation_ID
		},
		success:function(data){
			data=eval("("+data+")");
			if(data.msg=='0'){
				alert('ok');
				
				Reservation_Time=data.Reservation_Time;
				Reseration_Symptom=data.Reseration_Symptom;
				Reservation_Payed=data.Reservation_Payed;
				Operation_Time=data.Operation_Time;
				Hospital_Name=data.Hospital_Name;
				Hospital_Location=data.Hospital_Location;
				Depart_Name=data.Depart_Name;
				Doctor_Name=data.Doctor_Name;
				Doctor_Level=data.Doctor_Level;
				Doctor_Fee=data.Doctor_Fee;
				alert(Reservation_Time);
				window.location.href="../php/printReservationSheet.php?Reservation_Time="+data.Reservation_Time
				                     +"&Reseration_Symptom="+data.Reseration_Symptom
				                     +"&Reservation_ID="+Reservation_ID
				                     +"&Hospital_Name="+data.Hospital_Name
				                     +"&Hospital_Location="+data.Hospital_Location
				                     +"&Depart_Name="+data.Depart_Name;
			}else if(data.msg=='3'){
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'请求超时！',
							ok:true,
							okVal:'确定'
			     });
			}else{
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！',
							ok:true,
							okVal:'确定'
			     });
			}
		},
		error:function(data){
			art.dialog({
							title:'系统消息',
							icon:'error',
							content:'与服务器交互失败，请稍后重试！',
							ok:true,
							okVal:'确定'
			});
		}
	});
	
}
function printAppointmentSheet(t){
	if($(t).parent().siblings().eq(5).find(".pay").attr("style")==undefined){
		 art.dialog({
				title:'系统消息',
				icon:'face-smile',
				content:"亲，先要支付挂号费才可打印挂号单哦！",
				ok:true,
				okVal:'确定'
		});
		return;
	}
    alert($(t).parent().siblings().eq(5).find(".pay").attr("style")==undefined);
	var Reservation_ID=$(t).attr('id').substr(12);
    var Reservation_Time;
    var Reseration_Symptom;
    var Reservation_Payed;
    var Reservation_PayTime;
    var Operation_Time;
    var Hospital_Name;
    var Hospital_Location;
    var Depart_Name;
    var Doctor_Name;
    var Doctor_Level;
    var Doctor_Fee;
    var encrypttime=getEncryptTime();
    var token=getToken(encrypttime);
	$.ajax({
		//url:"host/Check_Reservation_Detail",
		url:"../test_Reservation_detail.php",
	    type:'POST',
		datatype:'json',
		async:false,
		data:{
			token:token,
			encrypttime:encrypttime,
  			Reservation_ID:Reservation_ID
		},
		success:function(data){
			data=eval("("+data+")");
			if(data.msg=='0'){			
				Reservation_Time=data.Reservation_Time;
				Hospital_Name=data.Hospital_Name;
				Depart_Name=data.Depart_Name;
				Doctor_Name=data.Doctor_Name;
				Doctor_Level=data.Doctor_Level;
				Doctor_Fee=data.Doctor_Fee;
				Reservation_PayTime=data.Reservation_PayTime;
				window.location.href="../php/printAppointSheet.php?Reservation_Time="+data.Reservation_Time
				                     +"&Reseration_Symptom="+data.Reseration_Symptom
				                     +"&Reservation_ID="+Reservation_ID
				                     +"&Hospital_Name="+data.Hospital_Name
				                     +"&Hospital_Location="+data.Hospital_Location
				                     +"&Depart_Name="+data.Depart_Name
				                     +"&Doctor_Fee="+data.Doctor_Fee
				                     +"&Doctor_Name="+data.Doctor_Name
				                     +"&Reservation_PayTime="+data.Reservation_PayTime;
			}else if(data.msg=='3'){
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'请求超时！',
							ok:true,
							okVal:'确定'
			     });
			}else{
				art.dialog({
							title:'系统消息',
							icon:'error',
							content:'系统操作异常！',
							ok:true,
							okVal:'确定'
			     });
			}
		},
		error:function(data){
			art.dialog({
							title:'系统消息',
							icon:'error',
							content:'与服务器交互失败，请稍后重试！',
							ok:true,
							okVal:'确定'
			});
		}
	});
}
