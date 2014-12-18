/**
 * @author acer
 */
function confirm_cash(){
	var Amount=$('#cur_Amount').val();
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
	var token=getToken(encrypttime);
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
						var ans=$('#cur_Amount').val()*1.0+Amount*1.0;
						$('#cur_Amount').val(ans);
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
