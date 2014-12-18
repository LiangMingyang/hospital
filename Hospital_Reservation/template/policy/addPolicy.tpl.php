<?php
/**
 * addPolicy.tpl.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-8,created by Chenhuan
 */

include header_inc();
 ?>
 <body>
 <h5 class="title102"><em>添加审计策略</em></h5>
     <div class="itabContent">
     <form action="policy.php?target=policy&cmd=add" name="addPolicyForm" method="post">
     <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                    	<td width="20%" class="td1">
                        	策略名称：
                        </td>
                        <td>
                        	<input type="text" style="width: 200px;" name="policy[RuleName]"/>
                        </td>
                    </tr>
                    <tr>
                    	<td width="10%" class="td1">
                        	是否启用：
                        </td>
                        <td>
                        	<input type="radio" name="policy[Enabled]" value="1" checked="checked"/>是<input type="radio" name="policy[Enabled]" value="0"/>否
                        </td>
                    </tr>
                    <tr>
                    	<td class="btn" colspan="2">
                        	<a href="#" class="tijiao" onclick="submitForm();">提交</a><a href="javascript:history.go(-1);" class="repire">返回</a>
                        </td>
                    </tr>
                </tbody>
     </table>
     </form>   
     </div>
     
     <!-- 该审计策略包含的审计规则 -->
    <div class="itabContent"> 
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th align="left">
               	包含的审计规则列表
		   </th>
		   <th align="right">
                <div class="btn" style="width: 100px;">
                    <a href="#" class="neibu" onclick="addPolicyRule();">添加</a>
				</div>
			</th>
           </tr>                   
           </tbody>
         </table>
 		<div class="tabContent">
            <?php
                       $len = count($ruleList);
                       if ($len<=0){
                       	  echo '<font color="red" style="font-size:14px;">无结果显示，请重试！</font>';
                       } else {
              ?>
              <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                    <tr>
                        <th width="8%">编号</th>
                        <th width="15%">规则名</th>
                        <th width="15%">规则类型</th>
                        <th width="10%">服务名</th>
                        <th width="15%">对象组名称</th>
                        <th width="8%">失败次数</th>
                        <th width="10%">风险级别</th>
                        <th class="border_r0">操作</th>                        
                    </tr>   
                    <?php  
                       foreach ($ruleList as $rule) {
                    ?>      
                    <tr>
                    	<td><?php echo $rule['RuleID']?></td>
                    	<td><a href="ruleDetails.php?ruleId=<?php echo $rule['RuleID']?>"><?php echo $rule['RuleName']?></a></td>
                    	<td>
                    	<?php $tmpId = $rule['RuleTypeID'];
                    		foreach ($ruleTypeList as $type){
                    			if($tmpId == $type['RuleTypeID']) {
                    				echo $type['Description'];
                    				break;
                    			}
                    		}
                    	?>
                    	</td>
                    	<td>
                    		<?php $tmpId = $rule['ServiceId'];
                    			foreach ($serviceList as $service){
                    				if ($tmpId==$service['ServiceId']) {
                    					echo $service['ServiceName'];
                    					break;
                    				}
                    			}
                    		?>
                    	</td>
                    	<td>
                    	<?php $tmpId = $rule['ObjectGroupID'];
                    	foreach ($objectGroupList as $group) {
                    		if($tmpId = $group['ObjectGroupID']) {
                    			echo $group['GroupName'];
                    			break;
                    		}
                    	}
                    	?>	
                    	</td>
                    	<td><?php echo $rule['FailTimes']?></td>
                    	<td>
                    	<?php $tmpId = $rule['RiskLevel'];
                    	foreach ($riskLevelList as $riskLevel) {
                    		if($tmpId == $riskLevel['RiskLevel']) {
                    			echo $riskLevel['Description'];
                    			break;
                    		}
                    	}
                    	?>
                    	</td>
						<td class="border_r0">
                    		<a href="#" class="neibu" style="color: white;" onclick="deletePolicyRule(<?php echo $rule['prID']?>);">删除</a>
                    		&nbsp;&nbsp;
                    		<a href="ruleDetails.php?ruleId=<?php echo $rule['RuleID']?>" class="neibu" style="color: white;">查看</a>
                    	</td>
                    </tr>       
                    <?php 
                       }
                    ?>     
                </tbody>
             </table>   
             <?php  }?>  
         </div>
         <?php echo $rulePage->toString()?>         
    </div>
 	<!-- 该审计策略包含的白名单列表 -->
 	<div class="itabContent"> 
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th align="left">
             	包含的白名单列表
		   </th>
		   <th align="right">
                <div class="btn" style="width: 100px;">
                    <a href="#" class="neibu" onclick="addPolicyIPRange();">添加</a>
				</div>
			</th>
           </tr>                   
           </tbody>
         </table>
         <div class="tabContent">
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                	<tr>
                        <th width="10%">编号</th>
                        <th width="20%">IP范围名称</th>
                        <th width="20%">起始IP</th>
                        <th width="20%">终止IP</th>
                        <th class="border_r0">操作</th>                        
                    </tr>  
                    <?php 
                    	foreach ($whiteList as $white){
                    ?>          
                    <tr>
                    	<td><?php echo $white['WhiteListId']?></td>
                    	<td><?php echo $white['RangeName']?></td>
                    	<td><?php echo ($white['StartIP'])?></td>
                    	<td><?php echo ($white['EndIP'])?></td>
						<td><a href="#" class="neibu" style="color: white;" onclick="deletePolicyWhiteList(<?php echo $white['WhiteListId']?>);">删除</a></td>
                    </tr>       
                    <?php }?>   
                </tbody>
             </table> 
         </div> 
         <?php echo $whitePage->toString()?>         
     </div>
     
      
     <!-- 添加规则时，显示出不包含的规则列表 -->
     <div id="addPolicyRuleForm" title="为审计策略添加审计规则" style="display: none;">
		<form action="">
			<table id="policyRuleGrid" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<th></th>
					<th width="50px">规则名称</th>
					<th width="100px">规则类型</th>
					<th width="50px">服务名</th>
				</tr>
				<?php 
				foreach ($noselectRuleList as $rule) {
				?>
				<tr>
					<td><input type="checkbox" name="selectRule" value="<?php echo $rule['RuleID']?>"/></td>
					<td><?php echo $rule['RuleName']?></td>
					<td>
					<?php $tmpId = $rule['RuleTypeID'];
                    		foreach ($ruleTypeList as $type){
                    			if($tmpId == $type['RuleTypeID']) {
                    				echo $type['Description'];
                    				break;
                    			}
                    		}
                    ?>
					</td>
					<td>
                    		<?php $tmpId = $rule['ServiceId'];
                    			foreach ($serviceList as $service){
                    				if ($tmpId==$service['ServiceId']) {
                    					echo $service['ServiceName'];
                    					break;
                    				}
                    			}
                    		?>
                    </td>
				</tr>
				<?php
				}
				?>
			</table>
		</form>
	 </div>
     
     <!-- 添加规则时，显示出不包含的IPRange列表 -->
     <div id="addPolicyIPRangeForm" title="为审计策略添加白名单" style="display: none;">
		<form action="">
			<table id="policyIPRangeGrid" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<th></th>
					<th width="50px">编号</th>
					<th width="100px">范围名称</th>
					<th width="50px">起始IP</th>
					<th width="50px">终止IP</th>
				</tr>
				<?php 
				foreach ($noselectIPRangeList as $ipRange) {
				?>
				<tr>
					<td><input type="checkbox" name="selectIPRange" class="selectIPRange" value="<?php echo $ipRange['RangeID']?>"/></td>
					<td><?php echo $ipRange['RangeID']?></td>
					<td><?php echo $ipRange['RangeName']?></td>
					<td><?php echo ($ipRange['StartIP'])?></td>
					<td><?php echo ($ipRange['EndIP'])?></td>
				</tr>
				<?php
				}
				?>
			</table>
		</form>
	 </div>
 </body>
 </html>