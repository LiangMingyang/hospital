<?php
/**
 * server.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-14,created by Xu Guozhi
 */
include header_inc();
 ?>

 <body>
 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">
       		<tbody>
            	<tr>
                	<td width="44%">
                    	<div><h5 class="title102"><em>服务器配置</em> <span ><a href="serverInfo.php" class="neibu"><b>添加服务器</b></a></span></h5></div>
                        <div class="p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>
                                    	<th>编号</th>
                                        <th>服务器名</th>
                                        <th>服务器IP</th>
                                        <th>最后修改时间</th>
                                        <th>备注</th> 
                                        <th>状态</th>                                        
                                        <th class="border_r0">操作</th>
                                    </tr>
                                    <?php
                                    foreach ($servers as $server) {
                                    ?>
                                    <tr>
                                    	<td><?php echo $server['ServerID']?></td>
                                        <td><?php echo $server['ServerName']?></td>
										<td><?php echo ($server['ServerIP' ]);?></td>
										<td><?php echo $server['ModifyTime']?></td>
										<td><?php echo $server['Remarks']?></td> 
										<td><?php echo $server['Deleted']==0?"正常":"禁用"?></td>
										<td class="border_r0" width="150px">
                                        	<a class="neibu" style="width:30px" href="serverInfo.php?ServerID=<?php echo $server['ServerID']?>">修改</a>
                                        <?php 
                                        if($server['Deleted']==0){
                                        	?>
                                        	<a class="neibu" style="width:30px" href="serverInfo.php?cmd=disable&ServerID=<?php echo $server['ServerID']?>" >禁用</a>
                                        	<?php 
                                        } else {
                                        	?>
                                        	<a class="neibu" style="width:30px" href="serverInfo.php?cmd=enable&ServerID=<?php echo $server['ServerID']?>" >激活</a>
                                        	<?php
                                        }
                                        ?>
                                        	
                                        	</td>
									
                                    </tr>
                                   <?php }?>                             
                                </tbody>
                            </table>
                            <div style="width:100%;text-align:center;">
                            <?php if(count($servers)==0){
                            	?>
                            	<font style="color:red;">未添加任何数据库服务器！</font>
                            	<?php 
                            }?>
                            </div>
                        </div>  
                                          </td>
                </tr>
            </tbody>
       </table>
 </body>
 </html>