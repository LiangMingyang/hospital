/*以下是查看全部审计事件显示的表格，如果要只显示审计结果，请查看audit_dball.js文件*/
$(function(){		
	$("#queryGrid").flexigrid({ 
        url : 'post_risk_query.php', 
        dataType : 'json', 
        contentType: "application/json; charset=utf-8",
        colModel : [
                    { display : '编号', name : 'OpID', width : 80, sortable : true, align : 'left' },
                     { display : '风险等级', name : 'RiskLevel', width : 60, sortable : true, align : 'center' },
                     { display : '审核状态', name : 'IsProccessed', width : 100, sortable : true, align : 'left' },
                     { display : '服务器', name : 'DstIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '协议', name : 'Description', width : 80, sortable : true, align : 'left' },
                     { display : '数据库', name : 'ServiceName', width : 120, sortable : true, align : 'left' }, 
                     { display : '登录名', name : 'LoginName', width : 120, sortable : true, align : 'left' },
                     { display : '用户名', name : 'UserName', width : 100, sortable : true, align : 'left' },
                     { display : '用户IP', name : 'UserIP', width : 100, sortable : true, align : 'left' },
                     { display : '源IP', name : 'SrcIP', width : 150, sortable : true, align : 'left' },
                     { display : '操作时间', name : 'ExecTime', width : 120, sortable : true, align : 'left' },
                     { display : '操作类型', name : 'OpClass', width : 120, sortable : true, align : 'left' },
                     { display : 'SQL语句', name : 'SqlString', width : 150, sortable : true, align : 'left' },
//                     { display : '响应时间', name : 'ResponseTime', width : 80, sortable : true, align : 'left' },
                     { display : '是否合法', name : 'Legality', width : 80, sortable : true, align : 'center' }
                    ],
        buttons : [
                   		{name: '删除', bclass: 'delete', onpress : deleteRisk}	,
               			{name: '查看详细', bclass: 'edit', onpress : viewDetail}	
               		],
        sortname : "OpID", 
        sortorder : "asc", 
        usepager : true, 
//        title : '审计事件列表管理', 
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
				var  targetOpIds ="";
				var count = $('.trSelected').length;
				for(var i = 0;i < count;i ++){
					targetOpIds +=',';
					targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
				}
				targetOpIds = targetOpIds.substr(1);	
				$.ajax({
			        url : 'risk.php?cmd=del&ids='+targetOpIds,
			        type : 'POST',
			        dataType : 'text',
			        success : function(data) {
			        	if(data=="OK") {
			        		artDialog({content:'删除成功！', style:'succeed'}, function(){
			        			 $('#queryGrid').flexReload();//表格重载
			        		});
			        	} else if(data=="ARCHIVE_CONNECT_ERROR"){
			        		artDialog({content:'<font color="red">您选中的记录有些归档至其他数据库，连接归档数据库失败！</font>', style:'alert'}, function(){
			        			 $('#queryGrid').flexReload();//表格重载
			        		});
			        	} else {
			        		artDialog({content:'<font color="red">服务器出错，删除失败，请稍后重试！</font>', style:'error'}, function(){
			        			 $('#queryGrid').flexReload();//表格重载
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
 * 查看审计事件
 */
function viewDetail() {
	if( $('.trSelected').length==1){
		//查看某一条记录的详细信息	
		var targetId = $('.trSelected').find("td:first").eq(0).text();
		/*就换成
		var targetId = $('.trSelected').find("td:eq(0)").eq(0).text();
		多好，偏偏用td:first，搞什么特殊啊
		*/
		var datetime =$('.trSelected').find("td:eq(10)").eq(0).text();
		//var datetime="20140806";
		/* added by gengjinkun 2014-07-29
		* */
		//.get是.ajax的简写函数
		$.get(WEB_ROOT+"risk/risk.php",{
			cmd:"get",
			recordID:targetId,
			dateTime:datetime
			},function(data){
				$('#riskDetail').html(data);
				$('#riskDetail').dialog("open");
				});
	}else{
//		alert("每次只能查看一条报警事件！");
		artDialog({content:'每次只能查看一条报警事件！', style:'alert'}, function(){});
	}
}

function deleteRisk(){
	if( $('.trSelected').length>0){
		$( "#deleteConfirm" ).dialog( "open" );	
	}else{
//		alert("请选择记录进行删除！");
		artDialog({content:'请选择记录进行删除！', style:'alert'}, function(){});
	}
	
}

