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
 <script type="text/javascript" src="<?php echo JS_PATH?>flexigrid.js"></script>
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
		document.queryRisk.submit();
		}
	function refresh(processed){
		$('#processed').val(processed);
		document.queryRisk.submit();
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
 <body>
<h5 class="title102"><em>风险事件审核</em></h5>
<div class="box102 p20">
  <form action="" method="post" name="queryRisk">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                		<th>选择数据库：</th><td><?php require "../cfg/services.php"?></td>  
                      	<td><a href="javascript:void(0)" class="neibu" onclick="refresh(0)">未审核</a>
                      	<a href="javascript:void(0)" class="tijiao2" onclick="refresh(1)">风险事件</a>
                      	<a href="javascript:void(0)" class="repire2"onclick="refresh(2)">非风险事件</a>
                      	<input type="hidden" name="processed" id="processed" value="<?php echo $processed?>"/>
                      	<input type="hidden" name="pageNo" id="pageNo" value="<?php echo $pageNo?>"/>
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
                                	 <th width="16">风险等级</th>
                                        <th width="80">服务器</th>
                                        <th width="50">协议</th>
                                        <th width="80">数据库</th>
                                        <th width="80">登录名</th>
                                        <th width="80">源IP</th>
                                        <th width="80">操作类型</th>
                                        <th width="200">SQL语句</th> 
                                        <th width="50">响应时间</th>
                                        <th width="16">合法与否</th>
                                        <th width="250"></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php if($result){
                                     foreach($result as $item){
                                     ?>
                                    <tr>
                                		<td width="16"><img src="<?php echo IMAGE_PATH?>risklevel<?php echo $item['RiskLevel']?>.gif"/></td>                                       
                                        <td width="80"><?php echo ($item['DstIP'])?></td>
                                        <td width="50"><?php echo $item['Description']?></td>
                                        <td width="80"><?php echo $item['ServiceName']?></td>
                                        <td width="80"><?php echo $item['LoginName']?></td>
                                        <td width="80"><?php echo ($item['SrcIP'])?></td>
                                        <td width="80"><?php echo $item['OpClass']?>
                                        <td width="200"><?php echo $item['SqlString']?></td>
                                        <td width="50"><?php echo $item['ResponseTime']?>ms</td>
                                        <td width="16"><img src="<?php echo IMAGE_PATH?><?php switch($item['Legality']){case -1:echo'unknown';break;case 0:echo'err';break;case 1:echo'ok';}?>.gif"/></td>
                                        <td width="250"><a href="javascript:void(0)" class="neibu" onclick="viewDetail(<?php echo $item['OpID']?>)">查看详细</a>
                                        <?php if($item['IsProcessed']==0){?>
                                        <a href="javascript:void(0)" class="tijiao2" onclick="review(<?php echo $item['OpID']?>,1)">确认风险</a>
                                        <a href="javascript:void(0)" class="repire2" onclick="review(<?php echo $item['OpID']?>,2)">忽略风险</a>
                                        <?php }?>
                                        </td>         
                                    </tr>
                                    <?php }}?>
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
 $(".tblist").flexigrid({
	 width:930, 
	 height:600
	 });
 </script>
 </body>
 </html>