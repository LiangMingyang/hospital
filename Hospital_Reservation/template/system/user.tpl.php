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
function check(userId)
{
	$.ajax({
		url:"userInfo.php?cmd=active&id="+userId,
		type:"post",
		dataType:"text",
		success:function(data){
			if(data=="ERROR"){
        		artDialog({content:'该用户所属角色已删除', style:'error'}, function(){
				});
			}
			else{
				window.location.href="userMgr.php";
			}
		}
	});	
}
</script>
<body>
       <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">

       		<tbody>
            	<tr>
                	<td width="44%">
                    	<h5 class="title102"><em>用户管理</em> <span style="padding-top:5px;"><a href="userInfo.php" class="neibu">添加用户</a></span></h5>
                        <div class="p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>

                                    	<th width="8%">用户名</th>
                                        <th width="8%">角色</th>
                                        <th width="10%">姓名</th>
                                        <th width="15%">电话</th>
                                        <th width="15%">电子邮件</th>
                                        <th width="8%">状态</th>
                                        <th width="10%">审核状态</th>
                                        <th class="border_r0" width="40%">操作</th>
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
										<td>
										<?php echo ($user['isReviewed']==1?'<font color="green">审核通过</font>':'<font color="red">审核未通过</font>')?>
										</td>
                                        <td class="border_r0" width="15%">
                                        <?php $UID=$user['UID']?>
                                    	<?php if($user['Deleted']==1){ 
                                    	?>
                                        <!-- <a href="userInfo.php?cmd=active&id=<?php echo $user['UID']?>" class="neibu" onclick="check();">激活</a> -->
                                         <a class="neibu" onclick="check(<?php echo $user['UID']?>);">激活</a>
                                        <?php }else{?>
                                        
                                        <a href="userInfo.php?id=<?php echo $user['UID']?>" class="neibu">修改</a>
                                        <a href="userInfo.php?cmd=delete&id=<?php echo $user['UID']?>" class="neibu">删除</a>
                                        <?php if($user['Locked']==1){
                                        	?>
                                        	<a href="userInfo.php?cmd=unlock&id=<?php echo $user['UID']?>" class="neibu">解锁</a>
                                        	<?php
                                        }else {
                                        	?>
                                        	<a href="userInfo.php?cmd=lock&id=<?php echo $user['UID']?>" class="neibu">锁定</a>
                                        	<?php
                                        }?>
                                        
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

