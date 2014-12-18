<?php
/**
 * 自定义审计规则
 * addPolicy.tpl.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-8,created by Chenhuan
 */

include policy_inc();


function ip2int($ip){
    list($ip1,$ip2,$ip3,$ip4)=explode(".",$ip);
    return ($ip1<<24)|($ip2<<16)|($ip3<<8)|($ip4);
}
function int2ip($int){
	return (($int/16777216)%256).".".(($int/65536)%256).".".(($int/256)%256).".".($int%256);
}
 ?>
 <script type="text/javascript">
 function check_danger(str){
	var reg = /[|&;$%@,\'"<>()+]/;
    var res=reg.test(str);
	if(res){		
			return true;
		    }
	else if(str.length>64){
		return true;
	}
	else{
			return false;
	}
}
 function check_danger_patch(str){
	var reg = /[|&$%@,\'"<>()+]/;
    var res=reg.test(str);
	if(res){		
			return true;
		    }
	else if(str.length>64){
		return true;
	}
	else{
			return false;
	}
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
 <h5 class="title102"><em>添加自定义审计规则</em></h5>
          <div class="box102 p20">
       		 <form action="policy.php?target=rule&cmd=add" method="post" name="addRuleForm">
       		 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                    	<td width="20%" class="td1">
                        	规则名：
                        </td>
                        <td>
                        	<input type="text" style="width: 200px;" id="ruleNameText" name="rule[RuleName]" onchange="checkExistedRuleName();"/><font color="red">*</font>
                        	<span id="ruleNameInfo"></span>
                        </td>
                    </tr>
                    <tr>
                    	<td  class="td1">
                        	审计规则状态：
                        </td>
                        <td>
                        	<input type="radio" name="rule[RuleStatus]" value="1" checked="checked"/>启用<input type="radio" name="rule[RuleStatus]" value="0"/>禁用
                        </td>
                    </tr>
                    <tr>
                    	<td  class="td1">
                    		所属的数据库服务:
                    	</td>
                    	<td>
                    		<select id="rule[ServiceId]" name="rule[ServiceId]" style="width: 200px;" onchange="showObjectSelectList(this.options[this.options.selectedIndex].value);">
                    			<?php 
                    			foreach ($serviceList as $service) {
                    				?>
                    				<option value="<?php echo $service['ServiceId']?>"><?php echo $service['ServerName']?>:<?php echo $service['Name']?>:<?php echo $service['ServiceName']?></option>
                    				<?php 
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
                        	foreach ($objectGroupList as $obj){
                        		?>
                        		<option value="<?php echo $obj['ObjectGroupID']?>"><?php echo $obj['GroupName']?></option>
                        		<?php
                        	}
                        	?>
                        	</select>
                        	&nbsp;&nbsp;<a href="objectGroupList.php" style="text-decoration: underline;">>>点击添加对象组</a>
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	数据库登录名：
                        </td>
                        <td>
                        	<input type="text" name="rule[LoginNames]" id="log_NameText"  style="width: 200px;"/>&nbsp;&nbsp;<font color="red">注：多个登录名以“;”分开</font> 
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	所审计的数据库操作类型：
                        </td>
                        <td>
                        	<select id="ruleOpClass" name="rule[OpClass]" style="width: 200px;">
                        		<option value="1">连接</option>
                        		<option value="2">断开</option>
                        		<option value="3" selected>执行SQL语句</option>
                        	</select>	
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	匹配查询和返回内容关键字：
                        </td>
                        <td>
                        	<input type="text" name="rule[KeyWord]" id="key_area" style="width: 200px;"/>
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	所审计的操作结果：
                        </td>
                        <td>
                        	<select id="rule[ExecResult]" name="rule[ExecResult]" style="width: 200px;">
                        		<option value="0">失败</option>
                        		<option value="1">成功</option>
                        		<option value="NULL">不审计此项</option>
                        	</select>	
                        </td>
                    </tr>
                    <tr id="failRow">
                    	<td  class="td1">
                        	操作连续失败次数：
                        </td>
                        <td>
                        	<input type="text" id="num_area" name="rule[FailTimes]" style="width: 200px;" value="0" onchange="check_num(this)"/> 
							<script>
							 function check_num(t){
								 var num = $(t).val();
								 if(isNaN(num)){
									 alert("失败次数不是数字！");
                                      $(t).val('0');
								 }
							}
							</script>
                        </td>
                    </tr>  
                    <tr>
                    	<td  class="td1">
                        	风险等级：
                        </td>
                        <td>
                        	<select id="rule[RiskLevel]" name="rule[RiskLevel]" style="width: 200px;">
                        	<?php 
                        	foreach ($riskLevelList as $risk){
                        	?>
                        	<option value="<?php echo $risk['RiskLevel']?>">
                        	<?php echo $risk['Description']?>
                        	</option>
                        	<?php 
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
                        	foreach ($activeTimeList as $activeTime){
                        	?>
                        	<option value="<?php echo $activeTime['ActiveTimeID']?>">
                        	<?php echo $activeTime['Description']?>
                        	</option>
                        	<?php 
                        	}
                        	?>
                        	</select>
                        </td>
                    </tr>   
                    <tr>
                    	<td  class="td1">
                        	行为类别：
                        </td>
                        <td>
                        	<select id="rule[ActionId]" name="rule[ActionId]" style="width: 200px;" onchange="checkAction();">
                        	<?php 
                        	foreach ($actionList as $action){
                        	?>
                        	<option value="<?php echo $action['ActionId']?>">
                        	<?php echo $action['Description']?>
                        	</option>
                        	<?php 
                        	}
                        	?>
                        	</select><font color="red">*</font>
                        	<span id="actionInfo"></span>
                        </td>
                    </tr>   
                    <tr id="sqlTypeRow" >
                    	<td  class="td1">
                        	SQL语句类型：
                        </td>
                        <td><table><tr>
                        	<?php 
                        	$i = 0;
                        	foreach ($sqlTypeList as $sql){
                        	?>
                        	<td><input type="checkbox" name="sqlTypeCheck[]" class="sqlTypeCheck" value="<?php echo $sql['SqlType']?>"/><?php echo $sql['Name']?></td>
                        	<?php
	                        	$i++;
	                        	if($i%4==0){
	                        		?>
	                        		</tr><tr>
	                        		<?php
	                        	}
                        	}
                        	?>
                        	</tr></table>
                        	<input type="hidden" name="sqlTypeHidden" id="sqlTypeHidden"/>
                        </td>
                    </tr>   
                   <!-- <tr>
                    	<td class="td1">
                    		规则所审计的数据来源IP：
                    	</td>
                    	<td>
                    		<a href="#" class="neibu" onclick="chooseIPRange();">选择IP范围</a>&nbsp;&nbsp;
                    		<a href="#" class="neibu" onclick="addIPRange();">添加IP范围</a>&nbsp;&nbsp;
                    		<a href="#" class="neibu" onclick="viewAddIPRange();">查看添加的IP</a>
                    	</td>
                    </tr> -->
                    <tr>
                    	<td colspan="2">
                    	<input type="hidden" id="chooseIpHidden" name="chooseIpHidden" value=""/>
                    	<input type="hidden" id="chooseTrustHidden" name="chooseTrustHidden" value=""/>
                    	<input type="hidden" id="newRangeNameHidden" name="newRangeNameHidden" value=""/>
                    	<input type="hidden" id="newStartIPHidden" name="newStartIPHidden" value=""/>
                    	<input type="hidden" id="newEndIPHidden" name="newEndIPHidden" value=""/>
                    	<input type="hidden" id="newTrustIPHidden" name="newTrustIPHidden" value=""/>
                    	</td>
                    </tr>        
                    <tr>
                    	<td class="btn" colspan="2">
                        	<a href="#" class="tijiao" onclick="submitForm();">提交</a><a href="definedList.php" class="repire">返回</a>
                        </td>
                    </tr>
                </tbody>
             </table>
             </form>
          </div>
          
     <!-- 选择IPRange-->
     <div id="chooseIPRangeDiv" title="选择IP范围" style="display: none;">
		<form action="">
			<?php 
			$count = count($ipRangeList);
			if($count <= 0) {
				?>
				<font color="red">当前无可以用来选择的IP！请到IP范围管理添加IP范围！</font>
				<?php
			} else {
				?>
				<table id="chooseIPRangeTable" style="color: orange; left: 1px;" class="tab4">
					<tr>
						<th>选择</th>
						<th>范围名称</th>
						<th>起始IP</th>
						<th>结束IP</th>
						<th></th>
					</tr>
	                <?php 
					foreach ($ipRangeList as $ipRange){
						?>
						<tr>
							<td><input type="checkbox" name="ipRangeCheck" value="<?php echo $ipRange['RangeID']?>"/></td>
							<td><?php echo $ipRange['RangeName']?></td>
							<td><?php echo ($ipRange['StartIP'])?></td>
							<td><?php echo ($ipRange['EndIP'])?></td>
							<td><input type="radio" name="trustIP<?php echo $ipRange['RangeID']?>" value="1"/>信任<input type="radio" name="trustIP<?php echo $ipRange['RangeID']?>" value="0"/>不信任</td>
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
     <div id="addIPRangeDiv" title="添加IP范围" style="display: none;">
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
						<input type="radio" name="newTrustIPText" value="0" checked="checked"/>不信任
						<input type="radio" name="newTrustIPText" value="1"/>信任
					</td>
				</tr>
			</table>
			<span id="warningInfo"></span>
		</form>
	 </div>   
	 
	 <!-- 查看添加的IP范围 -->
	 <div id="viewAddIPRangeDiv" style="display: none;">
	 	<form action="" method="post" name="addNewIPRangeForm">
			<table id="viewAddIPRangeTable" style="color: orange; left: 1px;" class="tab3">
				<thead>
					<tr>
						<th>范围名称</th>
						<th>起始IP</th>
						<th>终止IP</th>
						<th>是否信任</th>
					</tr>
				</thead>
				<tbody id="viewAddIPRangeTbody">
					
				</tbody>
			</table>
			<span id="warningInfo"></span>
		</form>
	 </div>
	 
 </body>
 </html>
 <script type="text/javascript">
 	function submitForm() {
 	 	var ruleName = $("#ruleNameText").val();
		var logName= $("#log_NameText").val();
		var key_match= $("#key_area").val();
	    var num=$("#num_area").val();
		/*added by gengjinkun*/
		//alert(logName);
		if(check_danger(ruleName)||check_danger(key_match)||check_danger(num)){
               artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
		}
		if(check_danger_patch(logName)){
			 artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
		}
		/////////////////////
 		if(checkNonEmpty(trim(ruleName))) {
 	 		if(ruleName.length > 20) {
 	 			$("#ruleNameInfo").html("<font color='red'>规则名不能超过20个字符！</font>");
 	 		} else {
				//检查规则是否重名
				$.ajax({
					url:"addAuditRule.php?cmd=checkRuleName&ruleName="+ruleName,
					type:"post",
					dataType:"text",
					success:function(data){
						/*Add By Yip Date:2014.8.5*/
						if (data =="ILLEGAL")
 						{$("#ruleNameInfo").html("<font color='red'>该规则名含有非法字符！</font>");}
	 					else 
	 					/*************************/	
	 						if(data=="ERROR"){
							$("#ruleNameInfo").html("<font color='red'>该规则名已存在！</font>");
						} else {//OK
							$("#ruleNameInfo").html("<font color='green'>该规则名不存在，可用！</font>");
							var groupObj = document.getElementById("rule[ObjectGroupID]").value;
							var actionObj= document.getElementById("rule[ActionId]").value;
			 	 	 		if(checkNonEmpty(groupObj)){
				 	 	 		//alert(groupObj);
			 	 	 			if(checkNonEmpty(actionObj)){
			 	 	 				    document.addRuleForm.submit();
                                        return true;
				 	 	 			}
			 	 	 			else{
			 	 	 				//alert(actionObj);
			 	 	 				$("#actionInfo").html("<font color='red'>行为类别不能为空！</font>");
			 	 	 				return false;
				 	 	 			}
			 	 	 	 	} else {
			 	 	 	 	 	alert("请选择对象组！");
			 	 	 	 		return false;
			 	 	 	 	}
						}
					}
				});
 	 	 		
 	 			
 	 	 	}
 	 		
 		} else {
 			$("#ruleNameInfo").html("<font color='red'>规则名不能为空！</font>");
 			return false;
 		}
 	}
 	function trim(str){ 
 		return str.replace(/(^\s*)|(\s*$)/g, ""); 
 	} 
 	function checkNonEmpty(objText) {
		if(objText.length>0) {
			return true;
		} else {
			return false;
		}
 	}

 	function checkExistedRuleName(){
 		var ruleName = $("#ruleNameText").val();

 		if(ruleName.length > 20){
 			$("#ruleNameInfo").html("<font color='red'>规则名不能大于20个字符！</font>");
 		} else {
 			$.ajax({
 				url:"addAuditRule.php?cmd=checkRuleName&ruleName="+ruleName,
 				type:"post",
 				dataType:"text",
 				success:function(data){
 					if (data =="ILLEGAL")
 						{$("#ruleNameInfo").html("<font color='red'>该规则名含有非法字符！</font>");}
 					else if(data=="ERROR"){
 						$("#ruleNameInfo").html("<font color='red'>该规则名已存在！</font>");
 					} else {//OK
 						$("#ruleNameInfo").html("<font color='green'>该规则名不存在，可用！</font>");
 					}
 				}
 			});
 	 	}
 		
 	}
 	//验证是否不为空
 /*	function checkNonEmpty(o) {
 		if(o.val().trim().length > 0) {
 			return true;
 		} else {
 			return false;
 		}
 	}
 	function checkAction() {
 		if(!checkNonEmpty($("#rule[ActionId]"))) {
 			$("#actionInfo").html("<font color='red'>行为类别不能为空！</font>");
 		} 
 	}*/	
</script>