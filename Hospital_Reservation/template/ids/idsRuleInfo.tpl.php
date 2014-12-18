<?php
/**
 * idsRuleInfo.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-17,created by Xu Guozhi
 */
 ?>
 <table width="100%" cellspacing="0" cellpadding="0" class="tab2">
 	<tr>
 		<th>规则名称</th>
 		<td><?php echo $rule[0]['RuleName']?></td>
 	</tr>
 	<tr>
 		<th>数据库</th>
 		<td><?php echo $rule[0]['ServerName']?>:<?php echo $rule[0]['Protocol']?>:<?php echo $rule[0]['ServiceName']?></td>
 	</tr>
 	<tr>
 		<th>规则类型</th>
 		<td><?php echo $rule[0]['RuleType']?></td>
 	</tr>
	<tr>
 		<th>说明</th>
 		<td colspan="3">
 	<?php if($ruleType>=RULE_TYPE_MINING_MIN && $ruleType <= RULE_TYPE_MINING_MAX){
 		$showStr = "";
 		if(strlen(trim($rule[0]['UserName'])) > 0){
			$showStr .= "用户:".$rule[0]['UserName'];
		}
		
		if((strlen(trim($rule[0]['OpDate'])) > 0)||(strlen(trim($rule[0]['OpTime'])) > 0)){
			if(strlen(trim($showStr))>0){
				$showStr.=",";
			}
			$showStr .= "操作时间:".translate($rule[0]['OpDate']).translate($rule[0]['OpTime']);
		}
 		if((strlen(trim($rule[0]['IPRange'])) > 0)){
			if(strlen(trim($showStr))>0){
				$showStr.=",";
			}
			$showStr .= "操作IP:".translate($rule[0]['IPRange']);
		}
		
 	   	if((strlen(trim($rule[0]['OpClass'])) > 0)||(strlen(trim($rule[0]['OpObject'])) > 0)){
			if(strlen(trim($showStr))>0){
				$showStr.=",";
			}
			$showStr .= "操作方式:[";
			if((strlen(trim($rule[0]['SqlType'])) > 0) && (strlen(trim($rule[0]['OpObject'])) > 0)){
				$showStr .= $rule[0]['SqlType'].":".$rule[0]['OpObject'];
			}elseif(strlen(trim($rule[0]['SqlType'])) > 0){
				$showStr .= $rule[0]['SqlType'];
			}else{
				$showStr .= $rule[0]['OpObject'];
			}
			$showStr .= "]";
		}
		
		echo $showStr;
 	}
 	?>
 		</td>
 </tr>
 </table>
 <input type="hidden" name="ruleIdHidden" id="ruleIdHidden" value="<?php echo $rule[0]['RuleID']?>"/>