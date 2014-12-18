/**
 * 
 */
$(function(){
	$('#datasource').dialog({
		autoOpen: false,
		resizable: true,
		height:'auto',
		width:'600',
		modal: true,
		position:"top",
		title:"数据源配置",
		buttons: {
			"确定": function(){
				$(this).dialog("close");
			},
			"取消": function() {
				$( this ).dialog( "close" );
				delIds = '';
				ds = {};
			}
		},
		beforeclose: function(event, ui) { changeDs(0); }
	});
});
function showDataSource(){
	$('#datasource').dialog("open");
	$('#datasource table table tr.category').each(function(){$(this).css('cursor','pointer')});
}
function showCategory(obj){
	cat = $(obj);
	var i =$('#datasource table table tr.category').index(cat);
	var ds = $('#datasource table table tr').eq(i*2+1);
	if(ds.css('display')=='none'){
		$('#datasource table table tr.category span').eq(i).html('-');
		ds.show();
	}else{
		$('#datasource table table tr.category span').eq(i).html('+');
		ds.hide();
	}
}
function templateSave(){
	var datasource = '';
	$('#datasource table table input:checkbox[checked]').each(function(){
		id = $(this).val();
		tbl = $('#showTable'+id).val();
		chart = $('#chartType'+id).val();
		datasource+=',{"DataSourceID":'+id+',"Tbl":'+tbl+',"ChartType":"'+chart+'"}';
	})
	datasource = '['+datasource.substr(1)+']';
	$('#rptDataSource').val($.toJSON(ds));
	$('#delIds').val(delIds.substr(1));
	return true;
}
function showReceiver(obj){
	if($(obj).val()==1){
		$('#receiverTr').css('display','');
	}else{
		$('#receiverTr').css('display','none');
	}
}
function viewDataSource(category,classname){
	$.get(WEB_ROOT+'report/'+category+'_datasource.php',{
		classname:classname
	},function(data){
		$('#datasourceDetail').html(data);
		if(ds[currId]!=undefined){
			var cols = ds[currId]['Cols'];
			if(cols != undefined){
//				alert("cols: " + cols);
				colset = $.evalJSON(cols);
				for(var key in colset){
					$('#tabcolumns option').each(function(){
						if($(this).val()== key)
						{
							$(this).remove();
						}
					});
					$("#tabcolumns_selected").append("<option value='"+key+"' onclick='setRemove()' ondblclick='remove()'>"+colset[key]+"</option");   
				}
			}
			var chartType = ds[currId]['ChartType'];
			if(chartType != undefined){
				$('input:[name=chartType]:radio:[value='+chartType+']').attr('checked','checked');
			}
			var filters = ds[currId]['Filter'];
			if(filters != undefined){
				for(var name in filters){
					$('[name='+name+']').val(filters[name]);
				}
			}
		}
	});
}
function add(){
	if($("#tabcolumns option:selected").length>0)   
　　　　{   
　　　　　　　　$("#tabcolumns option:selected").each(function(){   
　　　　　　　　　　　$("#tabcolumns_selected").append("<option value='"+$(this).val()+"' onclick='setRemove()' ondblclick='remove()'>"+$(this).text()+"</option");   
　　　　　　　　　　　$(this).remove();　   
　　　　　　　　})   
　　　　}   
　　　　else  
　　　　{   
　　　　　　　　alert("请选择要添加的列！");   
　　　　} 
}
function addAll(){
　　　　$("#tabcolumns option").each(function(){   
　　　　$("#tabcolumns_selected").append("<option value='"+$(this).val()+"' onclick='setRemove()' ondblclick='remove()'>"+$(this).text()+"</option");   
　　　　$(this).remove();　   
　})
}
function remove(){
	if($("#tabcolumns_selected option:selected").length>0)   
　　　　{   
　　　　　　　　$("#tabcolumns_selected option:selected").each(function(){   
　　　　　　　　　　　$("#tabcolumns").append("<option value='"+$(this).val()+"' onclick='setAdd()' ondblclick='add()'>"+$(this).text()+"</option");   
　　　　　　　　　　　$(this).remove();　   
　　　　　　　　})   
　　　　}   
　　　　else  
　　　　{   
　　　　　　　　alert("请选择要移除的列！");   
　　　　} 
}
function removeAll(){
	$("#tabcolumns_selected option").each(function(){   
　　　　　　　　$("#tabcolumns").append("<option value='"+$(this).val()+"' onclick='setAdd()' ondblclick='add()'>"+$(this).text()+"</option");   
　　　　　　　　$(this).remove();　   
　　　　　})
}
function moveUp(){
	if($("#tabcolumns_selected option:selected").length>0)   
　　　　{   
　　　　　　　　$("#tabcolumns_selected option:selected").each(function(){
					var idx = $("#tabcolumns_selected option").index(this);
					if(idx>0){
						$("#tabcolumns_selected option:eq("+(idx-1)+")").before("<option value='"+$(this).val()+"' onclick='setAdd()' ondblclick='add()' selected>"+$(this).text()+"</option");
						$(this).remove();
					}　   
　　　　　　　　})   
　　　　}   
　　　　else  
　　　　{   
　　　　　　　　alert("请选择要移动的列！");   
　　　　} 
}
function moveDown(){
	if($("#tabcolumns_selected option:selected").length>0)   
　　　　{   
　　　　　　　　$("#tabcolumns_selected option:selected").each(function(){
					var idx = $("#tabcolumns_selected option").index(this);
					if(idx<$("#tabcolumns_selected option").length-1){
						$("#tabcolumns_selected option:eq("+(idx+1)+")").after("<option value='"+$(this).val()+"' onclick='setAdd()' ondblclick='add()' selected>"+$(this).text()+"</option");
						$(this).remove();　   
					}
　　　　　　　　})   
　　　　}   
　　　　else  
　　　　{   
　　　　　　　　alert("请选择要移动的列！");   
　　　　} 
}

function setAdd(){
	$('#singleBtn').html('> ');
	document.getElementById('singleBtn').onclick=add;
}
function setRemove(){
	$('#singleBtn').html('< ');
	document.getElementById('singleBtn').onclick=remove;
	//$('#singleBtn').click(function(){remove();});
}
function deleteDataSources(id){
	delIds+=","+id;
}
function setDataSourceDetail(id){
	if(currId > 0){
		delIds+=","+id;
		delete(ds[currId]);
		var chkBox = $('#ds'+currId);
		if(chkBox.attr('checked')){
			var param = {};
			var cols = {};
			var tbl = 0;
			$("#tabcolumns_selected option").each(function(){
					cols[$(this).val()]=encodeURIComponent($(this).text());
					tbl = 1;
			});
			if(tbl == 1){				
				param['Tbl'] = 1;
				param['Cols'] = cols;
			}else
				param['Tbl'] = 0;
			param['ChartType'] = $('input:[name=chartType]:radio:checked').val();
			param['Filter'] = {};
			var idx = 0;
			$('#filters input:[type=text]').each(function(){
				param['Filter'][$(this).attr("name")]=$(this).val();
			});
			$('#filters select').each(function(){
				param['Filter'][$(this).attr("name")]=$(this).val();
			})
			ds[currId] = param;
		}
	}
	currId = id;
}
function changeDs(id){
	deleteDataSources(id);
	setDataSourceDetail(id);
}