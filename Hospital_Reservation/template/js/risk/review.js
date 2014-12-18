/*以下是查看全部审计事件显示的表格，如果要只显示审计结果，请查看audit_dball.js文件*/
$(function(){		
	$("#queryGrid").flexigrid({ 
        url : 'post_review_query.php', 
        dataType : 'json', 
        contentType: "application/json; charset=utf-8",
        colModel : [
                    { display : '编号', name : 'OpID', width : 80, sortable : true, align : 'left' },
                     { display : '风险等级', name : 'RiskLevel', width : 60, sortable : true, align : 'center' },
                     { display : '审核状态', name : 'IsProccessed', width :100, sortable : true, align : 'left' },
                     { display : '服务器', name : 'DstIP', width : 120, sortable : true, align : 'left' }, 
                     { display : '协议', name : 'Description', width : 80, sortable : true, align : 'left' },
                     { display : '数据库', name : 'ServiceName', width : 120, sortable : true, align : 'left' }, 
                     { display : '登录名', name : 'LoginName', width : 120, sortable : true, align : 'left' },
                     { display : '用户名', name : 'UserName', width : 100, sortable : true, align : 'left' },
                     { display : '用户IP', name : 'UserIP', width : 100, sortable : true, align : 'left' },
                     { display : '源IP', name : 'SrcIP', width : 150, sortable : true, align : 'left' },
                     { display : '操作时间', name : 'ExecTime', width : 150, sortable : true, align : 'left' },
                     { display : '操作类型', name : 'OpClass', width : 120, sortable : true, align : 'left' },
                     { display : 'SQL语句', name : 'SqlString', width : 150, sortable : true, align : 'left' },
//                     { display : '响应时间', name : 'ResponseTime', width : 80, sortable : true, align : 'left' },
                     { display : '是否合法', name : 'Legality', width : 80, sortable : true, align : 'center' }
                     
                    ],
        buttons : [
                   		
               			{name: '查看详细', bclass: 'edit', onpress : viewDetail},
               			{name: '确认风险', bclass: 'add', onpress : confirmRisk},
               			{name: '忽略风险', bclass: 'delete', onpress : ignoreRisk}
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
	/*updated by gengjinkun  
	   2014-08-07
		   */
	$( "#deleteConfirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:140,
		modal: false,
		buttons: {
			"删除": function() {			
				var  targetOpIds ="";
				var datetimes=""; 
				var count = $('.trSelected').length;
				for(var i = 0;i < count;i ++){
					targetOpIds +='!';
					targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
				}
				var items = $('.trSelected'); 
				items .each(function() {
				     datetimes += '!';
					 /* 以下两种方式可以*/
					 //从1开始数列数
                    // datetimes += $(this).children().eq(11).text(); 
					//从0开始数列数
					   datetimes +=$('.trSelected').find("td:eq(10)").eq(0).text();
                 });
				targetOpIds = targetOpIds.substr(1);	
				datetimes = datetimes.substr(1);
				$.ajax({
			        //url : 'risk.php?cmd=del&ids='+targetOpIds,
					url : "risk.php?cmd=del&ids="+targetOpIds+"&dts="+datetimes,
			        type : 'POST',
			        dataType : 'JSON',
			        contentType: "application/json; charset=utf-8",
			        success : function(data) {
			        	if(data == 'OK') {
//			        		alert("删除成功！");
			        		artDialog({content:'删除成功！', style:'succeed'}, function(){
			        			$('#queryGrid').flexReload();//表格重载
			        		});
			        	}
						else if(data=="ARCHIVE_CONTENT"){
							           
                             artDialog({content:'有数据已经归档，不可删除！', style:'succeed'}, function(){
			        			 //$('#queryGrid').flexReload();//表格重载
								 /*没删掉还重载个毛线 */
							  });
						}
						else {
//			        		alert("服务器出错，删除失败！请重试！");
			        		artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
			        			//$('#queryGrid').flexReload();//表格重载
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
		var dateTime = $('.trSelected').find("td:eq(10)").eq(0).text();
		$.get(WEB_ROOT+"risk/risk.php",{
			cmd:"get",
			recordID:targetId,
			dateTime:dateTime
			},function(data){
				$('#riskDetail').html(data);
				$('#riskDetail').dialog("open");
				});
	}else{
//		alert("每次只能查看一条报警事件！");
		if( $('.trSelected').length==0){
			artDialog({content:'请选择记录！', style:'alert'}, function(){});
		}else{
			artDialog({content:'每次只能查看一条报警事件！', style:'alert'}, function(){});
		}
		
	}
}

function confirmRisk(){
	if( $('.trSelected').length>0){
		var targetOpIds ="";
		var dateTimes=""; 
		var count = $('.trSelected').length;
		var bValid = true;
		
		for(var i = 0;i < count;i ++){
			targetOpIds +='!';
			targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
			proceed=$('.trSelected').find("td:eq(2)").eq(i).text();
			dateTimes +='!';
			dateTimes +=$('.trSelected').find("td:eq(10)").eq(i).text();
//			//进行判断，选中的是否是“未审核”的事件
//			if(proceed!='未审核'){
//				bValid = false;
//				break;
//			}
		}
		if(bValid==true){
			targetOpIds = targetOpIds.substr(1);
			dateTimes = dateTimes.substr(1);
			$.ajax({
				url:"risk.php",
				type:"POST",
				dataType:"text",
				data:{
					cmd:'review',
					id:targetOpIds,
					dt:dateTimes,
					processed:'1'
				},
				success:function(data){
					if(data=='OK'){
						artDialog({content:'审核成功！', style:'succeed'}, function(){
							$('#queryGrid').flexReload();//表格重载
						});
					}else{
						artDialog({content:'审核失败！', style:'error'}, function(){
							//$('#queryGrid').flexReload();//表格重载
						});
					}
				}
			});
		} else {
			artDialog({content:'请选择未审核的报警事件！', style:'alert'}, function(){
			});
		}
		
	}else{
		artDialog({content:'请选择记录！', style:'alert'}, function(){});
	}
	
}
function ignoreRisk(){
	if( $('.trSelected').length>0){
		var targetOpIds ="";
		var dateTimes=""; 
		var count = $('.trSelected').length;
		var bValid = true;
		for(var i = 0;i < count;i ++){
			targetOpIds +='!';
			targetOpIds +=$('.trSelected').find("td:first").eq(i).text();
			proceed=$('.trSelected').find("td:eq(2)").eq(i).text();
			dateTimes +='!';
			dateTimes +=$('.trSelected').find("td:eq(10)").eq(i).text();
//			if(proceed!='未审核'){
//				bValid = false;
//				break;
//			}
		}
		if(bValid==true){
			targetOpIds = targetOpIds.substr(1);	
			dateTimes = dateTimes.substr(1);
					$.ajax({
						url:"risk.php",
						type:"POST",
						dataType:"text",
						data:{
							cmd:'review',
							id:targetOpIds,
							dt:dateTimes,
							processed:'2'
						},
						success:function(data){
							if(data=='OK'){
								artDialog({content:'审核成功！', style:'succeed'}, function(){
									$('#queryGrid').flexReload();//表格重载
								});
							}else{
								
								artDialog({content:'审核失败！', style:'error'}, function(){
									//$('#queryGrid').flexReload();//表格重载
								});
							}
						}
					});
		} else {
			artDialog({content:'请选择未审核的报警事件！', style:'alert'}, function(){
			});
		}
		

	}else{
//		alert("请选择记录！");
		artDialog({content:'请选择记录！', style:'alert'}, function(){});
	}
	
}

