<?php
/**
 * template.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-27,created by Xu Guozhi
 */
include header_inc();
 ?>
 <script type="text/javascript">
<!--
function del(id){
	if(confirm('确定要删除吗?')){
		window.location.href="?cmd=del&tplId="+id;
		}
}
//-->
</script>
 <body>
 	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab5">

       		<tbody>
            	<tr>
                	<td width="44%">
                    	<h5 class="title102"><em>报告模板</em> <span style="padding-top:5px;"><a href="?cmd=new" class="neibu"><b>添加模板</b></a></span></h5>
                        <div class="p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                            	<tbody>
                                	<tr>
                                    	<th>名称</th>
                                        <th>是否自动发送报告</th>
                                        <th>创建日期</th>
                                        <th class="border_r0">操作</th>
                                    </tr>
                                    <?php
                                    foreach ($templates as $template) {
                                    ?>
                                    <tr>
                                    	<td><?php echo $template['TplName']?></td>
                                        <td><?php echo ($template['AutoSend']==1?"是":"否")?></td>
										<td><?php echo $template['CreateTime']?></td>
                                        <td class="border_r0">
                                        	<a href="report.php?tplId=<?php echo $template['TplID']?>" class="neibu">查看报告</a>
                                        	<a href="?cmd=get&tplId=<?php echo $template['TplID']?>" class="neibu">查看模板</a>
                                        	<a href="javascript:del(<?php echo $template['TplID']?>)" class="neibu">删除模板</a>
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