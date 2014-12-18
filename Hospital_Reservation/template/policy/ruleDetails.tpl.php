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
//function ip2int($ip){
//    list($ip1,$ip2,$ip3,$ip4)=explode(".",$ip);
//    return ($ip1<<24)|($ip2<<16)|($ip3<<8)|($ip4);
//}
function int2ip($int){
	return (($int/16777216)%256).".".(($int/65536)%256).".".(($int/256)%256).".".($int%256);
}

 ?>
 <script type="text/javascript">
 function submitForm() {
	 document.updateRuleForm.submit();
 }

 function showObjectSelectList(serviceId) {
 	//清空一级以下的数据
 	var objectGroupSelectList = document.getElementById("rule[ObjectGroupID]");
 	objectGroupSelectList.options.length=0;
 	
 	$.ajax({
 		url:"addAuditRule.php?cmd=showObjectGroup",
 		dataType:"JSON",
 		type:"POST",
 		data:{
 			targetServiceId:serviceId
 		},
 		success:function(data) {
 			var dataList = data.objectGroupList;	
 			objectGroupSelectList.add(new Option("---请选择---",""));
 			for(var i = 0; i < dataList.length; i ++) {
 				var showValue = dataList[i].GroupName;
 				var value = dataList[i].ObjectGroupID; 
 				objectGroupSelectList.add(new Option(showValue,value));
 			}
 			
 			
 		}
 	});
 }

</script> 
<body>
<h5 class="title102"><em>查看审计规则信息</em></h5>
          <div class="box102 p20">
       		 <form action="policy.php?target=rule&cmd=update&id=<?php echo $targetRule['RuleID']?>" method="post" name="updateRuleForm">
       		 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                    	<td width="20%" class="td1">
                        	规则ID：
                        </td>
                        <td>
                        	<input type="text" style="width: 200px;" name="ruleId" value="<?php echo $targetRule['RuleID']?>" disabled="disabled"/>
                        	<span><font color="red">规则ID不能修改！</font></span>
                        	<input type="hidden" style="width: 200px;" id="ruleIdHidden" name="rule[RuleID]" value="<?php echo $targetRule['RuleID']?>"/>
                        </td>
                    </tr>
                	<tr>
                    	<td width="20%" class="td1">
                        	规则名：
                        </td>
                        <td>
                        	<input type="text" style="width: 200px;" name="rule[RuleName]" value="<?php echo $targetRule['RuleName']?>" disabled="disabled"/>
                        	<span><font color="red">规则名不能修改！</font></span>
                        </td>
                    </tr>
                    <tr>
                    	<td  class="td1">
                        	审计规则状态：
                        </td>
                        <td>
                        	<?php $state = $targetRule['RuleStatus'];
                        	if($state==1) {
                        		?>
                        		<input type="radio" name="rule[RuleStatus]" value="1" checked="checked"/>启用
                        		<input type="radio" name="rule[RuleStatus]" value="0"/>禁用
                        		<?php
                        	} else {
                        		?>
                        		<input type="radio" name="rule[RuleStatus]" value="1"/>启用
                        		<input type="radio" name="rule[RuleStatus]" value="0" checked="checked"/>禁用
                        		<?php
                        	}
                        	?>
                        </td>
                    </tr>
                    <tr>
                    	<td  class="td1">
                    		所属的数据库服务:
                    	</td>
                    	<td>
                    		<select id="rule[ServiceId]" name="rule[ServiceId]" style="width: 200px;" onchange="showObjectSelectList(this.options[this.options.selectedIndex].value);">
                    			<?php 
                    			$tmpId = $targetRule['ServiceId'];
                    			foreach ($serviceList as $service) {
                    				if($tmpId == $service['ServiceId']) {
                    					?>
	                    				<option value="<?php echo $service['ServiceId']?>" selected="selected"><?php echo $service['ServerName']?>:<?php echo $service['Name']?>:<?php echo $service['ServiceName']?></option>
	                    				<?php 
                    				} else {
                    					?>
	                    				<option value="<?php echo $service['ServiceId']?>"><?php echo $service['ServerName']?>:<?php echo $service['Name']?>:<?php echo $service['ServiceName']?></option>
	                    				<?php 
                    				}
                    			}
                    			?>
                    		</select>
                    	</td>
                    </tr>
                    <tr>
                    	<td  class="td1">
                        	对象组：
                        </td>
                        <td>
                        	<select id="rule[ObjectGroupID]" name="rule[ObjectGroupID]" style="width: 200px;">
                        	<?php 
                        	$tmpId = $targetRule['ObjectGroupID'];
                        	foreach ($objectGroupList as $group) {
                        		if($tmpId == $group['ObjectGroupID']) {
                        			if($group['Deleted']==0) {
                        				?>
                    					<option value="<?php echo $group['ObjectGroupID']?>" selected="selected"><?php echo $group['GroupName']?></option>
                    					<?php	
                        			} else {
                        				?>
                    					<option value="<?php echo $group['ObjectGroupID']?>" selected="selected" style="color: red;"><?php echo $group['GroupName']?>(已删除)</option>
                    					<?php	
                        			}
                        		} else {
                        			?>
                    				<option value="<?php echo $group['ObjectGroupID']?>"><?php echo $group['GroupName']?></option>
                    				<?php	
                        		}
                        	}
                        	?>
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	数据库登录名：
                        </td>
                        <td>
                        	<input type="text" name="rule[LoginNames]" style="width: 200px;" value="<?php echo $targetRule['LoginNames']?>"/>&nbsp;&nbsp;<font color="red">注：多个登录名以“;”分开</font> 
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	所审计的数据库操作类型：
                        </td>
                        <td>
                        	<select id="ruleOpClass" name="rule[OpClass]" style="width: 200px;">
                        	<?php 
                        	$tmpId = $targetRule['OpClass'];
                        	if($tmpId == 1){
                        		?>
                        		<option value="1" selected="selected">连接</option>
                        		<option value="2">断开</option>
                        		<option value="3">执行SQL语句</option>
                        		<?php
                        	} else if($tmpId == 2) {
                        		?>
                        		<option value="1">连接</option>
                        		<option value="2" selected="selected">断开</option>
                        		<option value="3">执行SQL语句</option>
                        		<?php
                        	} else {
                        		?>
                        		<option value="1">连接</option>
                        		<option value="2">断开</option>
                        		<option value="3" selected="selected">执行SQL语句</option>
                        		<?php
                        	}
                        	?>
                        	</select>	
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	匹配查询和返回内容关键字：
                        </td>
                        <td>
                        	<input type="text" name="rule[KeyWord]" style="width: 200px;" value="<?php echo $targetRule['KeyWord']?>"/>
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	所审计的操作结果：
                        </td>
                        <td>
                        	<select id="rule[ExecResult]" name="rule[ExecResult]" style="width: 200px;">
                        	<?php $tmpId = $targetRule['ExecResult'];
                        		if($tmpId == 0) {
                        			?>
                        			<option value="0" selected="selected">失败</option>
	                        		<option value="1">成功</option>
	                        		<option value="2">不审计此项</option>
                        			<?php
                        		} else if($tmpId == 1) {
                        			?>
                        			<option value="0">失败</option>
	                        		<option value="1" selected="selected">成功</option>
	                        		<option value="2">不审计此项</option>
                        			<?php
                        		} else {
                        			?>
                        			<option value="0">失败</option>
	                        		<option value="1">成功</option>
	                        		<option value="2" selected="selected">不审计此项</option>
                        			<?php
                        		}
                        	?>
                        	</select>	
                        </td>
                    </tr>
                    
                    <tr id="failRow">
                    	<td  class="td1">
                        	操作连续失败次数：
                        </td>
                        <td>
                        	<input type="text" name="rule[FailTimes]" style="width: 200px;" value="<?php echo $targetRule['FailTimes']?>"/> 
                        </td>
                    </tr>  
                     
                    <tr>
                    	<td  class="td1">
                        	风险等级：
                        </td>
                        <td>
                        	<select id="rule[RiskLevel]" name="rule[RiskLevel]" style="width: 200px;">
                        	<?php 
                        	$tmpId = $targetRule['RiskLevel'];
                        	foreach ($riskLevelList as $risk){
                        		if($tmpId == $risk['RiskLevel']) {
                        			?>
		                        	<option value="<?php echo $risk['RiskLevel']?>" selected="selected">
		                        	<?php echo $risk['Description']?>
		                        	</option>
		                        	<?php 
                        		} else {
                        			?>
		                        	<option value="<?php echo $risk['RiskLevel']?>">
		                        	<?php echo $risk['Description']?>
		                        	</option>
		                        	<?php 
                        		}
                        	}	
                        	?>
                        	</select>
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	规则起作用时间段：
                        </td>
                        <td>
                        	<select id="rule[ActiveTimeID]" name="rule[ActiveTimeID]" style="width: 200px;">
                        	<?php 
                        	$tmpId = $targetRule['ActiveTimeID'];
                        	foreach ($activeTimeList as $activeTime){
                        		if($tmpId == $activeTime['ActiveTimeID']) {
                        			?>
		                        	<option value="<?php echo $activeTime['ActiveTimeID']?>" selected="selected">
		                        	<?php echo $activeTime['Description']?>
		                        	</option>
		                        	<?php 
                        		} else {
                        			?>
		                        	<option value="<?php echo $activeTime['ActiveTimeID']?>">
		                        	<?php echo $activeTime['Description']?>
		                        	</option>
		                        	<?php 
                        		}
                        	}
                        	?>
                        	</select>
                        </td>
                    </tr>    
                    <tr>
                    	<td  class="td1">
                        	响应活动：
                        </td>
                        <td>
                        	<select id="rule[ActionId]" name="rule[ActionId]" style="width: 200px;">
                        	<?php 
                        	$tmpId = $targetRule['ActionId'];
                        	foreach ($actionList as $action){
                        		if($tmpId == $action['ActionId']) {
                        			?>
		                        	<option value="<?php echo $action['ActionId']?>" selected="selected">
		                        	<?php echo $action['Description']?>
		                        	</option>
		                        	<?php 
                        		} else {
                        			?>
		                        	<option value="<?php echo $action['ActionId']?>">
		                        	<?php echo $action['Description']?>
		                        	</option>
		                        	<?php 
                        		}
                        	}
                        		?>
                        	</select>
                        </td>
                    </tr>
                    <?php if($targetRule['OpClass']==3){?>   
                    <tr id="sqlTypeRow">
                    	<td class="td1">SQL语句类型：</td>
                    	<td>
                    		<table><tr>
                    		<?php 
                    		$i=0;
                        	foreach ($sqlTypeList as $sql){
                        		$flag = false;
                        		foreach ($ruleSqlTypeList as $ruleSql){
                        			if($sql['SqlType']==$ruleSql['SqlTypeID']) {
                        				$flag=true;
                        				break;
                        			}
                        		}
                        		if($flag) {
                        			?>
                        			<td><input type="checkbox" name="sqlTypeCheck[]" class="sqlTypeCheck" value="<?php echo $sql['SqlType']?>" checked="checked"/><?php echo $sql['Name']?></td>
                        			<?php 	
                        		} else {
                        			?>
                        			<td><input type="checkbox" name="sqlTypeCheck[]" class="sqlTypeCheck" value="<?php echo $sql['SqlType']?>"/><?php echo $sql['Name']?></td>
                        			<?php 	
                        		}
                        		$i++;
                        		if($i%4==0){
                        			?>
                        			</tr><tr>
                        			<?php
                        		}
                        	}
                        	?>
                        	</tr></table>
                    	</td>
                    </tr>
                    <?php }else{?>
                    <tr id="sqlTypeRow" style="display: none">
                    	<td class="td1">SQL语句类型：</td>
                    	<td>
                    		<table><tr>
                    		<?php 
                    		$i=0;
                        	foreach ($sqlTypeList as $sql){
                        		$flag = false;
                        		foreach ($ruleSqlTypeList as $ruleSql){
                        			if($sql['SqlType']==$ruleSql['SqlTypeID']) {
                        				$flag=true;
                        				break;
                        			}
                        		}
                        		if($flag) {
                        			?>
                        			<td><input type="checkbox" name="sqlTypeCheck[]" class="sqlTypeCheck" value="<?php echo $sql['SqlType']?>" checked="checked"/><?php echo $sql['Name']?></td>
                        			<?php 	
                        		} else {
                        			?>
                        			<td><input type="checkbox" name="sqlTypeCheck[]" class="sqlTypeCheck" value="<?php echo $sql['SqlType']?>"/><?php echo $sql['Name']?></td>
                        			<?php 	
                        		}
                        		$i++;
                        		if($i%4==0){
                        			?>
                        			</tr><tr>
                        			<?php
                        		}
                        	}
                        	?>
                        	</tr></table>
                    	</td>
                    </tr>
                    <?php }?>
                    
                     
                    <!-- 
                    <tr>
                    	<td class="td1">
                    		规则所审计的数据来源IP：
                    	</td>
                    	<td>
                    		<a href="#" class="neibu" onclick="viewIPRange();">点击查看</a>&nbsp;&nbsp;
                    		<a href="#" class="neibu" onclick="updateChooseIPRange();">选择IP范围</a>
                    	</td>
                    </tr>
                     -->
                    <tr>
                    	<td colspan="2">
                    	<input type="hidden" id="chooseIpHidden" name="chooseIpHidden" value=""/>
                    	<input type="hidden" id="chooseTrustHidden" name="chooseTrustHidden" value=""/>
                    	</td>
                    </tr>  
                    <tr>
                        <td class="btn" colspan="2">
                        	<a href="#" class="tijiao" onclick="submitForm();">更新</a><a href="javascript:history.go(-1);" class="repire">返回</a>
                        </td>
                    </tr>
                </tbody>
             </table>
             </form>
          </div>
     
     <!-- 添加规则时，显示出不包含的规则列表 -->
     <div id="viewIPRangeDiv" title="该审计规则所的数据来源IP列表" style="display: none;">
		<form action="">
		<?php 
		$count = count($selectedIpList);
        if($count <= 0) {
        	?>
        	<font color="red">没有数据来源IP记录！</font>
        	<?php
        } else {
		?>
			<table style="color: orange; left: 1px;" class="tab4">
                    			<tr>
                    				<th></th>
                    				<th>编号</th>
                    				<th>范围名称</th>
                    				<th>起始IP</th>
                    				<th>终止IP</th>
                    				<th>是否信任</th>
                    			</tr>
                    			<?php 
                    			foreach ($selectedIpList as $tmp) {
                    				?>
                    			<tr>
                    				<td><input type="checkbox" name="ipRangeCheck" value="<?php echo $tmp['WhiteListId']?>"/></td>
                    				<td><?php echo $tmp['WhiteListId']?></td>
                    				<td><?php echo $tmp['RangeName']?></td>
                    				<td><?php echo $tmp['StartIP']?></td>
                    				<td><?php echo $tmp['EndIP']?></td>
                    				<td><?php echo $tmp['Trusted']==0?'不信任':'信任'?></td>
                    			</tr>
                    				<?php
                    			}
                    			?>
                    		</table>
                    	
            <?php }?>
		</form>
	 </div>
     
     <!-- 选择IPRange：下面列表包含的是不属于rule所选择的iprange范围内-->
     <div id="updateChooseIPRange" title="选择IPRange<font color='red'>(注：请在所选择的IP范围后面填写信任IP)</font>" style="display: none;">
		<form action="">
			<?php 
			$count = count($nonIpList);
			if($count <= 0) {
				?>
				<font color="red">当前无可以用来选择的IP！请到IP范围管理添加IP范围！</font>
				<?php
			} else {
				?>
				<table id="chooseIPRangeTable" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<th></th>
					<th>范围名称</th>
					<th>起始IP</th>
					<th>结束IP</th>
					<th>信任IP</th>
				</tr>
                <?php 
				foreach ($nonIpList as $ipRange){
					?>
					<tr>
						<td><input type="checkbox" name="ipRangeCheck" value="<?php echo $ipRange['RangeID']?>"/></td>
						<td><?php echo $ipRange['RangeName']?></td>
						<td><?php echo ($ipRange['StartIP'])?></td>
						<td><?php echo ($ipRange['EndIP'])?></td>
						<td>
							<input type="radio" name="trustIP<?php echo $ipRange['RangeID']?>" value="1" checked="checked"/>信任
							<input type="radio" name="trustIP<?php echo $ipRange['RangeID']?>" value="0"/>不信任
						</td>
					</tr>
					<?php 
				}
				?>
			</table>
				<?php
			}
			?>
		</form>
	 </div>     
	 
	 <!-- 添加IPRange -->
     <div id="updateAddIPRange" title="添加IP范围" style="display: none;">
		<form action="addIpRange" method="post" name="addNewIPRangeForm">
			<table id="addNewObjectGroup" style="color: orange; left: 1px;" class="tab3">
				<tr>
					<td>范围名称：</td>
					<td><input type="text" style="width: 150px;" id="newRangeNameText"/><font color="red">*</font></td>
				</tr>
				<tr>
					<td>起始IP：</td>
					<td><input type="text" style="width: 150px;" id="newStartIPText"/><font color="red">*</font></td>
				</tr>
				<tr>
					<td>结束IP：</td>
					<td><input type="text" style="width: 150px;" id="newEndIPText"/><font color="red">*</font></td>
				</tr>
				<tr>
					<td>是否信任IP：</td>
					<td>
						<input type="radio" name="newTrustIPText" value="0" checked="checked"/>不信任<input type="radio" name="newTrustIPText" value="1"/>信任
					</td>
				</tr>
			</table>
			<span id="warningInfo"></span>
		</form>
	 </div>   
     
 </body>
 </html>