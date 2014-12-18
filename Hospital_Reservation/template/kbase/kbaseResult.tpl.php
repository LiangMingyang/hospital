<?php
/**
 * @modification history 
 * ---------------------
 * 2014-4-25,created by zhangxin
 */
include kbase_header_inc();
 ?>
 <html>
 <script type="text/javascript">
 function ipaddr_check()
	{
	var scanIp=$('#srcIP').val();
	 var reg = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$/;
	 if(scanIp.match(reg)){
		
	     return true;
	 }
	 else{
		   artDialog({content:'输入IP格式不合法', style:'alert'}, function(){});
		   $('#srcIp').val('');
	     return false;
	 }
	}
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

 $(function(){
		$('#resultDetail').dialog({
			autoOpen: false,
			resizable: true,
			height:'auto',
			width:'800',
			modal: false,
			position:"top",
			title:"知识库检测结果详情"
		});
		});
 </script>
 <script type="text/javascript" src="<?php echo JS_PATH?>kbase/ids.js?"></script>
 <body id="body">
 <h5 class="title102" style="position:relative; zoom:1;"><em>检测结果查询</em> <span></span></h5>
  <div id="searchDiv" class="box102 p20">
  <form action="" method="post" id="searchForm" name="searchForm">
	<input type="hidden" name="currentPageHidden" id="currentPageHidden" value="<?php echo $currentPage?>"/>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
         <tbody>
                	<tr>      		
                		<td>数据库类型：
                			<select id="searchProtocol" name="searchProtocol" style="width: 200px;">
                				<option value="">全部</option>
                				<?php 
                				foreach ($protocolList as $pro) {
if($searchProtocol==$pro['Protocol']){
	?>
	                				<option value="<?php echo $pro['Protocol']?>" selected="selected"><?php echo $pro['Name']?></option>
	                				<?php 
}else {
?>
	                				<option value="<?php echo $pro['Protocol']?>"><?php echo $pro['Name']?></option>
	                				<?php 
}
                					
                				}
                				?>
                			</select>
                		</td>
                		<td>&nbsp;</td>
                		<td>源IP：<input type="text" name="srcIP" id="srcIP" onblur="ipaddr_check()" value="<?php echo $srcIP?>"/></td>
                		<td>&nbsp;</td>
                		<td>
                		 <a href="javascript:void(0)" onclick="showMore()" id="showmore" class="down"  hidefocus="true">更多</a>
                		</td>    
                	</tr>
                	<tr class="more" style=<?php echo $advance=='0'?"display:none":""?>>
                		<td>风险等级：<select name="riskLevel" id="riskLevel"><option value="">全部</option>
                      		<?php foreach ($riskLevelList as $risk){
                      			
                      			if($riskLevel==$risk['RiskLevel']){
?>
                      			<option value="<?php echo $risk['RiskLevel']?>" selected="selected"><?php echo $risk['Description']?></option>
                      			<?php
}else{
	?>
                      			<option value="<?php echo $risk['RiskLevel']?>"><?php echo $risk['Description']?></option>
                      			<?php
}
                      			
                      		}?>
                      	</select>
                      	</td> 
                      	<td>登录名：<input type="text" name="loginName" id="loginName" value="<?php echo $loginName?>"/></td>
                      	<td>报警原因：<select name="riskReason" id="riskReason"><option value="">全部</option>
                      	          <?php foreach ($reason as $key=>$value){
                      	          	if($riskReason==$key){
                      	          ?>
                      	          		<option value="<?php echo $key?>" selected="selected"><?php echo $value?></option>
                      	          <?php }else{?>	
                      	                <option value="<?php echo $key?>"><?php echo $value?></option>
                      	          <?php 
                      	         }
                      	          }
                      	          ?>
                      	</select>
                      	</td>
                    </tr>
                      <tr>
                      	<td colspan="4">
                      		<a href="#" id="searchButton" class="neibu" >查询</a>
                      		<input type="hidden" name="advance" id="advance" value="<?php echo $advance?>"/>
                      		<input type="hidden" name="target" id="target" value="dbAll"/>
                      	</td>
                     </tr>            
		</tbody>
	</table>
  </form>
</div>

<!-- 审计事件查询结果 -->
<div class="box102 p20" style="display: block;position: relative;margin-top: 5px;height: 600px;">
    <table id="idsResultGrid"></table>
</div>

<div id="resultDetail" style="display:none">
 </div>

      <div id="deleteConfirm" title="确定删除吗？">
        <p>确定删除所选的审计事件吗？</p>
      </div>
 </body>
 </html>