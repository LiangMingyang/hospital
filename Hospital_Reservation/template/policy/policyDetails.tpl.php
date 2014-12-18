<?php
/**
 * policyDetails.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-8,created by Chenhuan
 */
include policy_inc();
function int2ip($int){
	return (($int/16777216)%256).".".(($int/65536)%256).".".(($int/256)%256).".".($int%256);
}
 ?>
<script type="text/javascript">
 function policyWhitePage(pageNo) {
				 
		 if(pageNo == -1) {
			 pageNo = $('#policyWhitePageNum').val();
		 }
		 var re = /^[1-9]\d*$/;
		 pageCount = $("#whitePageCount").val();
		 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
		 {
		   	 alert("必须为正整数，且不能大于"+pageCount);
		 } else {
//			 var currentPageNo = parseInt($(".numon").html());
//			 if(pageNo==currentPageNo){
//				alert("当前为"+pageNo+"页");
//			 } else{
				 var policyId = $("#policyIdHidden").val();
				window.location.href="policyDetails.php?policyId="+policyId+"&whitePage=policyWhitePage"+"&whitePageNo="+pageNo;
//			 } 
		 }
}
function policyRulePage(pageNo) {

		 if(pageNo == -1) {
			 pageNo = $('#policyRulePageNum').val();
		 }
		 var re = /^[1-9]\d*$/;
		 pageCount = $("#rulePageCount").val();
		 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
		 {
		   	 alert("必须为正整数，且不能大于"+pageCount);
		 } else {
//			 var currentPageNo = parseInt($(".numon").html());
//			 if(pageNo==currentPageNo){
//				alert("当前为"+pageNo+"页");
//			 } else{
				 var policyId = $("#policyIdHidden").val();
				window.location.href="policyDetails.php?rulePage=policyRulePage&policyId="+policyId+"&rulePageNo="+pageNo;
//			 } 
		 }
}
</script>
 <body id="body">
 <h5 class="title102" style="position:relative; zoom:1;"><em>查看审计策略</em> <span></span></h5>
 	<input type="hidden" name="policyIdHidden" id="policyIdHidden" value="<?php echo $targetPolicy['PolicyId']?>"/>
 	<!-- 审计策略基本信息 -->
 	<div class="itabContent"> 
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th align="left">
               	审计策略基本信息
		   </th>
           </tr>                   
           </tbody>
         </table>
         <div class="tabContent">
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
             		<tr>
                    	<td width="30%">策略ID</td>
                    	<td class="border_r0"><?php echo $targetPolicy['PolicyId']?></td>
                    </tr>      
                    <tr>
                    	<td>策略名称</td>
                    	<td class="border_r0"><?php echo $targetPolicy['PolicyName']?></td>
                    </tr>
                    <tr>
                    	<td>创建时间</td>
                    	<td class="border_r0"><?php echo $targetPolicy['CreateTime']?></td>
                    </tr>      
                    <tr>
                    	<td>更新时间</td>
                    	<td class="border_r0"><?php echo $targetPolicy['ModifyTime']?></td>
                    </tr>     
                    <tr>
                    	<td>是否启用</td>
                    	<td class="border_r0"><?php echo $targetPolicy['Enabled']==1?'<font color="green">已启用</font>':'<font color="red">未启用</font>'?></td>
                    </tr>
                </tbody>
             </table>     
         </div> 
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
                        <th width="8%">规则ID</th>
                        <th width="15%">规则名</th>
                        <th width="15%">规则类型</th>
                        <th width="10%">服务名</th>
                        <th width="15%">对象组名称</th>
						<!-- 
						<th width="8%">失败次数</th>
                        <th width="10%">风险级别</th>
						 -->
                        <th class="border_r0">操作</th>                        
                    </tr>   
					<?php 
					//print_r($ruleList);
					?>
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
                    		if($tmpId == $group['ObjectGroupID']) {
                    			echo $group['GroupName'];
                    			break;
                    		}
                    	}
                    	?>	
                    	</td>
                    	<!-- 
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
                    	 -->
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
         <?php
                       $len = count($whiteList);
                       if ($len<=0){
                       	  echo '<font color="red" style="font-size:14px;">无结果显示，请重试！</font>';
                       } else {
              ?>
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                	<tr>
                        <th width="10%">编号</th>
                        <th width="10%">IP范围编号</th>
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
                    	<td><?php echo $white['IPRange']?></td>
                    	<td><?php echo $white['RangeName']?></td>
                    	<td><?php echo ($white['StartIP'])?></td>
                    	<td><?php echo ($white['EndIP'])?></td>
						<td class="border_r0"><a href="#" class="neibu" style="color: white;" onclick="deletePolicyWhiteList(<?php echo $white['WhiteListId']?>);">删除</a></td>
                    </tr>       
                    <?php }?>   
                </tbody>
             </table> 
             <?php }?>
         </div> 
         <?php echo $whitePage->toString()?>         
     </div>
 	
 	<div class="itabContent">
 	<table align="center" width="100%">
 		<tr>
                        <td class="btn" colspan="2">
                        	<a href="policyMgr.php" class="repire">返回</a>
                        </td>
                    </tr>
    </table>
 	</div>
     <!-- 添加规则时，显示出不包含的规则列表 -->
     <div id="addPolicyRuleForm" title="为审计策略添加审计规则" style="display: none;">
			<table id="policyRuleGrid" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<th></th>
					<th>规则名称</th>
					<th>规则类型</th>
					<th>服务名</th>
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
                    					echo $service['ServerName'].":".$service['Name'].":".$service['ServiceName'];
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
	 </div>
     
     <!-- 添加规则时，显示出不包含的IPRange列表 -->
     <div id="addPolicyIPRangeForm" title="为审计策略添加白名单" style="display: none;">
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
	 </div>
 </body>
 </html>