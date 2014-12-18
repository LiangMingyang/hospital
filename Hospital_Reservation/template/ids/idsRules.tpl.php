<?php
/**
 * idsRules.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-9,created by Xu Guozhi
 */
include header_inc();
 ?>
 <script>
 serviceId='<?php echo $serviceId?>';
 var RULE_TYPE_MINING = <?php echo RULE_TYPE_MINING?>;
 var RULE_TYPE_RIGHT = <?php echo RULE_TYPE_RIGHT?>;
 var RULE_TYPE_BUILTIN = <?php echo RULE_TYPE_BUILTIN?>; 
 </script>
 <script type="text/javascript" src="<?php echo JS_PATH?>ids.js?2"></script>
 <body>
  <div>
	<div><h5 class="title102">
                    	<form name="idsRulesForm" method="post" action="?cmd=query">
                    	<em>数据库:<?php require "../cfg/services.php"?>
                    		 <a href="javascript:void(0)" onclick="idsRulesForm.submit()" class="neibu">刷新</a></em>
                    		<div style="float: right; margin-right: 5px;margin-top: 5px;"><a href="javascript:void(0)" onclick="save()" class="neibu">保存</a></div>
                    	</form>
                    	</h5>
    </div>
 <div class="box102 p20" id="idsRules">
       		<div class="loudong tab5" id="builtin">
            	<h4><em>-</em> 内置规则</h4>
                <div class="p20" id="builtindiv">
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
                                    	<?php if($builtin){ 
                                    	    $idx = -1;
                                    	    foreach($builtin as $rule){
                                    	    $idx++;
                                    	        ?>
                                    <tr>
                                    	<td><input type="checkbox" name="builtinRule" onclick="check('builtin',<?php echo $idx?>)" <?php if($rule['RuleStatus']==1) echo 'checked'?>></td>
                                        <td><?php echo $rule['RuleName']?></td>
                                        <td><select name="risklevel" id="builtinRiskLevel<?php echo $idx?>" onchange="check('builtin',<?php echo $idx?>)">
                                        	<?php foreach($riskLevels as $riskLevel){?><option value="<?php echo $riskLevel['RiskLevel']?>" <?php if($rule['RiskLevel'] == $riskLevel['RiskLevel']) echo "selected"?>><?php echo $riskLevel['Description']?></option><?php }?>
                                        </select></td>
                                        <td><select name="activetime" id="builtinActiveTime<?php echo $idx?>"onchange="check('builtin',<?php echo $idx?>)" style="width:100%">
                                        	<?php foreach($activeTimes as $activeTime){?><option value="<?php echo $activeTime['ActiveTimeID']?>" <?php if($rule['ActiveTimeID'] == $activeTime['ActiveTimeID']) echo "selected"?>><?php echo $activeTime['Description']?></option><?php }?>
                                        </select></td>
                                        <td><select name="action" id="builtinActionId<?php echo $idx?>"onchange="check('builtin',<?php echo $idx?>)" style="width:100%">
                                        	<?php foreach($actions as $action){?><option value="<?php echo $action['ActionId']?>" <?php if($rule['ActionId'] == $action['ActionId']) echo "selected"?>><?php echo "邮件报警:".($action['MailWarn']==1?"开":"关").";气泡报警:".($action['PopWarn']==1?"开":"关")?></option><?php }?>
                                        </select></td>
                                        <td class="border_r0"><a href="javascript:void(0)" onclick="showRule2(<?php echo $rule['SubRuleId']?>,<?php echo ($rule['RuleTypeID']?$rule['RuleTypeID']:6)?>)" class="neibu">查看</a></td>
                                        <input type="hidden" id="builtinRuleId<?php echo $idx?>" value="<?php echo $rule['RuleID'];?>"/>
                                        <input type="hidden" id="builtinSubRuleId<?php echo $idx?>" value="<?php echo $rule['SubRuleId'];?>"/>
                                         <?php if($rule['RuleStatus']==1) echo "<script>check('builtin',$idx)</script>"?>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                           <?php if($bulitinPage)echo $bulitinPage->toString()?>
                </div>
            </div>
            <div class="loudong tab5" style="margin-top:20px;" id="mining">
            	<h4><em>-</em> 用户行为模式</h4>
                <div class="p20" id="miningdiv">
                	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>
                                		<th></th>
                                    	<th width="15%">规则名称</th>
                                       	<th width="10%">风险级别</th>
                                        <th width="25%">检测时间</th>
                                        <th width="25%">响应</th>
                                        <th class="border_r0">操作</th>
                                    </tr>
                                    	<?php if($mining){
                                    	    $idx = -1; 
                                    	    foreach($mining as $rule){
                                    	    $idx++;
                                    	        ?>
                                    <tr>
                                    	<td><input type="checkbox" name="miningRule" onclick="check('mining',<?php echo $idx;?>)" <?php if($rule['RuleStatus']==1) echo 'checked'?>></td>
                                        <td><?php echo $rule['RuleName']?></td>
                                        <td><select name="risklevel" id="miningRiskLevel<?php echo $idx?>" onchange="check('mining',<?php echo $idx;?>)">
                                        	<?php foreach($riskLevels as $riskLevel){?><option value="<?php echo $riskLevel['RiskLevel']?>" <?php if($rule['RiskLevel'] == $riskLevel['RiskLevel']) echo "selected"?>><?php echo $riskLevel['Description']?></option><?php }?>
                                        </select></td>
                                        <td><select name="activetime" id="miningActiveTime<?php echo $idx?>"onchange="check('mining',<?php echo $idx;?>)" style="width:100%">
                                        	<?php foreach($activeTimes as $activeTime){?><option value="<?php echo $activeTime['ActiveTimeID']?>" <?php if($rule['ActiveTimeID'] == $activeTime['ActiveTimeID']) echo "selected"?>><?php echo $activeTime['Description']?></option><?php }?>
                                        </select></td>
                                        <td><select name="action" id="miningActionId<?php echo $idx?>"onchange="check('mining',<?php echo $idx;?>)" style="width:100%">
                                        	<?php foreach($actions as $action){?><option value="<?php echo $action['ActionId']?>" <?php if($rule['ActionId'] == $action['ActionId']) echo "selected"?>><?php echo "邮件报警:".($action['MailWarn']==1?"开":"关").";气泡报警:".($action['PopWarn']==1?"开":"关")?></option><?php }?>
                                        </select></td>
                                        <td class="border_r0"><a href="javascript:void(0)" onclick="showRule2(<?php echo $rule['SubRuleId']?>,<?php echo $rule['RuleTypeID']?>)" class="neibu">查看</a></td>
                                        <input type="hidden" id="miningRuleId<?php echo $idx?>" value="<?php echo $rule['RuleID'];?>"/>
                                        <input type="hidden" id="miningSubRuleId<?php echo $idx?>" value="<?php echo $rule['SubRuleId'];?>"/>
                                         <?php if($rule['RuleStatus']==1) echo "<script>check('mining',$idx)</script>"?>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                            <?php if($miningPage) echo $miningPage->toString()?>             
                </div>
            </div><!-- 
            <div class="loudong tab5" style="margin-top:20px;" id="rights">
            	<h4><input type="checkbox"/> 数据库权限规则</h4>
                <div class="p20">
                	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>
                                		<th width="5px"></th>
                                    	<th>规则名称</th>
                                        <th>风险级别</th>
                                        <th>检测时间</th>
                                        <th>响应</th>
                                        <th class="border_r0">操作</th>
                                    </tr>
                                    <?php if($rights){
                                        $idx = -1;
                                        foreach($rights as $rule){
                                        $idx++;
                                            ?>
                                    <tr>
                                    	<td><input type="checkbox" name="rightsRule" onclick="check('rights',<?php echo $idx?>)"  <?php if($rule['RuleStatus']==1) echo 'checked'?>></td>
                                        <td><?php echo $rule['RuleName']?></td>
                                        <td><select name="risklevel" id="rightsRiskLevel<?php echo $idx?>"onchange="check('rights',<?php echo $idx?>)">
                                        	<?php foreach($riskLevels as $riskLevel){?><option value="<?php echo $riskLevel['RiskLevel']?>" <?php if($rule['RiskLevel'] == $riskLevel['RiskLevel']) echo "selected"?>><?php echo $riskLevel['Description']?></option><?php }?>
                                        </select></td>
                                        <td><select name="activetime" id="rightsActiveTime<?php echo $idx?>"onchange="check('rights',<?php echo $idx?>)" style="width:100%">
                                        	<?php foreach($activeTimes as $activeTime){?><option value="<?php echo $activeTime['ActiveTimeID']?>" <?php if($rule['ActiveTimeID'] == $activeTime['ActiveTimeID']) echo "selected"?>><?php echo $activeTime['Description']?></option><?php }?>
                                        </select></td>
                                        <td><select name="action" id="rightsActionId<?php echo $idx?>"onchange="check('rights',<?php echo $idx?>)" style="width:100%">
                                        	<?php foreach($actions as $action){?><option value="<?php echo $action['ActionId']?>" <?php if($rule['ActionId'] == $action['ActionId']) echo "selected"?>><?php echo $action['Description']."-阻塞:".($action['Block']==1?"开":"关").";邮件报警:".($action['MailWarn']==1?"开":"关").";短信报警:".($action['SMSWarn']==1?"开":"关").";气泡报警:".($action['PopWarn']==1?"开":"关")?></option><?php }?>
                                        </select></td>
                                        <td class="border_r0"><a href="javascript:void(0)" onclick="showRule(<?php echo $rule['SubRuleId']?>,<?php echo $rule['RuleTypeID']?>)" class="neibu">查看</a></td>
                                        <input type="hidden" id="rightsRuleId<?php echo $idx?>" value="<?php echo $rule['RuleID'];?>"/>
                                        <input type="hidden" id="rightsSubRuleId<?php echo $idx?>" value="<?php echo $rule['SubRuleId'];?>"/>
                                         <?php if($rule['RuleStatus']==1) echo "<script>check('rights',$idx)</script>"?>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>       
                            <?php if($rightsPage) echo $rightsPage->toString()?>            
                </div>-->
            </div>
            </div>
</div>
<div id="ruleDetail2" style="display:none"></div>
 </body>
 </html>