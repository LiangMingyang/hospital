<?php
/**
 * 数据库服务器运行状态
 * dbServerStatus.tpl.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-21,created by Chenhuan
 */
include header_inc();
 ?>
<script type="text/javascript" src="<?php echo JS_PATH?>monitor/traffic.js"></script>
<body id="body">
<div><h5 class="title102"><em>数据库服务器监控</em></h5></div>	
<div class="box102 p20">
  <!-- 查询区域 -->
	<form action="" method="post" id="searchForm" name="searchForm">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
         <tbody>
                	<tr>
                		<td>数据库：
                			<select name="searchServer" id="searchServer" style="width: 150px;">
                				<option value="">全部</option>
 								<?php 
                				foreach ($serverList as $ser) {
                					if($searchServerIp==$ser['ServerIP']) {
                						?>
                						<option value="<?php echo $ser['ServerIP']?>" selected="selected"><?php echo $ser['ServerName']?></option>
                						<?php 
                					} else {
                						?>
                						<option value="<?php echo $ser['ServerIP']?>"><?php echo $ser['ServerName']?></option>
                						<?php 	
                					}
                				}
                				?>
                			</select>
                		</td>
                		<td>
                		协议类型：
                			<select id="searchProtocol" name="searchProtocol">
                				<option value="">所有</option>
                				<?php 
                				foreach ($protocolList as $pro) {
                					if($searchProtocol==$pro['Protocol']) {
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
                		<td>
                			<?php 
                			//按小时
                			if($timeRadio==0) {
                				?>
                				<input type="radio" name="timeRadio" value="1"/>最近一天
                				<input type="radio" name="timeRadio" value="0" checked="checked"/>最近一小时
                				<?php
                			} else {
                				?>
                				<input type="radio" name="timeRadio" value="1" checked="checked"/>最近一天
                				<input type="radio" name="timeRadio" value="0"/>最近一小时
                				<?php
                			}
                			?>
                		</td>
                		<td>
                			<!-- 
                			<input type="submit" class="neibu" id="searchButton" name="searchButton" value="查询">
                			 -->
                			<a href="#" id="searchButton" name="searchButton" class="neibu" onclick="javascript:document.searchForm.submit();">查询</a>
                		<input type="hidden" name="serverIpHidden" id="serverIpHidden" value="<?php echo $searchServerIp?>"/>
                		<input type="hidden" name="protocolHidden" id="protocolHidden" value="<?php echo $protocol?>"/>
                		<input type="hidden" name="timeRadioHidden" id="timeRadioHidden" value="<?php echo $timeRadio?>"/>
                		</td>      
                      </tr>
		</tbody>
	</table>
  </form>
</div>


<div class="box102 p20">
<div class="tabContent">
    <p align="left" style="font-size:14px;">连接用户实时查看</p>
		 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
			<tr>
				<th width="30%">用户名</th>
				<th width="30%">IP地址</th>
				<th>访问时间</th>
			</tr>
							<?php 
							$count = count($connList);
							if($count==0) {
								?>
								<tr>
									<td colspan="3"><font color='red'>暂时无用户连接记录！</font></td>
								</tr>
								<?php
							} else {
								foreach ($connList as $conn) {
									?>
									<tr>
										<td><?php echo $conn['LoginName']?></td>
										<td><?php echo $conn['SrcIP']?></td>
										<td><?php echo $conn['ExecTime']?></td>
									</tr>
									<?php
								}
							}
							?>			
		 </table>
</div>
</div>

<div class="box102 p20">
<div class="tabContent">
   <p align="left" style="font-size:14px;">操作类型实时查看</p>
		 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
							<tr>
								<th width="20%">操作类型</th>
								<th width="20%">用户名</th>
								<th width="20%">IP地址</th>
								<th>访问时间</th>
							</tr>
							<?php 
							$count = count($opList);
							if($count == 0) {
								?>
								<tr>
									<td colspan="4"><font color="red">暂时无操作类型记录！</font></td>
								</tr>
								<?php
							} else {
								foreach ($opList as $op) {
									?>
									<tr>
										<td><?php echo $op['SqlTypeName']?></td>
										<td><?php echo $op['LoginName']?></td>
										<td><?php echo $op['SrcIP']?></td>
										<td><?php echo $op['ExecTime']?></td>
									</tr>
									<?php
								}
							}
							?>
						</table> 
</div>
</div>

<div class="box102 p20">
<div class="tabContent">
   <p align="left" style="font-size:14px;">报警信息实时查看</p>
		 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
							<tr>
								<th width="20%">服务器</th>
								<th width="20%">协议</th>
								<th width="20%">风险</th>
								<th>操作类型</th>
							</tr>
							<?php 
							$count = count($alarmList);
							if($count == 0) {
								?>
								<tr>
									<td colspan="4"><font color="red">暂时无报警信息记录！</font></td>
								</tr>
								<?php
							} else {
								foreach ($alarmList as $alarm) {
									?>
									<tr>
										<td><?php echo $alarm['ServiceName']?></td>
										<td>
											<?php $tmpId=$alarm['Protocol'];
											foreach ($protocolList as $pro) {
												if($pro['Protocol']==$tmpId) {
													echo $pro['Name'];
												}
											}
											?>
										</td>
										<td>
											<?php $tmpId=$alarm['RiskLevel'];
											foreach ($riskLevelList as $risk) {
												if($risk['RiskLevel']==$tmpId) {
													echo $risk['Description'];
												}
											}
											?>
										</td>
										<td>
											<?php $tmpId=$alarm['OpClass'];
											foreach ($opclassList as $op) {
												if($op['OpClass']==$tmpId) {
													echo $op['Name'];
												}
											}
											?>
										</td>
									</tr>
									<?php
								}
							}
							?>
						</table> 
</div>
</div>
 </body>
 </html>