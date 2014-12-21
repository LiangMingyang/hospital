/**
 *入侵检测页面相关函数 
 */
$(function(){
	$('.save').click(function(){
		var i =$('.save').index(this);
		save(i);
	});
	
	$('.delete').click(function(){
		var i =$('.delete').index(this);
		deleteRow(i);
	});
	$('.add').click(function(){
		html = '<tr><td><input type="text" class="description"/></td>';
//		html+='<td><select class="block"><option value="0">不阻塞</option><option value="1">阻塞</option></select></td>';
		html+='<td><select class="mail"><option value="0">关闭</option><option value="1">开启</option></select></td>';
//		html+='<td><select class="sms"><option value="0">关闭</option><option value="1">开启</option></select></td>';
		html+='<td><select class="pop"><option value="0">关闭</option><option value="1">开启</option></select></td>';
		html+='<td><input type="hidden" class="actionId" value="#"/><a href="javascript:void(0)" onclick="var i =$(\'.save\').index(this);save(i);"class="neibu save">保存</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="var i =$(\'.delete\').index(this);del(i);" class="neibu delete">删除</a></td>';
//		$('#last').before(html);
		$('#actionTbody').append(html);
 	 	});
});
function del(idx){
	var actionId = $(".actionId").eq(idx).val();
//	if(actionId==undefined || actionId==""){
	if(actionId=="#"){
		idx = $('.save').length-$('.delete').length+idx;
		$('.box102 table tr').eq(idx+1).remove();
//		$('.box102 table tr').eq(idx).remove();
	} else {
		deleteRow(idx);
	}
}
function deleteRow(idx) {
	var actionId = $(".actionId").eq(idx).val();
	$.post(WEB_ROOT+'cfg/action.php?cmd=del',{
		'actionId':actionId
	},function(data){
		if(data == "OK"){
			artDialog({content:'删除成功！', style:'succeed'}, function(){
				window.location.href="action.php";
			});
		}
		else {
			artDialog({content:'该响应活动已被自定义审计规则使用，不能被删除，可以修改该响应活动！', style:'error'}, function(){
			});
		}
		
	});
}

function checkNameLength(idx) {
	var description = $(".description").eq(idx).val();
	if($.trim(description) == "") {
		artDialog({content:'活动名称不能为空！', style:'alert'}, function(){
		});
		return false;
	} else if($.trim(description).length > 20){
		artDialog({content:'活动名称不能超过20个字符！', style:'alert'}, function(){
		});
		return false;
	}
	return true;
}

function save(idx){
	var description = $(".description").eq(idx).val();
//	var block = $(".block").eq(idx).val();
	var mail = $(".mail").eq(idx).val();
//	var sms = $(".sms").eq(idx).val();
	var pop = $(".pop").eq(idx).val();
	var id = $(".actionId").eq(idx).val();
	
	var block = 0;
	var sms = 0;
	if($.trim(description) == "") {
		artDialog({content:'活动名称不能为空！', style:'alert'}, function(){
		});
	} else if($.trim(description).length > 20){
		artDialog({content:'活动名称不能超过20个字符！', style:'alert'}, function(){
		});
	} else {
		$.post(WEB_ROOT+'cfg/action.php?cmd=save',{
			'action[Description]':description,
			'action[Block]':block,
			'action[MailWarn]':mail,
			'action[SMSWarn]':sms,
			'action[PopWarn]':pop,
			'action[ActionID]':id
		},function(data){
			if(data == "SAVE_Error"){
				artDialog({content:'添加失败！', style:'error'}, function(){
				});
			}else if(data == "SAVE_OK"){
				artDialog({content:'添加成功！', style:'succeed'}, function(){
					window.location.href="action.php";
				});
			}else if(data == "UPDATE_Error"){
				artDialog({content:'修改失败！', style:'error'}, function(){
					window.location.href="action.php";
				});
				
			}else if(data == "UPDATE_OK"){
				artDialog({content:'修改成功！', style:'succeed'}, function(){
					window.location.href="action.php";
				});
				
			} else if(data == "NameError") {
//				alert("活动名称不能重名！");
//				$(".description").eq(idx).val("");
				artDialog({content:'活动名称不能重名！', style:'alert'}, function(){
				});
			}
			
		});
	}
	 
}


String.prototype.trim=function(){
	　　 return this.replace(/(^\s*)|(\s*$)/g, "");
	　　}
