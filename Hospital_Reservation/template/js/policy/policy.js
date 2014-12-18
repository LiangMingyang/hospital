String.prototype.trim = function () {return this .replace(/^\s\s*/, '' ).replace(/\s\s*$/, '' );}
		function check_danger(str){
				var reg = /[|&;$%@,\'"<>()+]/;
				
				var res=reg.test(str);
			if(res){
					//artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					return true;
				}
			else if(str.length>64){
				return true;
			}
			else{
					return false;
			}
	
	}
$(function(){
	$("#ruleOpClass").change(function(){
		var selectValue = $(this).children('option:selected').text();
		if(selectValue=="执行SQL语句"){
			$("#sqlTypeRow").css("display","");
		} else {
			$("#sqlTypeRow").css("display","none");
		}
	});
	
		/*弹出对话框-审计策略查看页面中弹出添加审计策略白名单的对话框*/
		$( "#addPolicyIPRangeForm" ).dialog({
			autoOpen: false,
			resizable: true,
			height:400,
			width:600,
			modal: false,
			position:"center",
			title:"选择所要添加的IP范围",
			buttons: {
				"确定": function() {		
					var ipRangeCheck = $("input:[name=selectIPRange]:checkbox:checked");
					var count = ipRangeCheck.length;
					if(count > 0) {
						var chooseIdStr = "";
						for(var i = 0; i < count; i ++) {
							chooseIdStr += ipRangeCheck[i].value+"!";
						}
						var policyId = $("#policyIdHidden").val();
						window.location.href="policyDetails.php?cmd=addPolicyWhite&policyId="+policyId+"&ipRangeIds="+chooseIdStr;
						$( this ).dialog( "close" );
					} else {
//						alert("请选择您要添加的IP范围！");
						artDialog({content:'请选择您要添加的IP范围！', style:'alert'}, function(){});
					}
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		/*弹出对话框——添加审计策略白名单*/
		$( "#addPolicyWhiteForm" ).dialog({
			autoOpen: false,
			resizable: true,
			height:200,
			width:400,
			modal: false,
			position:"top",
			title:"添加审计策略白名单",
			buttons: {
				"确定": function() {			
					var policyId = $("#policySelector").val();
					var ipRangeId = $("#ipRangeSelector").val();
					/* added by gengjinkun*/
					if(check_danger(policyId)){
                       artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
					} 
					if(check_danger(ipRangeId)){
                       artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
					} 
	                ///////////////////////////
//					window.location.href="whiteList.php?cmd=addWhiteList&selPolicyId="+policyId+"&selIpRangeId="+ipRangeId;
					$.post(WEB_ROOT+'policy/whiteList.php?cmd=addWhiteList',{
						'selPolicyId':policyId,
						'selIpRangeId':ipRangeId
					},function(data){
						if(data == "Error"){
//							alert("服务器出错，添加失败，请重试！");
							artDialog({content:'服务器出错，添加失败，请重试！', style:'error'}, function(){
								$( this ).dialog( "close" );
								window.location.href="whiteList.php";
							});
							
						}else if(data == "OK"){
							artDialog({content:'保存成功！', style:'succeed'}, function(){
								$( this ).dialog( "close" );
								window.location.href="whiteList.php";
							});
							
						} else if(data == "Existed") {
//							alert("该白名单已存在，请勿重复添加！");
							artDialog({content:'该白名单已存在，请勿重复添加！', style:'error'}, function(){
								$( this ).dialog( "close" );
							});
							
						}
						
					});
					
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		/*弹出对话框——添加审计策略规则*/
		$( "#addPolicyRuleForm" ).dialog({
			autoOpen: false,
			resizable: true,
			height:350,
			width:500,
			modal: false,
			position:"center",
			title:"添加审计策略规则",
			buttons: {
				"确定": function() {			
					var ruleCheck = $("input:[name=selectRule]:checkbox:checked");
					var count = ruleCheck.length;
					if(count <= 0) {
//						alert("请选择您要添加的审计规则！");
						artDialog({content:'请选择您要添加的审计规则！', style:'alert'}, function(){});
					} else {
						var chooseIdStr = "";
						for(var i = 0; i < count; i ++) {
							chooseIdStr += ruleCheck[i].value+",";
						}
						var policyId = $("#policyIdHidden").val();
						window.location.href="policyDetails.php?cmd=addPolicyRule&policyId="+policyId+"&ruleIds="+chooseIdStr;
						$( this ).dialog( "close" );
					}
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});

		/*弹出对话框——选择IPRange对话框*/
		$( "#chooseIPRangeDiv" ).dialog({
			autoOpen: false,
			resizable: true,
			height:400,
			width:600,
			modal: false,
			position:"center",
			title:"选择IP范围",
			buttons: {
				"确定": function() {			
					var ipCheckList = $("input:[name=ipRangeCheck]:checkbox:checked");
					if(check_danger(ipCheckList)){
                     artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
					} 
					var count = ipCheckList.length;  
					if(count <= 0) {
//						alert("请选择IP范围！");
						artDialog({content:'请选择IP范围！', style:'alert'}, function(){});
					} else {
						var chooseIpStr="";
						var chooseTrustStr="";
						for(var i = 0; i < count; i ++) {
							chooseIpStr += ipCheckList[i].value+",";
							var trustRadio = document.getElementsByName("trustIP"+ipCheckList[i].value);
							for(var j = 0; j < trustRadio.length; j ++) {
								if(trustRadio[j].checked==true) {
									chooseTrustStr += trustRadio[j].value + ",";  
									break;
								}
							}
						}
						$("#chooseIpHidden").val(chooseIpStr);
						$("#chooseTrustHidden").val(chooseTrustStr);
						$( this ).dialog( "close" );
					}
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		/*弹出对话框——添加IPRange对话框*/
		$( "#addIPRangeDiv" ).dialog({
			autoOpen: false,
			resizable: true,
			height:300,
			width:450,
			modal: false,
			position:"center",
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
							var newTrust = $("input:[name=newTrustIPText]:radio:checked").val();  

							var oldName = $("#newRangeNameHidden").val();
							var oldStart = $("#newStartIPHidden").val();
							var oldEnd = $("#newEndIPHidden").val();
							var oldTrust = $("#newTrustIPHidden").val();
							
							$("#newRangeNameHidden").val(oldName+newName+",");
							$("#newStartIPHidden").val(oldStart+newStart+",");
							$("#newEndIPHidden").val(oldEnd+newEnd+",");
							$("#newTrustIPHidden").val(oldTrust+newTrust+",");
							
							//清空填写对话框里面的数据
							$ipNameObj.val("");
							$startIpObj.val("");
							$endIpObj.val("");
							
							$( this ).dialog( "close" );
							
							//添加到“查看添加IP对话框”中
							var newTrustStr = newTrust==0?'否':'是';
							var viewTbody = $("#viewAddIPRangeTbody");
							var tr="<tr><td>"+newName+"</td>"
									+"<td>"+newStart+"</td>"
									+"<td>"+newEnd+"</td>"
									+"<td>"+newTrustStr+"</td></tr>";
							viewTbody.append(tr);
							
						} else {
							$("#warningInfo").html("<font color='red'>输入的IP格式不正确！</font>");
						}
					} else {
						$("#warningInfo").html("<font color='red'>必填项不能为空！</font>");
					}
					
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		$("#viewAddIPRangeDiv").dialog({
			autoOpen: false,
			resizable: true,
			height:400,
			width:500,
			modal: false,
			position:"center",
			title:"查看添加的IP范围",
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
							var newTrust = $("input:[name=newTrustIPText]:radio:checked").val();  

							var oldName = $("#newRangeNameHidden").val();
							var oldStart = $("#newStartIPHidden").val();
							var oldEnd = $("#newEndIPHidden").val();
							var oldTrust = $("#newTrustIPHidden").val();
							
							$("#newRangeNameHidden").val(oldName+newName+",");
							$("#newStartIPHidden").val(oldStart+newStart+",");
							$("#newEndIPHidden").val(oldEnd+newEnd+",");
							$("#newTrustIPHidden").val(oldTrust+newTrust+",");
							
							$( this ).dialog( "close" );
						} else {
							$("#warningInfo").html("<font color='red'>输入的IP格式不正确！</font>");
						}
					} else {
						$("#warningInfo").html("<font color='red'>必填项不能为空！</font>");
					}
					
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		/*弹出对话框——查看当前规则当前的数据来源IP*/
		$( "#viewIPRangeDiv" ).dialog({
			autoOpen: false,
			resizable: true,
			height:300,
			width:500,
			modal: false,
			position:"center",
			title:"选择要删除的IP",
			buttons: {
				
				"删除": function() {	
					var deleteCheckedList = $("input:[name=ipRangeCheck]:checkbox:checked");
					var deleteCount = deleteCheckedList.length;  
					if(deleteCount <= 0) {
//						alert("请选择您要删除的IP！");
						artDialog({content:'请选择您要删除的IP！', style:'alert'}, function(){
						});
						
						
					} else {
						if(confirm("确定要删除您所选的IP吗？")){
							var delIdStr = "";
							for(var i = 0; i < deleteCount; i ++) {
								delIdStr += deleteCheckedList[i].value + ",";
							}
							
							window.location.href="ruleDetails.php?ruleId="+ $("#ruleIdHidden").val() +"&method=deleteIpRange&delIds="+delIdStr;
						}
						$( this ).dialog( "close" );
					}
				},
				
				"取消": function() {			
					$( this ).dialog( "close" );
				}
			}
		});
		
		
		/*弹出对话框——选择IPRange对话框：修改页面中*/
		$( "#updateChooseIPRange" ).dialog({
			autoOpen: false,
			resizable: true,
			height:400,
			width:600,
			modal: false,
			position:"center",
			title:"选择IP范围<font color='red'>(注：请在所选择的IP范围后面填写信任IP)</font>",
			buttons: {
				"确定": function() {			
					var ipCheck = document.getElementsByName("ipRangeCheck");
					var chooseIpStr="";
					var chooseTrustStr="";
					var count = ipCheck.length;
					for(var i = 0; i < count; i ++) {
						if(ipCheck[i].checked==true) {
							chooseIpStr += ipCheck[i].value+",";
//							chooseTrustStr += $("#trustIP"+ipCheck[i].value).val()+",";
							var trustRadio = document.getElementsByName("trustIP"+ipCheck[i].value);
							for(var j = 0; j < trustRadio.length; j ++) {
								if(trustRadio[j].checked==true) {
									chooseTrustStr += trustRadio[j].value + ",";  
									break;
								}
							}
						}
					}
//					$("#chooseIpHidden").val(chooseIpStr);
//					$("#chooseTrustHidden").val(chooseTrustStr);
					window.location.href="ruleDetails.php?ruleId="+ $("#ruleIdHidden").val() +"&method=addIpRange&addIds="+chooseIpStr+"&trust="+chooseTrustStr;
					
					$( this ).dialog( "close" );
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		/*弹出对话框——添加IPRange对话框：修改页面中*/
		$( "#updateAddIPRange" ).dialog({
			autoOpen: false,
			resizable: true,
			height:300,
			width:400,
			modal: false,
			position:"center",
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
							var newTrust = $("input:[name=newTrustIPText]:radio:checked").val();  

							window.location.href="ruleDetails.php?ruleId="+ $("#ruleIdHidden").val() +"&method=addNewIpRange&newName="+newName+"&newStart="+newStart+"&newEnd="+newEnd+"&trust="+newTrust;
							$( this ).dialog( "close" );
						} else {
							$("#warningInfo").html("<font color='red'>输入的IP格式不正确！</font>");
						}
					} else {
						$("#warningInfo").html("<font color='red'>必填项不能为空！</font>");
					}
					
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		
		/*添加新审计策略对话框*/
		$( "#addPolicyDiv" ).dialog({
			autoOpen: false,
			resizable: true,
			height:250,
			width:400,
			modal: false, 
			position:"top",
			title:"添加新的审计策略",
			buttons: {
				"确定": function() {			
					$policyNameObj = $("#newPolicyName");
                    if(check_danger($policyNameObj.val())){
                     artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
					} 
//					$serviceId = $("#serviceSelect").val();
//					if($serviceId==0){
//						alert("请选择数据库！");
//					} else {
						if(checkNonEmpty($policyNameObj)) {
							var policyName = $policyNameObj.val();
							if(policyName.length>20){
								$("#warningInfo").html("<font color='red'>审计策略名称不能超过20个字符！</font>");
							} else {
								var newStatus = $("input:[name=newPolicyStatus]:radio:checked").val();  
//								window.location.href="policyDetails.php?cmd=addNewPolicy&newName="+$policyNameObj.val()+"&newStatus="+newStatus;
								$.post(WEB_ROOT+'policy/policyDetails.php?cmd=addNewPolicy',{
									'newName':policyName,
//									'serviceId':$serviceId,
									'newStatus':newStatus
								},function(data){
									if(data == "Error"){
//										alert("服务器出错，添加失败，请重试！");
										artDialog({content:'服务器出错，添加失败，请重试！', style:'error'}, function(){
											window.location.href="policyMgr.php";
										});
										
									} else if(data == "NameError") {
//										alert("该策略名称已存在！");
										artDialog({content:'该策略名称已存在！', style:'error'}, function(){
											$policyNameObj.val("");
										});
										
									}
									/*Add By Yip Date:2014.8.5*/
									else if(data == "NameIllegal") {
										artDialog({content:'该策略名称含有非法字符，请重试！', style:'error'}, function(){
											$policyNameObj.val("");
										});
										
									}/*************************/
									 else {
										$( this ).dialog( "close" );
//										alert("添加成功！");
										artDialog({content:'保存成功！', style:'succeed'}, function(){
											window.location.href="policyDetails.php?policyId="+data;
										});
										
									}
								});
							}
							
							
						} else {
							$("#warningInfo").html("<font color='red'>必填项不能为空！</font>");
						}
//					}
					
					
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		/*弹出对话框:添加新对象组*/
		$( "#addObjectGroupForm" ).dialog({
			autoOpen: false,
			resizable: true,
			height:200,
			width:400,
			modal: false,
			position:"top",
			title:"添加新对象组",
			buttons: {
				"确定": function() {		
					newGroupNameObj = $("#newGroupName");
					serviceSelector = $("#serviceSelector");
					
					if(check_danger(newGroupNameObj.val())){
                     artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
					} 
					if(check_danger(serviceSelector.val())){
                     artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
					} 
					if(checkNonEmpty(newGroupNameObj)) {
						var newGroupName = newGroupNameObj.val();
						if(newGroupName.length<=20) {
//							window.location.href="objectGroupList.php?cmd=addNewGroup&groupName="+newGroupName+"&serviceId="+serviceSelector.val();
							$.ajax({
								url:"objectGroupList.php?cmd=addNewGroup",
								type:"POST",
								dataType:"text",
								data:{
									groupName:newGroupName,
									serviceId:serviceSelector.val()
								},
								success:function(data){
									if(data=="OK"){
										artDialog({content:'添加成功！', style:'succeed'}, function(){
											$( this ).dialog( "close" );
											window.location.href="objectGroupList.php";
										});
									} else if(data == "NAME_ERROR") {
										$("#groupInfo").html("<font color='red'>同一数据库的该对象组名称已存在！</font>");
									} else {
										artDialog({content:'服务器错误，添加失败，请稍后重试！', style:'error'}, function(){
										});
									}
								}
							});
							
						} else {
							$("#groupInfo").html("<font color='red'>对象组名称不能超过20个字符！</font>");
						}
					} else {
						$("#groupInfo").html("<font color='red'>对象组名称不能为空！</font>");
					}
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		/*弹出对话框:添加对象*/
		$( "#addObjectForm" ).dialog({
			autoOpen: false,
			resizable: true,
			height:300,
			width:400,
			modal: false,
			position:"center",
			title:"选择新的数据库对象",
			buttons: {
				"确定": function() {		
					newObjNameObj = $("#newObjectName");
					objType = $("#objectTypeSelector");
					objGroup = $("#objectGroupSelector");
                    if(check_danger(newObjNameObj.val())||check_danger(objType.val())||check_danger(objGroup.val())){
                     artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
					} 
					
					if(checkNonEmpty(newObjNameObj)&&checkNonEmpty(objGroup)) {
						var newObjName = newObjNameObj.val();
						if(newObjName.length > 20) {
							$("#objectInfo").html("<font color='red'>对象名称不能超过20个字符！</font>");
						} else {
							$.post(WEB_ROOT+'policy/objectGroupList.php?cmd=addNewObject',{
								'objectName':newObjName,
								'objType':objType.val(),
								'objGroup':objGroup.val()
							},function(data){
								if(data == "ERROR"){
//									alert("服务器错误，保存失败，请稍后重试！");
									artDialog({content:'服务器错误，保存失败，请稍后重试！', style:'error'}, function(){
									});
								}else if(data == "OK"){
//									alert("保存成功！");
									artDialog({content:'保存成功！', style:'succeed'}, function(){
										$( this ).dialog( "close" );
										window.location.href="objectGroupList.php?tab=object";
									});
									
								} else if(data == "NameError") {
//									alert("不能添加重复的对象！");
									artDialog({content:'不能添加重复的对象！', style:'error'}, function(){
										newObjNameObj.val("");
									});
									
								}
								
							});
						}
//						window.location.href="objectGroupList.php?cmd=addNewObject&objectName="+newObjName+"&objType="+objType.val()+"&objGroup="+objGroup.val();
						
					} else if(!checkNonEmpty(newObjNameObj)){
						$("#objectInfo").html("<font color='red'>对象名称不能为空！</font>");
					} else if(!checkNonEmpty(objGroup)) {
						$("#objectInfo").html("<font color='red'>请先添加对象组！</font>");
					}
				},
				取消: function() {
					$( this ).dialog( "close" );
				}
				
			}
		});
		
		/*弹出对话框:添加对象*/
		$( "#addObjectToGroupForm" ).dialog({
			autoOpen: false,
			resizable: true,
			height:300,
			width:400,
			modal: false,
			position:"center",
			title:"选择新的数据库对象",
			buttons: {
				"确定": function() {		
					newObjNameObj = $("#newObjectName");
					objType = $("#objectTypeSelector");
					objGroup = $("#groupIdHidden");
					if(check_danger(newObjNameObj.val())||check_danger(objType.val())||check_danger(objGroup.val())){
                     artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
					} 
					if(checkNonEmpty(newObjNameObj)) {
						var newObjName = newObjNameObj.val();
						window.location.href="groupDetails.php?cmd=addNewObject&objectName="+newObjName+"&objType="+objType.val()+"&groupId="+objGroup.val();
						$( this ).dialog( "close" );
					} else {
						$("#objectInfo").html("<font color='red'>对象名称不能为空！</font>");
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

//打开添加新对象组对话框
function addObjectToGroup() {
	$( "#addObjectToGroupForm" ).dialog( "open" );	
}

//打开添加新对象组对话框
function addObject() {
	$( "#addObjectForm" ).dialog( "open" );	
}

//打开添加新策略的对话框
function showAddPolicy() {
	$("#addPolicyDiv").dialog("open");	
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



//添加白名单
function addWhiteList(){
//	alert("添加新的白名单！");
	$( "#addForm" ).dialog( "open" );	
}

function viewIPRange() {
	$( "#viewIPRangeDiv" ).dialog( "open" );	
}

function addPolicyIPRange() {
	$("#addPolicyIPRangeForm").dialog("open");
}

//往某个审计策略里添加白名单：白名单列表页面
function addPolicyWhite() {
	$("#addPolicyWhiteForm").dialog("open");
}

//往某个审计策略里添加规则：查看审计策略详细信息页面
function addPolicyRule() {
	$("#addPolicyRuleForm").dialog("open");
}

//打开选择IPRange的对话框
function chooseIPRange() {
	$("#chooseIPRangeDiv").dialog("open");
}

function addIPRange() {
	$("#addIPRangeDiv").dialog("open");
}

function viewAddIPRange() {
	$("#viewAddIPRangeDiv").dialog("open");
}

function updateChooseIPRange() {
	$("#updateChooseIPRange").dialog("open");
}
function updateAddIPRange() {
	$("#updateAddIPRange").dialog("open");
}

//取消启用策略
function cancelUsePolicy(policyId) {
//	if(confirm("确定要取消启用该条审计策略吗？")) {
//		window.location.href="policy.php?target=policy&cmd=cancel&id="+policyId;
//	}
	artDialog({content:'确定要取消启用该条审计策略吗？', style:'confirm'}, function(){
		window.location.href="policy.php?target=policy&cmd=cancel&id="+policyId;
	},function(){
		
	});
}

//启用策略
function usePolicy(policyId) {
//	if(confirm("确定要启用该条审计策略吗？")) {
//		window.location.href="policy.php?target=policy&cmd=use&id="+policyId;
//	}
	artDialog({content:'确定要启用该条审计策略吗？', style:'confirm'}, function(){
		window.location.href="policy.php?target=policy&cmd=use&id="+policyId;
	},function(){
		
	});
}

//启用规则
function useRule(ruleId) {
//	if(confirm("确定要启用该条审计规则吗？")) {
//		window.location.href="policy.php?target=rule&cmd=use&id="+ruleId;
//	}
	artDialog({content:'确定要启用该条审计规则吗？', style:'confirm'}, function(){
		window.location.href="policy.php?target=rule&cmd=use&id="+ruleId;
	},function(){
		
	});
}

//禁用规则
function cancelRule(ruleId) {
//	if(confirm("确定要禁用该条审计规则吗？")) {
//		window.location.href="policy.php?target=rule&cmd=cancel&id="+ruleId;
//	}
	artDialog({content:'确定要禁用该条审计规则吗？', style:'confirm'}, function(){
		window.location.href="policy.php?target=rule&cmd=cancel&id="+ruleId;
	},function(){
		
	});
}

//删除某条白名单
function deletePolicyWhite(policyWhiteId) {
//	if(confirm("确定要删除该条审计策略白名单吗？")) {
//		window.location.href="policy.php?target=white&cmd=delete&id="+policyWhiteId;
//	}
	artDialog({content:'确定要删除该条审计策略白名单吗？', style:'confirm'}, function(){
		window.location.href="policy.php?target=white&cmd=delete&id="+policyWhiteId;
	},function(){
		
	});
}

//删除某条自定义规则
function deleteRule(ruleId){
//	if(confirm("确定要删除该条自定义规则吗？")) {
//		window.location.href="policy.php?target=rule&cmd=delete&id="+ruleId;
//	}
	artDialog({content:'确定要删除该条自定义规则吗？', style:'confirm'}, function(){
		window.location.href="policy.php?target=rule&cmd=delete&id="+ruleId;
	},function(){
		
	});
}

//删除某条审计策略的审计规则
function deletePolicyRule($policyRuleId) {
	var policyId = $("#policyIdHidden").val();
//	if(confirm("确定要删除该条规则吗？")) {
//		window.location.href="policyDetails.php?policyId="+policyId+"&cmd=delPolicyRule&policyRuleId="+$policyRuleId;
//	}
	artDialog({content:'确定要删除该条规则吗？', style:'confirm'}, function(){
		window.location.href="policyDetails.php?policyId="+policyId+"&cmd=delPolicyRule&policyRuleId="+$policyRuleId;
	},function(){
		
	});
}

//在查看审计策略详细信息页面，删除当前审计策略的白名单
function deletePolicyWhiteList($policyWhiteId) {
	var policyId = $("#policyIdHidden").val();
//	if(confirm("确定要删除该条审计策略白名单吗？")) {
//		window.location.href="policyDetails.php?policyId="+policyId+"&cmd=delPolicyWhite&policyWhiteId="+$policyWhiteId;
//	}
	
	artDialog({content:'确定要删除该条审计策略白名单吗？', style:'confirm'}, function(){
		window.location.href="policyDetails.php?policyId="+policyId+"&cmd=delPolicyWhite&policyWhiteId="+$policyWhiteId;
	},function(){
		
	});
}

//删除策略
function deletePolicy(policyId) {
//	if(confirm("确定要删除该条审计策略吗？")) {
//		window.location.href="policy.php?target=policy&cmd=delete&id="+policyId;
//	}
	artDialog({content:'确定要删除该条审计策略吗？', style:'confirm'}, function(){
		window.location.href="policy.php?target=policy&cmd=delete&id="+policyId;
	},function(){
		
	});
}

//对象组管理页面中：删除对象
function deleteObject(objectId) {
//	if(confirm("确定要删除该数据库对象吗？")) {
//		window.location.href="objectGroupList.php?cmd=deleteObject&objId="+objectId;
//	}
	artDialog({content:'确定要删除该数据库对象吗？', style:'confirm'}, function(){
		window.location.href="objectGroupList.php?cmd=deleteObject&objId="+objectId;
	},function(){
		
	});
}

function deleteObjectFromGroup(objectId) {
//	if(confirm("确定要删除该数据库对象吗？")) {
//		var objGroup = $("#groupIdHidden").val();
//		window.location.href="groupDetails.php?cmd=deleteObject&objId="+objectId+"&groupId="+objGroup;
//	}
	artDialog({content:'确定要删除该数据库对象吗？', style:'confirm'}, function(){
		var objGroup = $("#groupIdHidden").val();
		window.location.href="groupDetails.php?cmd=deleteObject&objId="+objectId+"&groupId="+objGroup;
	},function(){
		
	});
}

//对象组管理页面中：查看对象组
function viewObjectGroup(groupId) {
	window.location.href="groupDetails.php?groupId="+groupId;
}

//对象组管理页面中：删除对象组
function deleteObjectGroup(groupId) {
//	if(confirm("确定要删除该对象组吗？")) {
//		window.location.href="objectGroupList.php?cmd=deleteGroup&groupId="+groupId;
//	}
	artDialog({content:'确定要删除该对象组吗？', style:'confirm'}, function(){
		window.location.href="objectGroupList.php?cmd=deleteGroup&groupId="+groupId;
	},function(){
		
	});
}

function checkAddRule() {
	if(checkNonEmpty($("#ruleNameText"))) {
		return true;
	} else {
		$("#ruleNameInfo").val("<font color='red'>规则名不能为空！</font>");
		return false;
	}
}

//启用内置规则
function useInRule(inruleId,serviceId) {	
	artDialog({content:'确定要启用该条内置审计规则吗？', style:'confirm'}, function(){
		window.location.href="inruleList.php?cmd=use&inruleId="+inruleId+"&serviceId="+serviceId;
	},function(){
		
	});
}

//禁用内置规则
function cancelInRule(inruleId,serviceId) {
	artDialog({content:'确定要禁用该条内置审计规则吗？', style:'confirm'}, function(){
		window.location.href="inruleList.php?cmd=cancel&inruleId="+inruleId+"&serviceId="+serviceId;
	},function(){
		
	});
}

//删除某条自定义规则
function deleteInRule(inruleId,serviceId){
	artDialog({content:'确定要删除该条内置规则吗？', style:'confirm'}, function(){
		window.location.href="inruleList.php?cmd=delete&inruleId="+inruleId+"&serviceId="+serviceId;
	},function(){
		
	});
}

function deleteInPolicyRule(inruleId,serviceId){
	artDialog({content:'确定要删除该条内置规则吗？', style:'confirm'}, function(){
		window.location.href="inruleList.php?cmd=deleteInPolicyRule&inruleId="+inruleId+"&serviceId="+serviceId;
	},function(){
		
	});
}