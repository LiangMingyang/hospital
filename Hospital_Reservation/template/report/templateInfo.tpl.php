<?php
/**
 * templateInfo.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-27,created by Xu Guozhi
 */
require header_inc();
 ?>
 <script>
 var ds ={};
 var delIds = "";
 var currId = -1;
 </script>
 <script type="text/javascript" src="<?php echo JS_PATH?>template.js?1"></script>
 <body>
 <div class="celue p20" style="margin-top:0px;">
 <table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<td width="32%">
				<div><form action="?cmd=save" method="post" onsubmit="return templateSave()">
					<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
						<tbody>
							<tr>
								<th width="20%">模板名称</th>
								<td><input type="text" id="rptName" value="<?php echo $template['TplName']?>" name="template[TplName]"/><span style="color:red">*</span><span class="errorTip" id='rptNameTip'></span></td>
                            </tr>
                            <tr>
								<th>数据源</th>
								<td><a href="javascript:void(0)" onclick="showDataSource()" class="neibu">配置数据源</a></td>
                            </tr>
                            <tr>
								<th>是否自动发送报告</th>
								<td><input type="radio" name="template[AutoSend]" value="0"<?php if($template['AutoSend']==0) echo "checked"?>onclick="showReceiver(this)">否  <input type="radio" name="template[AutoSend]" value="1"<?php if($template['AutoSend']==1) echo "checked"?> onclick="showReceiver(this)">是</td>
                            </tr>
                            <tr <?php if($template['AutoSend']==0) echo "style='display:none'"?> id='receiverTr'>
                            	<th>邮件发送地址(以逗号分割)</th>
                            	<td>
                            		<input type="text" name="template[Receiver]" value="<?php echo $template['Receiver']?>" style="width:90%"/>
                            	</td>
                             </tr>
                             <tr>                           
                            <input type="hidden" id='tplId' name="template[TplID]" value="<?php echo $template['TplID']?>"/>
                            <input type="hidden" id="rptDataSource" name="rptDataSource" />
                            <input type="hidden" id="delIds" name="delIds" />
                            <tr><td colspan="2"><input type="submit" class="tijiao" name="sbtUser" value="保存"/>
                            <input type="reset" class="repire" name="rstUser" value="重置"/>
						</tbody>
					</table></form>
				</div>
			</td>
		</tr>
	</tbody>
</table>
</div>  
<div id="datasource" style="display:none">
	<table border="0" cellspacing="0" cellpadding="0" class="tab4" width="100%" style="text-align: left">
	<tr><td width="30%" valign="top">
	<table border="0" cellspacing="0" cellpadding="0" class="tab4" width="100%" style="text-align: left">
		<?php if($category){while(list($key,$value)=each($category)){?>
		<tr class="category" onclick="showCategory(this)"><th><span>+</span><?php echo $key?></th></tr>		
		<tr style="display:none"><td>
		<?php foreach ($value as $datasource){
		    $check=null;
		    if($tplDatasource){
		    foreach ($tplDatasource as $selected) {
		        if($selected['DataSourceID']==$datasource['DataSourceID']){
		            $check = $selected;?>
		            <script>var id = <?php echo $selected['DataSourceID']?>;ds[id]={};
		            		ds[id]['Tbl']='<?php echo $selected['Tbl']?>';
		            		ds[id]['Cols']='<?php echo $selected['Cols']?>';
		            		ds[id]['ChartType']='<?php echo $selected['ChartType']?>';
		            		ds[id]['Filter'] = $.evalJSON('<?php echo $selected['Filter']?>');
		            </script>
		            
		<?php        break;
		        }
		    }
		    }
		    ?><p>&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' id='ds<?php echo $datasource['DataSourceID']?>' onclick="changeDs(<?php echo $datasource['DataSourceID'];?>);viewDataSource('audit','<?php echo $datasource['ClassName']?>')" <?php echo ($check?"checked":"")?> value='<?php echo $datasource['DataSourceID']?>'>
		    <a onclick="changeDs(<?php echo $datasource['DataSourceID'];?>);viewDataSource('audit','<?php echo $datasource['ClassName']?>')"><?php echo $datasource['DataSourceName']?></a>
		
		</p>
		<?php }?>
		</td></tr>
		<?php }	}?>
	</table>
	</td><td id='datasourceDetail' valign="top" width="70%"></td></tr></table>
</div> 
 </body>
 </html>