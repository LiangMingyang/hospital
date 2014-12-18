<?php
/**
 * role.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-2,created by Xu Guozhi
 */
include header_inc();
 ?>
 <body>
       <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">

       		<tbody>
            	<tr>
                	<td width="44%">
                    	<h5 class="title102"><em>角色管理</em> <span style="padding-top:5px;"><a href="?cmd=new" class="neibu">添加角色</a></span></h5>
                        <div class="p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>

                                    	<th>角色名</th>
                                        <th>状态</th>
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
                                        <td class="border_r0" width="25%">
                                        <?php if($role['IsDeleted']==1){?>
                                        <a href="?cmd=active&roleId=<?php echo $role['RoleID']?>" class="neibu">激活</a>
                                        <?php }else{?>
                                        <a href="?cmd=get&roleId=<?php echo $role['RoleID']?>" class="neibu">修改</a>
                                        <a href="?cmd=delete&roleId=<?php echo $role['RoleID']?>" class="neibu">删除</a>
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