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
 <body id="body">
 <h5 class="title102" style="position:relative; zoom:1;"><em>非数据库审计事件管理</em> <span></span></h5>
    <div class="itabContent" id="dataDiv"> 
     	 <form action="policy.php?target=rule&cmd=search" method="post" name="SearchForm">
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th>
                                      非数据库审计事件管理                     
           </th>
           </tr>                   
           </tbody>
         </table>
     	 </form>
     	 <!-- 查询区域 -->   	 
  <div class="box102 p20">
  <form action="audit_nonDB.php?cmd=search" method="post" id="searchForm" name="searchForm">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
         <tbody>
                	<tr>
                		<td>服务名：</td>
                		<td>
                			<select name="searchServiceName">
                				<?php 
                				foreach ($serviceList as $service) {
                					?>
                					<option value="<?php echo $service['ServiceName']?>"><?php echo $service['ServiceName']?></option>
                					<?php 
                				}
                				?>
                			</select></td>		
                		<td>协议类型：</td>
                		<td>
                			<select id="searchProtocol" name="searchProtocol">
                				<?php 
                				foreach ($protocolList as $pro) {
                					?>
                					<option value="<?php echo $pro['Protocol']?>"><?php echo $pro['Name']?></option>
                					<?php 
                				}
                				?>
                			</select>
                		</td>
                		<td>开始时间：</td>
                		<td>
                			<input name="beginDate" id='beginDate' value='<?php echo $beginDate?$beginDate:date('Y-m-d');?>' class="Wdate" onClick="WdatePicker()" type="text">
                			<input name="beginTime" id="beginTime" value='<?php echo $beginTime?$beginTime:date('h:i');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                		</td>
               		    <td>结束时间：</td>
               		    <td>
               		    	<input name="endDate" id='endDate' value='<?php echo $endDate?$endDate:date('Y-m-d',strtotime('+1 day'));?>' maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
                        	<input name="endTime" id='endTime' value='<?php echo $endTime?$endTime:date('h:i');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                       	</td>              
                      </tr>
                      <tr>
                      	<td colspan="8"><input type="submit" class="neibu" id="searchButton" name="searchButton" value="查询"></td>
                      </tr>
		</tbody>
	</table>
  </form>
</div>
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
                        <th width="10%">服务名</th>
                        <th width="15%">登录名</th>
                        <th width="15%">开始时间</th>
                        <th width="15%">结束时间</th>
                        <th class="border_r0">操作</th>                        
                    </tr>   
                    <?php  
                       foreach ($nonDBList as $nonDB) {
                    	$targetOpID = "";
                    	$type = "";
                    	if($nonDB['ftpOpID']!='') {
                    		$type = "ftp";
                    		$targetOpID = $nonDB['ftpOpID'];
                    	} else {
                    		$type = "rap";
                    		$targetOpID = $nonDB['rapOpID'];
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
                    	<td><?php echo $nonDB['ServiceName']?></td>
                    	<td><?php echo $nonDB['LoginName']?></td>
                    	<td><?php echo $nonDB['StartTime']?></td>
                    	<td><?php echo $nonDB['EndTime']?></td>
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