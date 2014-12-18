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
include risk_header_inc();
 ?>
 <script> 
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
	
	$(function(){
		$('#riskDetail').dialog({
			autoOpen: false,
			resizable: true,
			height:'auto',
			width:'800',
			modal: true,
			position:"top",
			title:"报警事件详情"
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
		document.queryRisk.submit();
		}
	function refresh(processed){
		$('#processed').val(processed);
//		document.queryRisk.submit();
		$('#queryGrid').flexReload();//表格重载
		}
	function review(id,processed){
		$.get(WEB_ROOT+'risk/risk.php',{
			cmd:'review',
			id:id,
			processed:processed},
			function(data){
				if(data != "OK"){
					alert("审核失败");
				}else{
					document.queryRisk.submit();
				}
			});
		}
 </script>

<script type="text/javascript" src="<?php echo JS_PATH?>risk/review.js?"></script>
 <body>
<h5 class="title102"><em>报警事件审核</em></h5>
<div class="box102 p20">
  <form action="" method="post" name="queryRisk" id="searchForm">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                		<th>数据库：</th>
						<td>
                		<select name="serviceId" style="width: 200px;"><option value="">全部</option>
                		<?php foreach ($serviceList as $service) {
                			?>
                			<option value="<?php echo $service['ServiceId']?>"><?php echo $service['ServerName'].":".$service['Name'].":".$service['ServiceName']?></option>
                			<?php
                		}?>
                		</select>
                        </td>
                        <th>事件类别：</th>
						<td>
						<select name="processed" style="width: 200px;">
                		<option value="-1" <?php echo $processed == -1?'selected="selected"':''?>>全部</option>
                		<option value="0" <?php echo $processed == 0?'selected="selected"':''?>>未审核</option>
                		<option value="1" <?php echo $processed == 1?'selected="selected"':''?>>风险事件</option>
                		<option value="2" <?php echo $processed == 2?'selected="selected"':''?>>非风险事件</option>
                		</select>
						</td>
                      
                     </tr> 
					 <tr>
					        
					 	
						    <th>开始时间：</th>
							<td><input name="beginDate" id='beginDate' value='<?php echo $beginDate?$beginDate:date('Y-m-d');?>' class="Wdate" onClick="WdatePicker()" type="text">
                		    <input name="beginTime" id="beginTime" value='<?php echo $beginTime?$beginTime:date('00:00');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                		    </td>

							<th>结束时间：</th>
							<td><input name="endDate" id='endDate' value='<?php echo $endDate?$endDate:date('Y-m-d');?>' maxlength="10" class="Wdate" onClick="WdatePicker()" type="text">
                        	<input name="endTime" id='endTime' value='<?php echo $endTime?$endTime:date('H:i');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm'})" type="text">
                            </td>

					
               		       
					 </tr>
					 <tr>
                      	<td colspan="7">
	                      	<a href="javascript:void(0)" class="neibu" id="searchButton">查询</a>
                      	</td>
                     </tr>      
                    </tbody>
	</table>
  </form>
</div>
<!-- 风险事件查询结果 -->
<div id="queryDiv" class="box102 p20" style="display: block;position: relative;margin-top: 5px;height: 600px;">
<?php 
foreach ($riskLevelList as $risk){
if($risk['RiskLevel']>0){
?>
   <img src="<?php echo IMAGE_PATH?>risklevel<?php echo $risk['RiskLevel']?>.gif"/><?php echo $risk['Description'].";&nbsp;&nbsp;"?>
    <?php
}
   
}
?>
<br/>
<br/>
<table id="queryGrid"></table>
</div>
 <div id="riskDetail" style="display:none">
 </div>
 <script type="text/javascript">
 $(".tblist").flexigrid({
	 width:930, 
	 height:600
	 });
 </script>
 </body>
 </html>