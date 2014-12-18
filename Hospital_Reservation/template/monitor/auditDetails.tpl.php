<?php
/**
 * auditDetails.php-.查看审计事件的详细信息
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-16,created by Chenhuan
 */
include header_inc();
 ?>
 
<link href="<?php echo CSS_PATH?>flexigrid/back_flexigrid.css?>" rel="stylesheet"
	type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH?>monitor/audit.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>monitor/back_flexigrid.js?"></script>

 <body id="body">
 <h5 class="title102" style="position:relative; zoom:1;"><em>查看审计事件</em> <span></span></h5>
 	<!-- 审计策略基本信息 -->
 	<div class="itabContent"> 
     	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
           <tbody>
           <tr>
           <th align="left">
               	审计事件基本信息
		   </th>
           </tr>                   
           </tbody>
         </table>
         <div class="tabContent">
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
             		<tr>
                    	<td width="15%" class="td1">编号</td>
                    	<td width="35%"><?php echo $targetDB['OpID']?></td>
                    	<td class="td1">执行时间</td>
                    	<td class="border_r0"><?php echo $targetDB['ExecTime']?></td>
                    </tr>
                    <tr>
                    	<td class="td1">SQL语句字符串</td>
                    	<td class="border_r0" colspan="3"><?php $new = htmlspecialchars($targetDB['SqlString'], ENT_QUOTES);echo $new;?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">执行结果</td>
                    	<td><?php echo $targetDB['ExecResult']==1?'<font color="green">成功</font>':'<font color="red">失败</font>'?></td>
                    	<td class="td1">失败原因</td>
                    	<td class="border_r0">
                    		<?php if($targetDB['FailReason']=='Too many connections'){
                    			echo $targetDB['FailReason']."<font color='red'>(用户并发数超过限制)</font>";
                    		} else {
                    			echo $targetDB['FailReason'];
                    		}
                    		?>
                    	</td>
                    </tr>     
                    <tr>
                    	<td class="td1">返回结果字符串</td>
                    	<td><?php echo $targetDB['ResponseString']?></td>
                    	<td class="td1">风险级别</td>
                    	<td class="border_r0">
                    	<?php $riskId = $targetDB['RiskLevel'];
                    	foreach ($riskLevelList as $risk) {
                    		if($riskId == $risk['RiskLevel']) {
                    			echo $risk['Description'];
                    			break;
                    		}
                    	}
                    	?>
                    	</td>
                    </tr>     
                    <tr>
                    	<td class="td1">操作所用数据包个数</td>
                    	<td><?php echo $targetDB['PktNum']?></td>
                    	<td class="td1">数据包所包含字节数</td>
                    	<td class="border_r0"><?php echo $targetDB['Bytes']?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">操作是否合法</td>
                    	<td><?php echo $targetDB['Legality']==-1?'未知':($targetDB['Legality']==0?'非法':'合法')?></td>
                    	<td class="td1">SQL语句影响记录的条数</td>
                    	<td class="border_r0"><?php echo $targetDB['AffectRows']?></td>
                    </tr>      
                    <tr>
                    	<td class="td1">会话ID</td>
                    	<td>
                    		<a href="#" onclick="viewSessionBack(<?php echo $targetSession['SessionID']?>);"><?php echo $targetSession['SessionID']?></a>
                    		<a href="#" style="color: red" onclick="viewSessionBack(<?php echo $targetSession['SessionID']?>);">>>点击会话回放</a>
                    	</td>
                    	<td class="td1">源主机IP</td>
                    	<td class="border_r0"><?php echo $targetSession['SrcIP']?></td>
                    </tr>     
                    <tr>
                    	<td class="td1">源主机端口号</td>
                    	<td><?php echo $targetSession['SrcPort']?></td>
                    	<!-- <td class="td1">源主机MAC地址</td>
                    	<td class="border_r0"><?php echo $targetSession['SrcMac']?></td> -->
                    	<td class="td1">源主机主机名</td>
                    	<td class="border_r0"><?php echo $targetSession['SrcHostName']?></td>
                    </tr>     
                    <tr>

                    	<td class="td1">目的主机IP</td>
                    	<td><?php echo $targetSession['DstIP']?></td>
                    	<td class="td1">目的主机端口号</td>
                    	<td class="border_r0"><?php echo $targetSession['DstPort']?></td>
                    </tr>     
                    <tr>
                    	
                    	<!-- <td class="td1">目的主机MAC地址</td> 
                    	<td class="border_r0"><?php echo $targetSession['DstMac']?></td>-->
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
                    	<td class="border_r0"><?php echo $targetDB['Reserved2']?></td>
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
	 	<form>
	 	<table align="center" width="100%">
	 		<tr>
	            <td class="btn" colspan="2">
	            	<a href="#" class="repire" onclick="detailBack();">返回</a>
	            </td>
	        </tr>
	    </table>
	    
	    <input type="hidden" name="target" id="target" value='<?php echo $target?>'/>
	    <input type="hidden" name="condition" id="condition" value='<?php echo $condition?>'/>
	    <input type="hidden" name="advance" id="advance" value="<?php echo $advance?>"/>

 <input type="hidden" name="currentPageHidden" id="currentPageHidden" value="<?php echo $currentPage?>"/>
 <input type="hidden" name="opIDHidden" id="opIDHidden" value="<?php echo $targetDB['OpID']?>"/>
 <input type="hidden" name="sessionIDHidden" id="sessionIDHidden" value="<?php echo $targetDB['SessionID']?>"/>
 <input type="hidden" name="execTimeHidden" id="execTimeHidden" value="<?php echo $targetDB['ExecTime']?>"/>
	 	</form>
	 	
 	</div>
 	
 	<!-- 会话回放对话框 -->
     <div id="sessionBackDiv" style="display: none;">
		<table id="sessionBackTable" width="100%">
			<!-- 
			<tbody id="sessionBackTbody">
				</tbody>
			 -->
		</table>
	 </div>   
 </body>
 </html>