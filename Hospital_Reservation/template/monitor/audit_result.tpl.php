<?php
/**
 * 数据库审计事件管理
 * addPolicy.php-.
 * @author Chenhuan<iconverseme@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-16,created by Chenhuan
 */
include audit_header_inc ();
?>
<script type="text/javascript">

 function showMore(){
	 if($('.more').eq(0).css('display')=='none'){
			$('.more').each(function(){
				$(this).show();
				});
			$('#showmore').removeClass('down');
			$('#showmore').addClass('up');
			$('#showmore').html('收起');
			$('#advance').val(1);
		 }else{
			 $('.more').each(function(){
				 $(this).hide();});
				$('#showmore').removeClass('up');
				$('#showmore').addClass('down');
				$('#showmore').html('更多');
				$('#advance').val(0);
		}
 }

 function checkSrcPort(){
		var port = $('#srcPort').val();
		if(port != null && port != "")
		{
	    if(port > 0 && port < 65536){
	            return true;
	        }else{
	             alert("请输入正确的端口号（0-65535）！");
	             return false;
	        }
		}
	}

	function checkDstPort(){
		var port = $('#destPort').val();
		if(port != null && port != "")
		{
	    if(port > 0 && port < 65536){
	            return true;
	        }else{
	             alert("请输入正确的端口号（0-65535）！");
	             return false;
	        }
		}
	}
function ismysqlSpecialChar(character){ 
			var mysqlSpecialChars = [ "_", "%", "[", "]", "^" , "'" ,";",",","\"","|","&","$","%","@","<",">","(",")","+"];
	    var len = mysqlSpecialChars.length; 
	    var ch; 
	    for(var i = 0; i < len; i++ )
	    { 
	        ch = mysqlSpecialChars[i]; 
	        if(character == ch) return true; 
	    } 
	    return false; 
	}
function safe_string_escape(str)
	{ 
	  var len=str.length;
	  var targetString=''; 
	  for(var i=0;i<len;i++) 
	  { 
	  	var c=str.charAt(i);
	    if (ismysqlSpecialChar(c))
	    {
	    	targetString+='\\';
	    }
	    targetString+=c;
	  }
	  return targetString; 
	}
function check_username()
  {
	 
  	var login_Name=$('#loginName').val();
	// alert(login_Name);
  	if(login_Name != null && login_Name != "")
  	{
  		login_Name=safe_string_escape(login_Name);
	  	if (login_Name!=$('#loginName').val())
	  	{
	  		alert('输入登录名中含有特殊字符，已作特殊处理！');
	  		$('#loginName').val(login_Name);
  		}
  	}
	
  	return true;
  }
/* added by gengjinkun
   2014-08-05
   */
function checkSrcIP(){
	var ip_source= document.getElementById("srcIP");
    var ip=ip_source.value;
	var reg = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$/;
 	if(ip.match(reg)){
 					
      return true;
 	}			
 	else{
 		alert("IP不合法，请重新输入！");
     	return false;
 	}
    			
}
/* added by gengjinkun
   2014-08-05
   */
function checkDstIP(){
	var ip_source= document.getElementById("destIP");
    var ip=ip_source.value;
	var reg = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$/;
 	if(ip.match(reg)){
 					
      return true;
 	}			
 	else{
 		alert("IP不合法，请重新输入！");
     	return false;
 	}
    			
}
 </script>
<body id="body">
	<h5 class="title102" style="position: relative; zoom: 1;">
		<em>审计结果管理</em> <span></span>
	</h5>
	<div class="box102 p20">
		<form action="" method="post" id="searchForm" name="searchForm">
			<input type="hidden" name="currentPageHidden" id="currentPageHidden"
				value="<?php echo $currentPage?>" />
			<table border="0" cellspacing="0" cellpadding="0" width="100%"
				class="tab3">
				<tbody>
					<tr>
						<td>数据库： <select name="searchServiceName" id="searchServiceName"
							style="width: 200px;">
								<option value="">全部</option>
 								<?php
									foreach ( $serviceList as $ser ) {
										if ($searchServiceName == $ser ['ServiceName']) {
											?>
                					<option
									value="<?php echo $ser['ServiceName'].':'.$ser['ServerIP']?>"
									selected="selected"><?php echo $ser['ServerName']?>:<?php echo $ser['Name']?>:<?php echo $ser['ServiceName']?></option>
                					<?php
										} else {
											?>
                					<option
									value="<?php echo $ser['ServiceName'].':'.$ser['ServerIP']?>"><?php echo $ser['ServerName']?>:<?php echo $ser['Name']?>:<?php echo $ser['ServiceName']?></option>
                					<?php
										}
									
									}
									?>
                			</select></td>
						<td>协议类型： <select id="searchProtocol" name="searchProtocol"
							style="width: 200px;">
								<option value="">全部</option>
                				<?php
																				foreach ( $protocolList as $pro ) {
																					if ($searchProtocol == $pro ['Protocol']) {
																						?>
	                				<option value="<?php echo $pro['Protocol']?>"
									selected="selected"><?php echo $pro['Name']?></option>
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
						<td>审计规则： <select id="searchAuditRule" name="searchAuditRule"
							style="width: 200px;">
								<option value="">全部</option>
                				<?php
																				foreach ( $auditRuleList as $rule ) {
																					if ($searchAuditRule == $rule ['RuleID']) {
																						?>
	                				<option value="<?php echo $rule['RuleID']?>"
									selected="selected"><?php echo $rule['RuleID'].":".$rule['RuleName']?></option>
	                				<?php
																					} else {
																						?>
	                				<option value="<?php echo $rule['RuleID']?>"><?php echo $rule['RuleID'].":".$rule['RuleName']?></option>
	                				<?php
																					}
																				}
																				?>
                			</select>
						</td>
						<td><a href="javascript:void(0)" onclick="showMore()"
							id="showmore" class="down" hidefocus="true">更多</a></td>
					</tr>
					<tr class="more" style=<?php echo $advance=='0'?"display:none":""?>>
						<td colspan="4">源IP：<input type="text" name="srcIP" id="srcIP"
							style="width: 150px;"  onchange="checkSrcIP();"/>&nbsp;&nbsp;&nbsp;&nbsp; 源端口：<input
							type="text" name="srcPort" id="srcPort"
							onchange="checkSrcPort();" />&nbsp;&nbsp;&nbsp;&nbsp; 目的IP：<input
							type="text" name="destIP" id="destIP" style="width: 150px;" onchange="checkDstIP();"/>&nbsp;&nbsp;&nbsp;&nbsp;
							目的端口：<input type="text" name="destPort" id="destPort"
							onchange="checkDstPort();" /></td>
					</tr>
					<tr class="more" style=<?php echo $advance=='0'?"display:none":""?>>
						<td>开始时间： <input name="beginDate" id='beginDate'
							value='<?php echo $beginDate?$beginDate:date('Y-m-d');?>' class="Wdate"
							onClick="WdatePicker()" type="text"> <input name="beginTime"
							id="beginTime" value='<?php echo $beginTime?$beginTime:date('00:00');?>' class="WTime"
							onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
						</td>
						<td>结束时间： <input name="endDate" id='endDate'
							value='<?php echo $endDate?$endDate:date('Y-m-d');?>'
							maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
							<input name="endTime" id='endTime'
							value='<?php echo $endTime?$endTime:date('H:i');?>' class="WTime"
							onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
						</td>
						<td>操作类型：<select name="opclass" id="opclass">
								<option value="">全部</option>
                      	<?php
																							
foreach ( $opclassList as $op ) {
																								?>
                      	<option value="<?php echo $op['OpClass']?>"
									<?php if($op['OpClass']==$opclass) echo "selected"?>><?php echo $op['Description']?></option><?php }?></select>
						</td>
						<td></td>
					</tr>
					<tr class="more" style=<?php echo $advance=='0'?"display:none":""?>>
						<td>执行结果：<select name="execResult" id="execResult">
								<option value="">全部</option>
								<option value="1"
									<?php echo $execResult=='1'?'selected="selected"':''?>>成功</option>
								<option value="0"
									<?php echo $execResult=='0'?'selected="selected"':''?>>失败</option>
						</select></td>
						<!-- 
                      	<td>响应时间：
                      		<select name="responseTime">
                      			<option value="0">0</option>
                      			<option value="5"><=5ms</option>
                      			<option value="10"><=10ms</option>
                      			<option value="11">>=10ms</option>
                      		</select>
                      	</td>
                      	 -->
						<td>风险等级：<select name="riskLevel" id="riskLevel"><option value="">全部</option>
                      		<?php
																								
foreach ( $riskLevelList as $risk ) {
																									
																									if ($riskLevel == $risk ['RiskLevel']) {
																										?>
                      			<option value="<?php echo $risk['RiskLevel']?>"
									selected="selected"><?php echo $risk['Description']?></option>
                      			<?php
																									} else {
																										?>
                      			<option value="<?php echo $risk['RiskLevel']?>"><?php echo $risk['Description']?></option>
                      			<?php
																									}
																								
																								}
																								?>
                      	</select>
						</td>
						<td>登录名：<input type="text" name="loginName"  id="loginName"
							value="<?php echo $loginName?>" onchange="check_username();"/></td>
					</tr>
					<tr>
						<td colspan="4">
							<!-- 
                      		<input type="button" class="neibu" id="searchButton" value="查询">
                      		 --> <a href="#" id="searchButton" class="neibu">查询</a>
							<input type="hidden" name="advance" id="advance"
							value="<?php echo $advance?>" /> <input type="hidden"
							name="target" id="target" value="dbResult" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>

	<!-- 审计事件查询结果 -->
	<div class="box102 p20" style="min-height: 450px;">
		<table id="auditResultGrid"></table>
	</div>

	<div id="deleteResultConfirm" title="确定删除吗？">
		<p>确定删除所选的审计事件吗？</p>
	</div>
</body>
</html>