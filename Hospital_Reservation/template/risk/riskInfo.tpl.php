<?php
/**
 * riskInfo.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-17,created by Xu Guozhi
 */
 ?>
 <table  width="100%" border=1 cellspacing="0" cellpadding="0" class="tab2" >
 	<tr >
 		<th width="10%">匹配的规则</th>
 		<td width="40%"><?php echo $risk['RuleName']?></td>
 		<th width="10%">规则类型</th>
 		<td width="40%"><?php echo $risk['RuleTypeName']?></td>
 	</tr>
 	<tr>
		<th  width="20%">规则详细内容</th>
		<td  width="80%" colspan="3"><?php echo $risk['RuleContent']?></td>
	</tr>
	<tr>
		<th width="10%">数据库服务器地址</th>
		<td width="40%"><?php echo ($risk['DstIP'])?></td>
		<th width="10%">数据库</th>
		<td width="40%"><?php echo $risk['ServiceName']?></td>
	</tr>
	<tr>
		<th width="10%">协议类型</th>
		<td width="40%"><?php echo $risk['Description']?></td>
		<th width="10%">数据库操作类型</th>
		<td width="40%"><?php echo $risk['OpClass']?></td>
	</tr>
	<tr>
		<th width="10%">客户端地址</th>
		<td width="40%"><?php echo ($risk['SrcIP'])?></td>
		<th width="10%">登录名</th>
		<td width="40%"><?php echo $risk['LoginName']?></td>
	</tr>
	<tr>
		<th width="20%">SQL语句内容</th>
		<td width="80%" colspan="3"><?php echo $risk['SqlString']?></td>
	</tr>
	<tr>
		<th  width="10%">执行时间</th>
		<td  width="40%"><?php echo $risk['ExecTime']?></td>
		<th  width="10%">执行结果</th>
		<td  width="40%"><?php echo ($risk['ExecResult']==1?"成功":"失败")?></td>
	</tr>
	<!-- 
	<tr>
		<th>风险等级</th>
		<td><img src="<?php echo IMAGE_PATH?>risklevel<?php echo $risk['RiskLevel']?>.gif"/>(<?php echo $risk['RiskLevel']==1?"低风险":($risk['RiskLevel']==2?"中风险":"高风险")?>)</td>
		<th>是否合法</th>
		<td><?php switch($risk['Legality']){case 0:echo "非法";break;case 1:"合法";break;default:"未知";}?></td>
	</tr>
	 -->
	<tr>
		<th width="20%">审核状态</th>
		<td width="80%" colspan="3">
		<?php 
		if($risk['IsProcessed']==0){
			?>
			<font color='red'>未审核</font>
			<?php 
		}
		if($risk['IsProcessed']==2){
			?>
			<font color='green'>已审核(非风险)</font>
			<?php 
		}
		if($risk['IsProcessed']==1){
			?>
			<font color='green'>已审核(风险)</font>
		</td>
		<?php 
		}?>
	</tr>
	<?php 
	if($risk['IsProcessed']==1){
		?>
	<tr>
		<th width="20%">风险等级</th>
		<td width="80%" colspan="3"><img src="<?php echo IMAGE_PATH?>risklevel<?php echo $risk['RiskLevel']?>.gif"/>(<?php echo $risk['RiskLevel']==1?"低风险":($risk['RiskLevel']==2?"中风险":"高风险")?>)</td>
	</tr>
		<?php
	}
	?>
 </table>