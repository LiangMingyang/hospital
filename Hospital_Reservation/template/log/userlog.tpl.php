<?php
/**
 * userlog.tpl.php-.
 * @author Fu Cheng
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-13,created by Fu Cheng
 */
include header_inc();
 ?>
 <script type="text/javascript">

function checkAll(){
	flag = $("#checkAll").attr("checked");
	if(flag == 'checked')
		$("input[name='rptType']").attr("checked",flag);
	else
		$("input[name='rptType']").removeAttr("checked");
}
function uncheckAll(obj){
	flag = obj.checked;
	if(flag){
		types = document.getElementsByName("rptType");
		for(var i = 0; i < types.length; ++i){
			if(!types[i].checked)
				return;
		}
		document.getElementById("checkAll").checked = true;
	}else
		document.getElementById("checkAll").checked = false;
}

function logPage(pageNo)
{
	
	if(pageNo == -1) {
		 pageNo = $('#logPageNum').val();
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
			 beginDate = $("#beginDate").val();
			 endDate = $("#endDate").val();
			 UserID = $("#UserID").val();
			 window.location.href="userlog.php?beginDate="+beginDate+"&endDate="+endDate+"&UserID="+UserID+"&page=logPage&pageNo="+pageNo;
		 }
		 
	 }
}

function deleteSelected()
{
	var checked="";
	$('input:checkbox:checked').each(function(){
		checked+=","+$(this).val();
	});
	if($.trim(checked).length == 0)
	{
		artDialog({content:'当前未选择任何日志！', style:'alert'}, function(){
			
		});
	} else {
		artDialog({content:'是否要删除当前选中的用户日志？', style:'confirm'}, 
				function(){
					$.ajax({
						url:"userlog.php?cmd=delete",
						data:{
							logIds:checked
						},
						type:"POST",
						dataType:"text",
						success:function(data){
							if(data == "OK"){
								artDialog({content:'删除成功！', style:'succeed'}, function(){
									document.myForm.submit();
								});
							} else {
								artDialog({content:'服务器出错，删除失败，请稍后重试！', style:'error'}, function(){
									document.myForm.submit();
								});
							}
						}
					});
				},
				function(){

				});
	}
	
}

function deleteAll()
{
	var beginDate=$('#beginDate').val();
	var endDate=$('#endDate').val();
	var User=$('#User').val();
	var url=WEB_ROOT+"/log/userlog.php?cmd=deleteAll";
	url+="&&beginDate=";
	url+=beginDate;
	url+="&&endDate=";
	url+=endDate;
	url+="&&User=";
	url+=User;
	var r=confirm("是否要删除当前查询出的所有用户日志");
	if(r==true)
	{
		window.location.href=url;
	}
	else
		return;
}
</script>
<body>
 <h5 class="title102"><em>用户日志管理</em></h5>
<div class="box102 p20">
  <form action="<?php echo WEB_ROOT?>log/userlog.php?cmd=select" method="post" name="myForm">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                		<td align="center">
                        	开始日期：
						<input name="beginDate" id='beginDate' value='<?php echo $beginDate?$beginDate:date('Y-m-01');?>' maxlength="10" size='12' class="Wdate" onClick="WdatePicker()" type="text">
						&nbsp;&nbsp;
                        	结束日期：<input name="endDate" id='endDate' value='<?php echo $endDate?$endDate:date('Y-m-d');?>' maxlength="10" size='12' class="Wdate" onClick="WdatePicker()" type="text">
                        &nbsp;&nbsp;
                        	用户：
                        <select name='UserID' id='UserID'>
                        <option value=''>所有</option>                        
                        <?php foreach($users as $user){?>
                        <option value='<?php echo $user['UID']?>' <?php echo $user['UID']==$targetUserID?'selected':''?>><?php echo $user['Username']?> </option>
                        <?php }?>
                        </select>&nbsp;&nbsp;
                         	<a href='javascript:document.myForm.submit();' class="neibu"><b>查询</b></a>&nbsp;&nbsp;
                         	<a href='javascript:deleteSelected()' class="neibu"><b>删除</b></a>
                         </td>
                     </tr>            
                    </tbody>
	</table>
  </form>
</div>
<?php if($empty==1){?>
 	<script type="text/javascript">
// 	alert("符合当前查询条件的用户日志不存在");
 	artDialog({content:'符合当前查询条件的用户日志不存在！', style:'alert'}, function(){
	});
 	</script>
 	<?php }?>
<?php if($Logs){?>
 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">
       		<tbody>
            	<tr>
                	<td width="44%">
                        <div class="p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>
                                	 <th><input type="checkbox" id="checkAll" onclick="checkAll()"> 全选</th>
                                    	<th>日志编号</th>
                                        <th>开始时间</th>
                                        <th>结束时间</th>
                                        <th>用户名</th>
                                        <th>操作类型</th>
                                        <!--<th>操作对象</th>
                                        <th>操作内容</th>-->
                                        <th>执行结果</th>  
                                        <th>失败原因</th>           
                                    </tr>
                                    <?php
                                    foreach ($Logs as $log) {?>
                                    <tr>
                                    	<td><input type="checkbox" id="rptType" name="rptType" onclick="uncheckAll(this)" value="<?php echo $log['LogId']?>"></td>
                                    	<td><?php echo $log['LogId']?></td>
                                        <td><?php echo $log['BeginTime']?></td>
										<td><?php echo $log['EndTime']?></td>
										<td><?php echo $log['Username']?></td>
										<td><?php echo $log['LogTypeText']?></td>
										<!--<td width="0px"><?php echo $log['OpTargets']?></td>
										<td width="0px"><?php echo $log['OpItems']?></td>-->
										<td><?php if(!$log['Result'])echo '成功'; else echo '失败'?></td>
										<td><?php echo $log['ErrReason']?></td>
                                    </tr>
                                  <?php }?>                
                                </tbody>
                            </table>
                        </div>  
                                          </td>
                </tr>
            </tbody>
       </table>
       <div class="box102 p20">
       	<?php echo $page->toString();?>
 		<?php }?>
 	   </div>
 </body>
 </html>