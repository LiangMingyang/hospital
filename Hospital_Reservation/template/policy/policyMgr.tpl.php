<?php
/**
 * 审计策略列表管理
 * strategyList.tpl.php-.
 * @author Chenhuan
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-14,created by Chenhuan
 */
include policy_inc();
 ?>
<script type="text/javascript">
 function policyPage(pageNo)
 {
//	 if(pageNo == -1){
//		pageNo = $('#policyPageNum').val();
//	 }
//	 window.location.href="policyMgr.php?page=policyPage&pageNo="+pageNo;

	 if(pageNo == -1) {
		 pageNo = $('#policyPageNum').val();
	 }
	
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#pageCountHidden").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 var currentPageNo = parseInt($(".numon").html());
		 if(parseInt(pageNo)==currentPageNo){
			alert("当前为"+pageNo+"页");
		 } else{
			 window.location.href="policyMgr.php?page=policyPage&pageNo="+pageNo;
		 }
		 
	 }
 }
</script>
 <body id="body">
 <h5 class="title102" style="position:relative; zoom:1;"><em>审计策略管理</em> <span></span></h5>
    <div class="box102 p20">
         	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
             		<tr>
                        <th align="right">
                        	<div class="btn" style="width: 100px;">
                       	 		<a href="javascript:void(0)" class="neibu" onclick="showAddPolicy();">添加</a>
							</div>
						</th>
                    </tr>                 
             </table>
              <div class="tabContent">
     	 		<div>
     	 		<?php 
	     	 	$len=count($policyList);
	     	 	if ($len <= 0) {
	     	 		echo '<font color="red" style="font-size:14px;">没有审计策略记录！</font>';
	     	 	} else {
     	 		?>
             <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                	<tr>
                        <th>编号</th>
                        <th>策略名称</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>是否启用</th>
                        <th class="border_r0">其他操作</th>                        
                    </tr>            
                    <?php
                       foreach ($policyList as $policy) {
                       	if($policy['PolicyId']==1){
                    ?>
                    <tr>
                        <td><?php echo "1"?></td>
                        <td><a href="policyDetails.php?policyId=1"><?php echo $policy['PolicyName']?></a></td>
						<td><?php echo $policy['CreateTime']?></td>
						<td><?php echo $policy['ModifyTime']?></td>
						<td><?php echo $policy['Enabled']==1?'<font color="green">已启用</font>':'<font color="red">未启用</font>'?></td>
                        <td class="border_r0">
                    		<?php 
                    		if ($policy['Enabled']==1){
                    			?>
                    			<a href="#" class="neibu" style="color: white;" onclick="cancelUsePolicy(<?php echo $policy['PolicyId']?>);">禁用</a>
                    			<?php
                    		} else {
                    			?>
                    			<a href="#" class="neibu" style="color: white;" onclick="usePolicy(<?php echo $policy['PolicyId']?>);">启用</a>
                    			<?php 
                    		}
                    		?>
                    		&nbsp;&nbsp;
                    		<a href="InPolicyDetails.php" class="neibu" style="color: white;">查看</a>
                    	</td>
                     </tr>
                    <?php
                       	}
                       	else{
                    ?>
                    <tr>
                        <td><?php echo $policy['PolicyId']?></td>
                        <td><a href="policyDetails.php?policyId=<?php echo $policy['PolicyId']?>"><?php echo $policy['PolicyName']?></a></td>
						<td><?php echo $policy['CreateTime']?></td>
						<td><?php echo $policy['ModifyTime']?></td>
						<td><?php echo $policy['Enabled']==1?'<font color="green">已启用</font>':'<font color="red">未启用</font>'?></td>
                        <td class="border_r0">
                    		<?php 
                    		if ($policy['Enabled']==1){
                    			?>
                    			<a href="#" class="neibu" style="color: white;" onclick="cancelUsePolicy(<?php echo $policy['PolicyId']?>);">禁用</a>
                    			<?php
                    		} else {
                    			?>
                    			<a href="#" class="neibu" style="color: white;" onclick="usePolicy(<?php echo $policy['PolicyId']?>);">启用</a>
                    			<?php 
                    		}
                    		?>
                    		&nbsp;&nbsp;
                    		<a href="#" class="neibu" style="color: white;" onclick="deletePolicy(<?php echo $policy['PolicyId']?>);">删除</a>
                    		<?php
                    		?>&nbsp;&nbsp;
                    		<a href="policyDetails.php?policyId=<?php echo $policy['PolicyId']?>" class="neibu" style="color: white;">查看</a>
                    	</td>
                     </tr>
                     <?php } 
                       }?>
                    
                </tbody>
             </table>
             <?php }?>
         </div>
        </div>
        <?php echo $page->toString()?>
        
     <!-- 添加新策略对话框 -->
     <div id="addPolicyDiv" title="添加新审计策略" style="display: none;">
		<form action="">
			<table id="addNewPolicyGrid" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<td>策略名称：</td>
					<td align="left"><input type="text" name="newPolicyName" id="newPolicyName"/></td>
				</tr>
				<!-- 
				<tr>
					<td>数据库：</td>
					<td><?php require "../cfg/services.php"?></td>
				</tr>
				 -->
				<tr>
					<td>是否启用：</td>
					<td align="left">
						<input type="radio" name="newPolicyStatus" value="1" checked="checked"/>启用<input type="radio" name="newPolicyStatus" value="0"/>禁用
					</td>
				</tr>
			</table>
			<span id="warningInfo"></span>
		</form>
	 </div>
	 </div>
 </body>
 </html>