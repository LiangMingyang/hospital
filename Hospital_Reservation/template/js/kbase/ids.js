/*以下是查看全部审计事件显示的表格，如果要只显示审计结果，请查看audit_dball.js文件*/
$(function(){		
	/*flexigrid表格设置*/
	$("#idsResultGrid").flexigrid({ 
        url : 'post_ids_result.php', 
        dataType : 'json', 
        contentType: "application/json; charset=utf-8",
        colModel : [
                     { display : 'SQL操作ID', name : 'SinjID', width : 80, sortable : true, align : 'left' },
                     { display : '数据库操作ID', name : 'OpID', width : 80, sortable : true, align : 'left' }, 
                     { display : '数据库类型', name : 'Protocol', width : 120, sortable : true, align : 'left' },
                     { display : 'SQL语句', name : 'SqlString', width : 120, sortable : true, align : 'left' }, 
                     { display : '登录名', name : 'LoginName', width : 120, sortable : true, align : 'left' },
                     { display : '源IP', name : 'SrcIP', width : 100, sortable : true, align : 'left' },
                     { display : '禁用IP', name : 'VIp', width : 100, sortable : true, align : 'left' },
                     { display : '用户创建漏洞函数', name : 'VUserFuncName', width : 150, sortable : true, align : 'left' },
                     { display : '数据库漏洞函数', name : 'VFunctionName', width : 120, sortable : true, align : 'left' },
                     { display : 'SQL注入语句ID', name : 'VSQLInjID', width : 80, sortable : true, align : 'left' },
                     { display : '风险等级', name : 'RiskLevel', width : 100, sortable : true, align : 'left' }
                    ],
        buttons : [
               			{name: '删除', bclass: 'delete', onpress : deletekbaseResult},
               			{name: '查看详细信息', bclass: 'edit', onpress : viewkbaseResult}	
               		],

        sortname : "SinjID", 
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
	
	
	/*弹出对话框-删除*/
	$( "#deleteConfirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:140,
		modal: false,
		buttons: {
			"删除": function() {			
				var targetOpIds ="";
				var count = $('.trSelected').length;
				for(var i = 0;i < count;i ++){
					targetOpIds +=',';
					targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
				}
				
				$.ajax({
			        url : 'kbaseResult.php?cmd=delete&targetids='+targetOpIds,
			        type : 'POST',
			        dataType : 'text',
			        contentType: "application/json; charset=utf-8",
			        success : function(data) {
			        	if(data =='OK') {
			        		artDialog({content:'删除成功！', style:'succeed'}, function(){
			        			$('#idsResultGrid').flexReload();//表格重载
			        		});
			        	} else {
			        		artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
			        			$('#idsResultGrid').flexReload();//表格重载
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
 * 删除审计事件
 */
function deletekbaseResult() {
	if( $('.trSelected').length>0){
		$( "#deleteConfirm" ).dialog( "open" );				
	}else{
//		alert("请选择记录进行删除！");
		artDialog({content:'请选择记录进行删除！', style:'alert'}, function(){});
	}
}


/**
 * 查看审计事件
 */
function viewkbaseResult() {
	if( $('.trSelected').length==1){
		//查看某一条记录的详细信息	
		var targetId = $('.trSelected').find("td:first").eq(0).text();
		$.get(WEB_ROOT+"kbase/kbaseResult.php",{
			cmd:"get",
			recordID:targetId
			},function(data){
				$('#resultDetail').html(data);
				$('#resultDetail').dialog("open");
				});
	}else{
//		alert("每次只能查看一条报警事件！");
		artDialog({content:'每次只能查看一条报警事件！', style:'alert'}, function(){});
	}
}