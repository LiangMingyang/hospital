<?php
/**
 * action.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-9,created by Xu Guozhi
 */
include header_inc();
 ?>
 <script type="text/javascript" src="<?php echo JS_PATH?>action.js?"></script>
 <body>
 <div class="tab5">
	<div><h5 class="title102"><em>响应行为配置</em> <span ><a href="javascript:void(0);" class="neibu add"><b>添加活动</b></a></span></h5></div>
	<div class="box102 p20">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody id="actionTbody">
				<tr>
					<th>行为类别</th>
					<!-- 
					<th>阻塞</th>
					 -->
					<th>邮件报警</th>
					<!-- 
					<th>短信报警</th>
					 -->
					<th>气泡报警</th>
					<th class="border_r0"></th>
				</tr>
                 <?php if($actions){
                     foreach($actions as $action){?>
                 <tr>
                 	<td><input type="text" class="description" value="<?php echo $action['Description']?>" onblur="var i =$('.description').index(this);checkNameLength(i);"/></td>
                 	<!-- 
                 	<td>
                 		<select class="block">
                 			<option value="0" <?php if($action['Block']==0) echo selected?>>不阻塞</option>
                 			<option value="1" <?php if($action['Block']==1) echo selected?>>阻塞</option>
                 		</select>
                 	</td>
                 	 -->
                 	<td>
                 		<select class="mail">
                 			<option value="0" <?php if($action['MailWarn']==0) echo selected?>>关闭</option>
                 			<option value="1" <?php if($action['MailWarn']==1) echo selected?>>开启</option>
                 		</select>
                 	</td>
                 	<!-- 
                 	<td>
                 		<select class="sms">
                 			<option value="0" <?php if($action['SMSWarn']==0) echo selected?>>关闭</option>
                 			<option value="1" <?php if($action['SMSWarn']==1) echo selected?>>开启</option>
                 		</select>
                 	</td>
                 	 -->
                 	<td>
                 		<select class="pop">
                 			<option value="0" <?php if($action['PopWarn']==0) echo selected?>>关闭</option>
                 			<option value="1" <?php if($action['PopWarn']==1) echo selected?>>开启</option>
                 		</select>
                 	</td>
                 	<td class="border_r0">
                 		<input type="hidden" class="actionId" value="<?php echo $action['ActionId']?>"/>
                 		<a href="javascript:void(0)" class="neibu save">保存</a>
                 		<a href="javascript:void(0)" class="neibu delete">删除</a>
                 	</td>
                 </tr>
                 <?php }}?>         
                <!-- 
                 <tr id="last"><td align="right" colspan="6" class="border_r0"><a href="javascript:void(0);" class="neibu add">添加</a></td></tr>  
                 -->    	
			</tbody>
		 </table>                            
	</div> 
</div> 
 </body>
 </html>