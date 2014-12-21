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
		url:"report/alarm.php",
		type:"post",
		dataType:"json",
		success:function(data){
			var count = data.length;
			var innerHTML = "";
			for(var i=0;i<count;i++) {
				var item = data[i];
				innerHTML += "<tr>";
				innerHTML += "<td>"+ item.DstIP + ":" + item.Protocol + ":" + item.ServiceName + "</td>";
				innerHTML += "<td>"+ item.RiskCount + "</td>";
				innerHTML += "<td>"+ (item.RiskCount-item.ConfirmCount) + "</td>";
				innerHTML += "<td>"+ item.IpCount + "</td>";
				innerHTML += "</tr>";
			}
			$('#alarmInfoTbody').append(innerHTML);
			if(count > 0) {
				$( "#alarmDialog" ).dialog( "open" );
			}
		}
	});
});