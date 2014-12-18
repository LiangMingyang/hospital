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
 <script type="text/javascript">
<!--
$(function(){
//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "daily", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getDailyData"}, {"wmode":"opaque"} );
//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "hourly", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getHourlyData"}, {"wmode":"opaque"} );
//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "weekly", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getWeeklyData"}, {"wmode":"opaque"} );
//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "monthly", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getMonthlyData"}, {"wmode":"opaque"} );
//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "yearly", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getYearlyData"}, {"wmode":"opaque"} );
//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "session", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getSessionData"}, {"wmode":"opaque"} );
//	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "optype", "100%", "300", "9.0.0", "expressInstall.swf",{"get-data":"getOpData"}, {"wmode":"opaque"} );

	var serId = $("#serviceSelect").val();
	
	
	var byteURL = "<?php echo WEB_ROOT?>report/staticDetailSwf.php?action=1&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&service="+serId;
	var byte2URL = "<?php echo WEB_ROOT?>report/staticDetailSwf.php?action=2&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&service="+serId;
	var byte3URL = "<?php echo WEB_ROOT?>report/staticDetailSwf.php?action=3&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&service="+serId;
	var byte4URL = "<?php echo WEB_ROOT?>report/staticDetailSwf.php?action=4&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&service="+serId;
	var byte5URL = "<?php echo WEB_ROOT?>report/staticDetailSwf.php?action=5&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&service="+serId;
	var byte6URL = "<?php echo WEB_ROOT?>report/staticDetailSwf.php?action=6&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&service="+serId;
	var byte7URL = "<?php echo WEB_ROOT?>report/staticDetailSwf.php?action=7&startDate=<?php echo $startDate?>&endDate=<?php echo $endDate?>&service="+serId;

	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "daily", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":escape(byteURL)}, {"wmode":"opaque"} );
	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "hourly", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":escape(byte2URL)}, {"wmode":"opaque"} );
	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "weekly", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":escape(byte3URL)}, {"wmode":"opaque"} );
	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "monthly", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":escape(byte4URL)}, {"wmode":"opaque"} );
	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "yearly", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":escape(byte5URL)}, {"wmode":"opaque"} );
	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "session", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":escape(byte6URL)}, {"wmode":"opaque"} );
	swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "optype", "100%", "300", "9.0.0", "expressInstall.swf",{"data-file":escape(byte7URL)}, {"wmode":"opaque"} );
	
})
function getDailyData(){
	return JSON.stringify(<?php echo $daily_chart_str?>);
}
function getHourlyData(){
	return JSON.stringify(<?php echo $hourly_chart_str?>);
}function getWeeklyData(){
	return JSON.stringify(<?php echo $weekly_chart_str?>);
}
function getMonthlyData(){
	return JSON.stringify(<?php echo $monthly_chart_str?>);
}
function getYearlyData(){
	return JSON.stringify(<?php echo $yearly_chart_str?>);
}
function getSessionData(){
	return JSON.stringify(<?php echo $session_chart_str?>);
}
function getOpData(){
	return JSON.stringify(<?php echo $op_chart_str?>);
}
//-->
</script>
 <body>
 <h5 class="title102"><em>数据库审计信息统计</em><span>
<a class="tab" href="#visit">访问量</a>
<a class="tab" href="#opclass">操作类型</a>
</span></h5>
<div class="box102 p20">
	<form name="statForm" method="post">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                    	<td width="14%" class="td1">
                        	数据库
                        </td>
                        <td width="14%"><?php require "../cfg/services.php"?></td>
                        <td width="14%" class="td1">
							起止日期
                        </td>
                        <td width="14%"><input type="text" name="startDate" class="Wdate" onClick="WdatePicker()" value="<?php echo $startDate?>"></td>
                        <td><input type="text" name="endDate" class="Wdate" onClick="WdatePicker()" value="<?php echo $endDate?>"></td>
                       
                        <td width="14%" class="td1">关键字</td>
                        <td width="14%"><input type="text" value="<?php echo $keyword?>" name="keyword"></td>
                       <td colspan="5" align="right"><a onclick="document.statForm.submit();"class="tijiao" >查询</a></td>
                        </tr>
                    </tbody>
	</table></form>
</div>
<div class="bottom">
 <h5 class="title101"><em><?php echo ($keyword?"关键字\"<font color='yellow'>$keyword</font>\"统计":"非法访问统计")?></em></h5>
<div class="box102 p20">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab2">		
		<tr>
			<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
				<tbody>
					<tr><th><?php echo ($keyword?"出现次数":"报警次数")?></th><?php if(!$keyword){?><th>未审核的报警次数</th><?php }?><th>独立IP数</th><th>平均响应时间</th><th>会话数</th></tr>
					<tr><td><?php echo $total['RiskCount']?></td><?php if(!$keyword){?><td><?php echo $total['RiskCount']-$total['ConfirmCount']?></td><?php }?><td><?php echo $total['IpCount']?></td><td><?php echo $total['AvgResponseTime']?>ms</td><td><?php echo $total['SessionCount']?></td></tr>
				</tbody>
			</table>
			</td>			
		</tr>
		<tr>
		<td style="padding:10px" colspan="2"><div id="daily"></div></td>
		
       	</tr>
       	<tr>
       	<tr>
		<td style="padding:10px"><div id="hourly"></div></td>
		<td style="padding:10px"><div id="weekly"></div>
		</td>
       	</tr>
       	<tr>
       	<tr>
		<td style="padding:10px"><div id="monthly"></div></td>
		<td style="padding:10px"><div id="yearly"></div>
		</td>
       	</tr>
	</table>
</div>
</div>
<div class="bottom">
	<h5 class="title101"><em>访问量统计</em><a name="visit" id="visit"></a></h5>
	<div class="box102 p20">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab2">
		<tr>
		<td style="width:50%"><div id="session"></div></td>
		<td style="padding-right: 20px" valign="top">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
				<tbody>
					<tr><th>编号</th><th>来源IP</th><th>会话数</th></tr>
					<?php $i = 0;if($sessionCount){foreach ($sessionCount as $src){
					    if($i>10)break;
					?>
					<tr><td><?php echo ++$i?></td><td><?php echo $src['IP']?></td><td><?php echo $src['SessionCount']?></td></tr>
					<?php }}?>
				</tbody>
			</table>
		</td>
       	</tr>
	</table>
    </div>
</div>
<div class="bottom">
	<h5 class="title101"><em>操作信息统计</em><a name="opclass" id="opclass"></a></h5>
	<div class="box102 p20">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab2">
		<tr>
		<td style="padding:10px"><div id="optype"></div></td>
		<td style="padding:10px"><div id="opTime"></div></td>
       	</tr>
	</table>
    </div>
</div>
 </body>
 </html>