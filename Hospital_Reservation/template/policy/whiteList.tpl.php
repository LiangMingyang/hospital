<?php
/**
 * 白名单列表管理
 * whiteList.tpl.php-.
 * @author Chenhuan
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-14,created by Chenhuan
 */
//include header_inc();
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
/*白名单管理的分页*/
function whitePage(pageNo){
	
//	if(pageNo == -1){
//		pageNo = $('#whitePageNum').val();
//	}
//	policyId = $("#policyIdHidden").val();
//	var searchName = $("#searchPolicyHidden").val();
//	window.location.href="policy.php?target=white&cmd=search&searchPolicy="+searchName+"&policyId="+policyId+"&page=whitePage&pageNo="+pageNo;

	 
	 if(pageNo == -1) {
		 pageNo = $('#whitePageNum').val();
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
			 policyId = $("#policyIdHidden").val();
			 var searchName = $("#searchPolicyHidden").val();
			 window.location.href="whiteList.php?cmd=search&searchPolicy="+searchName+"&page=whitePage&pageNo="+pageNo;

		 }
		 
	 }
	
}

function check_danger(str){
		var reg = /[|&;$%@,\'"<>()+]/;	
		var res=reg.test(str);
		if(res){
					return true;
				}
		else{
	             return false;
			}
	
}
function checkPolicyName(){
	var policy = $("#searchPolicy").val();
	if(policy.length>20){
		artDialog({content:'输入的审计策略名称不能超过20个字符！', style:'error'}, function(){
			
		});
		return false;
	}
	if(check_danger(policy)){
		 artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
		return false;
	}
	return true;
}
</script>
 <body id="body">
 <input type="hidden" name="policyIdHidden" id="policyIdHidden" value="<?php echo $policyId?>"/>
 <h5 class="title102" style="position:relative; zoom:1;"><em>白名单管理</em> <span></span></h5>
    <div class="itabContent"> 
    <?php 
    if($targetPolicy!=null) {
    ?>
    <font color="blue" style="font-size: 14px;">当前所查看的审计策略:id=<?php echo $targetPolicy['PolicyId']?>,&nbsp;&nbsp;<?php echo $targetPolicy['PolicyName']?></font>
    <?php
    }
    ?>
    <form action="whiteList.php?cmd=search" method="post" name="SearchForm">
    <input type="hidden" name="searchPolicyHidden" id="searchPolicyHidden" value="<?php echo $policyName?>"/>
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th>
             	策略名称：<input type="text" name="searchPolicy" id="searchPolicy" value="<?php echo $policyName?>"/>&nbsp;
                <a href="#" class="tijiao" onclick="javascript:if(checkPolicyName()){document.SearchForm.submit();}">查询</a>
           </th>
		   <th align="right">
                <div class="btn"">
                    <a href="#" class="neibu" onclick="addPolicyWhite();">添加</a>
				</div>
			</th>
           </tr>                   
           </tbody>
         </table>
         </form>
         <div class="tabContent">
     	 	<?php 
     	 	$len=count($whiteList);
     	 	if ($len <= 0) {
     	 		echo '<font color="red" style="font-size:14px;">无白名单记录显示，请重试！</font>';
     	 	} else {
     	 	?>
     	 	
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                	<tr>
                        <th width="8%">编号</th>
                        <th width="20%">策略名称</th>
                        <th width="18%">IP范围名称</th>
                        <th width="15%">起始IP</th>
                        <th width="15%">终止IP</th>
                        <th class="border_r0">操作</th>                        
                    </tr>  
                    <?php 
                    	foreach ($whiteList as $white){
                    ?>          
                    <tr>
                    	<td><?php echo $white['WhiteListId']?></td>
                    	<td><?php echo $white['PolicyName']?></td>
                    	<td><?php echo $white['RangeName']?></td>
                    	<td><?php echo ($white['StartIP'])?></td>
                    	<td><?php echo ($white['EndIP'])?></td>
						<td><a href="#" class="neibu" style="color: white;" onclick="deletePolicyWhite(<?php echo $white['WhiteListId']?>);">删除</a></td>
                    </tr>       
                    <?php }?>   
                </tbody>
             </table> 
             <?php
     	 	}
     	 	?>    
         </div>
         <?php echo $page->toString()?>         
     </div>
    
     <!-- 添加白名单时，显示不包含的白名单列表 -->
     <div id="addPolicyWhiteForm" title="添加审计策略白名单" style="display: none;">
		<form action="">
			<table id="policyWhiteGrid" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<td>选择审计策略：</td>
					<td>
						<select id="policySelector" name="policySelector" style="width: 200px;">
							<?php 
							foreach ($policyList as $policy) {
								?>
								<option value="<?php echo $policy['PolicyId']?>"><?php echo $policy['PolicyName']?></option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>选择IP范围：</td>
					<td>
						<select id="ipRangeSelector" name="ipRangeSelector" style="width: 200px;">
							<?php 
							foreach ($ipRangeList as $ipRange) {
								?>
								<option value="<?php echo $ipRange['RangeID']?>"><?php echo $ipRange['RangeName']?></option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
			</table>
		</form>
	 </div>     
 </body>
 </html>