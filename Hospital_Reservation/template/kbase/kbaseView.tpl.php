<?php
/**
 * kbaseView.tpl.php-.
 * @author zhangxin
 *
 * ---------------------
 * 2014-4-24,created by zhangxin
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
 function page(pageNo)
 {

	 if(pageNo == -1) {
		 pageNo = $('#pageNum').val();
	 }
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#pageCountHidden").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 var currentPageNo = parseInt($(".numon").html());
		 if(parseInt(pageNo)==currentPageNo){
			alert("当前为"+pageNo+"页");
		 } else{
			 var service = $("#serviceSelectHidden").val();
			 window.location.href="kbaseView.php?pageNo="+pageNo+"&page=page";

		 }
		 
	 }
 }
 
function showDiv() {
	    document.getElementById('popWindow').style.display = 'block';
	    document.getElementById('maskLayer').style.display = 'block';      
}
function closeDiv() {
	    document.getElementById('popWindow').style.display = 'none';
	    document.getElementById('maskLayer').style.display = 'none';
}

function deleteFunction(id){
	$.post(WEB_ROOT+'kbase/kbaseView.php?fid='+id+'&cmd=deletefun',{
	   
	},function(data){
		if(data == "OK"){
				window.location.href="kbaseView.php";
		} else {
			artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
				window.location.href="kbaseView.php";
			});
		} 
	});
}

function deleteSqlInj(sqlid){
	$.post(WEB_ROOT+'kbase/kbaseView.php?sqlid='+sqlid+'&cmd=deletesql',{
		   
	},function(data){
		if(data == "OK"){
				window.location.href="kbaseView.php";
		} else {
			artDialog({content:'服务器出错，删除失败！请重试！', style:'error'}, function(){
				window.location.href="kbaseView.php";
			});
		} 
	});
}
	
 </script>
 <script type="text/javascript" src="<?php echo JS_PATH?>ids.js?2"></script>
 <body>
 <div class="tab5">
	<div>
		<h5 class="title102"><em>知识库维护</em> 
			<span>
				<a href="#" style="font-size: 12px;" class="tab on">漏洞函数库</a> 
				<a href="#" style="font-size: 12px;" class="tab">Sql注入攻击库</a>
			</span>
		</h5>
	</div>
	<div class="box102 tabContent">
		<div class="itabContent">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<th>漏洞函数名</th>
					<th>数据库类型</th>
					<th>被利用最低版本</th>
					<th>可利用最高版本</th>
					<th>漏洞参数值范围</th>
					<th class="border_r0"><a href="addFunction.php" class="neibu">添加</a></th>
				</tr>
                 <?php if($kfunction){
                     foreach($kfunction as $fun){?>
                 <tr>
                 	<td><?php echo $fun['FName']?></td>
                 	<td><?php echo $fun['DBType']?></td>
                 	<td><?php echo $fun['LowVer']?></td>
                 	<td><?php echo $fun['HighVer']?></td>
                 	<td><?php echo $fun['ParaNum']?></td>
                 	<td class="border_r0"><a href="#" class="neibu" style="color: white;" onclick="deleteFunction(<?php echo $fun['FID']?>);">删除</a> <a href="addFunction.php?cmd=get&id=<?php echo $fun['FID']?>" class="neibu">编辑</a></td>
                 </tr>
                 <?php }}?>               	
			</tbody>
		 </table>
		 <?php echo $page1->toString()?>	
		 <br />
		 <hr />
	     <p style="font-size: 14px;">数据库漏洞更新参考源：&nbsp;&nbsp;美国国家漏洞库（NVD）<a href="http://nvd.nist.gov/" target="_blank" style="text-decoration: underline;" >http://nvd.nist.gov/</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;中国国家信息安全漏洞库（CNNVD）<a href="http://www.cnnvd.org.cn/" target="_blank" style="text-decoration: underline;">http://www.cnnvd.org.cn/</a></p>                           
	</div>
	<div class="itabContent" style="display:none">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<th>SQL注入语句</th>
					<th>关注序列</th>
					<th>近似序列</th>
					<th class="border_r0"><a href="addSqlInj.php" class="neibu">添加</a></th>
				</tr>    
				<?php if($kSqlInj){
                     foreach($kSqlInj as $s){
                     ?>
                 <tr>
                 	<td><?php echo $s['SQLSeq']?></td>
                 	<td><?php echo $s['FocusSeq']?></td>
                 	<td><?php echo $s['ApproxSeq']?></td>
                  	<td class="border_r0"><a href="#" class="neibu" style="color: white;" onclick="deleteSqlInj(<?php echo $s['SQLInjID']?>);">删除</a> <a href="addSqlInj.php?cmd=get&sqlid=<?php echo $s['SQLInjID']?>" class="neibu">编辑</a></td>
                 </tr>
                 <?php }}?>              	
			</tbody>
		 </table>
		 <?php echo $page2->toString() ?>
		 <br />
		 <hr />                         
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