$(function(){
	/*flexigrid表格设置*/
	$("#auditFTPGrid").flexigrid({ 
        url : 'ftp_json.php', 
        dataType : 'json', 
        contentType: "application/json; charset=utf-8",
        colModel : [
                     { display : '操作ID', name : 'OpID', width : 80, sortable : true, align : 'left' },
                     { display : '操作类型', name : 'OpClass', width : 120, sortable : true, align : 'left' },
                     { display : 'Sql语句', name : 'SqlString', width : 120, sortable : true, align : 'left' },
                     { display : '会话ID', name : 'SessionID', width : 80, sortable : true, align : 'left' }, 
                     { display : '源IP', name : 'SrcIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '源端口', name : 'SrcPort', width : 120, sortable : true, align : 'left'}, 
                     { display : '目的IP', name : 'DstIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '目的端口', name : 'DstPort', width : 120, sortable : true, align : 'left' }, 
                     { display : '服务名', name : 'ServiceName', width : 120, sortable : true, align : 'left' }, 
                     { display : '登录名', name : 'LoginName', width : 120, sortable : true, align : 'left' },
                     { display : '协议名称', name : 'Protocol', width : 120, sortable : true, align : 'left' },
                     { display : '开始时间', name : 'StartTime', width : 120, sortable : true, align : 'left' },
                     { display : '结束时间', name : 'EndTime', width : 120, sortable : true, align : 'left' },
                     { display : '执行时间', name : 'ExecTime', width : 120, sortable : true, align : 'left' },
                     { display : '执行结果', name : 'ExecResult', width : 120, sortable : true, align : 'left' },
                     { display : '风险级别', name : 'RiskLevel', width : 120, sortable : true, align : 'left' },
                     { display : '源MAC地址', name : 'SrcName', width : 120, sortable : true, align : 'left' },
                     { display : '源主机名', name : 'SrcHostName', width : 120, sortable : true, align : 'left' }
                    ],
        buttons : [
//               			{name: '添加', bclass: 'add', onpress : function(){}},
               			{name: '删除', bclass: 'delete', onpress : deleteDBOperation},
               			{name: '查看', bclass: 'edit', onpress : viewDBOperation}	
//               			{name: '权限', bclass: 'privilege', onpress : function(){}}
               		],
        searchitems : [ { display : '服务名', name : 'ServiceName' }, 
                        { display : '会话ID', name : 'SessionID', isdefault : true } 
        			  ], 
        sortname : "SessionID", 
        sortorder : "asc", 
        usepager : true, 
        title : '非数据库审计事件列表管理', 
        useRp : true, 
        rp : 15, 
        showTableToggleBtn : true, 
        width:document.body.scrollWidth-60, 
        height:400,
        checkbox:true
	});
	
	/*flexigrid表格设置*/
	$("#auditRapGrid").flexigrid({ 
        url : 'rap_json.php', 
        dataType : 'json', 
        contentType: "application/json; charset=utf-8",
        colModel : [
                     { display : '操作ID', name : 'OpID', width : 80, sortable : true, align : 'left' },
                     { display : '操作类型', name : 'OpClass', width : 120, sortable : true, align : 'left' },
                     { display : 'Sql语句', name : 'SqlString', width : 120, sortable : true, align : 'left' },
                     { display : '会话ID', name : 'SessionID', width : 80, sortable : true, align : 'left' }, 
                     { display : '源IP', name : 'SrcIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '源端口', name : 'SrcPort', width : 120, sortable : true, align : 'left'}, 
                     { display : '目的IP', name : 'DstIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '目的端口', name : 'DstPort', width : 120, sortable : true, align : 'left' }, 
                     { display : '服务名', name : 'ServiceName', width : 120, sortable : true, align : 'left' }, 
                     { display : '登录名', name : 'LoginName', width : 120, sortable : true, align : 'left' },
                     { display : '协议名称', name : 'Protocol', width : 120, sortable : true, align : 'left' },
                     { display : '开始时间', name : 'StartTime', width : 120, sortable : true, align : 'left' },
                     { display : '结束时间', name : 'EndTime', width : 120, sortable : true, align : 'left' },
                     { display : '执行时间', name : 'ExecTime', width : 120, sortable : true, align : 'left' },
                     { display : '执行结果', name : 'ExecResult', width : 120, sortable : true, align : 'left' },
                     { display : '风险级别', name : 'RiskLevel', width : 120, sortable : true, align : 'left' },
                     { display : '源MAC地址', name : 'SrcName', width : 120, sortable : true, align : 'left' },
                     { display : '源主机名', name : 'SrcHostName', width : 120, sortable : true, align : 'left' }
                    ],
        buttons : [
//               			{name: '添加', bclass: 'add', onpress : function(){}},
               			{name: '删除', bclass: 'delete', onpress : deleteDBOperation},
               			{name: '查看', bclass: 'edit', onpress : viewDBOperation}	
//               			{name: '权限', bclass: 'privilege', onpress : function(){}}
               		],
        searchitems : [ { display : '服务名', name : 'ServiceName' }, 
                        { display : '会话ID', name : 'SessionID', isdefault : true } 
        			  ], 
        sortname : "SessionID", 
        sortorder : "asc", 
        usepager : true, 
        title : '非数据库审计事件列表管理', 
        useRp : true, 
        rp : 15, 
        showTableToggleBtn : true, 
        width:920, 
        height:400,
        checkbox:true
	});
	
	
});

/**
 * 删除审计事件
 */
function deleteFTPOperation(targetOpId) {
	if(confirm("确定删除所选的FTP事件吗？")) {
		window.location.href="audit_nonDB.php?cmd=deleteFTP&targetOpId="+targetOpId;
	}
}

/**
 * 删除FTP操作
 * @returns
 */
function deleteRAPOperation(targetOpId) {
	if(confirm("确定删除所选的FTP事件吗？")) {
		window.location.href="audit_nonDB.php?cmd=deleteRAP&targetOpId="+targetOpId;
	}
}

/**
 * 查看RAP审计事件
 */
function viewRAPOperation(targetOpId) {
	window.location.href="audit_nonDBDetails.php?type=rap&targetOpId="+targetOpId;
}

/**
 * 查看FTP审计事件
 */
function viewFTPOperation(targetOpId) {
	window.location.href="audit_nonDBDetails.php?type=ftp&targetOpId="+targetOpId;
}

/**
 * 删除非数据库审计事件
 * @param targetIpId
 * @param type
 * @returns
 */
function deleteNonDBOperation(targetOpId, type) {
	if(confirm("确定删除该非数据库审计事件记录吗？")) {
		if(type=='ftp') {
			window.location.href="audit_nonDB.php?cmd=deleteFTP&targetOpId="+targetOpId;
		} else {
			window.location.href="audit_nonDB.php?cmd=deleteRAP&targetOpId="+targetOpId;
		}
	}
}

/**
 * 查看非数据库审计事件
 * @param targetOpId
 * @param type
 * @returns
 */
function viewNonDBOperation(targetOpId, type) {
	window.location.href="audit_nonDBDetails.php?type="+type+"&targetOpId="+targetOpId;
}

//function page(pageNo) {
//	var serviceName = $("#searchNameHidden").val();
//	var protocol = $("#searchProtocolHidden").val();
//	var beginDate = $("#beginDateHidden").val();
//	var beginTime = $("#beginTimeHidden").val();
//	var endDate = $("#endDateHidden").val();
//	var endTime = $("#endTimeHidden").val();
//	if(pageNo == -1){
//		pageNo = $('#pageNum').val();
//	}
//	$.get(WEB_ROOT+"monitor/audit_nonDB.php?cmd=search",{
//		searchServiceName:serviceName,
//		searchProtocol:protocol,
//		beginDate:beginDate,
//		beginTime:beginTime,
//		endDate:endDate,
//		endTime:endTime,
//		page:'page',
//		pageNo:pageNo
//	},function(data){
//		$('#body').html(data);
//	})
//}

//function searchNonDB() {
//	var serviceName = $("#searchServiceName").val();
//	var protocol = $("#searchProtocol").val();
//	var beginDate = $("#beginDate").val();
//	var beginTime = $("#beginTime").val();
//	var endDate = $("#endDate").val();
//	var endTime = $("#endTime").val();
//	$.get(WEB_ROOT+"monitor/audit_nonDB.php?cmd=search",{
//		searchServiceName:serviceName,
//		searchProtocol:protocol,
//		beginDate:beginDate,
//		beginTime:beginTime,
//		endDate:endDate,
//		endTime:endTime
//	},function(data){
//		$('#body').html(data);
//	})
//}
		