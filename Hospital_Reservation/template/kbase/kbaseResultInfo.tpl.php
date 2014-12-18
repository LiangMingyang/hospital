<?php
/**
 * kbaseResultInfo.tpl.php-.
 * ---------------------
 * 2014-5-13,created by zhangxin
 */
 ?>
 <table width="100%" cellspacing="0" class="tab2">
 	<tr>
 		<th>SQL操作ID</th>
 		<td><?php echo $kResult['SinjID']?></td>
 		<th>数据库操作ID</th>
 		<td><?php echo $kResult['OpID']?></td>
 	</tr>
 	<tr>
		<th>SQL语句</th>
		<td colspan="3"><?php echo $kResult['SqlString']?></td>
	</tr>
	<tr>
		<th>数据库类型</th>
		<td><?php foreach ($protocolList as $pro) {
		if($pro['Protocol']==$kResult['Protocol']) {
			echo $pro['Name'];
			break;
		}
	   }?></td>
		<th>登录名</th>
		<td><?php echo $kResult['LoginName']?></td>
	</tr>
	<tr>
		<th>源IP</th>
		<td><?php echo $kResult['SrcIP']?></td>
		<th>风险等级</th>
		<td><?php foreach ($riskLevelList as $risk) {
		if($risk['RiskLevel']==$kResult['RiskLevel']) {
			echo $risk['Description'];
			break;
		}
	    }?></td>
	</tr>
	<tr>
		<th>禁用IP</th>
		<td><?php echo ($kResult['VIp'])?></td>
		<th>用户创建漏洞函数</th>
		<td><?php echo $kResult['VUserFuncName']?></td>
	</tr>
	<tr>
		<th>数据库漏洞函数</th>
		<td><?php echo $kResult['VFunctionName']?></td>
		<th>SQL注入语句ID</th>
		<td><?php echo $kResult['VSQLInjID']?></td>
	</tr>
 </table>