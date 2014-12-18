<?php
/**
 * sysriskStatus.tpl.php-.
 * @author zhangxin
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history
 * ---------------------
 * 2014-6-19,created by zhangxin
 */
include header_inc();
?>
<html>
<body>
	<div>
		<div><h5 class="title102"><em>系统风险状态</em> <span ></span></h5></div>
		<div class="box102 p20">
		    <p style="font-size:14px;">当天各被审计服务器风险状态如下。</p>
		    <br />
        	<table id="val" border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
            	<tbody>
            		<tr>
            		    <th align="center">被审计服务器</th>
            			<th align="center">当天发生低风险次数</th>
            			<th align="center">当天发生中风险次数</th>
            			<th align="center">当天发生高风险次数</th>
            		</tr>		
            		<?php foreach($riskinfo as $ri){?>
            		<tr align="center">
            		<td><?php echo $ri['ServerName'].":".$ri['ServerIP'].":".$ri['ServiceName'];?></td>
            		<?php if($ri['lowRisk']>$riskthreshold[0]){?>
            		<td style="color: red"><?php echo $ri['lowRisk']."(该项大于设定阈值!)";?></td>
            		<?php }else{?>
            		<td><?php echo $ri['lowRisk'];?></td>
            		<?php }?>
            		
            		<?php if($ri['midRisk']>$riskthreshold[1]){?>
            		<td style="color: red"><?php echo $ri['midRisk']."(该项大于设定阈值!)";?></td>
            		<?php }else{?>
            		<td><?php echo $ri['midRisk'];?></td>
            		<?php }?>
            		
            		<?php if($ri['highRisk']>$riskthreshold[2]){?>
            		<td style="color: red"><?php echo $ri['highRisk']."(该项大于设定阈值!)";?></td>
            		<?php }else{?>
            		<td><?php echo $ri['highRisk'];?></td>
            		<?php }?>
            		</tr>
            		<?php }?>
                </tbody>
            </table>                            
		</div> 
	</div>
</body>
</html>