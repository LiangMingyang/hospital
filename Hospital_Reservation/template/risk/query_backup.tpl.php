<?php
/**
 * query.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-16,created by Xu Guozhi
 */
include header_inc();
 ?>
<script type="text/javascript" src="<?php echo JS_PATH?>flexigrid.js?<?php echo mktime()?>"></script>
 <script>
 function showMore(){
	 if($('.more').eq(0).css('display')=='none'){
			$('.more').each(function(){
				$(this).show();
				});
			showSql();
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
				$('.sql').hide();
		}
 }
 function showSql(){
	if($('#opclass').val()==3){
		$('.sql').show();
	}else{
		$('.sql').hide();
		}
	 }
 function checkall(obj){
		flag = $(obj).attr("checked");
		if(flag == 'checked')
			$("input[name='item']").attr("checked",flag);
		else{
			$("input[name='item']").removeAttr("checked");
			$(obj).removeAttr("checked");
		}
	}
 function checkall(obj){
		flag = $(obj).attr("checked");
		if(flag == 'checked')
			$("input[name='item']").attr("checked",flag);
		else
			$("input[name='item']").removeAttr("checked");
	}
	function uncheckall(obj){
		flag = obj.checked;
		if(flag){
			types = document.getElementsByName("item");
			for(var i = 0; i < types.length; ++i){
				if(!types[i].checked)
					return;
			}
			document.getElementsByName("checkAllItems")[1].checked = true;
		}else
			document.getElementsByName("checkAllItems")[1].checked = false;

	}
	function del(){
		var ids ="";
		$("input[name='item']:checked").each(function(){
			ids+=","+$(this).val();
			});
		if(ids==""){
			alert("请至少选择一条风险事件");
			return;
		}else{
			ids = ids.substr(1);
			$.post(WEB_ROOT+"risk/risk.php",{
				cmd:"del",
				ids:ids
				},function(data){
					if(data == "OK"){
						alert("删除成功");	
						queryRisk.submit();
					}else{
						alert("删除失败");
						}})
			}
	}
	$(function(){
		$('#riskDetail').dialog({
			autoOpen: false,
			resizable: true,
			height:'auto',
			width:'800',
			modal: true,
			position:"top",
			title:"风险事件详情"
		});
		})
	function viewDetail(recordId){
		$.get(WEB_ROOT+"risk/risk.php",{
			cmd:"get",
			recordID:recordId
			},function(data){
				$('#riskDetail').html(data);
				$('#riskDetail').dialog("open");
				})
		}
	function go(pageNo){
		if(pageNo==-1)
			pageNo = $('#goNum').val();
		$('#pageNo').val(pageNo);
		queryRisk.submit();
		}

	function searchClick() {
		$("#searchHidden").val(1);
		document.queryRisk.submit();
		}
 </script>

 <body>
<h5 class="title102"><em>风险事件查询</em></h5>
<div class="box102 p20">
  <form action="query.php" method="post" name="queryRisk" id="searchForm">
  <input type="hidden" name="searchHidden" id="searchHidden" value="<?php echo $searchFlag?>"/>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                		<th>选择数据库：</th><td><?php require "../cfg/services.php"?></td>
                		<th>开始时间：</th><td><input name="beginDate" id='beginDate' value='<?php echo $beginDate?$beginDate:date('Y-m-d',strtotime('-1 day'));?>' class="Wdate" onClick="WdatePicker()" type="text">
                		<input name="beginTime" id="beginTime" value='<?php echo $beginTime?$beginTime:date('H:i');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                		</td>
               		    <th>
                        	结束时间：</th><td><input name="endDate" id='endDate' value='<?php echo $endDate?$endDate:date('Y-m-d');?>' maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
                        	<input name="endTime" id='endTime' value='<?php echo $endTime?$endTime:date('H:i');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                        	</td>              
                      	<td><a href="javascript:void(0)" onclick="showMore()" id="showmore" class="down">更多</a></td>         
                      </tr>
                      <tr class="more" style="display:none">
                      	<th>客户端IP：</th><td><input type="text" name="ip" value='<?php echo ($ip)?>'/></td>
                      	<th>登录名：</th><td><input type="text" name="loginName" value="<?php echo $loginName?>"></td>
                      	<th>数据库操作类型：</th><td><select name="opClass" id="opclass" onchange="showSql()"><option value="">全部</option><?php foreach ($opclasses as $op){?>
                      	<option value="<?php echo $op['OpClass']?>" <?php if($op['OpClass']==$opclass) echo "selected"?>><?php echo $op['Description']?></option><?php }?></select></td>
                      	<td></td>
                      </tr>
                      <tr class="sql" style="display:none">
                      	<th>数据库对象：</th><td><input type="text" name="object" value="<?php echo $object?>"></td>
                      	<th>SQL语句类型：</th><td><select name="sqlType"><option value="">全部</option>
                      	<?php foreach ($sqltypes as $type){?><option value="<?php echo $type['SqlType']?>" <?php if($type['SqlType']==$sqlType) echo "selected"?>><?php echo $type['Description']?></option><?php }?></select></td>
                      	<th>SQL语句内容：</th><td><input type="text" name="keyword" value="<?php echo $keyword?>"></td>
                      	<td></td>
                      </tr>
                      <tr class="more" style="display:none">
                      	<!-- 
                      	<th>执行结果：</th><td><select name="execResult"><option value="">全部</option><option value="1">成功</option><option value="0">失败</option></select></td>
                      	<th>响应时间：</th><td><input type="text" name="execTime" value="<?php echo $execTime?>"></td>
                      	
                      	 -->
                      	<th>风险等级：</th><td><select name="riskLevel"><option value="">全部</option>
                      	<?php 
                      	foreach ($riskLevelList as $risk){
                      		?>
                      		<option value="<?php echo $risk['RiskLevel']?>" <?php if($risk['RiskLevel']==$riskLevel) echo "selected"?>><?php echo $risk['Description']?></option>
                      		<?php
                      	}
                      	?>
                      	</select>
                      	<td></td>
                      </tr>
                      <tr>
                      	<td colspan="7"><input type="submit" class="neibu"value="查询" onClick="searchClick();">
                      	<input type="hidden" name="advance" id="advance" value="<?php echo $advance?>"/>
                      	<input type="hidden" name="pageNo" id="pageNo"/>
                      	<?php if($result){?><input type="button" class="neibu" value="删除" onclick="del()"><?php }?>
                      	</td>
                     </tr>            
                    </tbody>
	</table>
  </form>
</div>
 
<div class="bottom">
 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">
       		<tbody>
            	<tr>
                	<td width="44%">
                        <div class="p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tblist">
                            	<thead>
                                	<tr>
                                	 <th width="20"><input type="checkbox" name="checkAllItems" value="1"onclick="checkall(this)"></th>
                                	 <th width="16">风险等级</th>
                                        <th width="80">服务器</th>
                                        <th width="100">协议</th>
                                        <th width="100">数据库</th>
                                        <th width="100">登录名</th>
                                        <th width="80">源IP</th>
                                        <th width="80">操作类型</th>
                                        <th width="200">SQL语句</th> 
                                        <th width="50">响应时间</th>
                                        <th width="16">合法与否</th>
                                        <th width="50">审核状态</th>
                                        <th width="80"></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php if($result){
                                 	
                                     foreach($result as $item){
                                     ?>
                                    <tr>
                                	 <td width="20"><input type="checkbox" name="item" value="<?php echo $item['OpID']?>" onclick="uncheckall(this)"></td>
                                	  <td width="16"><img src="<?php echo IMAGE_PATH?>risklevel<?php echo $item['RiskLevel']?>.gif"/></td>                                       
                                        <td width="80"><?php echo ($item['DstIP'])?></td>
                                        <td width="100"><?php echo $item['Description']?></td>
                                        <td width="100"><?php echo $item['ServiceName']?></td>
                                        <td width="100"><?php echo $item['LoginName']?></td>
                                        <td width="80"><?php echo ($item['SrcIP'])?></td>
                                        <td width="80"><?php echo $item['OpClass']?>
                                        <td width="200"><?php echo $item['SqlString']?></td>
                                        <td width="50"><?php echo $item['ResponseTime']?>ms</td>
                                        <td width="16"><img src="<?php echo IMAGE_PATH?><?php switch($item['Legality']){case -1:echo'unknown';break;case 0:echo'err';break;case 1:echo'ok';}?>.gif"/></td>
                                        <td width="50"><?php if($item['IsProccessed']==1) echo "已审核";else echo "未审核"?></td>
                                        <td width="80"><a href="javascript:void(0)" class="neibu" onclick="viewDetail(<?php echo $item['OpID']?>)">查看详细</a></td>         
                                    </tr>
                                    <?php }}
                                    	?>
                                </tbody>
                            </table>
                            <?php echo $page->toString()?>
                        </div>  
                                          </td>
                </tr>
            </tbody>
       </table>
 </div>
 <div id="riskDetail" style="display:none">
 </div>
 <script type="text/javascript">
 $(".tblist").flexigrid(
		 {width:930, 
		  height:600});
 </script>

 </body>
 </html>