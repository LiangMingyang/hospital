<?php
/**
 * audit_datasource.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-5-2,created by Xu Guozhi
 */
 ?>
 <table border="0" cellspacing="0" cellpadding="0" class="tab4" width="100%">
 	<tbody>
 	<tr><th>名称</th><td class="border_r0"><?php echo $datasource->title;?></td></tr>
 	<tr><th>描述</th><td class="border_r0"><?php echo $datasource->description?></td></tr>
 	<tr><th>表格内容</th><td class="border_r0"><table style="border:0"><tr><td style="border:0">
 	<select name="list" id="tabcolumns" multiple  size="25" style="height:150px"  >
 	<?php while(list($key,$value) = each($datasource->columns)){?>
 	<option value="<?php echo $key?>" onclick="setAdd()" ondblclick="add()"><?php echo $value?></option><?php }?>
</select></td>
<td style="border:0" class="page2"><a href="javascript:void(0)" onclick="add()" class="num" id="singleBtn">> </a><br/>
<a href="javascript:void(0)" class="num" onclick="addAll()">>></a><br/>
<a href="javascript:void(0)" class="num" onclick="remove()"><</a><br/>
<a href="javascript:void(0)" class="num" onclick="removeAll()"><<</a></td>
<td style="border:0"><select name="list" id="tabcolumns_selected" multiple  size="25" style="height:150px"  >
</select><img src="<?php echo IMAGE_PATH?>moveup.gif" onclick="moveUp()"/><img src="<?php echo IMAGE_PATH?>movedown.gif" onclick="moveDown()"/></td></tr></table></td>
</tr>
 	<tr><th>图表</th><td class="border_r0"><input type="radio" name="chartType" value="">无
 						<input type="radio" name="chartType" value="Line">曲线图
 						<input type="radio" name="chartType" value="Pie">饼图
 						<input type="radio" name="chartType" value="Bar">柱状图</td></tr>
 	<tr><th>过滤条件</th><td class="border_r0"><table border="0" cellspacing="0" cellpadding="0" width="100%" id="filters">
 							<?php if($datasource->filters){
 							    foreach ($datasource->filters as $filter){?>
 								<tr><td><?php echo $filter->getText()?></td><td class="border_r0"><?php if($filter->getType()=='text'){?><input type="text" name="<?php echo $filter->getName()?>"/>
 								<?php }elseif ($filter->getType()=='select'){?><select name="<?php echo $filter->getName()?>" style="width:70%">
 									<?php foreach($filter->getOptions() as $option){?><option value="<?php echo $option['value']?>"><?php echo $option['text']?></option><?php }?>
 								</select><?php }?>
 							    <?php }}?>
 						</td></tr></table></td></tr>
 	</tbody>
 </table>