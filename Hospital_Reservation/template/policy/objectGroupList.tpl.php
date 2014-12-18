<?php
/**
 * 对象组管理
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
//对象组当中的分页
function objectPage(pageNo) {
	
//	if(pageNo == -1){
//		pageNo = $('#objectPageNum').val();
//	}
//	var group = $("#searchGroupSelectorHidden").val();
//	window.location.href="objectGroupList.php?cmd=searchObject&searchGroupSelector="+group+"&objectPage=objectPage&objectPageNo="+pageNo;

	
	if(pageNo == -1) {
		pageNo = $('#objectPageNum').val();
	 }
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#objectPageCount").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		var group = $("#searchGroupSelectorHidden").val();
		window.location.href="objectGroupList.php?cmd=searchObject&searchGroupSelector="+group+"&objectPage=objectPage&objectPageNo="+pageNo;
	 }
}

function groupPage(pageNo) {

	if(pageNo == -1) {
		pageNo = $('#groupPageNum').val();
	 }
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#groupPageCount").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		selectServiceId = $("#searchGroupServiceHidden").val();
		window.location.href="objectGroupList.php?cmd=searchGroup&groupPage=groupPage&groupPageNo="+pageNo+"&searchServiceId="+selectServiceId;
	 }
}
</script>
 <body id="body">
 <input type="hidden" name="policyIdHidden" id="policyIdHidden" value="<?php echo $policyId?>"/>
 <h5 class="title102" style="position:relative; zoom:1;"><em>对象组管理</em> <span></span></h5>
	<?php 
	if($delGroupError==true) {
		?>
		<script type="text/javascript">
		alert("该对象组已被使用，有关联数据，不能删除！");
		</script>
		<?php
	}
	?>
	
	
  <div class="box102 p20">
  	<form action="objectGroupList.php?cmd=searchGroup" method="post">
    <input type="hidden" name="searchGroupServiceHidden" id="searchGroupServiceHidden" value="<?php echo $selectServiceId?>"/>
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tr>
           <th align="left">
               	对象组列表：
               	<select name="searchServiceId" id="searchServiceId" style="width: 200px;">
                				<option value="">全部</option>
 								<?php 
                				foreach ($serviceList as $ser) {
                					if($ser['ServiceId']==$selectServiceId) {
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
               	<input type="submit" class="tijiao" value="查询"/>
		   </th>
                        <th align="right">
                        	<div class="btn" style="width: 150px;">
                       	 		<a href="#" class="neibu" onclick="addObjectGroup();">添加对象组</a>
							</div>
						</th>
          </tr>                        
         </table>
    </form>
         <div class="tabContent">
     	 	<?php 
     	 	$len=count($objectGroupList);
     	 	if ($len <= 0) {
     	 		echo '<font color="red" style="font-size:14px;">无对象组记录显示，请重试！</font>';
     	 	} else {
     	 	?>
     	 	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                	<tr>
                        <th width="8%">编号</th>
                        <th width="30%">对象组名称</th>
                        <th width="15%">服务器名</th>
                        <th width="15%">服务名</th>
                        <th width="15%">数据库名</th>
                        <th class="border_r0">操作</th>                        
                    </tr>  
                    <?php 
                    	foreach ($objectGroupList as $group){
                    ?>          
                    <tr>
                    	<td width="8%"><?php echo $group['ObjectGroupID']?>&nbsp;</td>
                    	<td width="30%"><?php echo $group['GroupName']?>&nbsp;</td>
                    	
                    	<?php $tmpId = $group['ServiceID'];
                    	$tmpServer="";
                    	$tmpService="";
                    	$tmpName="";
                    	foreach ($serviceList as $service){
                    		if($tmpId == $service['ServiceId']) {
                    			$tmpServer = $service['ServerName'];
                    			$tmpService = $service['ServiceName'];
                    			$tmpName = $service['Name'];
                    			break;
                    		}
                    	}
                    	?>
                    	<td width="15%">
                    	<?php echo $tmpServer?>&nbsp;
                    	</td>
                    	<td width="15%">
                    	<?php echo $tmpService?>&nbsp;
                    	</td>
                    	<td width="15%">
                    	<?php echo $tmpName?>&nbsp;
                    	</td>
						<td class="border_r0">
							<a href="#" class="neibu" style="color: white;" onclick="viewObjectGroup(<?php echo $group['ObjectGroupID']?>);">查看</a>
							<a href="#" class="neibu" style="color: white;" onclick="deleteObjectGroup(<?php echo $group['ObjectGroupID']?>);">删除</a>
						</td>
                    </tr>       
                    <?php }?>   
                </tbody>
             </table> 
             <?php
     	 	}
     	 	?>    
         </div>
         <?php echo $groupPage->toString()?>         
     </div>
     
     
<div class="box102 p20">
    <form action="objectGroupList.php?cmd=searchObject" method="post">
    <input type="hidden" name="searchGroupSelectorHidden" id="searchGroupSelectorHidden" value="<?php echo $selectGroupId?>"/>
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tr>
           <th align="left">
               	对象列表：
               	<!-- 
               		<select id="searchGroupSelector" name="searchGroupSelector">
               		<option value="ALL">显示所有</option>
         			<?php 
               		foreach ($objectGroupList as $group) {
               			?>
               			<option value="<?php echo $group['ObjectGroupID']?>"><?php echo $group['GroupName']?></option>
               			<?php
               		}
               		?>
               	</select>&nbsp;&nbsp;
               	<input type="submit" class="tijiao" value="查询"/>
               	 -->
		   </th>
                        <th align="right">
                        	<div class="btn" style="width: 150px;">
                       	 		<a href="#" class="neibu" onclick="addObject();">添加对象</a>
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
                        <th width="8%">编号</th>
                        <th width="18%">对象名称</th>
                        <th width="20%">对象类型</th>
                        <th width="10%">所属组ID</th>
                        <th width="20%">所属组名称</th>
                        <th class="border_r0">操作</th>                        
                    </tr>  
                    <?php 
                    	foreach ($objectList as $obj){
                    ?>          
                    <tr>
                    	<td><?php echo $obj['ObjectID']?></td>
                    	<td><?php echo $obj['ObjectName']?></td>
                    	<td><?php echo $obj['Name']?>(<?php echo $obj['Description']?>)</td>
                    	<td><?php echo $obj['ObjectGroupID']?></td>
                    	<td><?php echo $obj['GroupName']?></td>
						<td class="border_r0"><a href="#" class="neibu" style="color: white;" onclick="deleteObject(<?php echo $obj['ObjectID']?>);">删除</a></td>
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
    
     <!-- 添加对象组 -->
     <div id="addObjectGroupForm" title="添加对象组" style="display: none;">
		<form action="">
			<table id="objectGroupGrid" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<td>对象组名称：</td>
					<td>
						<input type="text" name="newGroupName" id="newGroupName" value="" style="width: 250px;"/>
						<span style="color:red;">*</span>
					</td>
				</tr>
				<tr>
					<td>选择数据库：</td>
					<td>
						<select id="serviceSelector" name="serviceSelector" style="width: 250px;">
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
			</table>
			<span id="groupInfo"></span>
		</form>
	 </div>     
	 
	 <!-- 添加对象-->
     <div id="addObjectForm" title="添加数据库对象" style="display: none;">
		<form action="">
			<table id="objectGrid" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<td>对象名称：</td>
					<td><input type="text" name="newObjectName" style="width: 200px;" id="newObjectName" value=""/><span style="color:red;">*</span></td>
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
						<select id="objectGroupSelector" name="objectGroupSelector" style="width: 200px;">
							<?php 
							foreach ($objectGroupList as $objGroup) {
								?>
								<option value="<?php echo $objGroup['ObjectGroupID']?>"><?php echo $objGroup['GroupName']?></option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
			</table>
			<span id="objectInfo"></span>
		</form>
	 </div>     
 </body>
 </html>