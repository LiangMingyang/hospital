
$(function(){
	/*弹出对话框-提示未审核报警信息*/
	$( "#alarmDialog" ).dialog({
		autoOpen: false,
		resizable: true,
		height:300,
		width:500,
		title:"气泡报警信息",
		modal: true,
		buttons: {
			"确定": function() {
				$( this ).dialog( "close" );
			}
			
		}
	});

	//查询获取报警统计信息
	$.ajax({

		url: "/report/alarm.php",
		type:"post",
		dataType:"json",
		success:function(data){
			var data_risk=data['risk'];
			var count = data_risk.length;
			var innerHTML = "";
			for(var i=0;i<count;i++) {
				var item = data_risk[i];
				innerHTML += "<tr>";
				innerHTML += "<td>"+ item.DstIP + ":" + item.Protocol + ":" + item.ServiceName + "</td>";
				innerHTML += "<td>"+ item.RiskCount + "</td>";
				innerHTML += "<td>"+ (item.RiskCount-item.ConfirmCount) + "</td>";
				innerHTML += "<td>"+ item.IpCount + "</td>";
				innerHTML += "</tr>";
			}
			var data_disk=data['disk'];
			data_disk/=1024*1024*1024;
            data_disk=Math.floor(data_disk);
			innerHTML +="<tr>";
			innerHTML += "<td>"+"当前磁盘剩余空间为： "+data_disk + "GB(小于10G建议清理)</td>";
			innerHTML += "<td>清理后的目标剩余空间"+"<select id='free_space'>"
			                   +"<option>10G</option>"
							   +"<option>20G</option>"
							   +"<option>50G</option>"
							   +"<option>100G</option>"
							   +"<option>500G</option>"
								  "</select>"+"</td>";
            innerHTML += "<td>"+"<input type='button' onclick='clear_disk()' value='清理磁盘' />"+ "</td>";
			innerHTML += "<td>"+"<input type='button' onclick='close_engine()' value='关闭引擎' />"+ "</td>";
            innerHTML +="</tr>";
			$('#alarmInfoTbody').append(innerHTML);
			if(count > 0) {
				$( "#alarmDialog" ).dialog( "open" );
			}
		},
		error:function(data){
			alert("error");
		}
	});
});
function clear_disk(){
	var freespace=$('#free_space').val();
	var url=WEB_ROOT+"cfg/clear_disk.php?free_space="+freespace;
	$.ajax({
		url:url,
		type:'POST',
		datatype:'text',
		success: function(data){
		 var res=Math.floor(data/1024/1024/1024);
		 //alert(data);
            alert("清理成功,剩余磁盘容量为"+res+"GB");
			/*
			var dialog=art.dialog({
    						title: "系统消息",
    						content: "清理成功,剩余磁盘容量为"+data,
    						icon: 'succeed',
      				        ok:function(){return true;},
      				        okVal:'确定',
                           resize:false
                           });
						   */
			
		},
		error: function(data){
			alert("与服务器交互失败");
			/*
			var dialog=art.dialog({
    						title: "系统消息",
    						content: "与服务器交互失败，失败信息"+data,
    						icon: 'fail',
      				        ok:function(){return true;},
      				        okVal:'确定',
                           resize:false
                           });
						   */
		 

		}
		
		
	});
}
function close_engine(){

	$.get(WEB_ROOT+'cfg/backend.php?cmd=stop','',function(data){
	}
	);
	 $.get(WEB_ROOT+'cfg/backend.php?cmd=check&ps=auditor','',function(data){
		 if(data == 'RUNNING'){
			 alert("异常，无法关闭引擎");
			 }else{
				 alert("引擎已经关闭！");
			}
		});
}