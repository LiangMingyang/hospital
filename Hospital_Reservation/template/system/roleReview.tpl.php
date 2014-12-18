<?php
/**
 * roleReview.tpl.php-.
 *
 * @modification history 
 * ---------------------
 * 2014-7-15,created by zhangxin
 */
include header_inc();
 ?>
 <body>
       <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">

       		<tbody>
            	<tr>
                	<td width="44%">
                    	<h5 class="title102"><em>角色审核</em></h5>
                        <div class="p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>

                                    	<th>角色名</th>
                                        <th>角色状态</th>
                                        <th>审核状态</th>
                                        <th class="border_r0">操作</th>
                                    </tr>
                                    <?php
                                    foreach ($roles as $role) {
                                    ?>
                                    <tr>
                                    	<td><?php echo $role['RoleName']?></td>                                        
										<td><?php echo ($role['IsDeleted']==1?'已删除':'正常')?></td>
										<?php if($role['isUsable']==1){?>
										     <td style="color: green;"><?php echo '审核通过'?></td>
										<?php }else{?>
										     <td style="color: red;"><?php echo '审核未通过'?></td>
										<?php }?>
                                        <td class="border_r0" width="30%">
                                        <a href="?cmd=get&roleId=<?php echo $role['RoleID']?>" class="neibu">查看</a>
                                        <?php if($role['isUsable']==1){?>
                                        <a href="?cmd=noreviewed&roleId=<?php echo $role['RoleID']?>" class="neibu">不通过审核</a>
                                        <?php }else{?>
                                        <a href="?cmd=reviewed&roleId=<?php echo $role['RoleID']?>" class="neibu">通过审核</a>
                                        <?php }?>
                                        </td>
                                    </tr>
                                   <?php }?>
                                </tbody>
                            </table>

                        </div>  
                                          </td>
                </tr>
            </tbody>
       </table>      
       
</body>
</html>