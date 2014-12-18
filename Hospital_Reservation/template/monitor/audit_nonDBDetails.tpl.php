<?php
/**
 * audit_nonDBDetails.php-.查看非数据库审计事件的详细信息
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
 <h5 class="title102" style="position:relative; zoom:1;"><em>查看非数据库审计事件</em> <span></span></h5>
 	<input type="hidden" name="opIDHidden" id="opIDHidden" value="<?php echo $targetDB['OpID']?>"/>
 	<!-- 审计策略基本信息 -->
 	<div class="itabContent"> 
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th align="left">
               	非数据库审计事件详细信息
		   </th>
           </tr>                   
           </tbody>
         </table>
         <div class="tabContent">
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
             		<?php 
             		if($type=='ftp') {
             		?>
             		<!-- 以下是FTP事件相关的信息 -->
             		<tr>
                    	<td width="15%" class="td1">操作ID</td>
                    	<td width="35%"><?php echo $targetNonDB['OpID']?></td>
                    	<td width="15%" class="td1">操作类型</td>
                    	<td width="35%" class="border_r0">
                    	<?php 
                    	$opClassId = $targetNonDB[OpClass];
                    	foreach ($ftpOpClassList as $op) {
                    		if($opClassId == $op['OpClass']) {
                    			echo $op['Name'];
                    			break;
                    		}
                    	}
                    	?>
                    	</td>
                    </tr>
                    <tr>
                    	<td class="td1">命令类型</td>
                    	<td>
                    	<?php $tmpId = $targetNonDB['CommandType'];
                    	foreach ($commandTypeList as $command) {
                    		if($tmpId == $command['CommandType']) {
                    			echo $command['Name'];
                    			break;
                    		}
                    	}
                    	?>
                    	</td>
                    	<td class="td1">命令</td>
                    	<td class="border_r0"><?php echo $targetNonDB['Command']?></td>
                    </tr> 
                    <tr>
                    	<td class="td1">操作所用数据包个数</td>
                    	<td><?php echo $targetNonDB['PktNum']?></td>
                    	<td class="td1">数据包所包含字节数</td>
                    	<td class="border_r0"><?php echo $targetNonDB['Bytes']?></td>
                    </tr>        
                    <tr>
                    	<td class="td1">执行时间</td>
                    	<td><?php echo $targetNonDB['ExecTime']?></td>
                    	<td class="td1">执行结果</td>
                    	<td class="border_r0"><?php echo $targetNonDB['ExecResult']==1?'<font color="green">成功</font>':'<font color="red">失败</font>'?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">失败原因</td>
                    	<td colspan="3" class="border_r0"><?php echo $targetNonDB['FailReason']?></td>
                    </tr>     
                       
             		<?php	
             		} else {
             		?>
             		<!-- 以下是RAP事件相关的信息 -->
             		<tr>
                    	<td width="15%" class="td1">操作ID</td>
                    	<td width="35%"><?php echo $targetNonDB['OpID']?></td>
                    	<td width="15%" class="td1">操作类型</td>
                    	<td width="35%" class="border_r0">
                    	<?php 
                    	$opClassId = $targetNonDB['OpClass'];
                    	foreach ($rapOpClassList as $op) {
                    		if($opClassId == $op['OpClass']) {
                    			echo $op['Name'];
                    			break;
                    		}
                    	}
                    	?>
                    	</td>
                    </tr>    
                    <tr>
                    	<td class="td1">执行时间</td>
                    	<td><?php echo $targetNonDB['ExecTime']?></td>
                    	<td class="td1">执行结果</td>
                    	<td class="border_r0"><?php echo $targetNonDB['ExecResult']==1?'<font color="green">成功</font>':'<font color="red">失败</font>'?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">命令</td>
                    	<td><?php echo $targetNonDB['Command']?></td>
                    	<td class="td1">失败原因</td>
                    	<td colspan="3" class="border_r0"><?php echo $targetNonDB['FailReason']?></td>
                    </tr>    
                    <tr>
                    	<td class="td1">操作所用数据包个数</td>
                    	<td><?php echo $targetNonDB['PktNum']?></td>
                    	<td class="td1">数据包所包含字节数</td>
                    	<td class="border_r0"><?php echo $targetNonDB['Bytes']?></td>
                    </tr>    
             		<?php
             		}
             		?>
                    <!-- 以下是会话信息 -->  
                    <tr>
                    	<td class="td1">会话ID</td>
                    	<td><?php echo $targetSession['SessionID']?></td>
                    	<td class="td1">源主机IP</td>
                    	<td class="border_r0"><?php echo $targetSession['SrcIP']?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">源主机端口号</td>
                    	<td><?php echo $targetSession['SrcPort']?></td>
                    	<td class="td1">源主机MAC地址</td>
                    	<td class="border_r0"><?php echo $targetSession['SrcMac']?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">源主机主机名</td>
                    	<td><?php echo $targetSession['SrcHostName']?></td>
                    	<td class="td1">目的主机IP</td>
                    	<td class="border_r0"><?php echo $targetSession['DstIP']?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">目的主机端口号</td>
                    	<td><?php echo $targetSession['DstPort']?></td>
                    	<td class="td1">目的主机MAC地址</td>
                    	<td class="border_r0"><?php echo $targetSession['DstMac']?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">协议名称</td>
                    	<td>
                    		<?php 
                    		$proId = $targetSession['Protocol'];
                    		foreach ($protocolList as $pro) {
                    			if($proId == $pro['Protocol']) {
                    				echo $pro['Name'];
                    				break;
                    			}
                    		}
                    		?>
                    	</td>
                    	<td class="td1">协议版本号</td>
                    	<td class="border_r0"><?php echo $targetSession['ProtocolVersion']?></td>
                    </tr>    
                    <tr>
                    	<td class="td1">数据库版本号</td>
                    	<td><?php echo $targetSession['DatabaseVersion']?></td>
                    	<td class="td1">服务名</td>
                    	<td class="border_r0"><?php echo $targetSession['ServiceName']?></td>
                    </tr>    
                    <tr>
                    	<td class="td1">登录名</td>
                    	<td><?php echo $targetSession['LoginName']?></td>
                    	<td class="td1">终端</td>
                    	<td class="border_r0"><?php echo $targetSession['Terminal']?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">开始时间</td>
                    	<td><?php echo $targetSession['StartTime']?></td>
                    	<td class="td1">结束时间</td>
                    	<td class="border_r0"><?php echo $targetSession['EndTime']?></td>
                    </tr>     
                </tbody>
             </table>     
         </div> 
     </div>
     <div class="itabContent">
	 	<table align="center" width="100%">
	 		<tr>
	            <td class="btn" colspan="2">
	            	<a href="javascript:history.go(-1);" class="repire">返回</a>
	            </td>
	        </tr>
	    </table>
 	</div>
 </body>
 </html>