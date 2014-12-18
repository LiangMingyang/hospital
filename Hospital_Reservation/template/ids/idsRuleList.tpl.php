<?php
/**
 * idsRuleList.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-9,created by Xu Guozhi
 */
 ?>
 <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>
                                		<th></th>
                                    	<th>规则名称</th>
                                        <th>风险级别</th>
                                        <th>检测时间</th>
                                        <th>响应</th>
                                        <th class="border_r0">操作</th>
                                    </tr>
                                    	<?php if($list){ 
                                    	    $idx = -1;
                                    	    foreach($list as $rule){
                                    	    $idx++;
                                    	        ?>
                                    <tr>
                                    	<td><input type="checkbox" name="<?php echo substr($pageDiv,0,-4)?>Rule" onclick="check('<?php echo substr($pageDiv,0,-4)?>',<?php echo $idx?>)"<?php if($rule['RuleStatus']==1) echo 'checked'?>></td>
                                        <td><?php echo $rule['RuleName']?></td>
                                        <td><select name="risklevel" id="<?php echo substr($pageDiv,0,-4)?>RiskLevel<?php echo $idx?>"onchange="check('<?php echo substr($pageDiv,0,-4)?>',<?php echo $idx?>)">
                                        	<?php foreach($riskLevels as $riskLevel){?><option value="<?php echo $riskLevel['RiskLevel']?>" <?php if($rule['RiskLevel'] == $riskLevel['RiskLevel']) echo "selected"?>><?php echo $riskLevel['Description']?></option><?php }?>
                                        </select></td>
                                        <td><select name="activetime" id="<?php echo substr($pageDiv,0,-4)?>ActiveTime<?php echo $idx?>"onchange="check('<?php echo substr($pageDiv,0,-4)?>',<?php echo $idx?>)" style="width:100%">
                                        	<?php foreach($activeTimes as $activeTime){?><option value="<?php echo $activeTime['ActiveTimeID']?>" <?php if($rule['ActiveTimeID'] == $activeTime['ActiveTimeID']) echo "selected"?>><?php echo $activeTime['Description']?></option><?php }?>
                                        </select></td>
                                        <td><select name="action" id="<?php echo substr($pageDiv,0,-4)?>ActionId<?php echo $idx?>"onchange="check('<?php echo substr($pageDiv,0,-4)?>',<?php echo $idx?>)" style="width:100%">
                                        	<?php foreach($actions as $action){?><option value="<?php echo $action['ActionId']?>" <?php if($rule['ActionId'] == $action['ActionId']) echo "selected"?>><?php echo $action['Description']."-阻塞:".($action['Block']==1?"开":"关").";邮件报警:".($action['MailWarn']==1?"开":"关").";短信报警:".($action['SMSWarn']==1?"开":"关").";气泡报警:".($action['PopWarn']==1?"开":"关")?></option><?php }?>
                                        </select></td>
                                        <td class="border_r0"><a href="javascript:void(0)" onclick="showRule(<?php echo $rule['SubRuleId']?>,<?php echo $rule['RuleTypeID']?>)" class="neibu">查看</a></td>
                                        <input type="hidden" id="<?php echo substr($pageDiv,0,-4)?>RuleId<?php echo $idx?>" value="<?php echo $rule['RuleID'];?>"/>
                                        <input type="hidden" id="<?php echo substr($pageDiv,0,-4)?>SubRuleId<?php echo $idx?>" value="<?php echo $rule['SubRuleId'];?>"/>
                                         <?php if($rule['RuleStatus']==1) echo "<script>check('".substr($pageDiv,0,-4)."',$idx)</script>"?>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                           <?php echo $page->toString()?>