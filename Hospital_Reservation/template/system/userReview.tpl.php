<?php include header_inc() ?>
<script type="text/javascript">
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
			 window.location.href="userMgr.php?page=page&pageNo="+pageNo;
		 } 
	 }
	
}
</script>
<body>
       <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">

       		<tbody>
            	<tr>
                	<td width="44%">
                    	<h5 class="title102"><em>用户审核</em></h5>
                        <div class="p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>

                                    	<th width="10%">用户名</th>
                                        <th width="10%">角色</th>
                                        <th width="10%">姓名</th>
                                        <th width="15%">电话</th>
                                        <th width="15%">电子邮件</th>
                                        <th width="10%">用户状态</th>
                                        <th width="10%">审核状态</th>
                                        <th class="border_r0" width="30%">操作</th>
                                    </tr>
                                    <?php
                                    foreach ($users as $user) {
                                    ?>
                                    <tr>
                                    	<td><?php echo $user['Username']?></td>
                                        <td><?php echo $user['RoleName']?></td>
										<td><?php echo $user['FullName']?></td>
										<td><?php echo $user['Tel']?></td>
										<td><?php echo $user['Email']?></td>
										<td><?php 
										if($user['Deleted']==1) {
											echo "已删除";
										} else if($user['Locked']==1) {
											echo "已锁定";
										} else {
											echo "正常";
										}?>
										</td>
										<td>
										<?php echo ($user['isReviewed']==1?'<font color="green">审核通过</font>':'<font color="red">审核未通过</font>')?>
										</td>
                                        <td class="border_r0" width="15%">
                                    	<?php if($user['isReviewed']==1){ ?>
                                    	   <a href="?cmd=noreviewed&uid=<?php echo $user['UID']?>" class="neibu">不通过审核</a>
                                    	<?php }else{?>
                                    	   <a href="?cmd=reviewed&uid=<?php echo $user['UID']?>" class="neibu">通过审核</a>
                                    	<?php }?>                                       
                                        </td>
                                    </tr>
                                   <?php }?>
                                </tbody>
                            </table>
								<?php echo $page->toString();?>

                        </div>  
                                          </td>
                </tr>
            </tbody>
       </table>      
       
</body>
</html>