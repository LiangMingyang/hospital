<?php
/**
 * analyse.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-4-11,created by Xu Guozhi
 */
include header_inc();
 ?>
 <style type="text/css">
    .popWindow{
        text-align: center;
        z-index:2;
        width:600px;
        height:300px;
        left: 50%;
        top: 50%;
        margin-left: -250px;
        margin-top: -150px;
        position: absolute;
        background:#FFFFFF;
    }
    .head-box{
        width:500px;
        height:25px;
        background:#4A4AFF;
    }
    .maskLayer {
        background-color:#9D9D9D;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        filter: alpha(opacity=50);
        opacity: 0.5;
        z-index: 1;
        position: absolute;
    }
    html{min-height:400px;}
</style>
 
 <script type="text/javascript">
function showDiv() {
	    document.getElementById('popWindow').style.display = 'block';
	    document.getElementById('maskLayer').style.display = 'block';      
}
function closeDiv() {
	    document.getElementById('popWindow').style.display = 'none';
	    document.getElementById('maskLayer').style.display = 'none';
}
	
 function analyse(id){
	 //alert('分析程序已启动');
	 artDialog({content:'分析程序已启动！', style:'succeed'}, function(){
		 showDiv();

		 /*
		 $.get(WEB_ROOT+'ids/mining.php?analysisId='+id,'',function(data){
			 artDialog({content:'分析程序已完成！', style:'succeed'}, function(){
				 closeDiv();
				});
		 });
		*/
		 $.ajax({
			url:"mining.php?analysisId="+id,
			type:"post",
			dataType:"text",
			async : true,
			success:function(data){
				artDialog({content:'分析程序已完成！', style:'succeed'}, function(){
					 closeDiv();
					});
			}
	
		 });
		 
		});
	 
	 
}

 function executeRightManage(id){
	 //alert('权限程序已启动');
	 artDialog({content:'权限程序已启动！', style:'succeed'}, function(){
		 showDiv();

		 $.get(WEB_ROOT+'ids/rightManage.php?recordId='+id,'',function(data){
//			 alert(data);
			 if(data.msg=="USERNAME_PASSWORD_ERROR") {
				 //alert('用户名或密码错误，请配置正确的数据库用户名和密码！');
				 artDialog({content:'用户名或密码错误，请配置正确的数据库用户名和密码！', style:'error'}, function(){
					 closeDiv();
					});
			 } else if(data.msg=="OK") {
				// alert('程序执行完成！用户权限模式挖掘成功！');
				 artDialog({content:'程序执行完成！用户权限模式挖掘成功！', style:'succeed'}, function(){
					 closeDiv();
					});
			 } else if(data.msg == "CONNECTION_ERROR") {
				// alert('目标数据库连接失败！用户权限模式挖掘失败！');
				 artDialog({content:'目标数据库连接失败！用户权限模式挖掘失败！', style:'error'}, function(){
					 closeDiv();
					});
			 } else if(data.msg == "NO_DATABASE_DRIVE"){
				// alert('没有该数据库连接驱动！请系统管理员检查后台程序！');
				 artDialog({content:'没有该数据库连接驱动！请系统管理员检查后台程序！', style:'error'}, function(){
					 closeDiv();
					});
			 }
			 //closeDiv();
		 },"JSON");
		 
		});
	 
     
	 

	 /*
	 $.ajax({
		url:"rightManage.php?recordId="+id,
		type:"post",
		dataType:"json",
		success:function(data){
			alert(data);
			 if(data=="USERNAME_PASSWORD_ERROR") {
				 alert('用户名或密码错误，请配置正确的数据库用户名和密码！');
			 } else if(data=="OK") {
				 alert('程序执行完成！用户权限模式挖掘成功！');
			 } else if(data == "CONNECTION_ERROR") {
				 alert('目标数据库连接失败！用户权限模式挖掘失败！');
			 } else if(data == "NO_DATABASE_DRIVE"){
				 alert('没有该数据库连接驱动！请系统管理员检查后台程序！');
			 }
			 closeDiv();
		}
	 });
	 */
	 
}
 </script>
 <script type="text/javascript" src="<?php echo JS_PATH?>ids.js?2"></script>
 <body>
 <div class="tab5">
	<div>
		<h5 class="title102"><em>自主学习配置</em> 
			<span>
				<a href="#" class="tab">行为模式</a> 
				<a href="#" class="tab on">权限管理</a>
			</span>
		</h5>
	</div>
	<div class="box102 tabContent">
		<div class="itabContent" style="display:none">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<th>服务器</th>
					<th>协议</th>
					<th>数据库</th>
					<th>是否启用云平台</th>
					<!-- 
					<th>周期</th>
					 -->
					<th>上次分析时间</th>
					<th>分析的日志范围</th>
					<th class="border_r0"><a href="analyseInfo.php" class="neibu">创建计划</a></th>
				</tr>
                 <?php if($schdule){
                     foreach($schdule as $sch){?>
                 <tr>
                 	<td><?php echo $sch['ServerName']?></td>
                 	<td><?php echo $sch['Name']?></td>
                 	<td><?php echo $sch['ServiceName']?></td>
                 	<td><?php echo ($sch['UseCloud']==1?"启用":"关闭")?></td>
                 	<!-- 
                 	<td><?php echo $sch['AnalysisInterval']?>天</td>
                 	 -->
                 	<td><?php echo $sch['LastStartTime']?></td>
                 	
                 	<td><?php if($sch['LogRange']==0){ echo "分析全部日志"; }elseif($sch['LogRange']==1){ echo "从上一次分析后的日志开始";}else {echo "从".$sch['AnalysisStartDay']."开始";}?></td>
                 	<td class="border_r0"><a href="#" class="neibu" style="color: white;" onclick="deleteAnalyse(<?php echo $sch['AnalysisId']?>);">删除</a> <a href="analyseInfo.php?cmd=get&id=<?php echo $sch['AnalysisId']?>" class="neibu">编辑</a> <a href="javascript:void(0)" onclick="analyse(<?php echo $sch['AnalysisId']?>)" class="neibu">立即执行</a></td>
                 </tr>
                 <?php }}?>               	
			</tbody>
		 </table>                            
	</div> 
	<div class="itabContent">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<th width="20%">数据库</th>
					<th width="10%">用户名</th>
					<th width="10%">模式名</th>
					<!-- 
					<th width="10%">状态</th>
					 -->
					<th width="20%">上次更新时间</th>
					<th class="border_r0"><a href="PrivilegeAnalyzeInfo.php" class="neibu">创建计划</a></th>
				</tr>    
				<?php if($schdule2){
                     foreach($schdule2 as $sch){
                     ?>
                 <tr>
                 	<td><?php echo $sch['ServerName'].":".$sch['Protocol'].":".$sch['ServiceName']?></td>
                 	<td><?php echo $sch['UserName']?></td>
                 	<td><?php echo $sch['Schema']?></td>
                 	<!-- 
                 	<td><?php echo ($sch['Enabled']==1?"开启":"禁用")?></td>
                 	 -->
                 	<td><?php echo $sch['LastUpdateTime']?></td>
                  	<td class="border_r0"><a href="#" class="neibu" style="color: white;" onclick="deleteRecord(<?php echo $sch['RecordId']?>);">删除</a> <a href="PrivilegeAnalyzeInfo.php?cmd=get&id=<?php echo $sch['RecordId']?>" class="neibu">编辑</a> <a href="javascript:void(0)" class="neibu" onclick="executeRightManage(<?php echo $sch['RecordId']?>)">立即执行</a></td>
                 </tr>
                 <?php }}?>              	
			</tbody>
		 </table>                            
	</div>
	</div>
</div> 
<script type="text/javascript">
	function tab(nav,content,on,type)
{
	$(nav).children().bind(type,(function(){
		var $tab=$(this);
		var tab_index=$tab.prevAll().length;
		var $content = $(content).children();
		$(nav).children().removeClass(on);
		$tab.addClass(on);
		$content.hide();
		$content.eq(tab_index).show();
	}));
}
   tab(".title102 span",".tabContent","on","mouseover");
</script>
<div id="popWindow" class="popWindow" style="display: none;">
	<img src="<?php echo IMAGE_PATH?>waiting_datamining.jpg" width="100%">
</div>
<div id="maskLayer" class="maskLayer" style="display: none;">
</div>
 </body>
 </html>
