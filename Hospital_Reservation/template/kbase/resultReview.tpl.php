<?php
/**
 * resultReview.tpl.php-.
 * @modification history 
 * ---------------------
 * 2014-4-25,created by zhangxin
 */
include header_inc();
 ?>
 <script type="text/javascript" src="<?php echo JS_PATH?>ids.js?2"></script>
  <script>

 function page(pageNo)
 {

	 if(pageNo == -1) {
		 pageNo = $('#pageNum').val();
	 }
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#pageCountHidden").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 var currentPageNo = parseInt($(".numon").html());
		 if(parseInt(pageNo)==currentPageNo){
			alert("当前为"+pageNo+"页");
		 } else{
			 window.location.href="resultReview.php?pageNo="+pageNo+"&page=page";

		 }
		 
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

function reviewIp(id,status)
{
	$.get(WEB_ROOT+'kbase/resultReview.php',{
	cmd:"reviewIp",
	id:id,
	status:status},
	function(data)
	{
		if(data=="OK")
		{
			artDialog({content:'审核成功！', style:'alert'}, function(){
				window.location.href="resultReview.php";
			});
		}else{
			artDialog({content:'审核失败！', style:'error'}, function(){
			});
		}
	});
}

 </script>
 <body>
  <h5 class="title102"><em>IP审核</em></h5>
	<!-- IP审核 -->
	<div class="box102 p20">   	
	   	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4" style="text-align: center;">
			<tbody>
				<tr>
					<th>编号</th>
					<th>待审核IP地址</th>
					<th>低风险次数</th>
					<th>中度风险次数</th>
					<th>高风险次数</th>
					<th>审核状态</th>
					<th class="border_r0">操作</th>
				</tr>
                <?php if($ipConList){
                                    	    foreach($ipConList as $ip){
                                    	        ?>
                                    <tr>
                                    	<td><?php echo $ip['IpConID']?></td>
                                    	<td><?php echo $ip['IpCon']?></td>
                                    	<?php $result=$kbase->findRiskNumberByIp($ip['IpCon']);?>
                                    	<td>
                                    	<?php 
                                    	foreach($result as $re){
                                    	   if($re['IsInjected']==1){
                                    		  echo $re['number'];
                                    	   }
                                    	    }?>
                                    	</td>
                                    	<td>
                                    	<?php 
                                    	foreach($result as $re){
                                    	   if($re['IsInjected']==2){
                                    		  echo $re['number'];
                                    	   }
                                    	    }?>
                                    	</td>
                                    	<td>
                                    	<?php 
                                    	foreach($result as $re){
                                    	   if($re['IsInjected']==3){
                                    		  echo $re['number'];
                                    	   }
                                    	    }?>
                                    	</td>
                                       	<td><?php switch($ip['IpStatus']){
                                       	    case 0:echo"<font color='red'>未通过</font>";
                                       	        break;
                                       	    case 1:echo"<font color='green'>已通过</font>";
                                       	        break;
                                       	    default:
                                       	        echo"未审核";
                                       	}
                                       	?> 
                                        <td class="border_r0">
                                        <a href="javascript:reviewIp(<?php echo $ip['IpConID']?>,1)" class="neibu">通过</a>
                                        <a href="javascript:reviewIp(<?php echo $ip['IpConID']?>,0)" class="neibu">不通过</a>
                                        </td>
                                       
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                           
		<?php echo $page->toString()?>                      
	</div>
 </body>
 </html>