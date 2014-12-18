String.prototype.trim = function () {return this .replace(/^\s\s*/, '' ).replace(/\s\s*$/, '' );}

$(function(){
		/*弹出对话框*/
		$( "#addObjectGroupForm" ).dialog({
			autoOpen: false,
			resizable: true,
			height:400,
			width:500,
			modal: false,
			position:'top',
			title:"选择所要添加的IP范围",
			buttons: {
				"确定": function() {		
					var ipRangeCheck = $("input:[name=selectIPRange]:checkbox:checked");
					var count = ipRangeCheck.length;
					if(count > 0) {
						var chooseIdStr = "";
						for(var i = 0; i < count; i ++) {
							chooseIdStr += ipRangeCheck[i].value+",";
						}
						var policyId = $("#policyIdHidden").val();
						window.location.href="policyDetails.php?cmd=addPolicyWhite&policyId="+policyId+"&ipRangeIds="+chooseIdStr;
						$( this ).dialog( "close" );
					} else {
						alert("请选择您要添加的IP范围！");
					}
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
});

//打开添加新对象组对话框
function addObjectGroup() {
	$( "#addObjectGroupForm" ).dialog( "open" );	
}

//验证是否不为空
function checkNonEmpty(o) {
	if(o.val().trim().length > 0) {
		return true;
	} else {
		return false;
	}
}
