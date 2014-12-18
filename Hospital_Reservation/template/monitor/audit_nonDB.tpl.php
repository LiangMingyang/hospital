<?php
/**
 * 非数据库审计事件管理
 * addPolicy.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-16,created by Chenhuan
 */
include audit_header_inc();
 ?>
 <script type="text/javascript">
 function page(pageNo)
 {
	 if(pageNo == -1){
		pageNo = $('#pageNum').val();
	 }
	 var service = $("#serviceSelectHidden").val();
	 window.location.href="policy.php?target=rule&cmd=search&pageNo="+pageNo+"&page=page&serviceSelect="+service+"&policyId="+$("policyIdHidden").val();
 }

 function page(pageNo) {
		var serviceName = $("#searchNameHidden").val();
		var protocol = $("#searchProtocolHidden").val();
		var beginDate = $("#beginDateHidden").val();
		var beginTime = $("#beginTimeHidden").val();
		var endDate = $("#endDateHidden").val();
		var endTime = $("#endTimeHidden").val();
		if(pageNo == -1){
			pageNo = $('#pageNum').val();
		}
		window.location.href="audit_nonDB.php?cmd=search&pageNo="+pageNo+"&page=page&searchServiceName="+serviceName+"&searchProtocol="+protocol+"&beginDate="+beginDate
		+"&beginTime="+beginTime+"&endDate="+endDate+"&endTime="+endTime;
//		document.searchForm.action="audit_nonDB.php?cmd=search&pageNo="+pageNo+"&page=page";
//		document.searchForm.submit();
}
function searchNonDB() {
		var serviceName = $("#searchServiceName").val();
		var protocol = $("#searchProtocol").val();
		var beginDate = $("#beginDate").val();
		var beginTime = $("#beginTime").val();
		var endDate = $("#endDate").val();
		var endTime = $("#endTime").val();

		$("#searchNameHidden").val(serviceName);
		$("#searchProtocolHidden").val(protocol);
		$("#beginDateHidden").val(beginDate);
		$("#beginTimeHidden").val(beginTime);
		$("#endDateHidden").val(endDate);
		$("#endTimeHidden").val(endTime);
		document.searchForm.action="audit_nonDB.php?cmd=search";
		document.searchForm.submit();
}
</script>
 <body id="body">
 <h5 class="title102" style="position:relative; zoom:1;"><em>非数据库审计事件管理</em> <span></span></h5>
   <!-- 查询区域 -->   	 
  <div class="box102 p20">
  <form action="audit_nonDB.php?cmd=search" method="post" id="searchForm" name="searchForm">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
         <tbody>
                	<tr>
                		<td>数据库：
                			<select name="searchServiceName" id="searchServiceName" style="width: 150px;">
                				<option value="">全部</option>
 								<?php 
                				foreach ($serviceList as $ser) {
                					if($ser['ServiceName']==$searchServiceName) {
                						?>
                						<option value="<?php echo $ser['ServiceName']?>" selected="selected"><?php echo $ser['ServerName']?>:<?php echo $ser['Name']?>:<?php echo $ser['ServiceName']?></option>
                						<?php 
                					} else {
                						?>
                						<option value="<?php echo $ser['ServiceName']?>"><?php echo $ser['ServerName']?>:<?php echo $ser['Name']?>:<?php echo $ser['ServiceName']?></option>
                						<?php 
                					}
                				}
                				?>
                			</select></td>		
                		<td>协议类型：
                			<select id="searchProtocol" name="searchProtocol">
                				<option value="">全部</option>
                				<?php 
                				foreach ($protocolList as $pro) {
                					if ($pro['Protocol']==$searchProtocol) {
                						?>
	                					<option value="<?php echo $pro['Protocol']?>" selected="selected"><?php echo $pro['Name']?></option>
	                					<?php 
                					} else {
                						?>
	                					<option value="<?php echo $pro['Protocol']?>"><?php echo $pro['Name']?></option>
	                					<?php 	
                					}
                				}
                				?>
                			</select>
                		</td>
                		<td>开始时间：
                			<input name="beginDate" id='beginDate' value='<?php echo $beginDate?$beginDate:date('Y-m-01');?>' class="Wdate" onClick="WdatePicker()" type="text">
                			<input name="beginTime" id="beginTime" value='<?php echo $beginTime?$beginTime:date('h:i');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                		</td>
               		    <td>结束时间：
               		    	<input name="endDate" id='endDate' value='<?php echo $endDate?$endDate:date('Y-m-d');?>' maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
                        	<input name="endTime" id='endTime' value='<?php echo $endTime?$endTime:date('h:i');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                       	</td>              
                      </tr>
                      <tr>
                      	<td colspan="4">
                      		<!-- 
                      		<input type="button" class="neibu" id="searchButton" name="searchButton" value="查询" onclick="searchNonDB();">
                      		 -->
                      		<a href="#" id="searchButton" name="searchButton" class="neibu" onclick="searchNonDB();">查询</a>
                      	</td>
                      </tr>
		</tbody>
	</table>
	<input type="hidden" name="searchNameHidden" id="searchNameHidden" value="<?php echo $searchServiceName?>"/>
	<input type="hidden" name="searchProtocolHidden" id="searchProtocolHidden" value="<?php echo $searchProtocol?>"/>
	<input type="hidden" name="beginDateHidden" id="beginDateHidden" value="<?php echo $beginDate?>"/>
	<input type="hidden" name="beginTimeHidden" id="beginTimeHidden" value="<?php echo $beginTime?>"/>
	<input type="hidden" name="endDateHidden" id="endDateHidden" value="<?php echo $endDate?>"/>
	<input type="hidden" name="endTimeHidden" id="endTimeHidden" value="<?php echo $endTime?>"/>
  </form>
</div>

  <div class="box102 p20">
         <div class="tabContent">
            <?php
                       $len = count($nonDBList);
                       if ($len<=0){
                       	  echo '<font color="red" style="font-size:14px;">无结果显示，请重试！</font>';
                       } else {
              ?>
              <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                    <tr>
                        <th width="8%">会话ID</th>
                        <th width="10%">协议名称</th>
                        <th width="15%">登录名</th>
                        <th width="15%">用户IP</th>
                        <th width="20%">执行时间</th>
                        <th class="border_r0">操作</th>                        
                    </tr>   
                    <?php  
                       foreach ($nonDBList as $nonDB) {
                    	$targetOpID = "";
                    	$type = "";
                    	$targetExecTime = "";
                    	if($nonDB['ftpOpID']!='') {
                    		$type = "ftp";
                    		$targetOpID = $nonDB['ftpOpID'];
                    		$targetExecTime = $nonDB['ftpExecTime'];
                    	} else {
                    		$type = "rap";
                    		$targetOpID = $nonDB['rapOpID'];
                    		$targetExecTime = $nonDB['rapExecTime'];
                    	}
                    	
                    ?>      
                    <tr>
                    	<td><?php echo $nonDB['SessionID']?></td>
                    	<td>
                    		<?php $tmpId=$nonDB['Protocol'];
                    		foreach ($protocolList as $pro) {
                    			if($tmpId == $pro['Protocol']) {
                    				echo $pro['Name'];
                    				break;
                    			}
                    		}
                    		?>
                    	</td>
                    	<td><?php echo $nonDB['LoginName']?></td>
                    	<td><?php echo $nonDB['SrcIP']?></td>
                    	<td><?php echo $targetExecTime?></td>
                    	<td class="border_r0">
							<a href="#" class="neibu" style="color: white;" onclick="deleteNonDBOperation(<?php echo $targetOpID?>,'<?php echo $type?>');">删除</a>&nbsp;&nbsp;
							<a href="#" class="neibu" style="color: white;" onclick="viewNonDBOperation(<?php echo $targetOpID?>,'<?php echo $type?>');">查看</a>
                    	</td>
                    </tr>       
                    <?php 
                       }
                    ?>     
                </tbody>
             </table>   
             <?php  }?>  
         </div>
        <?php echo $page->toString()?>
    </div>
 </body>
 </html>