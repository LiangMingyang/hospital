<?php
/**
 * 已生效的内置规则列表
 * @modification history 
 * ---------------------
 * 2014-1-14,created by liumoyao&zhangxin
 */
include policy_inc();
header('Cache-control: private, must-revalidate');
?>
 <script type="text/javascript">
 function page(pageNo)
 {

	 if(pageNo == -1) {
		 pageNo = $('#pageNum').val();
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
			 var service = $("#serviceSelectHidden").val();
			 window.location.href="inruleList.php?cmd=search&pageNo="+pageNo+"&page=page&serviceSelect="+service;

		 }
		 
	 }
 }
</script>
 <body id="body">
 <input type="hidden" name="policyIdHidden" id="policyIdHidden" value="<?php echo $policyId?>"/>
 <h5 class="title102" style="position:relative; zoom:1;"><em>内置规则管理</em> <span></span></h5>
    <div class="itabContent" id="dataDiv"> 
    <?php 
    if($targetPolicy!=null) {
    ?>
    <font color="blue" style="font-size: 14px;">当前所查看的审计策略:id=<?php echo $targetPolicy['PolicyId']?>,&nbsp;&nbsp;<?php echo $targetPolicy['PolicyName']?></font>
    <?php
    }
    ?>
     	 <form action="inruleList.php?cmd=search" method="post" name="SearchForm">
     	 <input type="hidden" name="serviceSelectHidden" id="serviceSelectHidden" value="<?php echo $serviceId?>"/>
		 <input type="hidden" name="pageNo" id="pageNo" value="<?php echo $pageNo?>"/>
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th>
                                      数据库：<select name="serviceSelect" style="width:250px; "><option value="">全部数据库</option>
           				<?php 
                    			foreach ($serviceList as $ser){
                    				if($serviceId==$ser['ServiceId']) {
                    					?>
                    					<option value="<?php echo $ser['ServiceId']?>" selected="selected"><?php echo $ser['ServerName']?>:<?php echo $ser['Name']?>:<?php echo $ser['ServiceName']?></option>
                    					<?php 
                    				} else {
                    					?>
                    					<option value="<?php echo $ser['ServiceId']?>"><?php echo $ser['ServerName']?>:<?php echo $ser['Name']?>:<?php echo $ser['ServiceName']?></option>
                    					<?php 	
                    				}
                    			}
                    	?>
           				</select>&nbsp;&nbsp;
                		<a href="#" class="tijiao" onclick="javascript:document.SearchForm.submit();">查询</a>
           </th>
           </tr>                   
           </tbody>
         </table>
     	 </form>
     	 
         <div class="tabContent">
            <?php
                       $len = count($inruleList);
                       if ($len<=0){
                       	  echo '<font color="red" style="font-size:14px;">无结果显示，请重试！</font>';
                       } else {
              ?>
              <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                    <tr>
                        <th width="8%">编号</th>
                        <th width="15%">规则名</th>
                        <th width="15%">服务名</th>
                        <th width="15%">规则类型</th>
                        <th width="10%">状态</th>
                        <th class="border_r0">操作</th>                        
                    </tr>   
                    <?php  
                       foreach ($inruleList as $rule) {
                    ?>      
                    <tr>
                    	<td><?php echo $rule['InRuleID']?></td>
                    	<td><a href="inruleDetails.php?ruleId=<?php echo $rule['InRuleID']?>&serviceId=<?php echo $rule['ServiceId']?>"><?php echo $rule['InRuleName'];?></a></td>
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
                    	<?php echo "内置规则"?>
                    	</td>
                    	<td><?php echo $rule['InRuleStatus']==0?"<font color='red'>禁用</font>":"<font color='green'>启用</font>"?></td>
						<td class="border_r0">
							<?php 
                    		if ($rule['InRuleStatus']==0){
                    			?>
                    			<a href="#" class="neibu" style="color: white;" onclick="useInRule(<?php echo $rule['InRuleID']?>,<?php echo $rule['ServiceId']?>);">启用</a>
                    			<?php
                    		} else {
                    			?>
                    			<a href="#" class="neibu" style="color: white;" onclick="cancelInRule(<?php echo $rule['InRuleID']?>,<?php echo $rule['ServiceId']?>);">禁用</a>
                    			<?php 
                    		}
                    		?>&nbsp;&nbsp;
                    		<a href="#" class="neibu" style="color: white;" onclick="deleteInRule(<?php echo $rule['InRuleID']?>,<?php echo $rule['ServiceId']?>);">删除</a>
                    		&nbsp;&nbsp;
                    		<a href="inruleDetails.php?ruleId=<?php echo $rule['InRuleID']?>
							&pageNo=<?php echo $pageNo?>&serviceId=<?php echo $rule['ServiceId']?>" class="neibu" style="color: white;">查看</a>
                    	</td>
                    </tr>       
                    <?php 
                       }
                    ?>     
                </tbody>
             </table>   
             <?php  }?>  
         </div>
         <!-- 
         <div class="page2 clearfix">
             	<p><a href="#" class="pre">上一页</a><a href="#" class="num">1</a><span class="numon">2</span><a href="#" class="num">3</a><a href="#" class="num">4</a><a href="#" class="num">5</a><a href="#" class="num">...</a><a href="#" class="num">19</a><a href="#" class="num">20</a><a href="#" class="next">下一页</a> <input type="text" /> <a href="#">跳转</a></p>本页显示1-20条信息
         </div>     
          -->
        <?php echo $page->toString()?>
     </div>    
 </body>
 </html>