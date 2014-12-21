$(function(){		
	/*flexigrid表格设置*/
	$("#auditGrid").flexigrid({ 
        url : 'post_json_dball.php', 
        dataType : 'json', 
        contentType: "application/json; charset=utf-8",
        colModel : [
                     { display : '事件ID', name : 'RecordID', width : 80, sortable : true, align : 'left',hide:true},
                     { display : '操作ID', name : 'OpID', width : 80, sortable : true, align : 'left' },
                     { display : '会话ID', name : 'SessionID', width : 80, sortable : true, align : 'left' }, 
                     { display : '规则ID', name : 'RuleID', width : 80, sortable : true, align : 'left' },
                     { display : '规则名', name : 'RuleName', width : 80, sortable : true, align : 'left' }, 
                     { display : '操作类型', name : 'OpClass', width : 120, sortable : true, align : 'left' },
                     { display : '服务名', name : 'ServiceName', width : 120, sortable : true, align : 'left' }, 
                     { display : '登录名', name : 'LoginName', width : 120, sortable : true, align : 'left' },
                     { display : 'Sql语句', name : 'SqlString', width : 150, sortable : true, align : 'left' },
                     { display : '执行时间', name : 'ExecTime', width : 120, sortable : true, align : 'left' },
                     { display : '执行结果', name : 'ExecResult', width : 80, sortable : true, align : 'left' },
                     { display : '响应时间', name : 'ResponseTime', width : 80, sortable : true, align : 'left' },
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
               			{name: '删除', bclass: 'delete', onpress : deleteDBOperation},
               			{name: '查看', bclass: 'edit', onpress : viewDBOperation}	
//               			{name: '权限', bclass: 'privilege', onpress : function(){}}
               		],
//        searchitems : [ { display : '服务名', name : 'ServiceName' }, 
//                        { display : '会话ID', name : 'SessionID', isdefault : true } 
//        			  ], 
        sortname : "SessionID", 
        sortorder : "asc", 
        usepager : true, 
//        title : '审计事件列表管理', 
        useRp : true, 
        rp : 13, 
        showTableToggleBtn : true, 
        width:930, 
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
				var  targetOpIds ="";
				var count = $('.trSelected').length;
				for(var i = 0;i < count;i ++){
					targetOpIds +=',';
					targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
				}
				$.ajax({
			        url : 'AuditOperationService.php?cmd=deleteOperations&targetOpIds='+targetOpIds,
			        type : 'POST',
			        dataType : 'JSON',
			        contentType: "application/json; charset=utf-8",
			        success : function(data) {
			        	if(data.msg=='SUCCESS') {
			        		alert("删除成功！");
			        	}
				        $('#auditGrid').flexReload();//表格重载
			        }
	       		});
				$( this ).dialog( "close" );
				
			},
			"取消": function() {
				$( this ).dialog( "close" );
			}
			
		}
	});
	
	/*弹出对话框-会话回放*/
	$( "#sessionBackDiv" ).dialog({
		autoOpen: false,
		resizable: true,
		title:"会话回放",
		height:500,
		width:800,
		modal: false,
		buttons: {
			"确定": function() {			
				$( this ).dialog( "close" );
				$("#sessionBackTbody").empty();
			}
		}
	});
	
	/*flexigrid表格设置*/
	$("#sessionBackTable").flexigrid({ 
        url : 'auditDetails.php?cmd=sessionBack&targetSessionID='+$("#sessionIDHidden").val(), 
        dataType : 'json',
        contentType: "application/json; charset=utf-8",
        colModel : [
//                     { display : 'ID', name : 'OpID', width : 200, sortable : true, align : 'left',hide:true},
                     { display : '执行时间', name : 'ExecTime', width : 200, sortable : true, align : 'left' },
                     { display : 'SQL语句', name : 'SqlString', width : 300, sortable : true, align : 'left' }
                    ],
        usepager : true, 
//        title : '会话回放', 
        useRp : false, 
        rp : 15, 
        showTableToggleBtn : true, 
        width:700, 
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
//	var a = "'{";
//	// 文本框
//	$("#" + formId + " input[type=text]").each(function(i) {
//		a += "\"" + this.name + "\":\"" + this.value + "\","; 
//	});
//	$("#" + formId + " select").each(function(i) {
//		a += "\"" + this.name + "\":\"" + this.value + "\","; 
//	});
//	$("#" + formId + " input[type=hidden]").each(function(i) {
//		a += "\"" + this.name + "\":\"" + this.value + "\","; 
//	});
//	a = a.substr(0,a.length-1);
//	a += "}'";
	return a;
}

/**
 * 删除审计事件
 */
function deleteDBOperation() {
	if( $('.trSelected').length>0){
		$( "#deleteConfirm" ).dialog( "open" );				
	}else{
		alert("请选择记录进行删除！");
	}
}
/**
 * 查看审计事件
 */
function viewDBOperation() {
	if( $('.trSelected').length==1){
		//查看某一条记录的详细信息	
		var targetId = $('.trSelected').find("td:first").eq(0).text();
		//window.location.href = "auditDetails_result.php.php?targetOpId="+targetId; //只需查询审计出来的结果，才查看详细信息
		window.location.href = "auditDetails_dbAll.php.php?targetOpId="+targetId;
	}else{
		alert("每次只能查看一条审计事件！");
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
	var pageNo = 1;
//	 if(pageNo == -1){
//			pageNo = $('#pageNum').val();
//	 }
	$( "#sessionBackDiv" ).dialog( "open" );	
//	 var sessionID = $("#sessionIDHidden").val();
//		$.ajax({
//			url:"auditDetails.php?cmd=sessionBack",
//			type:"POST",
//			dataType:"JSON",
//			timeout:30000,
//			data:{
//				targetSessionID:sessionID,
//				pageNo:pageNo,
//				page:"page"
//			},
//			error:function(XMLHttpRequest,textStatus,errorThrown) {
//				alert(XMLHttpRequest);
//				alert(textStatus);
//				alert(errorThrown);
//			},
//			success:function(data) {
//				var dataList = data.list;
//				count = dataList.length;
//				for(var i = 0; i < count; i ++) {
//					records.push({
//						"ExecTime":dataList[i].ExecTime,
//						"SqlString":dataList[i].SqlString
//					});
//				}
//				
//				var i = 0;
//				showcontent(i);
////				while(i<count) {
////					var record = records[i];
////					$('#sessionBackTbody').append("<tr><td>"+record['ExecTime']+"</td><td>"+record['SqlString']+"</td></tr>");
////					setTimeout(1000);
////					i++;
////				}
//			}
//		});
	
}

function showcontent(i){
	var record = records[i];
	$('#sessionBackTbody').append("<tr><td>"+record['ExecTime']+"</td><td>"+record['SqlString']+"</td></tr>");
	if(i < count) {
		setTimeout(showcontent,1000);
	}
	i++;
}

