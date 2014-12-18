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
	
function dm(id){
	 //alert('分析程序已启动');
	 artDialog({content:'挖掘 程序已启动！', style:'succeed'}, function(){
		 showDiv();
		 $.ajax({
			url:"learnCfg.php?cmd=dm&id="+id,
			type:"post",
			dataType:"text",
			async : true,
			success:function(data){
				artDialog({content:'挖掘程序已完成！', style:'succeed'}, function(){
					 closeDiv();
					});
			}
	
		 });
		 
		});
	 
	 
}

function match(id){
	artDialog({content:'挖掘 程序已启动！', style:'succeed'}, function(){
		$.ajax({
			url:"learnCfg.php?cmd=match&id="+id,
			type:"post",
			dataType:"text",
			async : false,

		 });
	});
	 	 
}
 </script>
 <script type="text/javascript" src="<?php echo JS_PATH?>ids.js?2"></script>
 <body>
 <div class="tab5">
	<h5 class="title102"><em>自主学习配置</em> </h5>
	<div class="box102 tabContent">
		<div class="itabContent">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<th>服务器</th>
					<th>协议</th>
					<th>数据库</th>
					<th>分析起始时间</th>
					<th>分析终止时间</th>
					<th class="border_r0"><a href="learnCfgInfo.php" class="neibu">创建计划</a></th>
				</tr>
                 <?php if($schdule){
                     foreach($schdule as $sch){?>
                 <tr>
                 	<td><?php echo $sch['ServerName']?></td>
                 	<td><?php echo $sch['Protocol']?></td>
                 	<td><?php echo $sch['ServiceName']?></td>
                 	<td><?php echo $sch['startTime']?></td>
                 	<td><?php echo $sch['endTime']?></td>
                 	
                 	<td class="border_r0">
                 	 <a href="learnCfgInfo.php?cmd=delete&id=<?php echo $sch['traceId']?>" class="neibu">删除</a>
                 	 <a href="learnCfgInfo.php?cmd=get&id=<?php echo $sch['traceId']?>" class="neibu">编辑</a> 
                 	 <a href="javascript:void(0)" onclick="dm(<?php echo $sch['traceId']?>)" class="neibu">挖掘</a>
                 	 <a href="javascript:void(0)" onclick="match(<?php echo $sch['traceId']?>)" class="neibu">执行计划</a>
                 	 </td>
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