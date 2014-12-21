String.prototype.trim = function () {return this .replace(/^\s\s*/, '' ).replace(/\s\s*$/, '' );}

$(function(){	
		/*弹出对话框——添加IPRange对话框*/
		$( "#addNewIPRangeDiv" ).dialog({
			autoOpen: false,
			resizable: true,
			height:250,
			width:300,
			modal: false,
			position:"top",
			title:"添加IP范围",
			buttons: {
				"确定": function() {			
					$ipNameObj = $("#newRangeNameText");
					$startIpObj = $("#newStartIPText");
					$endIpObj = $("#newEndIPText");
					if(checkNonEmpty($ipNameObj)&&checkNonEmpty($startIpObj)&&checkNonEmpty($endIpObj)) {
						if(validateIp($startIpObj)&&validateIp($endIpObj)) {
							var newName = $ipNameObj.val();
							var newStart = $startIpObj.val();
							var newEnd = $endIpObj.val();
							
							if(newName.length > 20) {
								$("#warningInfo").html("<font color='red'>IP范围名称不能超过20个字符！</font>");
							} else {
								$.ajax({
									url:"iprange.php?cmd=add",
									type:"POST",
									dataType:"text",
									data:{
										name:newName,
										start:newStart,
										end:newEnd
									},
									success:function(data){
										if(data == "NameError") {
//											alert("已存在该IP范围名称！");
											artDialog({content:'已存在该IP范围名称！', style:'error'}, function(){
												$ipNameObj.val("");
											});
											
										} else if(data == "IPError") {

											artDialog({content:'不能添加重复的IP范围！', style:'error'}, function(){
												$startIpObj.val("");
												$endIpObj.val("");
											});
										} else if(data == "OK") {
											
											artDialog({content:'添加成功！', style:'succeed'}, function(){
												$( this ).dialog( "close" );
												window.location.href="iprange.php";
											});
										} else if(data == "ERROR") {
//											alert("添加失败，请重试！");
											artDialog({content:'添加失败，请重试！', style:'error'}, function(){
												$ipNameObj.val("");
												$startIpObj.val("");
												$endIpObj.val("");
											});
											
										}
										
									}
								});
							}
						} else {
							$("#warningInfo").html("<font color='red'>输入的IP格式不正确！</font>");
						}
					} else {
						$("#warningInfo").html("<font color='red'>必填项不能为空！</font>");
					}
					
				},
				取消: function() {
					$( this ).dialog( "close" );
					$ipNameObj.val("");
					$startIpObj.val("");
					$endIpObj.val("");
				}
				
			}
		});
});

//删除iprange
function deleteIPRange(ipRangeID) {
	artDialog({content:'确定要删除该条IP范围吗？', style:'confirm'}, function(){
		$.ajax({
			url:"iprange.php?cmd=delete",
			type:"post",
			dataType:"text",
			data:{
				id:ipRangeID
			},
			success:function(data) {
				alert(data);
				window.location.href="iprange.php";
			}
		});
	},function(){
		
	});
//	if(confirm("确定要删除该条IP范围吗？")) {
//		//window.location.href="iprange.php?cmd=delete&id="+ipRangeID;
//		$.ajax({
//			url:"iprange.php?cmd=delete",
//			type:"post",
//			dataType:"text",
//			data:{
//				id:ipRangeID
//			},
//			success:function(data) {
//				alert(data);
//				window.location.href="iprange.php";
//			}
//		});
//	}
}
function addIPRange() {
	$("#addNewIPRangeDiv").dialog("open");
}

//验证是否不为空
function checkNonEmpty(o) {
	if(o.val().trim().length > 0) {
		return true;
	} else {
		return false;
	}
}

//验证是否是正确的IP
function validateIp(ipObj)
{
   var patrn = /^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/;
   if(!patrn.exec(ipObj.val()))
   {
       return false;
   }
   return true;
}


//function page(pageNo){
//	if(pageNo == -1){
//		pageNo = $('#pageNum').val();
//	}
//	$.post(WEB_ROOT+"policy/iprange.php",{
//		page:'page',
//		pageNo:pageNo
//	},function(data){
//		$('#body').html(data);
//	})
//}