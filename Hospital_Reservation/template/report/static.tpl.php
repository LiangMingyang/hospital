<?php
/**
 * report.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-16,created by Xu Guozhi
 */
include header_inc();
 ?>
<script type="text/javascript" src="<?php echo JS_PATH?>monitor.js"></script>
<script type="text/javascript">
function checkAll(){
	flag = $("#checkAll").attr("checked");
	if(flag == 'checked')
		$("input[name='rptType']").attr("checked",flag);
	else
		$("input[name='rptType']").removeAttr("checked");
}
function uncheckAll(obj){
	flag = obj.checked;
	if(flag){
		types = document.getElementsByName("rptType");
		for(var i = 0; i < types.length; ++i){
			if(!types[i].checked)
				return;
		}
		document.getElementById("checkAll").checked = true;
	}else
		document.getElementById("checkAll").checked = false;

}

function searchClick() {
	$("#searchHidden").val(1);
	document.statForm.submit();
	}

$(function(){
	var byteURL = "<?php echo WEB_ROOT?>report/staticSwf.php?action=1&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&searchHidden=<?php echo $searchFlag?>";
	var byte2URL = "<?php echo WEB_ROOT?>report/staticSwf.php?action=2&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&searchHidden=<?php echo $searchFlag?>";

//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf?r="+Math.random()*100000, "flow", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getRiskData"},{"wmode":"opaque"} );
//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf?r="+Math.random()*100000, "traffic", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getTrafficData"}, {"wmode":"opaque"} );
	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf?r="+Math.random()*100000, "flow", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":byteURL},{"wmode":"opaque"} );
	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf?r="+Math.random()*100000, "traffic", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":byte2URL}, {"wmode":"opaque"} );
	
})
function getRiskData(){
	return JSON.stringify(<?php echo $chart->toPrettyString()?>);
}
function getTrafficData(){
	return JSON.stringify(<?php echo $trafficchart->toPrettyString()?>);
}
</script>
 <body>
<h5 class="title102"><em>数据库审计信息统计</em></h5>
<div class="box102 p20">
<form name="statForm" method="post">
<input type="hidden" name="searchHidden" id="searchHidden" value="<?php echo $searchFlag?>"/>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                    	<td align="center">
                        	数据库:<?php require "../cfg/services.php"?>&nbsp;&nbsp;
                        	开始日期：<input name="startDate" type="text"class="Wdate" onClick="WdatePicker()" value="<?php echo $startDate?>">&nbsp;&nbsp;
						结束日期：<input name="endDate" type="text"class="Wdate" onClick="WdatePicker()" value="<?php echo $endDate?>">&nbsp;&nbsp;
                       	<a href="javascript:void(0)" class="neibu" onclick="searchClick();">查询</a>
                       </td>
                        </tr>
                    </tbody>
	</table></form>
</div>
<div class="bottom">
 <h5 class="title101"><em>非法访问</em></h5>
<div class="box102 p20">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab2">
		<tr>
			<td style="width:50%"valign="top">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
				<tbody>
					<tr><th>编号</th><th>数据库</th><th>风险次数</th><th>未审核的风险次数</th><th>IP数</th></tr>
					<?php if($risk){
					for($i=0;$i<count($risk);$i++){
					    $r = $risk[$i];
					?>
					<tr class='risk<?php echo $i+1?>'>
						<td><?php echo $i+1?></td>
						<td><?php echo ($r['DstIP']).":".$r['Protocol'].":".$r['ServiceName']?></td>
						<td><?php echo $r['RiskCount']?></td>
						<td><?php echo $r['RiskCount']-$r['ConfirmCount']?></td>
						<td><?php echo $r['IpCount']?></td>
					</tr>
					<?php }}?>
				</tbody>
			</table>
			</td>
			<!-- 图表位于表格的右侧 -->
			<!-- 
			<td valign="top"><div id="flow"></div></td>
			 -->
			</tr>
		</table>
		<table style="width:100%;">
		<tr>
		<td valign="top"><div id="flow"></div></td>
		</tr>
		</table>
</div>
</div>
<div class="bottom">
	<h5 class="title101"><em>访问量</em></h5>
	<div class="box102 p20">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab2">
		<tr>
		<td valign="top">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
				<tbody>
					<tr><th>编号</th><th>IP</th><th>会话数</th><th>上行流量</th><th>下行流量</th><!-- <th>平均响应时间</th> --></tr>
					<?php if($traffic){					
					    for($i = 0; $i < count($traffic); $i++){
					    $t = $traffic[$i];
					    ?>
					<tr><td><?php echo $i+1?></td>
					<!-- 
					<td><?php echo ($t['DstIP']).":".$t['Protocol'].":".$t['ServiceName']?></td>
					 -->
					<td><?php echo ($t['DstIP'])?></td>
					<td><?php echo $t['SessionCount']?></td>
					<td><?php $divider = 1;
		$unit = ' (Bytes)';	
		if ($t['SendBytes'] > 100000000)
		{
	    	$divider = 1000000;
	    	$unit = ' (MB)';
		}
		else if ($t['SendBytes'] > 100000)
		{
	    	$divider = 1000;
	    	$unit = ' (KB) ';
		}echo $t['SendBytes']/$divider.$unit?></td><td><?php $divider = 1;
		$unit = ' (Bytes)';	
		if ($t['RecvBytes'] > 100000000)
		{
	    	$divider = 1000000;
	    	$unit = ' (MB)';
		}
		else if ($t['RecvBytes'] > 100000)
		{
	    	$divider = 1000;
	    	$unit = ' (KB) ';
		}echo $t['RecvBytes']/$divider.$unit?></td>
					<!-- 
					<td><?php echo round($t['AvgResponseTime'],2)?>ms</td>
					 -->
					</tr>
					<?php }}?>
				</tbody>
			</table>
		</td>
		<!-- 图表位于表格的右侧 -->
		<!-- 
		<td style="width:50%"><div id="traffic"></div></td>
		 -->
       	</tr>
	</table>
	<table style="width:100%">
	<tr>
	<td><div id="traffic"></div></td>
	</tr>
	</table>
    </div>
</div>
<script type="text/javascript">
</script>
 </body>
 </html>