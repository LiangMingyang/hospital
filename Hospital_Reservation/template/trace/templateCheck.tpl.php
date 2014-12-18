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


function goToPage(pageNo,type,typeId)
{
		if(pageNo == -1){
			pageNo = $('#'+type+'PageNum').val();
		}
		$('#'+type+'Page').val(pageNo);
		$('#type').val(type);
		document.idsRulesForm.submit();
}

function review(relaId,traceId,status)
{
	$.get(WEB_ROOT+'trace/templateCheck.php',{
	cmd:"review",
	relaId:relaId,
	traceId:traceId,
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
		location.reload();
	});
}

function reviewAll(status){
	$.get(WEB_ROOT+'trace/templateCheck.php',{
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
	<div><h5 class="title102" style="position:relative; zoom:1;" id="banner"><em>规则审核:</em></h5></div>
                    	
	<div class="box102 tabContent">
		<div class="itabContent" <?php if($cmd=='queryRM'){?> style="display:none"<?php }?>>
		<form name="idsRulesForm" method="post" action="?cmd=query">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr><td class="border_r0"><?php require "../cfg/services.php"?>
                    					<input type="hidden" name="miningPage" id="miningPage" value="<?php echo $pg?>"/>
                    					<input type="hidden" name="type" id="type"/> 
                    		 <a href="javascript:void(0)" onclick="idsRulesForm.submit()" class="neibu">刷新</a>
                 </td></tr>
			</tbody>
		</table>
		</form>
		<br/>
		<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">模板列表</p>
	   	
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<th>HTTP模板</th>
					<th>SQL模板</th>
					<th>状态</th>
					<th class="border_r0">操作</th>
				</tr>
                <?php if($template){
                                    	    $idx = -1; 
                                    	    foreach($template as $rule){
                                    	    $idx++;
                                    	        ?>
                                    <tr>
                                    	<td width="20%" style="word-wrap:break-word"><?php echo $rule['httpRequest']?></td>
                                    	<td width="35%" style="word-wrap:break-word"><?php echo $rule['sqlRequest']?></td>
                                       	<td><?php switch($rule['status']){
                                       	    case 0:echo"<font color='red'>未通过</font>";
                                       	        break;
                                       	    case 1:echo"<font color='green'>已通过</font>";
                                       	        break;
                                       	    default:
                                       	        echo"未审核";
                                       	}
                                       	?> 
                                        <td class="border_r0">
                                        <a href="javascript:review(<?php echo $rule['relaId']?>,<?php echo $rule['traceId']?>,1)" class="neibu">通过</a>
                                        <a href="javascript:review(<?php echo $rule['relaId']?>,<?php echo $rule['traceId']?>,0)" class="neibu">不通过</a>
                                        </td>
                                       
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                            <?php if($miningPage) echo $miningPage->toString()?>
	</div> 
	</div>
</div> 


 </body>
 </html>