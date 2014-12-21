/**
 *入侵检测页面相关函数 
 */
$(function(){
	$('.loudong h4').css({cursor:"pointer"});
//左侧莱单显示隐藏切换
	$('.loudong h4').click(function(){
		var i =$('.loudong h4').index(this);
		if($('.loudong .p20').eq(i).css('display')=='none')
			{
				$('.loudong h4 em').eq(i).html('-');
				$('.loudong .p20').eq(i).show();
			}
		else{
			$('.loudong h4 em').eq(i).html('+');
			$('.loudong .p20').eq(i).hide();
			}
	});
	
	/*弹出对话框——显示用户权限模式详细信息*/
	$( "#privilegeDetails" ).dialog({
		autoOpen: false,
		resizable: true,
		height:400,
		width:500,
		modal: false,
		position:"top",
		title:"用户权限模式详细信息",
		buttons: {
			"确定": function() {			
				$( this ).dialog( "close" );
			}
		}
	});
});
var rules = {};
rules['builtin']={};
rules['mining']={};
rules['rights']={};
function check(module,idx){
		var ruleId = $('#'+module+'RuleId'+idx).val();
		var subRuleId = $('#'+module+'SubRuleId'+idx).val();
		var dbName = $('#'+module+'DbName'+idx).val();
		var riskLevel = $('#'+module+'RiskLevel'+idx).val();
		var activeTime = $('#'+module+'ActiveTime'+idx).val();
		var actionId = $('#'+module+'ActionId'+idx).val();
		var rule = {};
		rule['ruleId'] = ruleId;
		rule['subRuleId'] = subRuleId;
		rule['dbName'] = dbName;
		rule['riskLevel'] = riskLevel;
		rule['activeTimeID'] = activeTime;
		rule['actionId'] = actionId;
		//rule['ServiceId'] = serviceId;
		var i = 0;
		for( var oldR in rules[module]){
			if(rules[module][oldR]['ruleId']==ruleId){
			//	alert(module+'\n');
			//	alert(ruleId+'\n');
				break;
			}
			i++;
		}
	if(document.getElementsByName(module+'Rule')[idx].checked){
		//alert(i+'\n');
		rules[module][i]=rule;
		rules[module][i]['RuleStatus']=1;
		//alert(rules[module][i]['RuleStatus']+'\n');
	}else{
		//alert(i+'\n');
		rules[module][i]=rule;
		rules[module][i]['RuleStatus']=0;
		//alert(rules[module][i]['RuleStatus']+'\n');
		//rules[module][i]=undefined;
	}
}
function save(){
	$.post(WEB_ROOT+"ids/idsRules.php",{
		cmd:'save',
		rules:$.toJSON(rules)
	},function(data){
		artDialog({content:'保存成功！', style:'succeed'}, function(){});
	});
}
var serviceId;
function builtinPage(pageNo){
//	goToPage(pageNo,'builtin',RULE_TYPE_BUILTIN);
	
	if(pageNo == -1){
		pageNo = $('#builtinPageNum').val();
	}
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#builtinPageCount").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 $.get(WEB_ROOT+"ids/idsRules.php",{
				service:serviceId,
				RuleType:RULE_TYPE_BUILTIN,
				cmd:'page',
				pageNo:pageNo,
				page:'builtinPage'	
			},function(data){
				$('#builtindiv').html(data);
			});
	 }
	
}
function miningPage(pageNo){
//	goToPage(pageNo,'mining',RULE_TYPE_MINING);
	
	if(pageNo == -1){
		pageNo = $('#miningPageNum').val();
	}
	var re = /^[1-9]\d*$/;
	 pageCount = $("#miningPageCount").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 $.get(WEB_ROOT+"ids/idsRules.php",{
				service:serviceId,
				RuleType:RULE_TYPE_MINING,
				cmd:'page',
				pageNo:pageNo,
				page:'miningPage'	
			},function(data){
				$('#miningdiv').html(data);
			});
	 }
	
}
function rightsPage(pageNo){
//	goToPage(pageNo,'rights',RULE_TYPE_RIGHT);
	
	if(pageNo == -1){
		pageNo = $('#rightsPageNum').val();
	}
	var re = /^[1-9]\d*$/;
	 pageCount = $("#rightsPageCount").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 $.get(WEB_ROOT+"ids/idsRules.php",{
				service:serviceId,
				RuleType:RULE_TYPE_RIGHT,
				cmd:'page',
				pageNo:pageNo,
				page:'rightsPage'	
			},function(data){
				$('#rightsdiv').html(data);
			});
	 }
	
}
function goToPage(pageNo,type,typeId){
	if(pageNo == -1){
		pageNo = $('#'+type+'PageNum').val();
	}
	$.get(WEB_ROOT+"ids/idsRules.php",{
		service:serviceId,
		RuleType:typeId,
		cmd:'page',
		pageNo:pageNo,
		page:type+'Page'	
	},function(data){
		$('#'+type+' div').html(data);
	});
}
$(function(){
	$('#ruleDetail').dialog({
		autoOpen: false,
		resizable: true,
		height:'auto',
		width:'800',
		modal: true,
		position:"center",
		title:"入侵检测规则详情",
		buttons: {
			"通过": function() {		
				var ruleId = $("#ruleIdHidden").val();
				review(ruleId,1);
				$( this ).dialog( "close" );
			},
			"不通过": function() {
				var ruleId = $("#ruleIdHidden").val();
				review(ruleId,0);
				$( this ).dialog( "close" );
			},
			"取消": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	$('#ruleDetail2').dialog({
		autoOpen: false,
		resizable: true,
		height:'auto',
		width:'800',
		modal: true,
		position:"center",
		title:"入侵检测规则详情",
		buttons: {
			"确定": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	});
function showRule(ruleId,ruleType){
	$.get(WEB_ROOT+"ids/idsRuleInfo.php",{
		ruleId:ruleId,
		ruleType:ruleType
		},function(data){
			$('#ruleDetail').html(data);
			$('#ruleDetail').dialog("open");
			});
	}
function showRule2(ruleId,ruleType){
	$.get(WEB_ROOT+"ids/idsRuleInfo.php",{
		ruleId:ruleId,
		ruleType:ruleType
		},function(data){
			$('#ruleDetail2').html(data);
			$('#ruleDetail2').dialog("open");
			});
	}

function showPrivChange(ruleId,ruleType){
	$.ajax({
		url:"idsRuleInfo.php",
		type:"POST",
		dataType:"JSON",
		data:{
			ruleId:ruleId,
			ruleType:ruleType
		},
		success:function(data){
			$("#targetRuleId").html(data.targetRuleId);
			$("#privilegeUsers").val(data.userList);
			var dataList = data.privList;
			count = dataList.length;
			var tr = "";
			for(var i = 0; i < count; i ++) {
				tr += "<tr><td>"+dataList[i].table+"</td>"
				   +"<td>"+dataList[i].sqltype+"</td></tr>";
			}
			var viewTbody = $("#privilegeTbody");
			viewTbody.empty();
			viewTbody.append(tr);
		}
	});
	$('#privilegeDetails').dialog("open");

}

//删除权限挖掘计划
function deleteRecord(RecordId){
	artDialog({content:'确定要删除这条权限挖掘计划吗？', style:'confirm'}, function(){
		window.location.href="PrivilegeAnalyzeInfo.php?cmd=delete&id="+RecordId;
	},function(){		
	});
}

function deleteAnalyse(AnalysisId){
	artDialog({content:'确定要删除这条行为模式挖掘计划吗？', style:'confirm'}, function(){
		window.location.href="analyseInfo.php?cmd=delete&id="+AnalysisId;
	},function(){		
	});
}