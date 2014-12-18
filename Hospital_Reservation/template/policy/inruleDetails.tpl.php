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
<h5 class="title102"><em>查看内置审计规则信息</em></h5>
          <div class="box102 p20">
       		 <form action="policy.php?target=rule&cmd=update&id=<?php echo $targetRule['RuleID']?>" method="post" name="updateRuleForm">
       		 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                    	<td width="20%" class="td1">
                        	所属数据库：
                        </td>
                        <td>
							<?php echo $dbname?>
                        </td>
                    </tr>
                	<tr>
                    	<td width="20%" class="td1">
                        	规则编号：
                        </td>
                        <td>
							<?php echo $innerrule['InRuleID']?>
                        </td>
                    </tr>
                    <tr>
                    	<td width="20%" class="td1">
                        	规则名称：
                        </td>
                        <td>
							<?php echo $innerrule['InRuleName']?>
                        </td>
                    </tr>                   
                    <tr>
                    	<td width="20%" class="td1">
                        	操作类型：
                        </td>
                        <td>
							<?php echo $opname?>
                        </td>
                    </tr>
                    <tr>
                    	<td width="20%" class="td1">
                        	Sql语句类型：
                        </td>
                        <td>
							<?php echo $sqltype?>
                        </td>
                    </tr>
                    <tr>
                    	<td width="20%" class="td1">
                        	对象类型：
                        </td>
                        <td>
							<?php echo $objtype?>
                        </td>
                    </tr>
                    <tr>
                    	<td width="20%" class="td1">
                        	关键字：
                        </td>
                        <td>
							<?php echo $innerrule['KeyWord']?>
                        </td>
                    </tr>
                    <tr>
                    	<td width="20%" class="td1">
                        	用户名：
                        </td>
                        <td>
							<?php echo $innerrule['LoginName']?>
                        </td>
                    </tr>
                    <tr>
                    	<td width="20%" class="td1">
                        	风险等级：
                        </td>
                        <td>
							<?php echo $risklevel?>
                        </td>
                    </tr>
                    <tr>
                        <td class="btn" colspan="2">
						<!--
                        	<a href="javascript:history.go(-1);" class="repire">返回</a>
							-->
							<a href="/policy/inruleList.php?cmd=search&pageNo=<?php echo $pageNo?>&serviceSelect=<?php echo $serviceId?>" class="repire">返回</a>
                        </td>
                    </tr>
                </tbody>
             </table>
             </form>
          </div>
     
 </body>
 </html>