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

 ?>
<script type="text/javascript">
//对象组当中的分页
function objectPage(pageNo) {

	if(pageNo == -1) {
		pageNo = $('#objectPageNum').val();
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
			 var groupId = $("#groupIdHidden").val();
			window.location.href="groupDetails.php?groupId="+groupId+"&objectPage=objectPage&objectPageNo="+pageNo;
		 } 
	 }
}
</script>
 <body id="body">
 <h5 class="title102" style="position:relative; zoom:1;"><em>查看对象组</em> <span></span></h5>
 	<input type="hidden" name="groupIdHidden" id="groupIdHidden" value="<?php echo $id?>"/>
 	<!-- 对象组基本信息 -->
 	<div class="itabContent"> 
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th align="left">
               	对象组基本信息
		   </th>
           </tr>                   
           </tbody>
         </table>
         <div class="tabContent">
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
             		<tr>
                    	<td width="30%">对象组编号</td>
                    	<td><?php echo $targetGroup['ObjectGroupID']?></td>
                    </tr>      
                    <tr>
                    	<td>对象组名称</td>
                    	<td><?php echo $targetGroup['GroupName']?></td>
                    </tr>
                    <tr>
                    	<td>服务名</td>
                    	<td>
                    		<?php $tmp = $targetGroup['ServiceID'];
                    			foreach ($serviceList as $service) {
                    				if($tmp == $service['ServiceId']) {
                    					echo $service['ServiceName'];
                    					break;	
                    				}
                    			}
                    		?>
                    	</td>
                    </tr> 
                    <tr>
                    	<td>协议名称</td>
                    	<td>
                    		<?php $tmp = $targetGroup['ServiceID'];
                    			foreach ($serviceList as $service) {
                    				if($tmp == $service['ServiceId']) {
                    					echo $service['Name'];
                    					break;	
                    				}
                    			}
                    		?>
                    	</td>
                    </tr> 
                    <tr>
                    	<td>服务器名称</td>
                    	<td>
                    		<?php $tmp = $targetGroup['ServiceID'];
                    			foreach ($serviceList as $service) {
                    				if($tmp == $service['ServiceId']) {
                    					echo $service['ServerName'];
                    					break;	
                    				}
                    			}
                    		?>
                    	</td>
                    </tr> 
                </tbody>
             </table>     
         </div> 
     </div>
     
    <!-- 该对象组所包含的对象 -->
    <div class="itabContent"> 
    <form action="objectGroupList.php?cmd=searchObject" method="post">
    <input type="hidden" name="searchGroupSelectorHidden" id="searchGroupSelectorHidden" value="<?php echo $selectGroupId?>"/>
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tr>
           		<th align="left">
               		包含的对象列表
              	</th>
              	<th align="right">
                	<div class="btn" style="width: 150px;">
                    	<a href="#" class="neibu" onclick="addObjectToGroup();">添加对象</a>
					</div>
				</th>
          </tr>                        
         </table>
         </form>
         <div class="tabContent">
     	 	<?php 
     	 	$len=count($objectList);
     	 	if ($len <= 0) {
     	 		echo '<font color="red" style="font-size:14px;">无对象记录显示，请重试！</font>';
     	 	} else {
     	 	?>
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                	<tr>
                        <th width="12%">编号</th>
                        <th width="30%">对象名称</th>
                        <th width="30%">对象类型</th>
                        <th class="border_r0">操作</th>                        
                    </tr>  
                    <?php 
                    	foreach ($objectList as $obj){
                    ?>          
                    <tr>
                    	<td><?php echo $obj['ObjectID']?></td>
                    	<td><?php echo $obj['ObjectName']?></td>
                    	<td><?php echo $obj['Name']?>(<?php echo $obj['Description']?>)</td>
						<td><a href="#" class="neibu" style="color: white;" onclick="deleteObjectFromGroup(<?php echo $obj['ObjectID']?>);">删除</a></td>
                    </tr>       
                    <?php }?>   
                </tbody>
             </table> 
             <?php
     	 	}
     	 	?>    
         </div>
         <?php echo $objPage->toString()?>         
     </div>
 	
 	<div class="itabContent">
 	<table align="center" width="100%">
 		<tr>
                        <td class="btn" colspan="2">
                        	<a href="objectGroupList.php" class="repire">返回</a>
                        </td>
                    </tr>
    </table>
 	</div>
    <!-- 添加对象-->
     <div id="addObjectToGroupForm" title="添加数据库对象" style="display: none;">
		<form action="">
			<table id="objectGrid" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<td>对象名称：</td>
					<td><input type="text" name="newObjectName" style="width: 200px;" id="newObjectName" value=""/></td>
				</tr>
				<tr>
					<td>对象类型：</td>
					<td>
						<select id="objectTypeSelector" name="objectTypeSelector" style="width: 200px;">
							<?php 
							foreach ($objTypeList as $type) {
								?>
								<option value="<?php echo $type['ObjectType']?>"><?php echo $type['Name']?></option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>选择对象组：</td>
					<td>
						<select id="objectGroupSelector" name="objectGroupSelector" disabled="disabled" style="width: 200px;">
							<option value="<?php echo $targetGroup['ObjectGroupID']?>"><?php echo $targetGroup['GroupName']?></option>
						</select>
					</td>
				</tr>
			</table>
			<span id="objectInfo"></span>
		</form>
	 </div>     
 </body>
 </html>