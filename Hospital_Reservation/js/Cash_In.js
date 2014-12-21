/**
 * @author acer
 */
$(document).ready(function(){
	getAmount();
});
function getAmount(){
	var encrypttime=getEncryptTime();
	var User_ID=$('#name').attr('name');
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			encrypttime:encrypttime,
			url:"Get_Cash",
			User_ID:User_ID,
		},
		success:function(data){
			if(data.msg==0){
				$('#cur_Amount').val(data.amount);
			}else{
				('#cur_Amount').val('?');
			}
		},
		error:function(data){
			('#amount').val('?');
		}
	});
}
function confirm_cash(){
	var Amount=$('#amount').val();
	var User_ID=$('#name').attr('name');
	if(isNaN(Amount)){
		art.dialog({
			content:'请输入金额数字',
			ok:function(){
				$('#amount').val('0.00');
			},
			icon:'warning',
			okVal:'我知道了'
		});
		return;
	}
	var encrypttime=getEncryptTime();
	$.ajax({
		url:'../php/TransferStation.php',
		type:'POST',
		dataType:'json',
		data:{
			encrypttime:encrypttime,
			url:"In_Cash",
			User_ID:User_ID,
            Amount:Amount
		},
		success:function(data){
			if(data.msg=='0'){
				art.dialog({
					icon:"succeed",
					content:'充值成功',
					ok:function(){
						getAmount();
					},
					okVal:'我知道了',
				});
			}else{
				art.dialog({
					icon:"error",
					content:'操作失败,错误信息<br/>'+data.info,
					ok:true,
					okVal:'确定',
				});
			}
		},
		error:function(data){
			art.dialog({
					icon:"error",
					content:'与服务器交互失败！',
					ok:true,
					okVal:'确定',
				});
		}
	});
	
}
