<?php
/**
 * 流量监控
 * traffic.tpl.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-21,created by Chenhuan
 */
include header_inc();
 ?>
<script type="text/javascript" src="<?php echo JS_PATH?>monitor/traffic.js"></script>
<body>
<div class="box102 p20">
  <!-- 查询区域 -->
	<form action="" method="post" id="searchForm" name="searchForm">
	<input type="hidden" name="searchFlagHidden" value="<?php echo $searchFlagHidden?>" id="searchFlagHidden"/>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
         <tbody>
                	<tr>
                		<td>数据库：
                			<select name="traffic-stat-dbserverip" id="traffic-stat-dbserverip" style="width: 150px;">
                				<option value="">全部数据库</option>
 								<?php 
                				foreach ($serverList as $ser) {
                					?>
                					<option value="<?php echo $ser['ServerIP']?>"><?php echo $ser['ServerName']?></option>
                					<?php 
                				}
                				?>
                			</select>
                		</td>
                		<td>
                		协议类型：
                			<select id="traffic-stat-protocol" name="traffic-stat-protocol">
                				<option value="">所有</option>
                				<?php 
                				foreach ($protocolList as $pro) {
                					if(($pro['Protocol']>=0 && $pro['Protocol']<=6)) {
                						?>
	                					<option value="<?php echo $pro['Protocol']?>"><?php echo $pro['Name']?></option>
	                					<?php 
                					}
                				}
                				?>
                			</select>
                		</td>
                		<td>开始时间：
                			<input name="traffic-stat-startdate" id='traffic-stat-startdate' value='<?php echo $condition['start_date']?>' class="Wdate" onClick="WdatePicker()" type="text">
                		</td>
               		    <td>结束时间：
               		    	<input name="traffic-stat-enddate" id='traffic-stat-enddate' value='<?php echo $condition['end_date']?>' maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
                        </td>              
                		<td align="right">
                			<!-- 
                			<input type="button" class="neibu" id="searchButton" name="searchButton" value="查询" onclick="reload();">
                			 -->
                			<a href="#" id="searchButton" name="searchButton" class="neibu" onclick="reload();">查询</a>
                		</td>      
                      </tr>
                      <tr>
				  		<td colspan="4">
				  			<span id="searchInfo">
				  			全部结果显示：
				  			</span>
				  			<input type="radio" name="chartTypeRadio" class="chartTypeRadio" id="traffic-stat-bar" value="1" checked="checked"/>柱状图
				  			<input type="radio" name="chartTypeRadio" class="chartTypeRadio" id="traffic-stat-pie" value="2"/>饼图
				  			<input type="radio" name="chartTypeRadio" class="chartTypeRadio" id="traffic-stat-line" value="3"/>峰值图
				  		</td>
				  		<!-- 
				  		<td align="right">
				  			<input type="button" class="neibu" id="searchAllButton" name="searchAllButton" value="显示全部" onclick="reloadAll();">
				  		</td>
				  		 -->
				  	</tr>
		</tbody>
	</table>
  </form>
</div>

<div class="bottom">
	<h5 class="title101"><em>流量</em></h5>
	<div class="box102 p20">
	<table>
		<tr>
			<td>
				<div id='traffic-stat-chart1'></div>
			</td>
		</tr>
	</table>
    </div>
</div>
<div class="bottom">
	<h5 class="title101"><em>数据包</em></h5>
	<div class="box102 p20">
	<table>
		<tr>
			<td>
				<div id='traffic-stat-chart2'></div>
			</td>
		</tr>
	</table>
    </div>
</div>

<script type="text/javascript">
var byteURL = "<?php echo WEB_ROOT?>monitor/traffic.php?action=byte_bar_data&start_date=<?php echo $condition['start_date']?>&end_date=<?php echo $condition['end_date']?>";
var packageURL = "<?php echo WEB_ROOT?>monitor/traffic.php?action=package_bar_data&start_date=<?php echo $condition['start_date']?>&end_date=<?php echo $condition['end_date']?>";
swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "traffic-stat-chart1", "980", "280", "9.0.0", "expressInstall.swf", {"data-file":byteURL}, {"wmode":"opaque"} );
swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "traffic-stat-chart2", "980", "280", "9.0.0", "expressInstall.swf", {"data-file":packageURL}, {"wmode":"opaque"} );

var chart1 = $('#traffic-stat-chart1');
var chart2 = $('#traffic-stat-chart2');

$(function(){
//	reload();
	$(".chartTypeRadio").click(function(){
		var flag = $("#searchFlagHidden").val();
		if(flag == 0) { //all
			reloadAll();
		} else {
			reload();
		}
	});
});

function reloadAll() {
	$("#searchFlagHidden").val(0);
	$("#searchInfo").html('全部结果显示：');
   	var ids = new Array('traffic-stat-bar', 'traffic-stat-pie', 'traffic-stat-line');
//   	var chartTypeRadio = $("input:[name=chartTypeRadio]:radio:checked");  
//   	alert("chartTypeRadio:" + chartTypeRadio+chartTypeRadio.attr("id"));
//   	reloadChart(chartTypeRadio, true);
   	for(var i = 0; i < 3; i++) {
   	   	var field = document.getElementById(ids[i]);
   	   	if (field.checked) {
			reloadChart(field, false);
			break;
   	   	}
   	}
}

function reload() {
	$("#searchFlagHidden").val(1);
	$("#searchInfo").html('查询结果显示：');
   	var ids = new Array('traffic-stat-bar', 'traffic-stat-pie', 'traffic-stat-line');
//   	var chartTypeRadio = $("input:[name=chartTypeRadio]:radio:checked");  
//   	alert("chartTypeRadio:" + chartTypeRadio+chartTypeRadio.attr("id"));
//   	reloadChart(chartTypeRadio, true);
   	for(var i = 0; i < 3; i++) {
   	   	var field = document.getElementById(ids[i]);
   	   	if (field.checked) {
			reloadChart(field, true);
			break;
   	   	}
   	}
}

function reloadChart(field, checked) {
	var action1 = '';
   	var action2 = '';
   	if (field.id == 'traffic-stat-bar') {
   	   	action1 = 'byte_bar_data';
   	   	action2 = 'package_bar_data';
   	} else if (field.id == 'traffic-stat-pie') {
   	   	action1 = 'byte_pie_data';
   	   	action2 = 'package_pie_data';
   	} else if (field.id == 'traffic-stat-line') {
   	   	action1 = 'byte_line_data';
   	   	action2 = 'package_line_data';
   	} 
   	if (checked) { //查询部分
   	   	
		var dbServerIp = $("#traffic-stat-dbserverip").val();
		var protocol = $("#traffic-stat-protocol").val();
		var startDate = $("#traffic-stat-startdate").val();
		var endDate = $("#traffic-stat-enddate").val();	
		
	    $.ajax({ 
	    	url : 'traffic.php', 
			type:'post',
			dataType:'text',
	    	data : { 
	    		action : action1,
	    		'condition[db_server_ip]': dbServerIp,
	    		'condition[protocol]': protocol,
	    		'condition[start_date]' : startDate,
	    		'condition[end_date]' : endDate
	    	}, 
	    	success : function(response) { 
	    		tmp = findSWF("traffic-stat-chart1");
	    	    x = tmp.load(response);
	    	}
	    });
	    $.ajax({ 
	    	url : 'traffic.php',
	    	type:'post',
			dataType:'text',
	    	data : { 
	    		action : action2,
	    		'condition[db_server_ip]': dbServerIp,
	    		'condition[protocol]': protocol,
	    		'condition[start_date]' : startDate,
	    		'condition[end_date]' : endDate
	    	}, 
	    	success : function(response) { 
//		    	alert(response);
//	    		chart2.append(response.responseText);
	    		tmp = findSWF("traffic-stat-chart2");
	    	    x = tmp.load(response);
	    	}
	    });	    
   	} else {
   		$.ajax({ 
	    	url : 'traffic.php', 
			type:'post',
			dataType:'text',
	    	data : { 
	    		action : action1
	    	}, 
	    	success : function(response) { 
	    		tmp = findSWF("traffic-stat-chart1");
	    	    x = tmp.load(response);
	    	}
	    });
   		$.ajax({ 
	    	url : 'traffic.php',
	    	type:'post',
			dataType:'text',
	    	data : { 
	    		action : action2
	    	}, 
	    	success : function(response) { 
//		    	alert(response);
//	    		chart2.append(response.responseText);
	    		tmp = findSWF("traffic-stat-chart2");
	    	    x = tmp.load(response);
	    	}
	    });	    
   	}
}
</script>
          
 </body>
 </html>