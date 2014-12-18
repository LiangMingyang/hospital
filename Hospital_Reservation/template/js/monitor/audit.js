/*以下是查看全部审计事件显示的表格，如果要只显示审计结果，请查看audit_dball.js文件*/
$(function(){		
	var widthTmp = document.body.clientWidth;
//	alert("kuandu: " + widthTmp);
//	alert("quanwenkuan:" + document.body.scrollWidth);
//	alert("fenbianlv:"+ window.screen.width );
	
	/*flexigrid表格设置*/
	$("#auditGrid").flexigrid({ 
        url : 'post_json_dball.php', 
        dataType : 'json', 
        contentType: "application/json; charset=utf-8",
        colModel : [
                     { display : '操作ID', name : 'OpID', width : 80, sortable : true, align : 'left' },
                     { display : '会话ID', name : 'SessionID', width : 80, sortable : true, align : 'left' }, 
                     { display : '操作类型', name : 'OpClass', width : 120, sortable : true, align : 'left' },
                     { display : '服务名', name : 'ServiceName', width : 120, sortable : true, align : 'left' }, 
                     { display : '登录名', name : 'LoginName', width : 120, sortable : true, align : 'left' },
                     { display : '用户名', name : 'UserName', width : 100, sortable : true, align : 'left' },
                     { display : '用户IP', name : 'UserIP', width : 100, sortable : true, align : 'left' },
                     { display : 'Sql语句', name : 'SqlString', width : 150, sortable : true, align : 'left' },
                     { display : '执行时间', name : 'ExecTime', width : 120, sortable : true, align : 'left' },
                     { display : '执行结果', name : 'ExecResult', width : 80, sortable : true, align : 'left' },
                     { display : '风险级别', name : 'RiskLevel', width : 100, sortable : true, align : 'left' },
                     { display : '协议名称', name : 'Protocol', width : 80, sortable : true, align : 'left' },
                     { display : '源IP', name : 'SrcIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '源端口', name : 'SrcPort', width : 80, sortable : true, align : 'left'}, 
                     { display : '目的IP', name : 'DstIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '目的端口', name : 'DstPort', width : 80, sortable : true, align : 'left' }
                    ],
        buttons : [
//               			{name: '添加', bclass: 'add', onpress : function(){}},
               			{name: '删除', bclass: 'delete', onpress : deleteDBOperation},
//               			{name: '全部删除', bclass: 'deleteAll', onpress : deleteAllDBOperation},
               			{name: '查看', bclass: 'edit', onpress : viewDBOperation}	
//               			{name: '权限', bclass: 'privilege', onpress : function(){}}
               		],

        sortname : "SessionID", 
        sortorder : "asc", 
        usepager : true, 
//        title : '审计事件列表管理', 
        useRp : true, 
//        page:parseInt($('#currentPageHidden').val()),
        page: 1,
        rp : 10, 
        showTableToggleBtn : true, 
        width:document.body.scrollWidth-60, 
        height:350,
        checkbox:true,
        getQuery:getQuery
	});
	
	/*flexigrid表格设置*/
	/*审计结果显示*/
	/*
	 * $row['RecordID'],
									$row['OpID'],
									$row['SessionID'],
									$row['RuleID'],
									$row['RuleName'],
                  					$row['OpClass'],
                  					$row['ServiceName'], 
                  					$row['LoginName'],
                  					$row['SqlString'],
                  					$row['ExecTime'],
                  					$row['ExecResult'],
                  					$row['RiskLevel'],
                  					$row['Protocol'],
									$row['SrcIP'],
									$row['SrcPort'], 
                  					$row['DstIP'], 
                  					$row['DstPort']
	 * */
	$("#auditResultGrid").flexigrid({ 
        url : 'post_json_result.php', 
        dataType : 'json', 
        contentType: "application/json; charset=utf-8",
        colModel : [
//                     { display : '记录ID', name : 'RecordID', width : 80, sortable : true, align : 'left',hide:true },
                     { display : '操作ID', name : 'OpID', width : 80, sortable : true, align : 'left' },
                     { display : '会话ID', name : 'SessionID', width : 80, sortable : true, align : 'left' }, 
                     { display : '规则ID', name : 'RuleID', width : 80, sortable : true, align : 'left' },
                     { display : '规则名称', name : 'RuleName', width : 80, sortable : true, align : 'left' }, 
                     { display : '操作类型', name : 'OpClass', width : 120, sortable : true, align : 'left' },
                     { display : '服务名', name : 'ServiceName', width : 120, sortable : true, align : 'left' }, 
                     { display : '登录名', name : 'LoginName', width : 120, sortable : true, align : 'left' },
                     { display : '用户名', name : 'UserName', width : 100, sortable : true, align : 'left' },
                     { display : '用户IP', name : 'UserIP', width : 100, sortable : true, align : 'left' },
                     { display : 'Sql语句', name : 'SqlString', width : 150, sortable : true, align : 'left' },
                     { display : '执行时间', name : 'ExecTime', width : 120, sortable : true, align : 'left' },
                     { display : '执行结果', name : 'ExecResult', width : 80, sortable : true, align : 'left' },
//                     { display : '响应时间', name : 'ResponseTime', width : 80, sortable : true, align : 'left' },
                     { display : '风险级别', name : 'RiskLevel', width : 100, sortable : true, align : 'left' },
                     { display : '协议名称', name : 'Protocol', width : 80, sortable : true, align : 'left' },
                     { display : '源IP', name : 'SrcIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '源端口', name : 'SrcPort', width : 80, sortable : true, align : 'left'}, 
                     { display : '目的IP', name : 'DstIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '目的端口', name : 'DstPort', width : 80, sortable : true, align : 'left' }
//                     { display : '开始时间', name : 'StartTime', width : 120, sortable : true, align : 'left' },
//                     { display : '结束时间', name : 'EndTime', width : 120, sortable : true, align : 'left' },
//                     { display : '源MAC地址', name : 'SrcName', width : 120, sortable : true, align : 'left' },
//                     { display : '源主机名', name : 'SrcHostName', width : 120, sortable : true, align : 'left' }
                    ],
        buttons : [
//               			{name: '添加', bclass: 'add', onpress : function(){}},
               			{name: '删除', bclass: 'delete', onpress : deleteDBOperationResult},
               			{name: '查看', bclass: 'edit', onpress : viewDBOperationResult}	
//               			{name: '权限', bclass: 'privilege', onpress : function(){}}
               		],
//        searchitems : [ { display : '服务名', name : 'ServiceName' }, 
//                        { display : '会话ID', name : 'SessionID', isdefault : true } 
//        			  ], 
        sortname : "SessionID", 
        sortorder : "asc", 
        usepager : true, 
//        title : '审计事件列表管理', 
        page:parseInt($('#currentPageHidden').val()),
        useRp : true, 
        rp : 10, 
        showTableToggleBtn : true, 
        width:document.body.scrollWidth-60, 
        height:350,
        checkbox:true,
        getQuery:getQuery
	});
	
	/*弹出对话框-删除*/
	$( "#deleteConfirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:140,
		modal: false,
		buttons: {
			"删除": function() {			
				var targetOpIds ="";
				var targetTimes ="";
				var count = $('.trSelected').length;
				for(var i = 0;i < count;i ++){
					targetOpIds +='!';
					targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
				}
				
				var item=$('.trSelected');
				item.each(function() {
					targetTimes +='!';
					targetTimes += $(this).children().eq(9).text();
                });
				
				$.ajax({
			        url : 'AuditOperationService.php?cmd=deleteOperations&targetOpIds='+targetOpIds+'&targetTimes='+targetTimes,
			        type : 'POST',
			        dataType : 'JSON',
			        contentType: "application/json; charset=utf-8",
			        success : function(data) {
//			        	alert("aaaaa");
//    		        	alert(data);
			        	data = eval("(" + data + ")");
				
			        	if(data.msg =='SUCCESS') {
//			        		alert("删除成功！");
			        		artDialog({content:'删除成功！', style:'succeed'}, function(){
			        			$('#auditGrid').flexReload();//表格重载
			        		});
			        	} else {
//			        		alert("服务器出错，删除失败！请重试！");
			        		artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
			        			$('#auditGrid').flexReload();//表格重载
			        		});
			        	}
				        
			        },
					error:function(data){
						alert(data);
					}
	       		});
				$( this ).dialog( "close" );
				
			},
			"取消": function() {
				$( this ).dialog( "close" );
			}
			
		}
	});
	
	/*弹出对话框-删除全部*/
	$( "#deleteAllConfirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:140,
		modal: false,
		buttons: {
			"删除": function() {			
				var  targetOpIds ="";
				var targetTimes ="";
				var count = $('.trSelected').length;
				for(var i = 0;i < count;i ++){
					targetOpIds +='!';
					targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
				}
				
				var item=$('.trSelected');
				item.each(function() {
					targetTimes +='!';
					targetTimes += $(this).children().eq(9).text();
                });
				$.ajax({
			        url : 'AuditOperationService.php?cmd=deleteOperations&targetOpIds='+targetOpIds+'&targetTimes='+targetTimes,
			        type : 'POST',
			        dataType : 'JSON',
			        contentType: "application/json; charset=utf-8",
			        success : function(data) {
//			        	alert("bbb");
			        	data = eval("(" + data + ")");
			        	if(data.msg=='SUCCESS') {
//			        		alert("删除成功2！");
			        		artDialog({content:'删除成功！', style:'succeed'}, function(){
			        			$('#auditGrid').flexReload();//表格重载
			        		});
			        	} else {
//			        		alert("服务器出错，删除失败！请重试！");
			        		artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
			        			$('#auditGrid').flexReload();//表格重载
			        		});
			        	}
				       
			        }
	       		});
				$( this ).dialog( "close" );
				
			},
			"取消": function() {
				$( this ).dialog( "close" );
			}
			
		}
	});
	
	/*弹出对话框-删除*/
	$( "#deleteResultConfirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:140,
		modal: false,
		buttons: {
			"删除": function() {			
				var  targetOpIds ="";
				var targetTimes ="";
				var count = $('.trSelected').length;
				for(var i = 0;i < count;i ++){
					targetOpIds +='!';
					targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
				}
				
				var item=$('.trSelected');
				item.each(function() {
					targetTimes +='!';
					targetTimes += $(this).children().eq(11).text();
                });
				$.ajax({
			        url : 'AuditOperationService.php?cmd=deleteOperations&targetOpIds='+targetOpIds+'&targetTimes='+targetTimes,
			        type : 'POST',
			        dataType : 'JSON',
			        contentType: "application/json; charset=utf-8",
			        success : function(data) {
//			        	alert("ccc");
			        	data = eval("(" + data + ")");
			        	if(data.msg=='SUCCESS') {
//			        		alert("删除成功！");
			        		artDialog({content:'删除成功！', style:'succeed'}, function(){
			        			 $('#auditResultGrid').flexReload();//表格重载
			        		});
			        	}
				       
			        }
	       		});
				$( this ).dialog( "close" );
				
			},
			"取消": function() {
				$( this ).dialog( "close" );
			}
			
		}
	});
	
	var sessionDivWidth = 630;
	if(document.body.scrollWidth<700){
		sessionDivWidth=500;
	}
	
	/*弹出对话框-会话回放*/
	$( "#sessionBackDiv" ).dialog({
		autoOpen: false,
		resizable: true,
		title:"会话回放",
		height:460,
		width:sessionDivWidth,
		modal: false,
		buttons: {
			"确定": function() {			
				$( this ).dialog( "close" );
//				$("#sessionBackTbody").empty();
			}
		}
	});
	
	/*flexigrid表格设置*/
	$("#sessionBackTable").flexigrid({ 
        url : 'auditDetails_dbAll.php?cmd=sessionBack&targetSessionID='+$("#sessionIDHidden").val()+'&targetTime='+$("#execTimeHidden").val(), 
        dataType : 'json',
        contentType: "application/json; charset=utf-8",
        colModel : [
                     { display : '执行时间', name : 'ExecTime', width : 120, sortable : true, align : 'left' },
                     { display : 'SQL语句', name : 'SqlString', width : 300, sortable : true, align : 'left' }
                    ],
        usepager : true,  
        useRp : false, 
        rp : 15, 
        showTableToggleBtn : true, 
        width:sessionDivWidth-30, 
        height:300,
        checkbox:false
	});
});

/*定义查询函数*/
function getQuery() {
	return getJSONStr('searchForm');
}

function getJSONStr(formId) {
	var a = [];
	// 文本框
	$("#" + formId + " input[type=text]").each(function(i) {
		a.push({
			name : this.name,
			value : this.value
		});
	});
	$("#" + formId + " select").each(function(i) {
		a.push({
			name : this.name,
			value : this.value
		});
	});
	$("#" + formId + " input[type=hidden]").each(function(i) {
		a.push({
			name : this.name,
			value : this.value
		});
	});
	return a;
}

/**
 * 删除审计事件
 */
function deleteDBOperation() {

	if( $('.trSelected').length>0){
		$( "#deleteConfirm" ).dialog( "open" );				
	}else{
//		alert("请选择记录进行删除！");
		artDialog({content:'请选择记录进行删除！', style:'alert'}, function(){});
	}
}

function deleteDBOperationResult() {

	if( $('.trSelected').length>0){
		$( "#deleteResultConfirm" ).dialog( "open" );				
	}else{
//		alert("请选择记录进行删除！");
		artDialog({content:'请选择记录进行删除！', style:'alert'}, function(){});
	}
}

function deleteAllDBOperation() {
	$( "#deleteAllConfirm" ).dialog( "open" );	
}

/**
 * 查看审计事件
 */
function viewDBOperation() {
	if( $('.trSelected').length==1){
		//查看某一条记录的详细信息	
		var targetId = $('.trSelected').find("td:first").eq(0).text();
		var targetTime=$('.trSelected').find("td:nineth").eq(8).text();
		//window.location.href = "auditDetails_result.php.php?targetOpId="+targetId; //只需查询审计出来的结果，才查看详细信息
//		var currentPage = $("#currentPage").val();
		var currentPage = parseInt($('.pcontrol input').val());
		var advance = $("#advance").val();
		var target = $("#target").val();
		
		var searchServiceName=$("#searchServiceName").val();
		var searchProtocol=$("#searchProtocol").val();
		var beginDate=$("#beginDate").val();
		var beginTime=$("#beginTime").val();
		var endDate=$("#endDate").val();
		var endTime=$("#endTime").val();
		var srcIP=$("#srcIP").val();
		var srcPort=$("#srcPort").val();
		var destIP=$("#destIP").val();
		var destPort=$("#destPort").val();
		var opclass=$("#opclass").val();
		var execResult=$("#execResult").val();
		var riskLevel=$("#riskLevel").val();
		var loginName=$("#loginName").val();
		var searchAuditRule = $("#searchAuditRule").val();
		
		var condition = {};
		condition['searchServiceName']=searchServiceName;
		condition['searchProtocol']=searchProtocol;
		condition['beginDate']=beginDate;
		condition['beginTime']=beginTime;
		condition['endDate']=endDate;
		condition['endTime']=endTime;
		condition['srcIP']=srcIP;
		condition['srcPort']=srcPort;
		condition['destIP']=destIP;
		condition['destPort']=destPort;
		condition['opclass']=opclass;
		condition['execResult']=execResult;
		condition['riskLevel']=riskLevel;
		condition['loginName']=loginName;
		condition['searchAuditRule']=searchAuditRule;
		
		var url = "auditDetails_dbAll.php?targetOpId="+targetId+"&targetTime="+targetTime+"&currentPage="+currentPage;
		url+="&advance="+advance;
		url += "&condition="+$.toJSON(condition);
		url += "&target="+target;
		
		window.location.href = url;
//		window.location.href = "auditDetails_dbAll.php?targetOpId="+targetId+"&currentPage="+currentPage;
	}else{
//		alert("每次只能查看一条审计事件！");
		artDialog({content:'每次只能查看一条审计事件！', style:'alert'}, function(){});
	}
}

/**
 * 查看审计结果
 */
function viewDBOperationResult() {
	if( $('.trSelected').length==1){
		//查看某一条记录的详细信息	
		var targetId = $('.trSelected').find("td:first").eq(0).text();
		var targetTime=$('.trSelected').find("td:eleventh").eq(10).text();
//		alert(targetTime);
		//window.location.href = "auditDetails_result.php.php?targetOpId="+targetId; //只需查询审计出来的结果，才查看详细信息
//		var currentPage = $("#currentPage").val();
		var currentPage = parseInt($('.pcontrol input').val());
		var advance = $("#advance").val();
		var target = $("#target").val();
		
		var searchServiceName=$("#searchServiceName").val();
		var searchProtocol=$("#searchProtocol").val();
		var beginDate=$("#beginDate").val();
		var beginTime=$("#beginTime").val();
		var endDate=$("#endDate").val();
		var endTime=$("#endTime").val();
		var srcIP=$("#srcIP").val();
		var srcPort=$("#srcPort").val();
		var destIP=$("#destIP").val();
		var destPort=$("#destPort").val();
		var opclass=$("#opclass").val();
		var execResult=$("#execResult").val();
		var riskLevel=$("#riskLevel").val();
		var loginName=$("#loginName").val();
		var searchAuditRule = $("#searchAuditRule").val();
		
		var condition = {};
		condition['searchServiceName']=searchServiceName;
		condition['searchProtocol']=searchProtocol;
		condition['beginDate']=beginDate;
		condition['beginTime']=beginTime;
		condition['endDate']=endDate;
		condition['endTime']=endTime;
		condition['srcIP']=srcIP;
		condition['srcPort']=srcPort;
		condition['destIP']=destIP;
		condition['destPort']=destPort;
		condition['opclass']=opclass;
		condition['execResult']=execResult;
		condition['riskLevel']=riskLevel;
		condition['loginName']=loginName;
		condition['searchAuditRule']=searchAuditRule;
		
		var url = "auditDetails_dbAll.php?targetOpId="+targetId+"&targetTime="+targetTime+"&currentPage="+currentPage;
		url+="&advance="+advance;
		url += "&condition="+$.toJSON(condition);
		url += "&target="+target;
		
		window.location.href = url;
//		window.location.href = "auditDetails_dbAll.php?targetOpId="+targetId+"&currentPage="+currentPage;
	}else{
//		alert("每次只能查看一条审计事件！");
		artDialog({content:'每次只能查看一条审计事件！', style:'alert'}, function(){});
	}
}

/**
 * 查看会话回放
 * @param sessionID
 * @returns
 */
var records = [];
function viewSessionBack(sessionID) {
	var sessionID = $("#sessionIDHidden").val();
	var execTime= $("#execTimeHidden").val();
	var pageNo = 1;
	$( "#sessionBackDiv" ).dialog( "open" );		
}

//function showcontent(i){
//	var record = records[i];
//	$('#sessionBackTbody').append("<tr><td>"+record['ExecTime']+"</td><td>"+record['SqlString']+"</td></tr>");
//	if(i < count) {
//		setTimeout(showcontent,1000);
//	}
//	i++;
//}

function detailBack() {
	var advance = $("#advance").val();
	
	var searchServiceName=$("#searchServiceName").val();
	var searchProtocol=$("#searchProtocol").val();
	var beginDate=$("#beginDate").val();
	var beginTime=$("#beginTime").val();
	var endDate=$("#endDate").val();
	var endTime=$("#endTime").val();
	var srcIP=$("#srcIP").val();
	var srcPort=$("#srcPort").val();
	var destIP=$("#destIP").val();
	var destPort=$("#destPort").val();
	var opclass=$("#opclass").val();
	var execResult=$("#execResult").val();
	var riskLevel=$("#riskLevel").val();
	var loginName=$("#loginName").val();
	
//	var condition = {};
//	condition['searchServiceName']=searchServiceName;
//	condition['searchProtocol']=searchProtocol;
//	condition['beginDate']=beginDate;
//	condition['beginTime']=beginTime;
//	condition['endDate']=endDate;
//	condition['endTime']=endTime;
//	condition['srcIP']=srcIP;
//	condition['srcPort']=srcPort;
//	condition['destIP']=destIP;
//	condition['destPort']=destPort;
//	condition['opclass']=opclass;
//	condition['execResult']=execResult;
//	condition['riskLevel']=riskLevel;
//	condition['loginName']=loginName;
	
	var currentPage = $("#currentPageHidden").val();
	var condition = $("#condition").val();
	
	var url = "audit.php?currentPage="+currentPage;
	
	var target = $("#target").val();
	if(target=='dbResult') {
		url = "auditResult.php?currentPage="+currentPage;
	}
	
	url+="&advance="+advance;
//	url+="&searchServiceName="+searchServiceName;
//	url+="&searchProtocol="+searchProtocol;
//	url+="&beginDate="+beginDate;
//	url+="&beginTime="+beginTime;
//	url+="&endDate="+endDate;
//	url+="&endTime="+endTime;
//	url+="&srcIP="+srcIP;
//	url+="&srcPort="+srcPort;
//	url+="&destIP="+destIP;
//	url+="&destPort="+destPort;
//	url+="&opclass="+opclass;
//	url+="&execResult="+execResult;
//	url+="&riskLevel="+riskLevel;
//	url+="&loginName="+loginName;
//	url += "&condition="+$.toJSON(condition);
	url += "&condition="+condition;
	window.location.href = url;
}