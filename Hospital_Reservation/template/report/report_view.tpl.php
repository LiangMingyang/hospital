<?php
/**
 * report_view.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-6-28,created by Xu Guozhi
 */
require_once dirname(__FILE__).'/'.'../../include/cfg_rights_analyse.class.php';

 $DBHosts = 0;
 $DBEvents = 0;
 $riskEvents = 0;
 $high = 0;
 $mid = 0;
 $low = 0;
 $LAUser = 0;
 $NAUser = 0;
 $Unlimits = 0;
 $Unexpt = '0%';
 
if($dsList)
{
	for ($i = 0; $i < count($dsList);$i++)
	{
		$aDs = $dsList[$i]; 
		$datasource = new $aDs['ClassName'];
		if( $datasource->title == '审计事件' ){
			$data = $datasource->getData($startDate,$endDate);
			if( $data ){
				$DBHosts = count($data);
				foreach( $data as $item ){
					$DBEvents += $item['SessionCount'];
				}
			}
		}
		else if( $datasource->title == '报警事件' ){
			$data = $datasource->getData($startDate,$endDate);
			if( $data ){
				foreach( $data as $item ){
					$riskEvents += $item['RiskCount'];
				}
			}
		}
		else if( $datasource->title == '风险等级' ){
			$data = $datasource->getData($startDate,$endDate);
			if( $data ){
				foreach( $data as $item ){
	        		$c = $item['riskCount'];
					if($item['riskLevel'] == 0) {	        			
					} else if($item['riskLevel'] == 1) {
						$low += $c;	
					} else if($item['riskLevel'] == 2) {
						$mid += $c;	
					} else {
						$high += $c;	
					} 
				}
			}
		}
		else if( $datasource->title == '用户权限评估' ){
			$data = $datasource->getDataForBigPrivilege();
			$Unlimits = count($data);
		}
		else if( $datasource->title == '长时间未活动用户' ){
			$data = $datasource->getData($startDate,$endDate);
			$LAUser = count($data);
		}
		else if( $datasource->title == '从未活动过用户' ){
			$data = $datasource->getData($startDate,$endDate);
			$NAUser = count($data);
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title><?php echo $template['TplName']?></title>
</head>
<body>
<div style="width:649px;">
<div id="head" style="width:100%;border-bottom:1px solid #E3E3E3">
	<div id="title" style="width:100%;text-align:center;font-size: 30;color: #006599;font-family:微软雅黑;">
	<?php echo $template['TplName'] ?>
	</div>
</div>
<div style="text-align:center;">
	<table border="0" style="margin:auto;width:50%;">
	<tr><td align="right">报表类型：</td><td align="left">日报表</td></tr>
	<tr><td align="right">制作单位：</td><td align="left">国家电网</td></tr>
	<tr><td align="right">制作人：</td><td align="left">系统管理员</td></tr>
	<tr><td align="right">制作时间：</td><td align="left"><?php echo date('Y-m-d H:i:s') ?></td></tr>
	<tr><td align="right">起始时间：</td><td align="left"><?php echo $startDate.' 00:00:00' ?></td></tr>
	<tr><td align="right">结束时间：</td><td align="left"><?php echo $endDate.' 23:59:59' ?></td></tr>
	</table>
</div>
<div id="summarize" >
	<div  style="width:100%;font-size: 24p;color: #006599;font-family:微软雅黑;" >
	概述
	</div>
	<div>
	&nbsp;&nbsp;&nbsp;&nbsp;数据库审计系统在 <?php echo $startDate.' 00:00:00'; ?> 至 <?php echo $endDate.' 23:59:59'; ?> 期间共监测 <?php echo $DBHosts; ?> 台数据库主机，主机访问次数共计 <?php echo $DBEvents; ?> 次，存在风险的事件共计 <?php echo  $riskEvents; ?> 条。
	<p>其中高级风险事件 <?php echo $high; ?> 条；<br>
	&nbsp;&nbsp;&nbsp;&nbsp;中级风险事件 <?php echo $mid; ?> 条；<br>
	&nbsp;&nbsp;&nbsp;&nbsp;低级风险事件 <?php echo $low; ?> 条；</p>
	</div>
	<div>
	&nbsp;&nbsp;&nbsp;&nbsp;同期长期未活动用户数 <?php echo $LAUser; ?>，从未活动用户数 <?php echo $NAUser; ?>；权限设置过大的用户有 <?php echo $Unlimits; ?> 名。
	</div>

</div>

<div id="content">
	<?php if($dsList){
	    $count=count($dsList);
        for ($i = 0; $i < $count;$i++){
             $aDs = $dsList[$i]; 
            $datasource = new $aDs['ClassName'];
            if($aDs['Tbl']==1){
                $datasource->is_show = true;
//                $datasource->columns=json_decode($aDs['Cols'],true);
            }else
                $datasource->is_show = false;
            	$datasource->filters = json_decode($aDs['Filter'],true);
            	$datasource->setStartDate($startDate);
            	$datasource->setEndDate($endDate);
            ?>
            <div id="item<?php echo $i?>">
            	<div style="width:100%;font-size: 24p;color: #006599;font-family:微软雅黑;">
            	<?php echo ($i+1).".  ".$datasource->title?>
            	</div>
            	<div>
            	<?php echo $datasource->getDescription()?>
            	</div>
            	<div>
            	<?php if($aDs['ClassName']=='Privilege_DataSource'){
            		if($datasource->is_show){
            			echo $datasource->toTable();
            		}
            		if($aDs['ChartType']){
            			$url = $datasource->getChart($aDs['ChartType']);
            			//      			echo '<img src="http://'.$_SERVER["SERVER_NAME"].WEB_ROOT.'report/report_image/1344297090.jpg"/>';
            			if($url) {
            				echo '<table width="100%"><tr><td align="center"><img src="http://'.$_SERVER["SERVER_NAME"].WEB_ROOT.'report/'.$url.'"/></td></tr></table>';
            				//					} else {
            				//						echo '没有数据可以显示！';
            			}
            		}
            		$privilegeServiceDB = new RightAnalyse();
            		$services = $privilegeServiceDB->findServices(); //找到配置了权限挖掘计划的serviceI列表
            		
            		foreach ($services as $serviceObj){
            			echo "以下为".$serviceObj['ServerName'].":".$serviceObj['Protocol'].":".$serviceObj['ServiceName']."的用户权限评估及聚类结果.";
            			echo "<br />";
            			echo "<br />";
            			$targetserviceid=$serviceObj['ServiceId'];
            			echo $datasource->toTableDetails($targetserviceid);
            			echo "<br />";
            			$url = $datasource->getChartDetails($targetserviceid);
            			if($url) {
            				echo '<table width="100%"><tr><td align="center"><img src="http://'.$_SERVER["SERVER_NAME"].WEB_ROOT.'report/'.$url.'"/></td></tr></table>';
            			}
            		}
            		echo "<br />";
            		echo "以下表格中列出的为各用户所使用的权限与数据库为其设置的权限的对比。";
            		echo "<br />";
            		echo $datasource->toTablePrivilegeCompare();
            		echo "<br />";
            		echo "<br />";
            		echo "下面将权限设置确实过大的用户单独列出：";
            		echo "<br />";
            		echo "<br />";
            		echo $datasource->toTableBigPrivilege();
            		echo "<br />";
            		$url = $datasource->toBarChartBigPrivi();
            		if($url) {
            			echo '<table width="100%"><tr><td align="center"><img src="http://'.$_SERVER["SERVER_NAME"].WEB_ROOT.'report/'.$url.'"/></td></tr></table>';
            		}
            	}else{
            		if($datasource->is_show){
            	    echo $datasource->toTable();
            	}?>
            	</div>
            	
            	<?php if($aDs['ClassName']=="AuditOverView_DataSource"){?>
            		<div>
            		    <?php echo $datasource->getDescriptionDetail();?>
            		</div>
            		<div>
            			<?php echo $datasource->toTableDetail();?>
            		</div>
            	<?php } ?>
            	
            	<div style="width:100%;text-align:right;">
            	<br />
            	<br />
            	<?php 
            	if($aDs['ChartType']){
            	$url = $datasource->getChart($aDs['ChartType']);
//      			echo '<img src="http://'.$_SERVER["SERVER_NAME"].WEB_ROOT.'report/report_image/1344297090.jpg"/>';
					if($url) {
						echo '<table width="100%"><tr><td align="center"><img src="http://'.$_SERVER["SERVER_NAME"].WEB_ROOT.'report/'.$url.'"/></td></tr></table>';
//					} else {
//						echo '没有数据可以显示！';
					}
            	}
            	?>
            	</div>
            </div>
            
            <?php if($aDs['ClassName']=="AuditTraffic_DataSource"){?>
            		<div>
            		    <?php 
            		    $urlArray = $datasource->getTrafficLineChart ();
            		    foreach ($urlArray as $url){
            		    	if($url) {
            		    		echo '<table width="100%"><tr><td align="center"><img src="http://'.$_SERVER["SERVER_NAME"].WEB_ROOT.'report/'.$url.'"/></td></tr></table>';
            		    	}
            		    }
            		    ?>
            		</div>
            <?php } ?>
            
            
            <?php }
        }
            	}?>
</div>
</div>
</body>
</html>