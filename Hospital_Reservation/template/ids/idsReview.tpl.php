<?php
/**
 * idsReview.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-19,created by Xu Guozhi
 */
include header_inc();
 ?>
 <script type="text/javascript" src="<?php echo JS_PATH?>ids.js?2"></script>
  <script>
 serviceId='<?php echo $serviceId?>';
 var RULE_TYPE_MINING = <?php echo RULE_TYPE_MINING?>;
 var RULE_TYPE_RIGHT = <?php echo RULE_TYPE_RIGHT?>;
 var RULE_TYPE_BUILTIN = <?php echo RULE_TYPE_BUILTIN?>;
function miningPage(pageNo)
{

	if(pageNo == -1) {
		pageNo = $('#miningPageNum').val();
	}
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#miningPageCount").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		
		 	$('#miningPage').val(pageNo);
			$('#type').val("mining");
			document.idsRulesForm.submit();
//		 } 
	 }
	
}

function rightsPage(pageNo)
{
//	goToPage(pageNo,'rights',RULE_TYPE_RIGHT);
	
	if(pageNo == -1) {
		pageNo = $('#rightsPageNum').val();
	}
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#rightsPageCount").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 
		 	$('#rightsPage').val(pageNo);
			$('#type').val("rights");
			document.idsRulesForm.submit();
//		 } 
	 }
//	if(pageNo==-1)
//	{
//		var max=parseInt($('#pagecount').val());
//		alert(max);
//		pageNo=parseInt($('#logPageNum').val());
//		if(!(pageNo<=max && pageNo>=1))
//		{
//			alert("跳转页码输入错误");
//			return; 
//		}		
//	}
//	
//	var RMServiceId=$('#RMServiceId').val();	
//	var ReviewStatus=$('#ReviewStatus').val();	
//	var url=WEB_ROOT+"/ids/idsReview.php?cmd=queryRM&&pageNo="+pageNo;
//	url+="&&RMServiceId=";
//	url+=RMServiceId;
//	url+="&&ReviewStatus=";
//	url+=ReviewStatus;
//	window.location.href=url;
}

function goToPage(pageNo,type,typeId)
{
		if(pageNo == -1){
			pageNo = $('#'+type+'PageNum').val();
		}
		$('#'+type+'Page').val(pageNo);
		$('#type').val(type);
		document.idsRulesForm.submit();
}

function review(id,status)
{
	$.get(WEB_ROOT+'ids/idsReview.php',{
	cmd:"review",
	id:id,
	status:status},
	function(data)
	{
		/*if((data.length==3) && (data.substring(1,3)=="OK"))
		{
			artDialog({content:'审核成功！', style:'alert'}, function(){
				document.idsRulesForm.submit();
			});
		}else{
			artDialog({content:'审核失败！', style:'error'}, function(){
			});
		}*/
		if((data=="OK")||((data.length==3) && (data.substring(1,3)=="OK")))
		{
			artDialog({content:'审核成功！', style:'alert'}, function(){
				document.idsRulesForm.submit();
			});
		}else{
			artDialog({content:'审核失败！', style:'error'}, function(){
			});
		}
	});
}

function reviewAll(status){
	$.get(WEB_ROOT+'ids/idsReview.php',{
		cmd:"reviewAll",
		status:status},
		function(data)
		{			
			/*if((data.length==3) && (data.substring(1,3)=="OK"))
			{
				artDialog({content:'审核成功！', style:'alert'}, function(){
					document.idsRulesForm.submit();
				});
			}else if((data.length==10)&&(data.substring(1,10)=="NO_RECORD"))
			{
				artDialog({content:'没有未审核的规则！', style:'alert'}, function(){
				});
			}else{
				artDialog({content:'审核失败！', style:'error'}, function(){
				});
			}*/
			
			if((data=="OK")||((data.length==3) && (data.substring(1,3)=="OK")))
			{
				artDialog({content:'审核成功！', style:'alert'}, function(){
					document.idsRulesForm.submit();
				});
			}else if((data=="NO_RECORD")||((data.length==10)&&(data.substring(1,10)=="NO_RECORD")))
			{
				artDialog({content:'没有未审核的规则！', style:'alert'}, function(){
				});
			}else{
				artDialog({content:'审核失败！', style:'error'}, function(){
				});
			}
		});
	
}

function reviewPrivilege(id,status)
{
	$.get(WEB_ROOT+'ids/idsReview.php',{
	cmd:"review",
	id:id,
	status:status},
	function(data)
	{
		/*if((data.length==3) && (data.substring(1,3)=="OK"))
		{
			artDialog({content:'审核成功！', style:'alert'}, function(){
				document.patternForm.submit();
			});
		}else if((data.length==10)&&(data.substring(1,10)=="NO_RECORD"))
		{
			artDialog({content:'没有未审核的模式！', style:'alert'}, function(){
			});
		}else{
			artDialog({content:'审核失败！', style:'error'}, function(){
			});
		}*/

		if((data=="OK")||((data.length==3) && (data.substring(1,3)=="OK")))
		{
			artDialog({content:'审核成功！', style:'alert'}, function(){
				document.patternForm.submit();
			});
		}else if((data=="NO_RECORD")||((data.length==10)&&(data.substring(1,10)=="NO_RECORD")))
		{
			artDialog({content:'没有未审核的模式！', style:'alert'}, function(){
			});
		}else{
			artDialog({content:'审核失败！', style:'error'}, function(){
			});
		}
	});
}

function reviewAllPrivilege(status){
	$.get(WEB_ROOT+'ids/idsReview.php',{
		cmd:"reviewAllPrivilege",
		status:status},
		function(data)
		{
			/*if((data.length==3) && (data.substring(1,3)=="OK"))
			{
				artDialog({content:'审核成功！', style:'alert'}, function(){
					document.patternForm.submit();
				});
			}else if((data.length==10)&&(data.substring(1,10)=="NO_RECORD"))
			{
				artDialog({content:'没有未审核的模式！', style:'alert'}, function(){
				});
			}else{
				artDialog({content:'审核失败！', style:'error'}, function(){
				});
			}*/
			if((data=="OK")||((data.length==3) && (data.substring(1,3)=="OK")))
			{
				artDialog({content:'审核成功！', style:'alert'}, function(){
					document.patternForm.submit();
				});
			}else if((data=="NO_RECORD")||((data.length==10)&&(data.substring(1,10)=="NO_RECORD")))
			{
				artDialog({content:'没有未审核的模式！', style:'alert'}, function(){
				});
			}else{
				artDialog({content:'审核失败！', style:'error'}, function(){
				});
			}
		});
	
}		
 </script>
 <body>
 <div class="tab5">
	<div><h5 class="title102" style="position:relative; zoom:1;" id="banner"><em>规则审核:</em> <span><a href="#" class="tab <?php if($cmd!="queryRM") echo "on"?>">行为模式</a> 
	<a href="#" class="tab <?php if($cmd=="queryRM") echo "on"?>">权限模式</a>
	</span></h5></div>
                    	
	<div class="box102 tabContent">
		<div class="itabContent" <?php if($cmd=='queryRM'){?> style="display:none"<?php }?>>
		<form name="idsRulesForm" method="post" action="?cmd=query">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr><td class="border_r0"><?php require "../cfg/services.php"?>
                    					<input type="hidden" name="rightPage" id="rightPage" value="<?php echo $rightPage?>"/>
                    					<input type="hidden" name="miningPage" id="miningPage" value="<?php echo $miningPg?>"/>
                    					<input type="hidden" name="type" id="type"/> 
                    		 <a href="javascript:void(0)" onclick="idsRulesForm.submit()" class="neibu">刷新</a>
                    		 <?php if($mining){?>未审核规则操作：
                    		 <a href="javascript:void(0)" onclick="reviewAll(1)" class="tijiao">全部通过</a>
                    		 <a href="javascript:void(0)" onclick="reviewAll(0)" class="repire">全部不通过</a>
                    		 <?php }?>
                 </td></tr>
			</tbody>
		</table>
		</form>
		<br/>
		<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">行为规则列表</p>
	   	
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<th>规则编号</th>
					<th>规则名称</th>
					<th>状态</th>
					<th class="border_r0">操作</th>
				</tr>
                <?php if($mining){
                                    	    $idx = -1; 
                                    	    foreach($mining as $rule){
                                    	    $idx++;
                                    	        ?>
                                    <tr>
                                    	<td><?php echo $rule['RuleID']?></td>
                                    	<td><?php echo $rule['RuleName']?></td>
                                       	<td><?php switch($rule['ReviewStatus']){
                                       	    case 0:echo"<font color='red'>未通过</font>";
                                       	        break;
                                       	    case 1:echo"<font color='green'>已通过</font>";
                                       	        break;
                                       	    default:
                                       	        echo"未审核";
                                       	}
                                       	?> 
                                        <td class="border_r0"><a href="javascript:void(0)" onclick="showRule(<?php echo $rule['SubRuleId']?>,<?php echo $rule['RuleTypeID']?>)" class="neibu">查看</a>
                                        <a href="javascript:review(<?php echo $rule['RuleID']?>,1)" class="neibu">通过</a>
                                        <a href="javascript:review(<?php echo $rule['RuleID']?>,0)" class="neibu">不通过</a>
                                        </td>
                                       
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                            <?php if($miningPage) echo $miningPage->toString()?>
	</div> 
	
	<!-- 用户权限模式 -->
	<div class="itabContent" <?php if($cmd!='queryRM'){?> style="display:none"<?php }?>>
	  	<form name="patternForm" action="?cmd=queryRM" method="post">
	  		<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tbody>
					<tr><td class="border_r0"><?php require "../cfg/services.php"?>
	                    					<input type="hidden" name="rightPage" id="rightPage" value="<?php echo $rightPage?>"/>
	                    					<input type="hidden" name="miningPage" id="miningPage" value="<?php echo $miningPg?>"/>
	                    					<input type="hidden" name="type" id="type"/> 
	                    		 <a href="javascript:void(0)" onclick="patternForm.submit()" class="neibu">刷新</a>
	                    		 <?php if($privilegePatterns){?>未审核模式操作：
	                    		 <a href="javascript:void(0)" onclick="reviewAllPrivilege(1)" class="tijiao">全部通过</a>
	                    		 <a href="javascript:void(0)" onclick="reviewAllPrivilege(0)" class="repire">全部不通过</a>
	                    		 <?php }?>
	                 </td></tr>
				</tbody>
			</table>
	   	</form>
	   	<br/>
	   	<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">用户权限模式列表</p>
	   	
	   	<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<th>模式名称</th>
					<th>状态</th>
					<th class="border_r0">操作</th>
				</tr>
                <?php if($privilegePatterns){
                                    	    $idx = -1; 
                                    	    foreach($privilegePatterns as $rule){
                                    	    $idx++;
                                    	        ?>
                                    <tr>
                                    	<td><?php echo $rule['RuleName']?></td>
                                       	<td><?php switch($rule['ReviewStatus']){
                                       	    case 0:echo"<font color='red'>未通过</font>";
                                       	        break;
                                       	    case 1:echo"<font color='green'>已通过</font>";
                                       	        break;
                                       	    default:
                                       	        echo"未审核";
                                       	}
                                       	?> 
                                        <td class="border_r0"><a href="javascript:void(0)" onclick="showPrivChange(<?php echo $rule['RuleID']?>,<?php echo $rule['RuleTypeID']?>)" class="neibu">查看</a>
                                        <a href="javascript:reviewPrivilege(<?php echo $rule['RuleID']?>,1)" class="neibu">通过</a>
                                        <a href="javascript:reviewPrivilege(<?php echo $rule['RuleID']?>,0)" class="neibu">不通过</a>
                                        </td>
                                       
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                           
		<?php if($rightsPage) echo $rightsPage->toString()?>                      
	</div>
	</div>
</div> 
<div id="ruleDetail" style="display:none"></div>

	<!-- 显示用户权限模式详细信息-->
     <div id="privilegeDetails" style="display: none;">
		<table width="100%" cellspacing="0" cellpadding="0" class="tab4">
 			<tr>
 				<th>规则编号:</th>
 				<td><span id="targetRuleId"></span></td>
 			</tr>
 			<tr>
 				<th>模式所包含用户：</th>
 				<td><textarea id="privilegeUsers" rows="3" cols="40" readonly="readonly"></textarea></td>
 			</tr>
 		</table>
		<br/>
		<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">模式所拥有操作权限</p>
		<table id="patternPrivilegeTable" style="color: orange; left: 1px;" class="tab4" width="100%">
			<thead>
				<tr><th>表名</th>
				<th>操作</th></tr>
			</thead>	
			<tbody id="privilegeTbody"></tbody>
		</table>
	 </div>

<script type="text/javascript">
	function tab(nav,content,on,type)
{
	$(nav).children().bind(type,(function(){
		var $tab=$(this);
		var tab_index=$tab.prevAll().length;
		var $content = $(content).children();
		$(nav).children().removeClass(on);
		$tab.addClass(on);
		$content.hide();
		$content.eq(tab_index).show();
		$('#banner em b').hide();
		$('#banner em b').eq(tab_index).show();
	}));
}
   tab(".title102 span",".tabContent","on","mouseover");
</script>
 </body>
 </html>